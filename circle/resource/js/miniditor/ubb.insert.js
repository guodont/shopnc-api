(function($) {
	$.fn.ncUBB = function(options){
		var defaults = {
				c_id : 0,				// circle id
				t_id : 0,				// theme id
				UBBContent: '',			// content object (required)
				UBBSubmit : '',			// submit button object (required)
				UBBform : '',			// form object (required)
				UBBfileuploadurl : '',	// file upload url (required)
				UBBcontentleast : 0,	// Fill in the contents of the minimal number of characters
				run : ''				// Need immediate execution of a function, multiple use commas
			}; 
		var options = $.extend(defaults, options);
		var c_id = options.c_id; var t_id = options.t_id; var UBBContent = options.UBBContent; var UBBSubmit = options.UBBSubmit;
		var UBBform = options.UBBform; var UBBfileuploadurl = options.UBBfileuploadurl; var UBBcontentleast = options.UBBcontentleast;

		this.each(function() {
			
			if(options.run != '') {eval(options.run);}
			
			var $this = $(this);
			// 加粗
			$this.find('a[nctype="b"]').click(function(){
				UBBContent.inserEitherEndt({
					part_one : '[B]',
					part_two : '[/B]'
				});	
			});
			// 斜体
			$this.find('a[nctype="i"]').click(function(){
				UBBContent.inserEitherEndt({
					part_one : '[I]',
					part_two : '[/I]'
				});	
			});
			// 下划线
			$this.find('a[nctype="u"]').click(function(){
				UBBContent.inserEitherEndt({
					part_one : '[U]',
					part_two : '[/U]'
				});	
			});
			
			// 字体大小颜色
			$this.find('.ubb-layer').children().click(function(){
				var P='';var C=0;var parent=$(this).parent();
				if(parent.hasClass('font-family-layer')){
					P = 'FONT';
					C = $(this).attr('data-param');
				}else if(parent.hasClass('font-size-layer')){
					P = 'FONT-SIZE';
					C = $(this).attr('class').substring(1,3);
				}else if(parent.hasClass('font-color-layer')){
					P = 'FONT-COLOR';
					C = $(this).attr('class').substring(2,8);
				}
				if(P == '' || C == 0){
					return false;
				}
				UBBContent.inserEitherEndt({
					part_one : '['+P+'='+C+']',
					part_two : '[/'+P+']'
				});
			});
			// 表情
			$this.find('.smilier-layer').children().click(function(){
				var C = $(this).children().attr('data-param');
				UBBContent.insert({
					text : '[SMILIER='+C+'/]'
				});
			});
			$this.find('.url-handle').toggle(function(){$(this).find('.url-layer').show()},function(){$(this).find('.url-layer').hide()});
			// hyperlink
			$this.find('.url-layer').find('input[type="submit"]').click(function(){
				var C = $this.find('input[name="content"]').val();
				var U = $this.find('input[name="url"]').val();
				UBBContent.insert({
					text : '[URL='+U+']'+C+'[/URL]'
				});
				$this.find('input[name="content"]').val('');
				$this.find('input[name="url"]').val('');
				$this.find('.url-handle').click();
			});
			$this.find('.flash-handle').toggle(function(){$(this).find('.flash-layer').show()},function(){$(this).find('.flash-layer').hide()});
			$this.find('.flash-layer').find('input[type="submit"]').click(function(){
				var C = $this.find('input[name="flash"]').val();
				UBBContent.insert({
					text : '[FLASH]'+C+'[/FLASH]'
				});
				$this.find('input[name="flash"]').val();
				$this.find('.flash-handle').click();
			});
			
		    // 图片上传
		    $this.find("#test_file").fileupload({
		        dataType: 'json',
		            url: UBBfileuploadurl,
		            add: function (e,data) {
		                $('div[nctype="affix"]').hide();
		            	$.each(data.files, function (index, file) {
		                    $('<li id=' + file.name.replace(/\./g, '_') + '><p class="loading"></p></li>').appendTo('#scrollbar > ul');
		                });
		            	data.submit();
		            },
		            done: function (e,data) {
			            var param = data.result;
		                if(param.msg == 'success'){
		                	updateAffixInsert(param);
		                }else{
		                	$('#' + param.origin_file_name.replace(/\./g, '_')).remove();
		                	checkInsertAffix();
		                }
		            }
		    });
		
			$this.find('a[nctype="chooseGoods"]').click(function(){
				// 已经插入的商品数量计算
				var count = 10 - $('.insert-goods > dl').length; // 0 已经插入的商品数量
				var _uri = CIRCLE_SITE_URL+'/index.php?act=theme&op=choose_goods&c_id='+c_id+'&count='+count;
				CUR_DIALOG = ajax_form("choosegoods", '选择商品', _uri, 510);
			});
		
			$this.find('a[nctype="uploadImage"]').click(function(){
				var _uri = CIRCLE_SITE_URL+'/index.php?act=theme&op=choose_image&c_id='+c_id;
				CUR_DIALOG = ajax_form("uploadimage", '选择图片', _uri, 480);
			});
			// insert affix
		    $this.find('a[nctype="affix_insert"]').click(function(){
				affixInsert($(this));
		    });
		    // delete affix
		    $this.find('a[nctype="affix_delete"]').click(function(){
				affixDelete($(this));
			});
		    // Administrator delete appendage affix
		    $this.find('a[nctype="maffix_delete"]').click(function(){
		    	affixDeleteManage($(this));
			});
		    // delete goods
		    $this.find('.goods-del').click(function(){
				$(this).parent().remove();
				checkInsertGoods();
			});
			// 相册图片插入到话题
			$('a[nctype="imagealbum"]').die().live('click',function(){
				var data_str = $('.choose-image').find('a[nctype="chooseimage"][class="selected"]').attr('data-param'); eval('data_str = ' + data_str);
				if(typeof(data_str) == 'undefined') {return false;}
				insertImgUBB(data_str.img);
				DialogManager.close('uploadimage');
			});
			// 链接地址插入话题
			$('a[nctype="imageurl"]').die().live('click',function(){
				var img = $('input[nctype="imageurl"]').val();
				insertImgUBB(img);
				DialogManager.close('uploadimage');
			});

			// 插入到主题
			$('a[nctype="insertGoods"]').die().live('click',function(){
				insertGoods($('.selected-goods > dd'));
				DialogManager.close('choosegoods');
			});
			
			// 提交表单
			UBBSubmit.click(function(){
				UBBform.submit();
			});
			
			// Senior reply
			$this.find('a[nctype="highReply"]').click(function(){
				_uri = 'index.php?act=theme&op=reply&c_id='+c_id+'&t_id='+t_id;
				window.location.href = _uri;
			});

			/* group */
			// 点击发话题
			$('.thread-layer').find('p').click(function(){
				getUnusedAffix();
				$(this).parents('.thread-layer:first').fadeOut('fast',function(){
					$('.theme-editor').fadeIn('slow');
				});
			});
		});
		function insertImgUBB(C){
			UBBContent.insert({
				text : '[IMG]'+C+'[/IMG]'
			});
		}
		//插入商品
		function insertGoods(o){
			o.each(function(){
				var data_str = $(this).attr('data-param'); eval( "data_str = " + data_str);
				var key = 'k'+$('.insert-goods').find('dl').length;
				$('<dl></dl>').append('<dt class="goods-name">'+data_str.name+'</dt><dd class="goods-pic"><a href="javascript:void(0);"><img src="'+data_str.img+'" /></a></dd><dd class="goods-price"><em>'+data_str.price+'</em></dd><dd class="goods-del">删除</dd>')
					.append('<input type="hidden" name="goods['+key+'][id]" value="'+data_str.id+'" /><input type="hidden" name="goods['+key+'][name]" value="'+data_str.name+'" /><input type="hidden" name="goods['+key+'][price]" value="'+data_str.price+'" /><input type="hidden" name="goods['+key+'][image]" value="'+data_str.image+'" />')
					.append('<input type="hidden" name="goods['+key+'][storeid]" value="'+data_str.storeid+'" /><input type="hidden" name="goods['+key+'][type]" value="'+data_str.type+'" /><input type="hidden" name="goods['+key+'][uri]" value="'+data_str.uri+'" />')
					.appendTo('.insert-goods').find('.goods-del').click(function(){
						$(this).parent().remove();
						checkInsertGoods();
					});
			});
			checkInsertGoods();
		}
		// 验证已插入商品数量，决定$('div[class="insert-goods"]')是否显示
		function checkInsertGoods(){
			var igs = $('.quick-thread').find('.insert-goods');
			var len = igs.children('dl').length;
			if(len > 0){
				igs.fadeIn('slow');
			}else{
				igs.fadeOut('slow');
			}
		}
		// 验证已插入附件数量，决定$('div[nctype="affix"]')是否显示
		function checkInsertAffix(){
			var len = $('div[class="affix"]').find('li').length;
			if(len == 0){
				$('div[nctype="affix"]').show();
			}
		}
		// 附件插图到编辑器
		function affixInsert(o){
			var C = o.attr('data-param');
			insertImgUBB(C);
		}
		// 删除附件
		function affixDelete(o){
			// 删除图片
			var id = o.attr('data-param');
			$.getJSON(CIRCLE_SITE_URL+'/index.php?act=theme&op=delimg&c_id='+c_id+'&id='+id, function(){
				o.parents('li:first').remove();
				checkInsertAffix();
			});
		}
		// Administrator delete appendage affix
		function affixDeleteManage(o){
			// 删除图片
			var id = o.attr('data-param');
			$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=delimg&c_id='+c_id+'&id='+id, function(){
				o.parents('li:first').remove();
				checkInsertAffix();
			});
		}
		// 附件上传插入html中
		function updateAffixInsert(param){
			$('#' + param.origin_file_name.replace(/\./g, '_')).removeAttr('id').html('').append('<p><img src="'+param.file_url+'" /></p>')
			.append('<div class="handle"><a href="javascript:void(0);" nctype="affix_insert" data-param="'+param.file_insert+'"><i class="c"></i>插入</a><a href="javascript:void(0);" nctype="affix_delete" data-param="'+param.file_id+'"><i class="d"></i>删除</a></div>')
			.find('a[nctype="affix_insert"]').click(function(){
				affixInsert($(this));
			}).end().find('a[nctype="affix_delete"]').click(function(){
				affixDelete($(this));
			});
		}
		// get unused affixes
		function getUnusedAffix(){
			var len = $('.affix').find('li').length;
			if(len == 0){
				$.getJSON('index.php?act=theme&op=unused_img&c_id='+c_id, function(data){	// 获取未使用附件
					if(data != null){
						$('div[nctype="affix"]').hide();
						$.each(data, function(i, param){
							$('<li></li>').append('<p><img src="'+param.file_url+'" /></p>')
							.append('<div class="handle"><a href="javascript:void(0);" nctype="affix_insert" data-param="'+param.file_insert+'"><i class="c"></i>插入</a><a href="javascript:void(0);" nctype="affix_delete" data-param="'+param.file_id+'"><i class="d"></i>删除</a></div>')
							.appendTo('#scrollbar > ul')
							.find('a[nctype="affix_insert"]').click(function(){
								affixInsert($(this));
							}).end().find('a[nctype="affix_delete"]').click(function(){
								affixDelete($(this));
							});
						});
					}
				});
			}
		}
	}
})(jQuery);