$(function(){
	/* group.top */
	// 申请加入
	$('a[nctype="apply"]').click(function(){
		if(_ISLOGIN == 0){
			login_dialog();
		}else{
			CUR_DIALOG = ajax_form('apply_join','申请加入','index.php?act=group&op=apply&c_id='+c_id,520,1);
		}
	});
	// 退出圈子
	$('a[nctype="quitGroup"]').click(function(){
		showDialog('确定要退出圈子吗？', 'confirm', '', function(){
			var _uri = CIRCLE_SITE_URL+"/index.php?act=group&op=quit&c_id="+c_id;
			ajaxget(_uri);
		});
	});
	//横高局中比例缩放隐藏显示图片
	$(window).load(function () {
		$(".theme-intro-pic .t-img").VMiddleImg({"width":90,"height":60});
	});
	// 展开收起
	$('a[nctype="theme_read"],span[nctype="theme_read"]').click(function(){
		var $pli = $(this).parents('li:first');
		var $this = $pli.find('a[nctype="theme_read"]');
		if(!$this.hasClass('t')){
			$this.addClass('t');
			var $id = $this.attr('data-param');
			var $content = $pli.find('.theme-detail-content');
			var $reply = $pli.find('.quick-reply-2');
			var $reply_box = $pli.find('.quick-reply-box');
			$.getJSON(CIRCLE_SITE_URL+'/index.php?act=theme&op=ajax_themeinfo&c_id='+c_id+'&t_id='+$id, function(data){
				// 内容部分
				$content.append(data.theme_content);
				// 商品部分
				if(data.goods_list != ''){
					var ul = $('<ul></ul>');
					$.each(data.goods_list, function(e, d){
						$('<li></li>').append('<div class="goods-pic thumb"><a href="javascript:void(0);"><img class="t-img" src="'+d.image+'" /></a></div>')
							.append('<div class="goods-name">'+d.goods_name+'</div>')
							.append('<div class="goods-price"><em>'+d.goods_price+'</em></div>')
							.append('<a class="goto" target="_blank" href="'+d.thg_url+'">商品详情</a>')
							.appendTo(ul);
					});
					$('<div class="theme-content-goods"><h4><i></i>相关商品</h4></div>').append(ul).appendTo($content);
				}
				// 附件部分
				if(data.affix_list != ''){
					var div = $('<div class="file-hidden" style="display: none;"></div>');
					
					var ul = $('<ul></ul>');
					$.each(data.affix_list, function(e, d){
						$('<li></li>').append('<a href="javascript:void(0);"><img src="'+d.affix_filethumb+'" /></a>')
							.appendTo(ul);
					});
					$('<i class="arrow"></i>').appendTo(div);
					ul.appendTo(div);
					div = $('<div class="theme-content-file clearfix"><h4 class="file-hidden-btn"><i></i>相关附件</h4></div>').append(div);
					div.find('.file-hidden-btn').click(function(){
						div.find(".file-hidden").slideToggle(100);
					});
					div.appendTo($content);
				}
				// 最后编辑时间
				if(data.theme_edittime != null){
					$('<div class="theme-edittime"><span>'+data.theme_editname+'&nbsp;于&nbsp;'+data.theme_edittime+'&nbsp;最后编辑</span></div>').appendTo($content);
				}
				
				var normal = $('<div class="normal"></div>');
				if(data.theme_nolike){ // 赞
					var _$like = $('<a href="javascript:void(0);">赞(<em nctype="like">'+data.theme_likecount+'</em>)</a>');
					_$like.click(function(){
						if(_ISLOGIN){
							likeYes($(this), {t_id:$id,c_id:c_id});
						}else{
							login_dialog();
						}
					});
					_$like.appendTo(normal)
				}else{ // 取消赞
					var _$unlike = $('<a href="javascript:void(0);">取消赞(<em nctype="like">'+data.theme_likecount+'</em>)</a>');
					_$unlike.click(function(){
						if(_ISLOGIN){
							likeNo($(this), {t_id:$id,c_id:c_id});
						}else{
							login_dialog();
						}
					});
					_$unlike.appendTo(normal);
				}
				// 回复
				var _$reply = $('<a href="javascript:void(0);" nctype="reply">回复('+data.theme_commentcount+')</a>');
				_$reply.quick_reply({
						reply		: $reply,
						reply_box	: $reply_box,
						id			: $id,
						c_id		: c_id,
						identity	: identity
					})
				_$reply.appendTo(normal);
				
				$('<a href="javascript:void(0);">收起主题</a>').click(function(){
						fold($this);
					}).appendTo(normal);
				

				var bar = $('<div class="handle-bar"></div>');
				normal.appendTo(bar);
				bar.appendTo($content);
				
				unfold($this);
			});
			
		}else{
			unfold($this);
		}
	});
	
	
	/* theme.detail */
	// 赞
	$('a[nctype="themeLikeYes"]').click(function(){
		if(_ISLOGIN){
			likeYes($(this), {t_id:t_id,c_id:c_id});
		}else{
			login_dialog();
		}
	});
	// 取消赞
	$('a[nctype="themeLikeNo"]').click(function(){
		likeNo($(this), {t_id:t_id,c_id:c_id});
	});
	// 加精
	$('a[nctype="themeDigestYes"]').click(function(){
		digestYes($(this));
	});
	// 取消加精
	$('a[nctype="themeDigestNo"]').click(function(){
		digestNo($(this));
	});
	// 置顶
	$('a[nctype="themeTopYes"]').click(function(){
		topYes($(this));
	});
	// 取消置顶
	$('a[nctype="themeTopNo"]').click(function(){
		topNo($(this));
	});
	// 关闭
	$('a[nctype="themeShutYes"]').click(function(){
		shutYes($(this));
	});
	// 开启
	$('a[nctype="themeShutNo"]').click(function(){
		shutNo($(this));
	});
	// 禁言
	$('a[nctype="themeCloseYes"]').click(function(){
		var m_id = $(this).attr('data-param');
		var _uri = CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax_nospeak&value=0&c_id='+c_id+'&m_id='+m_id;
		ajaxget(_uri);
	});
	// 解除禁言
	$('a[nctype="themeCloseNo"]').click(function(){
		var m_id = $(this).attr('data-param');
		var _uri = CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax_nospeak&value=1&c_id='+c_id+'&m_id='+m_id;
		ajaxget(_uri);
	});
	// 管理删除主题
	$('a[nctype="themeDelManage"]').click(function(){
		showDialog('确定要删除主题吗？', 'confirm', '', function(){
			var _uri = CIRCLE_SITE_URL+"/index.php?act=manage&op=del_theme&c_id="+c_id+"&t_id="+t_id;
			ajaxget(_uri);
		});
	});
	// 管理删除回复
	$('a[nctype="replyDelManage"]').click(function(){
		var $this = $(this);
		showDialog('确定要删除回复吗？', 'confirm', '', function(){
			var r_id = $this.attr('data-param');
			var _uri = CIRCLE_SITE_URL+'/index.php?act=manage&op=del_reply&c_id='+c_id+'&t_id='+t_id+'&r_id='+r_id;
			ajaxget(_uri);
		});
	});
	
	//管理菜单  隐藏/显示
	$(".manage-button").click(function(){
		$(this).next().slideToggle(300);
	});
	
	// Applied to be an administrator
	$('a[nctype="manageApply"]').click(function(){
		var _uri = CIRCLE_SITE_URL+'/index.php?act=group&op=manage_apply&c_id='+c_id;
		CUR_DIALOG = ajax_form('manage_apply', '申请管理', _uri, 520, 1);
	});
});
// 主题展开
function unfold(o){
	o.removeClass('read-unfold').addClass('read-fold').html('<i></i>收起主题');
	o.parents('li:first').find('.theme-intro').hide()
		.end().find('.theme-lastspeak-name').hide()
		.end().find('.theme-lastspeak-time').hide()
		.end().find('.theme-noreply').hide()
		.end().find('.theme-detail-content').show();
	o.unbind().click(function(){
		fold(o);
	});
}
// 主题折叠
function fold(o){
	o.removeClass('read-fold').addClass('read-unfold').html('<i></i>展开主题');
	o.parents('li:first').find('.theme-detail-content').hide()
		.end().find('.quick-reply-box').hide()
		.end().find('.theme-intro').show()
		.end().find('.theme-lastspeak-name').show()
		.end().find('.theme-lastspeak-time').show()
		.end().find('.theme-noreply').show();
	o.unbind().click(function(){
		unfold(o);
	});
}
// 加精
function digestYes(o){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax&column=digest&value=1&c_id='+c_id+'&id='+t_id, function(data){
		if(data){
			o.html('取消精华');
			$('.theme-title > i').removeClass().addClass('digest');
			o.unbind().click(function(){
				digestNo(o);
			});
		}
	});
}
// 取消加精
function digestNo(o){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax&column=digest&value=0&c_id='+c_id+'&id='+t_id, function(data){
		if(data){
			o.html('精华');
			$('.theme-title > i').removeClass().addClass('normal');
			o.unbind().click(function(){
				digestYes(o);
			});
		}
	});
}
// 置顶
function topYes(o){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax&column=top&value=1&c_id='+c_id+'&id='+t_id, function(data){
		if(data){
			o.html('取消置顶');
			$('.theme-title > i').removeClass().addClass('top');
			o.unbind().click(function(){
				topNo(o);
			});
		}
	});
}
// 取消置顶
function topNo(o){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax&column=top&value=0&c_id='+c_id+'&id='+t_id, function(data){
		if(data){
			o.html('置顶');
			$('.theme-title > i').removeClass().addClass('normal');
			o.unbind().click(function(){
				topYes(o);
			});
		}
	});
}
// 关闭
function shutYes(o){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax&column=shut&value=1&c_id='+c_id+'&id='+t_id, function(data){
		if(data){
			o.html('开启');
			$('.theme-title > i').removeClass().addClass('close');
			o.unbind().click(function(){
				shutNo(o);
			});
			$('.quick-reply').prepend('<div class="ban">本话题已经关闭</div>');
		}
	});
}
// 开启
function shutNo(o){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax&column=shut&value=0&c_id='+c_id+'&id='+t_id, function(data){
		if(data){
			o.html('关闭');
			$('.theme-title > i').removeClass().addClass('normal');
			o.unbind().click(function(){
				shutYes(o);
			});
			$('.quick-reply').find('.ban:first').remove();
		}
	});
}
// 禁言
function speakNo(m_id){
	_uri = CIRCLE_SITE_URL+'/index.php?act=manage&op=ajax_nospeak&value=0&c_id='+c_id+'&m_id='+m_id;
	ajaxget(_uri);
}
// 删除回复