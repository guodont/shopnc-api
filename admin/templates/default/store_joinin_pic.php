<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>开店首页</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '图片及提示';?></span></a></li>
        <li><a href="index.php?act=store_joinin&op=help_list"><span><?php echo '入驻指南';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>可以传三张图片，在开店首页头部显示，建议使用1920px * 350px</li>
            <li>“置空”会删除图片，提交保存后生效</li>
            <li>所填写的“贴心提示”会出现在开店首页图片下方</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="space">
          <th colspan="2">图片上传:</th>
        </tr>
        <?php for ($i = 1;$i <= $output['size'];$i++) { ?>
        <tr class="noborder">
          <td colspan="2"><label>IMG<?php echo $i;?>:</label>
            <a href="JavaScript:void(0);" onclick="clear_pic(<?php echo $i;?>)"><span>置空</span></a></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <?php if(!empty($output['pic'][$i])){ ?>
            <span class="type-file-show" id="show<?php echo $i;?>"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.'/'.$output['pic'][$i];?>">
            <img class="show_image" title="<?php echo L('login_click_open');?>" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span>
            <?php } ?>
            <span class="type-file-box">
            <input type="text" name="textfield" id="textfield<?php echo $i;?>" class="type-file-text" />
            <input type="button" name="button" id="button<?php echo $i;?>" value="" class="type-file-button" />
            <input name="pic<?php echo $i;?>" type="file" class="type-file-file" id="pic<?php echo $i;?>" size="30" hidefocus="true">
            <input type="hidden" name="show_pic<?php echo $i;?>" id="show_pic<?php echo $i;?>" value="<?php echo $output['pic'][$i];?>" />
            </span></td>
          <td class="vatop tips"></td>
        </tr>
        <?php } ?>
        <tr class="space">
          <th colspan="2"><label for="show_txt">贴心提示:</label></th>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="show_txt" rows="6" class="tarea" id="show_txt" ><?php echo $output['show_txt'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"></span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
$(function(){
    $('input[class="type-file-file"]').change(function(){
    	var pic=$(this).val();
    	var extStart=pic.lastIndexOf(".");
    	var ext=pic.substring(extStart,pic.lengtd).toUpperCase();
    	$(this).parent().find(".type-file-text").val(pic);
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
		    alert("<?php echo $lang['default_img_wrong'];?>");
			$(this).attr('value','');
			return false;
		}
	});
    $('.nyroModal').nyroModal();
});
function clear_pic(n){//置空
	$("#show"+n+"").remove();
	$("#textfield"+n+"").val("");
	$("#pic"+n+"").val("");
	$("#show_pic"+n+"").val("");
}
</script>
