<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>    <a href="javascript:void(0)"  class="ncm-btn ncm-btn-orange" onclick="go('index.php?act=member_flea&op=add_goods');" title="<?php echo $lang['store_goods_index_new_goods'];?>"><?php echo $lang['store_goods_index_new_flea'];?></a>
  </div>
  <form method="get" action="index.php">
    <table class="ncm-search-table">
      <input type="hidden" name="act" value="member_flea" />
      <input type="hidden" name="op" value="flea_list" />
      <tr>
        <td>&nbsp;</td>
        <th style="width:90px;"><?php echo $lang['flea_goods_name'].$lang['nc_colon'];?></th>
        <td class="w150"><input type="text" class="text" name="keyword" value="<?php echo $_GET['keyword']; ?>"/></td>
        <td class="w90 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr nc_type="table_header">
        <th class="w30"></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['flea_goods_name'];?></th>
        <th class="w200"><?php echo $lang['flea_goods_gc_name'];?></th>
        <th class="w100"><?php echo $lang['flea_goods_price'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php  if (count($output['list_goods'])>0) { ?>
      <?php foreach($output['list_goods'] as $val) { ?>
      <tr class="bd-line">
        <td></td>
        <td><div class="goods-pic-small"> <span class="thumb size60"> <i></i><a href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><img height="50" width="50" src="<?php if ($val['goods_image']) { echo $val['goods_image']; } else { echo SHOP_TEMPLATES_URL.'/images/member/default_image.png'; } ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><?php echo $val['goods_name']; ?></dt>
          </dl></td>
        <td><?php echo $val['gc_name']; ?></td>
        <td><?php echo $val['goods_store_price']; ?></td>
        <td><p><a href="index.php?act=member_flea&op=edit_goods&goods_id=<?php echo $val['goods_id']; ?>"><?php echo $lang['store_goods_index_edit_flea'];?></a></p>
          <p><a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']?>')){location.href='index.php?act=member_flea&op=flea_del&goods_id=<?php echo $val['goods_id']; ?>'}"class="ncu-btn2 mt5"><?php echo $lang['nc_del']?></a></p></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list_goods'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>