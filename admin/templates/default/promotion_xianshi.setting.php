<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['promotion_xianshi'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=promotion_xianshi&op=xianshi_setting_save">
    <input type="hidden" id="submit_type" name="submit_type" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['xianshi_price'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_xianshi_price" name="promotion_xianshi_price" value="<?php echo $output['setting']['promotion_xianshi_price'];?>" class="txt">
            </td>
            <td class="vatop tips"><?php echo $lang['xianshi_price_explain'];?></td>
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
        	promotion_xianshi_price: {
                required : true,
                digits : true,
                min : 0
            }
        },
        messages : {
      		promotion_xianshi_price: {
       			required : '<?php echo $lang['xianshi_price_error'];?>',
       			digits : '<?php echo $lang['xianshi_price_error'];?>',
                min : '<?php echo $lang['xianshi_price_error'];?>'
            }
        }
	});
});
//submit函数
function submit_form(submit_type){
	$('#submit_type').val(submit_type);
	$('#add_form').submit();
}
</script> 
