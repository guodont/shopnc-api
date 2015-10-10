<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>

<?php if ($output['isOwnShop']) { ?>
  <a class="ncsc-btn ncsc-btn-green"  href="index.php?act=store_promotion_bundling&op=bundling_add" ><i class="icon-plus-sign"></i><?php echo $lang['bundling_add'];?></a>

<?php } else { ?>

  <?php if (empty($output['bundling_quota'])) { ?>
  <a href="javascript:void(0)" class="ncsc-btn ncsc-btn-acidblue" onclick="go('index.php?act=store_promotion_bundling&op=bundling_quota_add');" title="<?php echo $lang['bundling_quota_add'];?>"><i class="icon-money"></i><?php echo $lang['bundling_quota_add'];?></a>
  <?php } else if((isset($output['bundling_surplus']) && intval($output['bundling_surplus']) != 0 ) || C('promotion_bundling_sum') == 0) { ?>
  <?php if ($output['bundling_quota']['bl_state'] == 1) {?>
  <a class="ncsc-btn ncsc-btn-green"  href="index.php?act=store_promotion_bundling&op=bundling_add" style="right:100px"><i class="icon-plus-sign"></i><?php echo $lang['bundling_add'];?></a>
  <?php }?>
  <a class="ncsc-btn ncsc-btn ncsc-btn-acidblue" href="index.php?act=store_promotion_bundling&op=bundling_renew"><i class="icon-money"></i>套餐续费</a>
  <?php } ?>
<?php } ?>

</div>

<?php if ($output['isOwnShop']) { ?>
    <?php if (C('promotion_bundling_sum') != 0) {?>
<div class="alert alert-block mt10">
  <ul>
    <li>1、您最多可以发布<?php echo C('promotion_bundling_sum');?>个优惠套装。</li>
  </ul>
</div>
    <?php }?>
<?php } else { ?>
<!-- 有可用套餐，发布活动 -->
<div class="alert alert-block mt10">
<?php if(empty($output['bundling_quota']) || $output['bundling_quota']['bl_state'] == 0) { ?>
  <strong>你还没有购买套餐或套餐已经过期，请购买或续费套餐。</strong>
<?php } else {?>
  <strong>套餐过期时间<?php echo $lang['nc_colon'];?></strong> <strong style=" color:#F00;"><?php echo date('Y-m-d H:i:s',$output['bundling_quota']['bl_quota_endtime']);?></strong>
<?php }?>
  <ul>
    <li>1、点击购买套餐或续费套餐可以购买或续费套餐</li>
    <li>2、<strong style="color: red">相关费用会在店铺的账期结算中扣除</strong>。</li>
    <?php if (C('promotion_bundling_sum') != 0) {?>
    <li>3、您最多可以发布<?php echo C('promotion_bundling_sum');?>个优惠套装。</li>
    <?php }?>
  </ul>
</div>
<?php } ?>
<form method="get">
  <input type="hidden" name="act" value="store_promotion_bundling" />
  <input type="hidden" name="op" value="bundling_list" />
  <table class="search-form">
    <tr>
      <td>&nbsp;</td>
      <th><?php echo $lang['bundling_status'];?></th>
      <td class="w100"><select name="state">
          <option value='all'><?php echo $lang['bundling_status_all'];?></option>
          <option value='0' <?php if(isset($_GET['state']) && $_GET['state'] == 0){?>selected="selected"<?php }?>><?php echo $lang['bundling_status_0'];?></option>
          <option value='1' <?php if(isset($_GET['state']) && $_GET['state'] == 1){?>selected="selected"<?php }?>><?php echo $lang['bundling_status_1'];?></option>
        </select></td>
      <th class="w110"><?php echo $lang['bundling_name'];?></th>
      <td class="w160"><input type="text" class="text w150" name="bundling_name" value="<?php echo $_GET['bundling_name'];?>"/></td>
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>

<?php if(empty($output['list'])) { ?>
<!-- 没有添加活动 -->
<table class="ncsc-default-table ncsc-promotion-buy">
  <tbody>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
  </tbody>
</table>
<?php } else { ?>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w10"></th>
      <th class="w50"></th>
      <th class="tl"><?php echo $lang['bundling_name'];?></th>
      <th class="w180"><?php echo $lang['bundling_add_price'];?></th>
      <th class="w180"><?php echo $lang['bundling_list_goods_count'];?></th>
      <th class="w90"><?php echo $lang['nc_state'];?></th>
      <th class="w110"><?php echo $lang['nc_handle'];?></th>
    </tr>
    <tr>
      <td class="w30 tc"><input type="checkbox" id="all" class="checkall"/></td>
      <td colspan="20"><label for="all" ><?php echo $lang['nc_select_all'];?></label>
        <a href="javascript:void(0);" class="ncsc-btn-mini" nc_type="batchbutton" uri="index.php?act=store_promotion_bundling&op=drop_bundling" name="bundling_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a></td>
    </tr>
  </thead>
  <?php foreach($output['list'] as $key=>$val){?>
  <tbody>
    <tr class="bd-line">
      <td><input type="checkbox" class="checkitem tc" value="<?php echo $val['bl_id'];?>"/></td>
      <td><div class="pic-thumb"><a <?php if ($val['goods_id'] != '') {echo 'href="' . urlShop('goods', 'index', array('goods_id' => $val['goods_id'])) . '" target="_blank"';} else { echo 'href="javascript:void(0);"';}?> target="black"><img src="<?php echo $val['img'];?>"/></a></div></td>
      <td class="tl"><dl class="goods-name">
          <dt><a <?php if ($val['goods_id'] != '') {echo 'href="' . urlShop('goods', 'index', array('goods_id' => $val['goods_id'])) . '" target="_blank"';} else { echo 'href="javascript:void(0);"';}?>><?php echo $val['bl_name'];?></a></dt>
        </dl></td>
      <td class="goods-price"><?php echo $val['bl_discount_price'];?></td>
      <td class=""><?php echo $val['count'];?></td>
      <td><?php echo $output['state_array'][$val['bl_state']];?></td>
      <td class="nscs-table-handle"><span><a href="index.php?act=store_promotion_bundling&op=bundling_add&bundling_id=<?php echo $val['bl_id'];?>" class="btn-blue"><i class="icon-cog"></i>
        <p><?php echo $lang['bundling_edit'];?></p>
        </a></span> <span><a class="btn-red" href='javascript:void(0);' onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', '<?php echo urlShop('store_promotion_bundling', 'drop_bundling', array('bundling_id' => $val['bl_id']));?>');"><i class="icon-trash"></i>
        <p><?php echo $lang['nc_del'];?></p>
        </a></span></td>
    </tr>
  </tbody>
  <?php }?>
  <tfoot>
    <tr>
      <th class="tc"><input type="checkbox" id="all" class="checkall"/></th>
      <th colspan="20"><label for="all" ><?php echo $lang['nc_select_all'];?></label>
        <a href="javascript:void(0);" class="ncsc-btn-mini" nc_type="batchbutton" uri="index.php?act=store_promotion_bundling&op=drop_bundling" name="bundling_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a></th>
    </tr>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
</table>
<?php } ?>
