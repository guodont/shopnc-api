<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <form method="get" action="index.php">
    <table class="ncm-search-table">
      <input type="hidden" name='act' value='member_complain' />
      <tr>
        <td>&nbsp;</td>
        <td class="w100 tr"><select name="select_complain_state">
            <option value="0" <?php if (empty($_GET['select_complain_state'])){echo 'selected=true';}?>> <?php echo $lang['complain_state_all'];?> </option>
            <option value="1" <?php if ($_GET['select_complain_state'] == '1'){echo 'selected=true';}?>> <?php echo $lang['complain_state_inprogress'];?> </option>
            <option value="2" <?php if ($_GET['select_complain_state'] == '2'){echo 'selected=true';}?>> <?php echo $lang['complain_state_finish'];?> </option>
          </select></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th colspan="2">投诉商品</th>
        <th class="w200"><?php echo $lang['complain_subject_content'];?></th>
        <th class="w200"><?php echo $lang['complain_datetime'];?></th>
        <th class="w150"><?php echo $lang['complain_state'];?></th>
        <th class="w110"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php  if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) {
        $goods = $output['goods_list'][$val['order_goods_id']];
        ?>
      <tr class="bd-line">
        <td></td>
        <td class="w50"><div class="pic-thumb"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=> $goods['goods_id'])); ?>">
            <img src="<?php echo thumb($goods,60); ?>" onMouseOver="toolTip('<img src=<?php echo thumb($goods,240); ?>>')" onMouseOut="toolTip()" /></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=> $goods['goods_id'])); ?>"><?php echo $goods['goods_name']; ?></a></dt>
            <dd>商家：<?php echo $val['accused_name'];?></dd>
          </dl></td>
        <td><?php echo $val['complain_subject_content'];?></td>
        <td class="goods-time"><?php echo date("Y-m-d H:i:s",$val['complain_datetime']);?></td>
        <td><?php
				if(intval($val['complain_state'])===10) echo $lang['complain_state_new'];
				if(intval($val['complain_state'])===20) echo $lang['complain_state_appeal'];
				if(intval($val['complain_state'])===30) echo $lang['complain_state_talk'];
				if(intval($val['complain_state'])===40) echo $lang['complain_state_handle'];
				if(intval($val['complain_state'])===99) echo $lang['complain_state_finish'];
				?></td>
        <td class="ncm-table-handle"><span><a href="index.php?act=member_complain&op=complain_show&complain_id=<?php echo $val['complain_id'];?>" class="btn-blue"><i class="icon-eye-open"></i>
          <p><?php echo $lang['complain_text_detail'];?></p></a></span>
            <?php if(intval($val['complain_state'])==10) { ?>
          <span><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['complain_cancel_confirm'];?>','index.php?act=member_complain&op=complain_cancel&complain_id=<?php echo $val['complain_id']; ?>')" class="btn-orange"><i class="icon-ban-circle"></i>
          <p><?php echo $lang['nc_cancel']; ?></p>
          </a></span>
          <?php } ?></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i></i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
