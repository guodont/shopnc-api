<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>闲置页面设置</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>SEO设置</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="flea_site_name">闲置首页名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="flea_site_name" name="flea_site_name" value="<?php echo $output['list_setting']['flea_site_name'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['web_name_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="flea_site_title">闲置首页标题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="flea_site_title" name="flea_site_title" value="<?php echo $output['list_setting']['flea_site_title'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['web_title_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="flea_site_description">闲置首页描述:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="flea_site_description" rows="6" class="tarea" id="flea_site_description"><?php echo $output['list_setting']['flea_site_description'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_description_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required">闲置首页关键字:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="flea_site_keywords" name="flea_site_keywords" value="<?php echo $output['list_setting']['flea_site_keywords'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_keyword_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="flea_hot_search">闲置首页热门搜索:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="flea_hot_search" name="flea_hot_search" value="<?php echo $output['list_setting']['flea_hot_search'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['field_notice'];?></span></td>
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
<script type="text/javascript">
// 模拟网站LOGO上传input type='file'样式
$(function(){
    var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
	$(textButton).insertBefore("#site_logo");
	$("#site_logo").change(function(){
	$("#textfield1").val($("#site_logo").val());
});
// 上传图片类型
$('input[class="type-file-file"]').change(function(){
	var filepatd=$(this).val();
	var extStart=filepatd.lastIndexOf(".");
	var ext=filepatd.substring(extStart,filepatd.lengtd).toUpperCase();		
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("<?php echo $lang['default_img_wrong'];?>");
				$(this).attr('value','');
			return false;
		}
	});
});
</script> 
