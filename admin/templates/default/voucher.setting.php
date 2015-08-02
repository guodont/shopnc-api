<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_voucher_price_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  
  <div class="fixed-empty"></div>
  <!-- <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=voucher&op=setting"> -->
  <form id="add_form" method="post" action="index.php?act=voucher&op=setting">
    <input type="hidden" id="form_submit" name="form_submit" value="ok"/>
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['admin_voucher_setting_price'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_voucher_price" name="promotion_voucher_price" value="<?php echo $output['setting']['promotion_voucher_price'];?>" class="txt">
            </td>
            <td class="vatop tips"><?php echo $lang['admin_voucher_setting_price_tip'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['admin_voucher_setting_storetimes'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_voucher_storetimes_limit" name="promotion_voucher_storetimes_limit" value="<?php echo $output['setting']['promotion_voucher_storetimes_limit'];?>" class="txt">
            </td>
            <td class="vatop tips"><?php echo $lang['admin_voucher_setting_storetimes_tip'];?></td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['admin_voucher_setting_buyertimes'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_voucher_buyertimes_limit" name="promotion_voucher_buyertimes_limit" value="<?php echo $output['setting']['promotion_voucher_buyertimes_limit'];?>" class="txt">
            </td>
            <td class="vatop tips"><?php echo $lang['admin_voucher_setting_buyertimes_tip'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(document).ready(function(){    
    $("#submitBtn").click(function(){
        $("#add_form").submit();
    });
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	promotion_voucher_price: {
                required : true,
                digits : true,
                min : 1
            },
            promotion_voucher_storetimes_limit: {
                required : true,
                digits : true,
                min : 1
            },
            promotion_voucher_buyertimes_limit: {
                required : true,
                digits : true,
                min : 1
            }
        },
        messages : {
        	promotion_voucher_price: {
       			required : '<?php echo $lang['admin_voucher_setting_price_error'];?>',
       			digits : '<?php echo $lang['admin_voucher_setting_price_error'];?>',
                min : '<?php echo $lang['admin_voucher_setting_price_error'];?>'
	    	},
	    	promotion_voucher_storetimes_limit: {
                required : '<?php echo $lang['admin_voucher_setting_storetimes_error'];?>',
                digits : '<?php echo $lang['admin_voucher_setting_storetimes_error'];?>',
                min : '<?php echo $lang['admin_voucher_setting_storetimes_error'];?>'
            },
            promotion_voucher_buyertimes_limit: {
                required : '<?php echo $lang['admin_voucher_setting_buyertimes_error'];?>',
                digits : '<?php echo $lang['admin_voucher_setting_buyertimes_error'];?>',
                min : '<?php echo $lang['admin_voucher_setting_buyertimes_error'];?>'
            }
        }
	});
});
</script>
