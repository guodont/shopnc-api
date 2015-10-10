<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_index_goods']?></h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('goods', 'goods');?>" ><span><?php echo $lang['goods_index_all_goods'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('goods', 'goods', array('type' => 'lockup'));?>"><span><?php echo $lang['goods_index_lock_goods'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('goods', 'goods', array('type' => 'waitverify'));?>"><span>等待审核</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_goods_set']?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form_goodsverify">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['goods_is_verify']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="rewrite_enabled"  class="cb-enable <?php if($output['list_setting']['goods_verify'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="rewrite_disabled" class="cb-disable <?php if($output['list_setting']['goods_verify'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="rewrite_enabled" name="goods_verify" <?php if($output['list_setting']['goods_verify'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="rewrite_disabled" name="goods_verify" <?php if($output['list_setting']['goods_verify'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips">
            <?php echo $lang['open_rewrite_tips'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_goodsverify.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>