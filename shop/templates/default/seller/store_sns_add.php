<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block alert-info mt10"> <strong><?php echo $lang['store_sns_type'].$lang['nc_colon'];?></strong>
  <label class="mr20">
    <input type="radio" name="sns_type" value="normal" id="sns_normal" checked="checked" class="vm mr5" />
    <?php echo $lang['store_sns_normal'];?></label>
  <label class="mr20">
    <input type="radio" name="sns_type" value="recommend" id="sns_recommend" class="vm mr5" />
    <?php echo $lang['store_sns_recommend'];?></label>
  <label class="mr20">
    <input type="radio" name="sns_type" value="hotsell" id="sns_hotsell" class="vm mr5" />
    <?php echo $lang['store_sns_hotsell'];?></label>
  <label class="mr20">
    <input type="radio" name="sns_type" value="new" id="sns_new" class="vm mr5" />
    <?php echo $lang['store_sns_new'];?></label>
</div>
<div class="ncsc-form-default" nctype="normal" style=" display: none;">
  <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="normal_form">
    <input type="hidden" name="type" value="2" />
    <dl>
      <dt><?php echo $lang['store_sns_image'].$lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-upload-thumb store-sns-pic">
          <p><img nctype="normal_img" src="<?php echo SHOP_TEMPLATES_URL?>/images/member/default_image.png"/></p>
          <input type="hidden" name="sns_image" id="sns_image" value="" />
        </div>
        <div class="handle">
          <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
            <input type="file" hidefocus="true" size="1" class="input-file" name="normal_file" id="normal_file">
            </span>
            <p><i class="icon-upload-alt"></i>图片上传</p>
            </a> </div>
            <a class="ncsc-btn mt5" nctype="get_img" href="index.php?act=store_album&op=pic_list&item=store_sns_normal"><i class="icon-picture"></i>从图片空间选择</a> <a href="javascript:void(0);" nctype="del_img" class="ncsc-btn ml5 mt5" style="display: none;"><i class="icon-circle-arrow-up"></i>关闭相册</a></div>
        <div id="get_img_ajaxContent" class="ajax-albume"></div>
        <p class="hint"><?php printf($lang['store_sns_normal_tips'],intval(C('image_max_filesize'))/1024);?></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="content" class="textarea w450 h100" id="content_normal" nctype="normal"></textarea>
        <p class="w450"><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"normal"}' class="ncsc-btn-mini ncsc-btn-orange"><i class="icon-smile"></i><?php echo $lang['store_sns_face'];?></a> <span id="weibocharcount_normal" class="weibocharcount"></span></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" /></label>
    </div>
  </form>
</div>
<div class="ncsc-form-default" nctype="recommend" style="display: none;">
  <div class="alert">
    <h4><?php echo $lang['store_sns_explain'].$lang['nc_colon'];?></h4>
    <ul>
      <li><?php echo $lang['store_sns_explain_notes1'];?></li>
    </ul>
  </div>
  <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="recommend_form">
    <input type="hidden" name="type" value="9" />
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_sns_goods'].$lang['nc_colon']?></dt>
      <dd>
        <p>
          <input type="text" class="text w400" name="goods_url" value="" placeholder="<?php echo $lang['store_sns_input_goods_url'];?>" />
        </p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="content" class="textarea w400 h100" nctype="recommend" id="content_recommend"></textarea>
        <p class="w450"><span class="smile"><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"recommend"}' class="ncsc-btn-mini ncsc-btn-orange"><i class="icon-smile"></i><?php echo $lang['store_sns_face'];?></a> </span> <span id="weibocharcount_recommend" class="weibocharcount"></span></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" /></label>
    </div>
  </form>
</div>
<div class="ncsc-form-default" nctype="hotsell" style="display: none;" >
  <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="hotsell_form">
    <input type="hidden" name="type" value="10" />
    <?php if(!empty($output['hotsell_list']) && is_array($output['hotsell_list'])){  ?>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_sns_hotsell_dt'].$lang['nc_colon'];?></dt>
      <dd>
        <div class="div-goods-select">
          <div class="search-result" style="width:739px;">
            <ul class="goods-list" style=" width:760px;">
              <?php foreach ($output['hotsell_list'] as $val){?>
              <li>
                <div class="goods-thumb"><img src="<?php echo cthumb($val['goods_image'], 240, $val['store_id']);?>" /></div>
                <dl class="goods-info">
                  <dt>
                    <input type="checkbox" class="checkbox" name="goods_id[]" value="<?php echo $val['goods_id'];?>" />
                    <?php echo $val['goods_name'];?></dt>
                </dl>
              </li>
              <?php }?>
            </ul>
          </div>
        </div>
        <p class="hint"><?php echo $lang['store_sns_hotsell_hint'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="content" class="textarea w450" nctype="hotsell" id="content_hotsell"></textarea>
        <p class="w450"><span class="smile"> <a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"hotsell"}' class="ncsc-btn-mini ncsc-btn-orange"><i class="icon-smile"></i><?php echo $lang['store_sns_face'];?></a> </span> <span id="weibocharcount_hotsell" class="weibocharcount"></span></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" /></label>
    </div>
    <?php }else{?>
    <div class="warning-option"><i class="icon-warning-sign">&nbsp;</i><span><span><?php echo $lang['store_sns_hotsell_null'];?>
      <label for="sns_recommend"><a><?php echo $lang['store_sns_self_recommend'];?></a></label>
      </span></div>
    <?php }?>
  </form>
</div>
<div class="ncsc-form-default" nctype="new" style="display: none;" >
  <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="new_form">
    <input type="hidden" name="type" value="3" />
    <?php if(!empty($output['new_list']) && is_array($output['new_list'])){  ?>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_sns_recommend_dt'].$lang['nc_colon'];?></dt>
      <dd>
        <div class="div-goods-select">
          <div class="search-result" style="width:739px;">
            <ul class="goods-list" style=" width:760px;">
              <?php foreach ($output['new_list'] as $val){?>
              <li>
                <div class="goods-thumb"><img src="<?php echo cthumb($val['goods_image'], 240, $val['store_id']);?>"/></div>
                <dl class="goods-info">
                  <dt>
                    <input type="checkbox" class="checkbox" name="goods_id[]" value="<?php echo $val['goods_id'];?>" />
                    <?php echo $val['goods_name'];?></dt>
                </dl>
              </li>
              <?php }?>
            </ul>
          </div>
        </div>
        <p class="hint"><?php echo $lang['store_recommend_hint'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="content" class="textarea w450" nctype="new" id="content_new"></textarea>
        <p class="w450"><span class="smile"> <a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"new"}' class="ncsc-btn-mini ncsc-btn-orange"><i class="icon-smile"></i><?php echo $lang['store_sns_face'];?></a> </span> <span id="weibocharcount_new" class="weibocharcount"></span></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" /></label>
    </div>
    <?php }else{?>
    <div class="warning-option"><i class="icon-warning-sign">&nbsp;</i><span><?php echo $lang['store_sns_new_null'];?>
      <label for="sns_recommend"><a><?php echo $lang['store_sns_self_recommend'];?></a></label>
      </span> </div>
    <?php }?>
  </form>
</div>
<!-- 表情弹出层 -->
<div id="smilies_div" class="smilies-module"></div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns_store.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies_data.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.caretInsert.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js"></script> 
<script>
$(function(){
	/* ajax添加商品  */
	$('a[nctype="get_img"]').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:SHOP_TEMPLATES_URL+"/images/transparent.gif",
		target:'#get_img_ajaxContent'
	}).click(function(){
	    $(this).hide();
	    $('a[nctype="del_img"]').show();
    });
    $('a[nctype="del_img"]').click(function(){
        $(this).hide();
        $('a[nctype="get_img"]').show();
        $('#get_img_ajaxContent').html('');
    });
	
	$('body').click(function(){ $("#smilies_div").html(''); $("#smilies_div").hide();});
	$('input[name="sns_type"]').each(function(){
		if($(this).attr('checked')){
			$('.ncsc-form-default').hide();
			$('.ncsc-form-default[nctype="'+$(this).val()+'"]').show();
		}
	});
	
	$('input[name="sns_type"]').change(function(){
		$('.ncsc-form-default').hide();
		$('.ncsc-form-default[nctype="'+$(this).val()+'"]').show();
	});

	$('textarea[name="content"]').each(function(){
		$(this).charCount({
			allowed: 140,
			warning: 10,
			counterContainerID:	'weibocharcount_'+$(this).attr('nctype'),
			firstCounterText:	'<?php echo $lang['sns_charcount_tip1'];?>',
			endCounterText:		'<?php echo $lang['sns_charcount_tip2'];?>',
			errorCounterText:	'<?php echo $lang['sns_charcount_tip3'];?>'
		});
	});

	$('#normal_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('normal_form', '', '', 'onerror') 
		},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});
    
	$('#recommend_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('recommend_form', '', '', 'onerror')
		},
		rules : {
			content : {
				required : true
			},
			goods_url : {
				required : true,
				url : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			},
			goods_url : {
				required : '<?php echo $lang['store_sns_input_goods_url'];?>',
				url : '<?php echo $lang['store_sns_input_goods_url'];?>'
			}
		}
	});
    
	$('#hotsell_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			// 验证是否选中商品
			if($('#hotsell_form').find('input[type="checkbox"]:checked').length == 0){
				$('#hotsell_form').find('ul').after('<label class="error" for="content" generated="true"><?php echo $lang['store_sns_choose_goods'];?></label>');
				return false;
			}else{
				$('#hotsell_form').find('ul').next('label').remove();
			}
			ajaxpost('hotsell_form', '', '', 'onerror')
		},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});
    
	$('#new_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
    	submitHandler:function(form){
    		// 验证是否选中商品
			if($('#new_form').find('input[type="checkbox"]:checked').length == 0){
				$('#new_form').find('ul').after('<label class="error" for="content" generated="true"><?php echo $lang['store_sns_choose_goods'];?></label>');
				return false;
			}else{
				$('#new_form').find('ul').next().remove('label');
			}
    		ajaxpost('new_form', '', '', 'onerror')
    	},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});

	// 图片上传js
	$('#normal_file').unbind().live('change', function(){
		$('img[nctype="normal_img"]').attr('src',SHOP_TEMPLATES_URL+"/images/loading.gif");

		$.ajaxFileUpload
		(
			{
				url:'index.php?act=store_sns&op=image_upload',
				secureuri:false,
				fileElementId:'normal_file',
				dataType: 'json',
				data:{id:'normal_file'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefind'){
						$('img[nctype="normal_img"]').attr('src',data.image);
						$('#sns_image').val(data.image);
					}else{
						alert(data.error);
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;

	});
});
//从图片空间中插入图片
function sns_insert(data){
	$('img[nctype="normal_img"]').attr('src',data);
	$('#sns_image').val(data);
}
</script>