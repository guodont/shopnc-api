<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_operation_set']?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
                <!-- 促销开启 -->
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['promotion_allow'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="promotion_allow_1" class="cb-enable <?php if($output['list_setting']['promotion_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="promotion_allow_0" class="cb-disable <?php if($output['list_setting']['promotion_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input type="radio" id="promotion_allow_1" name="promotion_allow" value="1" <?php echo $output['list_setting']['promotion_allow'] ==1?'checked=checked':''; ?>>
            <input type="radio" id="promotion_allow_0" name="promotion_allow" value="0" <?php echo $output['list_setting']['promotion_allow'] ==0?'checked=checked':''; ?>>
          <td class="vatop tips"><?php echo $lang['promotion_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['groupbuy_allow'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="groupbuy_allow_1" class="cb-enable <?php if($output['list_setting']['groupbuy_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="groupbuy_allow_0" class="cb-disable <?php if($output['list_setting']['groupbuy_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input id="groupbuy_allow_1" name="groupbuy_allow" <?php if($output['list_setting']['groupbuy_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="groupbuy_allow_0" name="groupbuy_allow" <?php if($output['list_setting']['groupbuy_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['groupbuy_isuse_notice'];?></td>
        </tr>

          <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['points_isuse'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="points_isuse_1" class="cb-enable <?php if($output['list_setting']['points_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_open'];?>"><span><?php echo $lang['points_isuse_open'];?></span></label>
            <label for="points_isuse_0" class="cb-disable <?php if($output['list_setting']['points_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_close'];?>"><span><?php echo $lang['points_isuse_close'];?></span></label>
            <input type="radio" id="points_isuse_1" name="points_isuse" value="1" <?php echo $output['list_setting']['points_isuse'] ==1?'checked=checked':''; ?>>
            <input type="radio" id="points_isuse_0" name="points_isuse" value="0" <?php echo $output['list_setting']['points_isuse'] ==0?'checked=checked':''; ?>>
          <td class="vatop tips"><?php echo $lang['points_isuse_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['open_pointshop_isuse'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="pointshop_isuse_1" class="cb-enable <?php if($output['list_setting']['pointshop_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="pointshop_isuse_0" class="cb-disable <?php if($output['list_setting']['pointshop_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input id="pointshop_isuse_1" name="pointshop_isuse" <?php if($output['list_setting']['pointshop_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="pointshop_isuse_0" name="pointshop_isuse" <?php if($output['list_setting']['pointshop_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo sprintf($lang['open_pointshop_isuse_notice'],"index.php?act=setting&op=pointshop_setting");?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['open_pointprod_isuse'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="pointprod_isuse_1" class="cb-enable <?php if($output['list_setting']['pointprod_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="pointprod_isuse_0" class="cb-disable <?php if($output['list_setting']['pointprod_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input id="pointprod_isuse_1" name="pointprod_isuse" <?php if($output['list_setting']['pointprod_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="pointprod_isuse_0" name="pointprod_isuse" <?php if($output['list_setting']['pointprod_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['open_pointprod_isuse_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['voucher_allow'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="voucher_allow_1" class="cb-enable <?php if($output['list_setting']['voucher_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="voucher_allow_0" class="cb-disable <?php if($output['list_setting']['voucher_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input id="voucher_allow_1" name="voucher_allow" <?php if($output['list_setting']['voucher_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="voucher_allow_0" name="voucher_allow" <?php if($output['list_setting']['voucher_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['voucher_allow_notice'];?></td>
        </tr>

        <tr>
          <td class="" colspan="2"><table class="table tb-type2 nomargin">
              <thead>
                <tr class="space">
                  <th colspan="16"><?php echo $lang['points_ruletip']; ?>:</th>
                </tr>
                <tr class="thead">
                  <th><?php echo $lang['points_item']; ?></th>
                  <th><?php echo $lang['points_number']; ?></th>
                </tr>
              </thead>
              <tbody>
                <tr class="hover">
                  <td class="w200"><?php echo $lang['points_number_reg']; ?></td>
                  <td><input id="points_reg" name="points_reg" value="<?php echo $output['list_setting']['points_reg'];?>" class="txt" type="text" style="width:60px;"></td>
                </tr>
                <tr class="hover">
                  <td><?php echo $lang['points_number_login'];?></td>
                  <td><input id="points_login" name="points_login" value="<?php echo $output['list_setting']['points_login'];?>" class="txt" type="text" style="width:60px;"></td>
                </tr>
                <tr class="hover">
                  <td><?php echo $lang['points_number_comments']; ?></td>
                  <td><input id="points_comments" name="points_comments" value="<?php echo $output['list_setting']['points_comments'];?>" class="txt" type="text" style="width:60px;"></td>
                </tr>
                 <tr class="hover">
                  <td>邀请注册</td>
                  <td><input id="points_comments" name="points_invite" value="<?php echo $output['list_setting']['points_invite'];?>" class="txt" type="text" style="width:60px;">邀请非会员注册时给邀请人的积分数</td>
                </tr>
				  <tr class="hover">
                  <td>返利比例</td>
                  <td><input id="points_comments" name="points_rebate" value="<?php echo $output['list_setting']['points_rebate'];?>" class="txt" type="text" style="width:35px;">% &nbsp;&nbsp;&nbsp;被邀请会员购买商品时给邀请人返的积分数(例如设为5%，被邀请人购买100元商品，返给邀请人5积分)</td>
                </tr>
              </tbody>
            </table>
            <table class="table tb-type2 nomargin">
              <thead>
                <tr class="thead">
                  <th colspan="2"><?php echo $lang['points_number_order']; ?></th>
                </tr>
              </thead>
              <tbody>
                <tr class="hover">
                  <td class="w200"><?php echo $lang['points_number_orderrate'];?></td>
                  <td><input id="points_orderrate" name="points_orderrate" value="<?php echo $output['list_setting']['points_orderrate'];?>" class="txt" type="text" style="width:60px;">
                    <?php echo $lang['points_number_orderrate_tip']; ?></td>
                </tr>
                <tr class="hover">
                  <td><?php echo $lang['points_number_ordermax']; ?></td>
                  <td><input id="points_ordermax" name="points_ordermax" value="<?php echo $output['list_setting']['points_ordermax'];?>" class="txt" type="text" style="width:60px;">
                    <?php echo $lang['points_number_ordermax_tip'];?></td>
                </tr>



      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>

$(function(){$("#submitBtn").click(function(){
    if($("#settingForm").valid()){
     $("#settingForm").submit();
	}
	});
});
//
$(document).ready(function(){
	$("#settingForm").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        },
        messages : {
        }
	});
});
</script>
