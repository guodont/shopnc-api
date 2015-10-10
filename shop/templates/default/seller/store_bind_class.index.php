<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
<?php if ($notOwnShop = !checkPlatformStore()) { ?>
  <a href="javascript:void(0)" class="ncsc-btn ncsc-btn-green" nc_type="dialog" dialog_title="申请新的经营类目" dialog_id="my_goods_brand_apply" dialog_width="480" uri="index.php?act=store_info&op=bind_class_add">申请新的经营类目</a>
<?php } ?>
  </div>

<?php if (checkPlatformStoreBindingAllGoodsClass()) { ?>
<table class="ncsc-default-table">
  <tbody>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><span>店铺已绑定全部商品类目</span></div></td>
    </tr>
  </tbody>
</table>

<?php } else { ?>

<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w20"></th>
      <th colspan="3">经营类目</th>
      <th>分佣比例</th>
<?php if ($notOwnShop) { ?>
      <th>状态</th>
      <th>操作</th>
<?php } ?>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($output['bind_list'])) { ?>
    <?php foreach($output['bind_list'] as $val) { ?>
    <tr class="bd-line">
      <td></td>
      <td class="w180 tl"><?php echo $val['class_1_name']; ?></td>
      <td class="w180 tl"><?php echo $val['class_2_name'] ? '>' : null; ?>&emsp;<?php echo $val['class_2_name']; ?></td>
      <td class="w180 tl"><?php echo $val['class_3_name'] ? '>' : null; ?>&emsp;<?php echo $val['class_3_name']; ?></td>
      <td class="w180"><?php echo $val['commis_rate'];?> %</td>
<?php if ($notOwnShop) { ?>
      <td class="w100"><?php echo $val['state'] == '1' ? '已审核' : '审核中'; ?></td>
      <td class="nscs-table-handle">
      <?php if ($val['state'] == '0') {?>
      <span><a href="javascript:void(0)" class="btn-red" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store_info&op=bind_class_del&bid=<?php echo $val['bid']; ?>');"><i class="icon-trash"></i><p><?php echo $lang['nc_del'];?></p></a></span>
     <?php } ?>
      </td>
<?php } ?>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php } ?>
