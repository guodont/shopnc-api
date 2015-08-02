<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.evo-color div { font-size: 12px; line-height: normal;
}
.evo-color span { font-size: 12px !important; line-height: normal !important;}
</style>


<div class="tabmenu">
  <?php include template('layout/submenu'); ?>
</div>
<div class="ncsc-form-default">
  <form method="post" enctype="multipart/form-data" action="index.php?act=store_album&op=store_watermark" id="wm_form">
    <input type="hidden" name="image_quality" value="100" />
    <input type="hidden" name="image_transition" value="20" />
    <input type="hidden" name="wm_text_angle" value="0" />
    <dl>
      <dt><?php echo $lang['store_watermark_pic'];?></dt>
      <dd>
        <?php if(!empty($output['store_wm_info']['wm_image_name'])){?>
        <div class="ncsc-upload-thumb watermark-pic"><p><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_WATERMARK.DS.$output['store_wm_info']['wm_image_name'];?>" id="imgView"/></p><a href="javascript:void(0);" id="del_image" title="<?php echo $lang['store_watermark_del_pic'];?>">X</a>
          <input type="hidden" id="is_del_image" name="is_del_image" value=""/>
        </div>
        <?php }else{?>
        <div class="ncsc-upload-thumb watermark-pic"><p><i class="icon-picture"></i></p></div>
        <?php }?>
        <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="image" id="image" nc_type="logo"/>
          </span>
          <p><i class="icon-upload-alt"></i>图片上传</p>
          </a> </div>
        <p class="hint"><?php echo $lang['store_watermark_choose_pic'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_watermark_pic_pos'];?></dt>
      <dd>
        <ul class="ncsc-watermark-pos" id="wm_image_pos">
          <li>
            <input type="radio" name="image_pos" value="1"<?php if($output['store_wm_info']['wm_image_pos'] == 1){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos1'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="2"<?php if($output['store_wm_info']['wm_image_pos'] == 2){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos2'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="3"<?php if($output['store_wm_info']['wm_image_pos'] == 3){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos3'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="4"<?php if($output['store_wm_info']['wm_image_pos'] == 4){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos4'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="5"<?php if($output['store_wm_info']['wm_image_pos'] == 5){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos5'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="6"<?php if($output['store_wm_info']['wm_image_pos'] == 6){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos6'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="7"<?php if($output['store_wm_info']['wm_image_pos'] == 7){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos7'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="8"<?php if($output['store_wm_info']['wm_image_pos'] == 8){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos8'];?></label>
          </li>
          <li>
            <input type="radio" name="image_pos" value="9"<?php if($output['store_wm_info']['wm_image_pos'] == 9){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_pic_pos9'];?></label>
          </li>
        </ul>
        <p class="hint"><?php echo $lang['store_watermark_choose_pos'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_watermark_text'];?></dt>
      <dd>
        <p>
          <textarea name="wm_text" class="textarea w180" ><?php echo $output['store_wm_info']['wm_text'];?></textarea>
        </p>
        <p class="hint"><?php echo $lang['store_watermark_text_notice'];?>,建议用字母和数字</p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_watermark_text_size'];?></dt>
      <dd><input id="wm_text_size" class="text w40"  type="text" name="wm_text_size" value="<?php echo $output['store_wm_info']['wm_text_size'];?>"/><em class="add-on">px</em>
        <p class="hint"><?php echo $lang['store_watermark_text_size_notice'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_watermark_text_color'];?></dt>
      <dd>
        <p><div class="w160">
          <input id="wm_text_color"  class="text w100"  type="text"  name="wm_text_color" value="<?php echo $output['store_wm_info']['wm_text_color']?$output['store_wm_info']['wm_text_color']:"#CCCCCC"; ?>"/>
        </div>
         <div id="colorpanel" style="display:none;width:253px;height:177px;"></div></p>
         <p class="hint" style="clear: both;"><?php echo $lang['store_watermark_text_color_notice'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_watermark_text_font'];?></dt>
      <dd>
        <p>
          <select name="wm_text_font" class="w80">
            <?php foreach($output['file_list'] as $key=>$value){?>
            <option value="<?php echo $key;?>"<?php if($output['store_wm_info']['wm_text_font'] == $key){echo ' selected="selected"';}?>><?php echo $value;?></option>
            <?php }?>
          </select>
        </p>
        <p class="hint"><?php echo $lang['store_watermark_text_font_notice'];?>,如果文字使用汉字则管理员要安装中文的字体</p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_watermark_text_pos'];?></dt>
      <dd>
        <ul class="ncsc-watermark-pos" id="wm_text_pos">

          <li>
            <input type="radio" name="wm_text_pos" value="1"<?php if($output['store_wm_info']['wm_text_pos'] == 1){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos1'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="2"<?php if($output['store_wm_info']['wm_text_pos'] == 2){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos2'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="3"<?php if($output['store_wm_info']['wm_text_pos'] == 3){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos3'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="4"<?php if($output['store_wm_info']['wm_text_pos'] == 4){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos4'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="5"<?php if($output['store_wm_info']['wm_text_pos'] == 5){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos5'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="6"<?php if($output['store_wm_info']['wm_text_pos'] == 6){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos6'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="7"<?php if($output['store_wm_info']['wm_text_pos'] == 7){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos7'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="8"<?php if($output['store_wm_info']['wm_text_pos'] == 8){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos8'];?></label>
          </li>
          <li>
            <input type="radio" name="wm_text_pos" value="9"<?php if($output['store_wm_info']['wm_text_pos'] == 9){echo ' checked';}?>/>
            <label><?php echo $lang['store_watermark_text_pos9'];?> </label>
          </li>
        </ul>
      </dd>
    </dl>
    
    
    
    <div class="bottom">
      <input type="hidden" name="form_submit" value="ok" />
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_watermark_submit'];?>" /></label>
    </div>
  </form>
</div>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/colorpicker/evol.colorpicker.css" rel="stylesheet" type="text/css">
<script src="<?php echo RESOURCE_SITE_URL;?>/js/colorpicker/evol.colorpicker.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script>
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(function(){
    $("div").cssRadio();
    $('#wm_text_color').colorpicker({showOn:'both'});
    $('#wm_text_color').parent().css("width",'');
    $('#wm_text_color').parent().addClass("color");
	$('#del_image').click(function (){
		var result = confirm('<?php echo $lang['store_watermark_del_pic_confirm'];?>');
		if (result)
		{
			$('#image').css('display','none');
			$('#del_image').css('display','none');
			$('#is_del_image').val('ok');
			$('#wm_form').submit();
		}
	});
	$('#wm_form').validate({
    	submitHandler:function(form){
    		ajaxpost('wm_form', '', '', 'onerror')
    	},
        rules : {
			wm_text_size : {
				required : true,
				number : true
			},
			wm_text_color : {
				required : true,
				maxlength : 7
			}
        },
        messages : {
			wm_text_size : {
				required : '<?php echo $lang['store_watermark_text_size_null'];?>',
				number : '<?php echo $lang['store_watermark_text_size_number'];?>'
			},
			wm_text_color : {
				required : '<?php echo $lang['store_watermark_text_color_null'];?>',
				maxlength : '<?php echo $lang['store_watermark_text_color_max'];?>'
			}
        }
    });
});

jQuery.fn.cssRadio = function () {
    $(":input[type=radio] + label").each( function(){
            if ( $(this).prev()[0].checked )
                $(this).addClass("checked");
            })
        .hover(
            function() { $(this).addClass("over"); },
            function() { $(this).removeClass("over"); }
            )
        .click( function() {
             var contents = $(this).parent().parent(); /*多组控制 关键*/
            $(":input[type=radio] + label", contents).each( function() {
                $(this).prev()[0].checked=false;
                $(this).removeClass("checked");
            });
            $(this).prev()[0].checked=true;
             $(this).addClass("checked");
            }).prev().hide();
};
</script>