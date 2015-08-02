<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <table class="ncm-default-table order">
    <thead>
      <tr>
        <th class="w30"></th>
        <th><?php echo $lang['store_consult_reply'];?></th>
        <th class="w30"></th>
      </tr>
    </thead>
    <tbody>
      <?php  if (count($output['list_consult'])>0){ ?>
      <?php foreach($output['list_consult'] as $consult){?>
      <tr>
        <td colspan="19" class="sep-row"></td>
      </tr>
      <tr>
        <th colspan="20"><span class="ml10"><a href="index.php?act=goods&goods_id=<?php echo $consult['goods_id']; ?>" target="_blank"><?php echo $consult['goods_name'];?></a></span><span class="ml20"><?php echo $lang['store_consult_list_consult_time'].$lang['nc_colon'];?><em class="goods-time"><?php echo date("Y-m-d H:i:s",$consult['consult_addtime']);?></em></span></th>
      </tr>
      <tr>
        <td class="tl bdl"></td>
        <td class="tl"><strong><?php echo $lang['store_consult_list_consult_content'].$lang['nc_colon'];?></strong><span class="gray"><?php echo nl2br($consult['consult_content']);?></span></td>
        <td class="bdr"></td>
        <?php if($consult['consult_reply'] != ""){?>
      <tr>
        <td class="tl bdl"></td>
        <td class="tl"><strong><?php echo $lang['store_consult_list_reply_time'].$lang['nc_colon'];?></strong><span class="gray"><?php echo nl2br($consult['consult_reply']);?></span><span class="ml10 goods-time">(<?php echo date("Y-m-d H:i:s",$consult['consult_reply_time']);?>)</span></td>
        <td class="bdr"></td>
      </tr>
      <?php }?>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list_consult'])>0){ ?>
      <tr>
        <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
      <?php }?>
    </tfoot>
  </table>
</div>
