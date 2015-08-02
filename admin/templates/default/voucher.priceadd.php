<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
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
  <form id="add_form" method="post" action="index.php?act=voucher&op=<?php echo $output['menu_key']; ?>">
    <input type="hidden" id="form_submit" name="form_submit" value="ok"/>
    <input type="hidden" name="priceid" value="<?php echo $output['info']['voucher_price_id'];?>"/>
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['admin_voucher_price_title'];?>(<?php echo $lang['currency_zh'];?>)<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="voucher_price" name="voucher_price" class="txt" value="<?php echo $output['info']['voucher_price'];?>"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['admin_voucher_price_describe'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="voucher_price_describe" rows="6" class="tarea" id="voucher_price_describe"><?php echo $output['info']['voucher_price_describe'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['admin_voucher_price_points'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="voucher_points" name="voucher_points" class="txt" value="<?php echo $output['info']['voucher_defaultpoints'] >0?$output['info']['voucher_defaultpoints']:0;?>"></td>
          <td class="vatop tips"><?php echo $lang['admin_voucher_price_points_tip'];?></td>
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
//按钮先执行验证再提交表单
$(function(){
	$("#submitBtn").click(function(){
		$("#add_form").submit();
	});
	//页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	voucher_price_describe: {
                required : true,
                maxlength : 255
        	},
        	voucher_price: {
                required : true,
                digits : true,
                min : 1
            },
            voucher_points: {
                digits : true
            }
        },
        messages : {
      		voucher_price_describe: {
       			required : '<?php echo $lang['admin_voucher_price_describe_error'];?>',
       			maxlength : '<?php echo $lang['admin_voucher_price_describe_lengtherror'];?>'
	    	},
	    	voucher_price: {
                required : '<?php echo $lang['admin_voucher_price_error'];?>',
                digits : '<?php echo $lang['admin_voucher_price_error'];?>',
                min : '<?php echo $lang['admin_voucher_price_error'];?>'
		    },
		    voucher_points: {
		    	digits : '<?php echo $lang['admin_voucher_price_points_error'];?>'
            }
        }
	});
});
</script>