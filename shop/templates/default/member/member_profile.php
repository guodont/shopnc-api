<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncm-user-profile">
    <div class="user-avatar"><span><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']);?>"></span></div>
    <div class="ncm-default-form fr">
      <form method="post" id="profile_form" action="index.php?act=member_information&op=member">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_info']['member_avatar']; ?>" />
        <dl>
          <dt><?php echo $lang['home_member_username'].$lang['nc_colon'];?></dt>
          <dd>
              <span class="w400"><?php echo $output['member_info']['member_name']; ?>&nbsp;&nbsp;
              <?php if ($output['member_info']['level_name']){ ?>
              <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?></div>
              <?php } ?>
              </span>
              <span>&nbsp;&nbsp;<?php echo $lang['home_member_privacy_set'];?></span>
         </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['home_member_email'].$lang['nc_colon'];?></dt>
          <dd><span class="w400"><?php echo $output['member_info']['member_email']; ?>&nbsp;&nbsp;
            <?php if ($output['member_info']['member_email_bind'] == '1') { ?>
            <a href="index.php?act=member_security&op=auth&type=modify_email">更换邮箱</a>
            <?php } else { ?>
            <a href="index.php?act=member_security&op=auth&type=modify_email">绑定邮箱</a>
            <?php } ?></span><span>
            <select name="privacy[email]">
              <option value="0" <?php if($output['member_info']['member_privacy']['email'] == 0){?>selected="selected"<?php }?>><?php echo $lang['home_member_public'];?></option>
              <option value="1" <?php if($output['member_info']['member_privacy']['email'] == 1){?>selected="selected"<?php }?>><?php echo $lang['home_member_friend'];?></option>
              <option value="2" <?php if($output['member_info']['member_privacy']['email'] == 2){?>selected="selected"<?php }?>><?php echo $lang['home_member_privary']?></option>
            </select>
            </span>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['home_member_truename'].$lang['nc_colon'];?></dt>
          <dd><span class="w400">
            <input type="text" class="text" maxlength="20" name="member_truename" value="<?php echo $output['member_info']['member_truename']; ?>" />
            </span><span>
            <select name="privacy[truename]">
              <option value="0" <?php if($output['member_info']['member_privacy']['truename'] == 0){?>selected="selected"<?php }?>><?php echo $lang['home_member_public'];?></option>
              <option value="1" <?php if($output['member_info']['member_privacy']['truename'] == 1){?>selected="selected"<?php }?>><?php echo $lang['home_member_friend'];?></option>
              <option value="2" <?php if($output['member_info']['member_privacy']['truename'] == 2){?>selected="selected"<?php }?>><?php echo $lang['home_member_privary']?></option>
            </select>
            </span></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['home_member_sex'].$lang['nc_colon'];?></dt>
          <dd><span class="w400">
            <label>
              <input type="radio" name="member_sex" value="3" <?php if($output['member_info']['member_sex']==3 or ($output['member_info']['member_sex']!=2 and $output['member_info']['member_sex']!=1)) { ?>checked="checked"<?php } ?> />
              <?php echo $lang['home_member_secret'];?></label>
            &nbsp;&nbsp;
            <label>
              <input type="radio" name="member_sex" value="2" <?php if($output['member_info']['member_sex']==2) { ?>checked="checked"<?php } ?> />
              <?php echo $lang['home_member_female'];?></label>
            &nbsp;&nbsp;
            <label>
              <input type="radio" name="member_sex" value="1" <?php if($output['member_info']['member_sex']==1) { ?>checked="checked"<?php } ?> />
              <?php echo $lang['home_member_male'];?></label>
            </span><span>
            <select name="privacy[sex]">
              <option value="0" <?php if($output['member_info']['member_privacy']['sex'] == 0){?>selected="selected"<?php }?>><?php echo $lang['home_member_public'];?></option>
              <option value="1" <?php if($output['member_info']['member_privacy']['sex'] == 1){?>selected="selected"<?php }?>><?php echo $lang['home_member_friend'];?></option>
              <option value="2" <?php if($output['member_info']['member_privacy']['sex'] == 2){?>selected="selected"<?php }?>><?php echo $lang['home_member_privary']?></option>
            </select>
            </span></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['home_member_birthday'].$lang['nc_colon'];?></dt>
          <dd><span class="w400">
            <input type="text" class="text" name="birthday" maxlength="10" id="birthday" value="<?php echo $output['member_info']['member_birthday']; ?>" />
            </span><span>
            <select name="privacy[birthday]">
              <option value="0" <?php if($output['member_info']['member_privacy']['birthday'] == 0){?>selected="selected"<?php }?>><?php echo $lang['home_member_public'];?></option>
              <option value="1" <?php if($output['member_info']['member_privacy']['birthday'] == 1){?>selected="selected"<?php }?>><?php echo $lang['home_member_friend'];?></option>
              <option value="2" <?php if($output['member_info']['member_privacy']['birthday'] == 2){?>selected="selected"<?php }?>><?php echo $lang['home_member_privary']?></option>
            </select>
            </span></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['home_member_areainfo'].$lang['nc_colon'];?></dt>
          <dd><span id="region" class="w400">
            <input type="hidden" value="<?php echo $output['member_info']['member_provinceid'];?>" name="province_id" id="province_id">
            <input type="hidden" value="<?php echo $output['member_info']['member_cityid'];?>" name="city_id" id="city_id">
            <input type="hidden" value="<?php echo $output['member_info']['member_areaid'];?>" name="area_id" id="area_id" class="area_ids" />
            <input type="hidden" value="<?php echo $output['member_info']['member_areainfo'];?>" name="area_info" id="area_info" class="area_names" />
            <?php if(!empty($output['member_info']['member_areaid'])){?>
            <span><?php echo $output['member_info']['member_areainfo'];?></span>
            <input type="button" value="<?php echo $lang['nc_edit'];?>" style="background-color: #F5F5F5; width: 60px; height: 32px; border: solid 1px #E7E7E7; cursor: pointer" class="edit_region" />
            <select style="display:none;">
            </select>
            <?php }else{?>
            <select>
            </select>
            <?php }?>
            </span><span>
            <select name="privacy[area]">
              <option value="0" <?php if($output['member_info']['member_privacy']['area'] == 0){?>selected="selected"<?php }?>><?php echo $lang['home_member_public'];?></option>
              <option value="1" <?php if($output['member_info']['member_privacy']['area'] == 1){?>selected="selected"<?php }?>><?php echo $lang['home_member_friend'];?></option>
              <option value="2" <?php if($output['member_info']['member_privacy']['area'] == 2){?>selected="selected"<?php }?>><?php echo $lang['home_member_privary']?></option>
            </select>
            </span></dd>
        </dl>
        <dl>
          <dt>QQ<?php echo $lang['nc_colon'];?></dt>
          <dd><span class="w400">
            <input type="text" class="text" maxlength="30" name="member_qq" value="<?php echo $output['member_info']['member_qq']; ?>" />
            </span><span>
            <select name="privacy[qq]">
              <option value="0" <?php if($output['member_info']['member_privacy']['qq'] == 0){?>selected="selected"<?php }?>><?php echo $lang['home_member_public'];?></option>
              <option value="1" <?php if($output['member_info']['member_privacy']['qq'] == 1){?>selected="selected"<?php }?>><?php echo $lang['home_member_friend'];?></option>
              <option value="2" <?php if($output['member_info']['member_privacy']['qq'] == 2){?>selected="selected"<?php }?>><?php echo $lang['home_member_privary']?></option>
            </select>
            </span> </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['home_member_wangwang'].$lang['nc_colon'];?></dt>
          <dd><span class="w400">
            <input name="member_ww" type="text" class="text" maxlength="50" id="member_ww" value="<?php echo $output['member_info']['member_ww'];?>" />
            </span><span>
            <select name="privacy[ww]">
              <option value="0" <?php if($output['member_info']['member_privacy']['ww'] == 0){?>selected="selected"<?php }?>><?php echo $lang['home_member_public'];?></option>
              <option value="1" <?php if($output['member_info']['member_privacy']['ww'] == 1){?>selected="selected"<?php }?>><?php echo $lang['home_member_friend'];?></option>
              <option value="2" <?php if($output['member_info']['member_privacy']['ww'] == 2){?>selected="selected"<?php }?>><?php echo $lang['home_member_privary']?></option>
            </select>
            </span></dd>
        </dl>
        <dl class="bottom">
          <dt></dt>
          <dd>
            <label class="submit-border">
              <input type="submit" class="submit" value="<?php echo $lang['home_member_save_modify'];?>" />
            </label>
          </dd>
        </dl>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
//注册表单验证
$(function(){
	regionInit("region");
	$('#birthday').datepicker({dateFormat: 'yy-mm-dd'});
    $('#profile_form').validate({
    	submitHandler:function(form){
    		if ($('select[class="valid"]').eq(0).val()>0) $('#province_id').val($('select[class="valid"]').eq(0).val());
			if ($('select[class="valid"]').eq(1).val()>0) $('#city_id').val($('select[class="valid"]').eq(1).val());
			ajaxpost('profile_form', '', '', 'onerror')
		},
        rules : {
            member_truename : {
				minlength : 2,
                maxlength : 20
            },
            member_qq : {
				digits  : true,
                minlength : 5,
                maxlength : 12
            }
        },
        messages : {
            member_truename : {
				minlength : '<?php echo $lang['home_member_username_range'];?>',
                maxlength : '<?php echo $lang['home_member_username_range'];?>'
            },
            member_qq  : {
				digits    : '<?php echo $lang['home_member_input_qq'];?>',
                minlength : '<?php echo $lang['home_member_input_qq'];?>',
                maxlength : '<?php echo $lang['home_member_input_qq'];?>'
            }
        }
    });
});
</script> 
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>