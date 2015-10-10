<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<table class="ncsc-default-table">
  <?php if(!empty($output['list']) && is_array($output['list'])){?>
  <thead>
    <tr>
      <th class="w20">&nbsp;</th>
      <th class="tl w200"><?php echo $lang['store_activity_theme'];?></th>
      <th class="tl"><?php echo $lang['store_activity_intro'];?></th>
      <th class="w150"><?php echo $lang['store_activity_start_time'];?></th>
      <th class="w150"><?php echo $lang['store_activity_end_time'];?></th>
      <th class="w90"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($output['list'] as $k => $v){?>
    <tr>
      <td></td>
      <td class="tl"><a target="_blank" href="index.php?act=activity&activity_id=<?php echo $v['activity_id'];?>"><?php echo $v['activity_title']; ?></a></td>
      <td class="tl"><?php echo $v['activity_desc'];?></td>
      <td class="goods-time"><?php echo @date('Y-m-d',$v['activity_start_date']);?></td>
      <td class="goods-time"><?php echo @date('Y-m-d',$v['activity_end_date']);?></td>
      <td class="nscs-table-handle"><span><a id="a_<?php echo $v['activity_id'];?>" href="index.php?act=store_activity&op=activity_apply&activity_id=<?php echo $v['activity_id'];?>"  class="btn-green"><i class="icon-edit"></i>
        <p><?php echo $lang['store_activity_join'];?></p>
        </a></span></td>
    </tr>
    <?php } } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php if(!empty($output['list']) && is_array($output['list'])){?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
    </tr>
    <?php }?>
  </tfoot>
</table>
