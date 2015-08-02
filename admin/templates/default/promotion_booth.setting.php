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
		    promotion_booth_price: {
				required : true,
				digits : true
			},
			promotion_booth_goods_sum: {
				required : true,
				digits : true,
				min : 1
			}
		},
		messages : {
		    promotion_booth_price: {
				required : '请填写展位价格',
				digits : '请填写展位价格'
			},
			promotion_booth_goods_sum: {
				required : '不能为空，且不小于1的整数',
				digits : '不能为空，且不小于1的整数',
				min : '不能为空，且不小于1的整数'
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
        <li><a href="<?php echo urlAdmin('promotion_booth', 'goods_list');?>"><span>商品列表</span></a></li>
        <li><a href="<?php echo urlAdmin('promotion_booth', 'booth_quota_list');?>"><span>套餐列表</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>设置</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="<?php echo urlAdmin('promotion_booth', 'booth_setting');?>">
    <input type="hidden" id="form_submit" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="promotion_booth_price">推荐展位价格<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_booth_price" name="promotion_booth_price" value="<?php echo $output['setting']['promotion_booth_price'];?>" class="txt">
            </td>
            <td class="vatop tips">购买单位为月(30天)，购买后卖家可以在所购买周期内推荐商品，在商品列表热卖商品中随机显示。</td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="promotion_booth_goods_sum">允许推荐商品最大数量<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="promotion_booth_goods_sum" name="promotion_booth_goods_sum" value="<?php echo $output['setting']['promotion_booth_goods_sum'];?>" class="txt">
            </td>
            <td class="vatop tips">每个店铺推荐商品的最大数量。</td>
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

