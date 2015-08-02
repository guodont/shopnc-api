<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['upload_set'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="form" method="post" enctype="multipart/form-data" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="site_name"><?php echo $lang['image_dir_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input id="image_dir_type_0" name="image_dir_type" type="radio" style="margin-bottom:6px;" value="1"<?php echo $output['list_setting']['image_dir_type'] == '1' ? ' checked="checked"' : '' ;?>/>
                <label for="image_dir_type_0"><?php echo $lang['image_dir_type_0'];?></label>
              </li>
              <li>
                <input id="image_dir_type_1" name="image_dir_type" type="radio" style="margin-bottom:6px;" value="2"<?php echo $output['list_setting']['image_dir_type'] == '2' ? ' checked="checked"' : '' ;?>/>
                <label for="image_dir_type_1"><?php echo $lang['image_dir_type_1'];?></label>
              </li>
              <li>
                <input id="image_dir_type_2" name="image_dir_type" type="radio" style="margin-bottom:6px;" value="3"<?php echo $output['list_setting']['image_dir_type'] == '3' ? ' checked="checked"' : '' ;?>/>
                <label for="image_dir_type_2"><?php echo $lang['image_dir_type_2'];?></label>
              </li>
              <li>
                <input id="image_dir_type_3" name="image_dir_type" type="radio" style="margin-bottom:6px;" value="4"<?php echo $output['list_setting']['image_dir_type'] == '4' ? ' checked="checked"' : '' ;?>/>
                <label for="image_dir_type_3"><?php echo $lang['image_dir_type_3'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
		<tr>
          <td colspan="2" class="required"><label for="image_max_filesize"><?php echo $lang['upload_image_filesize'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $lang['upload_image_file_size'];?>:
            <input id="image_max_filesize" name="image_max_filesize" type="text" class="txt" style="width:30px;" value="<?php echo $output['list_setting']['image_max_filesize'] ? $output['list_setting']['image_max_filesize'] : '1024' ;?>"/>
            KB&nbsp;(1024 KB = 1MB)</td>
          <td class="vatop tips"><?php echo $lang['image_max_size_tips'];?></td>
        </tr>
		<tr>
          <td colspan="2" class="required"><label for="image_allow_ext"><?php echo $lang['image_allow_ext'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="image_allow_ext" name="image_allow_ext" value="<?php echo $output['list_setting']['image_allow_ext'] ? $output['list_setting']['image_allow_ext'] : 'gif,jpeg,jpg,bmp,png,swf,tbi';?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['image_allow_ext_notice'];?></span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
//<!CDATA[
$(function(){
	$('#form').validate({
		rules : {
			image_max_size : {
				number : true,
				maxlength : 4
			},
			image_allow_ext : {
				required : true
			}
		},
		messages : {
			image_max_size : {
				number : '<?php echo $lang['image_max_size_only_num'];?>',
				maxlength : '<?php echo $lang['image_max_size_c_num'];?>'
			},
			image_allow_ext : {
				required : '<?php echo $lang['image_allow_ext_not_null'];?>'
			}
		}
	});
});
//]]>
</script>