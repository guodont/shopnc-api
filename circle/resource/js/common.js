$(function(){
	$('.my-group').mouseover(function(){
		var $this = $(this);
		if(!$this.hasClass('t')){
			$this.addClass('t');
			if(_ISLOGIN){
				$.getJSON(CIRCLE_SITE_URL+'/index.php?act=index&op=myjoinedcircle', function(data){
					if(data){
						$.each(data, function(e,d){
							$i = '';
							if(d.is_identity == 1){$i = "<span class=\"c\" title=\"圈主\"></span>";}else if(d.is_identity == 2){$i = "<span class=\"a\" title=\"管理员\"></span>";}
							$('<a href="'+CIRCLE_SITE_URL+'/index.php?act=group&c_id='+d.circle_id+'">'+d.circle_name+$i+'</a>').appendTo('span[nctype="span-mygroup"]');
						});
					}else{
						$('<a href="javascript:void(0);">暂未加入过</a>').appendTo('span[nctype="span-mygroup"]');
					}
				});
			}
		}
	});
	$('a[nctype="login"]').click(function(){
		login_dialog();
	});
	$('#topNav').find('li[class="cart"]').mouseover(function(){
		// 运行加载购物车
		load_cart_information();
		$(this).unbind();
	});
	
	// 创建圈子
	$('a[nctype="create_circle"]').click(function(){
		if(_ISLOGIN == 0){
			login_dialog();
		}else{
			window.location.href=CIRCLE_SITE_URL+"/index.php?act=index&op=add_group";
		}
	});
	
    //返回到顶部
    backTop=function (btnId){
	var btn=document.getElementById(btnId);
	var d=document.documentElement;
	window.onscroll=set;
	btn.onclick=function (){
		btn.style.display="none";
		window.onscroll=null;
		this.timer=setInterval(function(){
			d.scrollTop-=Math.ceil(d.scrollTop*0.1);
			if(d.scrollTop==0) clearInterval(btn.timer,window.onscroll=set);
		},10);
	};
	function set(){btn.style.display=d.scrollTop?'block':"none"}
	};
	backTop('gotop');
	
	$.fn.quick_reply = function(options){
		var defaults = {	
				reply		: '',
				reply_box	: '',
				id			: '',
				c_id		: '',
				identity	: 3
			}; 
		var options = $.extend(defaults, options);
		this.each(function(){
			$(this).click(function(){
				if(_ISLOGIN){
					if(options.identity  == 1 || options.identity == 2 || options.identity == 3){ 	// 成员点击展开回复
						if(options.reply_box.css('display') == 'none'){
							if(!options.reply.hasClass('t')){
								options.reply_box.show();
								// 快速回复
								$.getJSON(CIRCLE_SITE_URL+'/index.php?act=theme&op=ajax_quickreply&c_id='+options.c_id+'&t_id='+options.id, function(data){
									
									// 头像  快速回复栏
									if(data.c_istalk){
										$('<div class="member-avatar-m"><img src="'+data.member_avatar+'" /></div>').appendTo(options.reply);
										var form = $('<form method="post" id="reply_form'+options.id+'" action="'+data.form_action+'"></form>');
										$('<input type="hidden" value="ok" name="form_submit" />').appendTo(form);
										$('<div class="content"><textarea name="replycontent" id="textarea'+options.id+'" ></textarea></div>').appendTo(form);
										$('<span class="count" id="charcount'+options.id+'"></span>').appendTo(form);										
										$('<div class="bottom"><a class="submit-btn" href="javascript:void(0);" nctype="reply_submit">发表回复</a><div nctype="warning" id="warning"></div></div>').appendTo(form);						
										
										
										form.find('a[nctype="reply_submit"]').click(function(){
										    form.submit();
									    }).end().appendTo(options.reply);
										
										$('#textarea'+options.id).charCount({
											allowed: 140,
											warning: 10,
											counterContainerID:'charcount'+options.id,
											firstCounterText:'还可以输入',
											endCounterText:'字',
											errorCounterText:'已经超出'
										});
										
										form.validate({
									        errorLabelContainer: form.find('div[nctype="warning"]'),
									    	submitHandler:function(form){
									    		ajaxpost('reply_form'+options.id, data.form_action, '', 'onerror');
									    	},
									        rules : {
									        	replycontent : {
									                required : true,
									                minlength: data.c_contentleast,
									                maxlength : 140
									            }
									        },
									        messages : {
									        	replycontent  : {
									                required : '请填写内容',
									                minlength: data.c_contentmsg,
									                maxlength : '不能超过140个字符'
									            }
									        }
									    });
									}else{
										//  Reply function does close,put Reply's div hidden.
										options.reply.hide();
									}
									
									// 回复内容部分
									if(data.reply_list){
										$.each(data.reply_list, function(e, d){
											var reply_list = $('<div class="quick-reply-list-2"></div>');
											$('<div class="member-avatar-s"><img src="'+d.member_avatar+'" /></div>').appendTo(reply_list);
											d.reply_id = parseInt(d.reply_id);d.reply_id = ((d.reply_id > 9)?'9+':d.reply_id+'F');
											$('<div class="floor">'+d.reply_id+'</div><div class="line">&nbsp;</div>').appendTo(reply_list);
											var reply_dl = $('<dl></dl>');
											$('<dt class="member-name">'+d.member_name+'<span class="reply-date">'+d.reply_addtime+'</span></dt>').appendTo(reply_dl);
											$('<dd>'+d.reply_content+'</dd>').appendTo(reply_dl);
											reply_dl.appendTo(reply_list);
											reply_list.appendTo(options.reply_box);
										});
									}
									
									options.reply.addClass('t');
								});
							}else{
								options.reply_box.show();
							}
						}else{
							options.reply_box.hide();
						}
					}else{
						// 点击展开申请
						CUR_DIALOG = ajax_form('apply_join','申请加入','index.php?act=group&op=apply&c_id='+options.c_id,520,1);
					}
				}else{
					login_dialog();		
				}
			});
		});	
	}
	// Membership card
	$('[nctype="mcard"]').membershipCard({type:'circle'});
});
//弹出框登录
function login_dialog(){
		$.show_nc_login({
			nchash:NC_HASH,
			formhash:NC_TOKEN,
			anchor:'circle_comment_flag'
		});	
//    CUR_DIALOG = ajax_form('login','登录',CIRCLE_SITE_URL+'/index.php?act=login&inajax=1',360,1);
}

//赞
function likeYes(o,options){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=theme&op=ajax_likeyes&c_id='+options.c_id+'&t_id='+options.t_id, function(data){
		if(data){
			var likeCount = parseInt(o.find('em[nctype="like"]').html())+1;
			o.html('取消赞(<em nctype="like">'+likeCount+'</em>)');
			o.unbind().click(function(){
				likeNo(o,options);
			});
		}
	});
}
//取消赞
function likeNo(o,options){
	$.getJSON(CIRCLE_SITE_URL+'/index.php?act=theme&op=ajax_likeno&c_id='+options.c_id+'&t_id='+options.t_id, function(data){
		if(data){
			var likeCount = parseInt(o.find('em[nctype="like"]').html())-1;
			o.html('赞(<em nctype="like">'+likeCount+'</em>)');
			o.unbind().click(function(){
				likeYes(o,options);
			});
		}
	});
}


$(document).ready(function(){
  $('input[type="radio"][name!="levelset"]').on('ifChecked', function(event){
	if(this.id == 'radio-0'){
			$('.select-module').show();
		}else{
			$('.select-module').hide();
		}
  }).iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  });
  $('input[type="checkbox"][class!="checkall"][class!="checkitem"]').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  });

});