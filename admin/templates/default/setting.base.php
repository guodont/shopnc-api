<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--//zmr>v30-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_set'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="site_name"><?php echo $lang['web_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_name" name="site_name" value="<?php echo $output['list_setting']['site_name'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['web_name_notice'];?></span></td>
        </tr>
     
         

		
		
        <tr>
          <td colspan="2" class="required"><label for="site_logo"><?php echo $lang['site_logo'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['list_setting']['site_logo']);?>"></div>
            </span><span class="type-file-box"><input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="site_logo" type="file" class="type-file-file" id="site_logo" size="30" hidefocus="true" nc_type="change_site_logo">
            </span></td>
          <td class="vatop tips"><span class="vatop rowform">默认网站LOGO,通用头部显示，最佳显示尺寸为240*60像素</span></td>
        </tr>
        
        <!--//zmr>v30-->
         <tr>
          <td colspan="2" class="required"><label for="site_mobile_logo">手机网站LOGO:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview" style="background-color:red"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['list_setting']['site_mobile_logo']);?>"></div>
            </span><span class="type-file-box"><input type='text' name='textfield' id='textfield8' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="site_mobile_logo" type="file" class="type-file-file" id="site_mobile_logo" size="30" hidefocus="true" nc_type="change_site_mobile_logo">
            </span></td>
          <td class="vatop tips"><span class="vatop rowform">默认手机网站LOGO,通用头部显示，最佳显示尺寸为116*43像素</span></td>
        </tr>
        
        
        <tr>
          <td colspan="2" class="required"><label for="site_logo"><?php echo $lang['member_logo'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['list_setting']['member_logo']);?>"></div>
            </span><span class="type-file-box"><input type='text' name='textfield2' id='textfield2' class='type-file-text' /><input type='button' name='button2' id='button2' value='' class='type-file-button' />
            <input name="member_logo" type="file" class="type-file-file" id="member_logo" size="30" hidefocus="true" nc_type="change_member_logo">
            </span></td>
          <td class="vatop tips"><span class="vatop rowform">网站小尺寸LOGO，会员个人主页显示，最佳显示尺寸为200*40像素</span></td>
        </tr>
        <!-- 商家中心logo -->
        <tr>
          <td colspan="2" class="required"><label for="seller_center_logo">商家中心Logo:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['list_setting']['seller_center_logo']);?>"></div>
            </span><span class="type-file-box"><input type='text' name='textfield' id='textfield3' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="seller_center_logo" type="file" class="type-file-file" id="seller_center_logo" size="30" hidefocus="true" nc_type="change_seller_center_logo">
            </span></td>
          <td class="vatop tips"><span class="vatop rowform">商家中心LOGO，最佳显示尺寸为150*40像素，请根据背景色选择使用图片色彩</span></td>
        </tr>
        <!-- 商家中心logo -->
	  <!-- 商城底部微信二维码 -->
        <tr>
          <td colspan="2" class="required"><label for="site_logowx"><?php echo $lang['site_bank_weixinerwei'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['list_setting']['site_logowx']);?>"></div>
            </span><span class="type-file-box"><input type='text' name='textfield' id='textfield5' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="site_logowx" type="file" class="type-file-file" id="site_logowx" size="30" hidefocus="true" nc_type="change_site_logowx">
            </span></td>
          <td class="vatop tips"><span class="vatop rowform">放在网站右上角顶部及首页底部右下角,最佳显示尺寸为66*66像素</span></td>
        </tr>	
	 <!-- 商城底部微信二维码 -->
        <tr>
          <td colspan="2" class="required"><label for="icp_number"><?php echo $lang['icp_number'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="icp_number" name="icp_number" value="<?php echo $output['list_setting']['icp_number'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['icp_number_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="site_phone"><?php echo $lang['site_phone'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_phone" name="site_phone" value="<?php echo $output['list_setting']['site_phone'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_phone_notice'];?></span></td>
        </tr>
	
	
	
	<!-- 400 电话 -->		
<tr>
          <td colspan="2" class="required"><label for="site_tel400"><?php echo $lang['site_tel400'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_tel400" name="site_tel400" value="<?php echo $output['list_setting']['site_tel400'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['icp_number_notice400'];?></span></td>
        </tr>
		<!-- 400 电话 -->	

	
        <!--
        平台付款账号，前台暂时无调用
        <tr>
          <td colspan="2" class="required"><label for="site_bank_account"><?php echo $lang['site_bank_account'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_bank_account" name="site_bank_account" value="<?php echo $output['list_setting']['site_bank_account'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_bank_account_notice'];?></span></td>
        </tr>
        -->
        <tr>
          <td colspan="2" class="required"><label for="site_email"><?php echo $lang['site_email'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_email" name="site_email" value="<?php echo $output['list_setting']['site_email'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_email_notice'];?></span></td>
        </tr>
         <tr>
          <td colspan="2" class="required"><label for="statistics_code"><?php echo $lang['flow_static_code'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="statistics_code" rows="6" class="tarea" id="statistics_code"><?php echo $output['list_setting']['statistics_code'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['flow_static_code_notice'];?></span></td>
        </tr> 
        <tr>
          <td colspan="2" class="required"><label for="time_zone"> <?php echo $lang['time_zone_set'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="time_zone" name="time_zone">
              <option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
              <option value="-11">(GMT -11:00) Midway Island, Samoa</option>
              <option value="-10">(GMT -10:00) Hawaii</option>
              <option value="-9">(GMT -09:00) Alaska</option>
              <option value="-8">(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
              <option value="-7">(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
              <option value="-6">(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
              <option value="-5">(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
              <option value="-4">(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
              <option value="-3.5">(GMT -03:30) Newfoundland</option>
              <option value="-3">(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
              <option value="-2">(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
              <option value="-1">(GMT -01:00) Azores, Cape Verde Islands</option>
              <option value="0">(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
              <option value="1">(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
              <option value="2">(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
              <option value="3">(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi</option>
              <option value="3.5">(GMT +03:30) Tehran</option>
              <option value="4">(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
              <option value="4.5">(GMT +04:30) Kabul</option>
              <option value="5">(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
              <option value="5.5">(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
              <option value="5.75">(GMT +05:45) Katmandu</option>
              <option value="6">(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
              <option value="6.5">(GMT +06:30) Rangoon</option>
              <option value="7">(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
              <option value="8">(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
              <option value="9">(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
              <option value="9.5">(GMT +09:30) Adelaide, Darwin</option>
              <option value="10">(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
              <option value="11">(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
              <option value="12">(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
            </select></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['set_sys_use_time_zone'];?>+8</span></td>
        </tr>              
        <tr>
          <td colspan="2" class="required"><?php echo $lang['site_state'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="site_status1" class="cb-enable <?php if($output['list_setting']['site_status'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="site_status0" class="cb-disable <?php if($output['list_setting']['site_status'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="site_status1" name="site_status" <?php if($output['list_setting']['site_status'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="site_status0" name="site_status" <?php if($output['list_setting']['site_status'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_state_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="closed_reason"><?php echo $lang['closed_reason'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="closed_reason" rows="6" class="tarea" id="closed_reason" ><?php echo $output['list_setting']['closed_reason'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['closed_reason_notice'];?></span></td>
        </tr>
      </tbody>
      <tfoot id="submit-holder">
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
	$("#site_logo").change(function(){
		$("#textfield1").val($(this).val());
	});
	//zmr>v30
	$("#site_mobile_logo").change(function(){
		$("#textfield8").val($(this).val());
	});
	$("#member_logo").change(function(){
		$("#textfield2").val($(this).val());
	});
	$("#seller_center_logo").change(function(){
		$("#textfield3").val($(this).val());
	});
	$("#site_logowx").change(function(){
		$("#textfield5").val($(this).val());
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
$('#time_zone').attr('value','<?php echo $output['list_setting']['time_zone'];?>');	
});
</script>
