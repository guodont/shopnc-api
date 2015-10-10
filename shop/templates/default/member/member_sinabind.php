<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <?php if ($output['setting_config']['sina_isuse'] == 1){?>
  <div class="ncm-bind">
    <?php if (!empty($output['member_info']['member_sinaopenid'])){?>
    <div class="alert">
      <h4>提示信息：</h4>
      <ul>
        <li><?php echo $lang['member_sconnect_binding_tip_1'];?><em>“<?php echo $_SESSION['member_name'];?>”</em><?php echo $lang['member_sconnect_binding_tip_2'];?><em>“<?php echo $output['member_info']['member_sinainfoarr']['name'];?>”</em><?php echo $lang['member_sconnect_binding_tip_3'];?></li>
        <li><?php echo $lang['member_sconnect_modpw_tip_1']; ?><em>“<?php echo $_SESSION['member_name']; ?>”</em><?php echo $lang['member_sconnect_modpw_tip_2'];?></li>
      </ul>
    </div>
    <input type="hidden" name="form_submit" value="ok"  />
    <div class="relieve">
      <form method="post" id="editbind_form" name="editbind_form" action="index.php?act=member_connect&op=sinaunbind">
        <input type='hidden' id="is_editpw" name="is_editpw" value='no'/>
        <div class="ico-sina"></div>
        <p><?php echo $lang['member_sconnect_unbind_click']; ?></p>
        <div class="bottom">
          <label class="submit-border">
            <input class="submit" type="submit" value="<?php echo $lang['member_sconnect_unbind_submit'];?>" />
          </label>
        </div>
      </form>
    </div>
    <div class="revise ncm-default-form ">
      <form method="post" id="editpw_form" name="editpw_form" action="index.php?act=member_connect&op=sinaunbind">
        <input type='hidden' id="is_editpw" name="is_editpw" value='yes'/>
        <dl>
          <dt><?php echo $lang['member_sconnect_modpw_newpw'].$lang['nc_colon']; ?></dt>
          <dd>
            <input type="password" name="new_password" id="new_password"/>
            <label for="new_password" generated="true" class="error"></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_sconnect_modpw_two_password'].$lang['nc_colon']; ?></dt>
          <dd>
            <input type="password" name="confirm_password" id="confirm_password" />
            <label for="confirm_password" generated="true" class="error"></label>
          </dd>
        </dl>
        <dl class="bottom">
          <dt>&nbsp;</dt>
          <dd>
            <label class="submit-border">
              <input class="submit" type="submit" value="<?php echo $lang['member_sconnect_unbind_updatepw_submit'];?>" />
            </label>
          </dd>
        </dl>
      </form>
    </div>
    <?php } else {?>
    <div class="relieve pt50">
      <p class="ico"><a href="<?php echo SHOP_SITE_URL;?>/api.php?act=tosina"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/sina_bind_small.gif"></a></p>
      <p class="hint"><?php echo $lang['member_sconnect_binding_click']; ?></p>
    </div>
    <div class="revise pt50">
      <p class="sina"><?php echo $lang['member_sconnect_binding_goodtip_1']; ?></p>
      <p><?php echo $lang['member_sconnect_binding_goodtip_2']; ?></p>
      <p class="hint"><?php echo $lang['member_sconnect_binding_goodtip_3']; ?></p>
    </div>
    <?php }?>
  </div>
  <?php } else {?>
  <div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['member_sconnect_unavailable'];?></span></div>
  <?php }?>
</div>
<script type="text/javascript">
$(function(){
	$("#unbind").hide();

    $('#editpw_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        rules : {
            new_password : {
                required   : true,
                minlength  : 6,
                maxlength  : 20
            },
            confirm_password : {
                required   : true,
                equalTo    : '#new_password'
            }
        },
        messages : {
            new_password  : {
                required   : '<i class="icon-exclamation-sign"></i><?php echo $lang['member_sconnect_new_password_null'];?>',
                minlength  : '<i class="icon-exclamation-sign"></i><?php echo $lang['member_sconnect_password_range'];?>'
            },
            confirm_password : {
                required   : '<i class="icon-exclamation-sign"></i><?php echo $lang['member_sconnect_ensure_password_null'];?>',
                equalTo    : '<i class="icon-exclamation-sign"></i><?php echo $lang['member_sconnect_input_two_password_again'];?>'
            }
        }
    });
});
function showunbind(){
	$("#unbind").show();
}
function showpw(){
	$("#is_editpw").val('yes');
	$("#editbinddiv").hide();
	$("#editpwul").show();
}
</script>
