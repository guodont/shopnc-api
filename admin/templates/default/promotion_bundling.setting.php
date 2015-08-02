<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
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
			promotion_bundling_price: {
				required : true,
				digits : true,
				min : 1
			},
			promotion_bundling_sum: {
				required : true,
				digits : true
			},
			promotion_bundling_goods_sum: {
				required : true,
				digits : true,
				min : 1,
				max : 5
			}
		},
		messages : {
			promotion_bundling_price: {
				required : '<?php echo $lang['bundling_price_error'];?>',
				digits : '<?php echo $lang['bundling_price_error'];?>',
				min : '<?php echo $lang['bundling_price_error'];?>'
			},
			promotion_bundling_sum: {
				required : '<?php echo $lang['bundling_sum_error'];?>',
				digits : '<?php echo $lang['bundling_sum_error'];?>'
			},
			promotion_bundling_goods_sum: {
				required : '<?php echo $lang['bundling_goods_sum_error'];?>',
				digits : '<?php echo $lang['bundling_goods_sum_error'];?>',
				min : '<?php echo $lang['bundling_goods_sum_error'];?>',
				max : '<?php echo $lang['bundling_goods_sum_error'];?>'
			}
		}
	});
});
</script> 
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_promotion_bundling'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=promotion_bundling&op=bundling_list"><span><?php echo $lang['bundling_list'];?></span></a></li>
        <li><a href="index.php?act=promotion_bundling&op=bundling_quota"><span><?php echo $lang['bundling_quota'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['bundling_setting'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="index.php?act=promotion_bundling&op=bundling_setting">
    <input type="hidden" id="form_submit" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="promotion_bundling_price"><?php echo $lang['bundling_gold_price'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_bundling_price" name="promotion_bundling_price" value="<?php echo $output['setting']['promotion_bundling_price'];?>" class="txt">
            </td>
            <td class="vatop tips"><?php echo $lang['bundling_price_prompt'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="promotion_bundling_sum"><?php echo $lang['bundling_sum'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_bundling_sum" name="promotion_bundling_sum" value="<?php echo $output['setting']['promotion_bundling_sum'];?>" class="txt">
            </td>
            <td class="vatop tips"><?php echo $lang['bundling_sum_prompt'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="promotion_bundling_goods_sum"><?php echo $lang['bundling_goods_sum'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_bundling_goods_sum" name="promotion_bundling_goods_sum" value="<?php echo $output['setting']['promotion_bundling_goods_sum'];?>" class="txt">
            </td>
            <td class="vatop tips"><?php echo $lang['bundling_goods_sum_prompt'];?></td>
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

