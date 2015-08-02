<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w30"></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['flea_favorite_product_name'];?></th>
        <th class="w200"><?php echo $lang['flea_favorite_member_name'];?></th>
        <th class="w100"><?php echo $lang['flea_favorite_product_price'];?></th>
        <th class="w90"><?php echo $lang['flea_favorite_handle'];?></th>
      </tr>
      <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
      <tr>
        <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="20"><label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=member_flea&op=favorites&drop=ok" name="fav_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <?php }?>
    </thead>
    <tbody>
      <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
      <?php foreach($output['favorites_list'] as $key=>$favorites){?>
      <tr class="bd-line">
        <td><input type="checkbox" class="checkitem" value="<?php echo $favorites['flea']['goods_id'];?>"/></td>
        <td><p class="ware_pic"><a href="index.php?act=flea_goods&goods_id=<?php echo $favorites['flea']['goods_id'];?>" target="_blank"><img src="<?php if (!empty($favorites['flea']['goods_image'])) { echo ATTACH_PATH.'/flea/goods/'.$favorites['flea']['member_id'].'/'.str_replace('_small', '_tiny', $favorites['flea']['goods_image']); } else { echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_goods_image']; } ?>" width="60" height="60"  /></a></p></td>
        <td class="tl"><p class="ware_text"><a href="index.php?act=flea_goods&goods_id=<?php echo $favorites['flea']['goods_id'];?>" target="_blank"><?php echo $favorites['flea']['goods_name'];?></a></p></td>
        <td><?php echo $favorites['flea']['member_name'];?><a target="_blank" href="index.php?act=home&op=sendmsg&member_id=<?php echo $favorites['flea']['member_id'];?>" class="email" title="<?php echo $lang['nc_message'];?>"></a></td>
        <td><?php echo ncPriceFormat($favorites['flea']['goods_store_price']);?></td>
        <td><a href="javascript:drop_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=member_flea&op=favorites&drop=ok&type=flea&fav_id=<?php echo $favorites['fav_id'];?>');" class="ncu-btn2"><?php echo $lang['nc_del_&nbsp'];?></a></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php }?>
    </tbody>
      <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
    <tfoot>
      <tr>
        <td class="tc"><input type="checkbox" id="all2" class="checkall"/></td>
        <td colspan="20"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=member_flea&op=favorites&drop=ok" name="fav_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a>
          <div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php }?>
  </table>
</div>