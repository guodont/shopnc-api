<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <form id="list_form" method="get">
    <table class="ncm-search-table">
      <input type="hidden" id='act' name='act' value='member_inform' />
      <input type="hidden" id='op' name='op' value='inform_list' />
      <tr>
        <td></td>
        <td class="w100 tr"><select name="select_inform_state">
            <option value="0" <?php if (!$_GET['select_inform_state'] == '0'){echo 'selected=true';}?>> <?php echo $lang['inform_state_all']; ?> </option>
            <option value="1" <?php if ($_GET['select_inform_state'] == '1'){echo 'selected=true';}?>> <?php echo $lang['inform_state_unhandle'];?> </option>
            <option value="2" <?php if ($_GET['select_inform_state'] == '2'){echo 'selected=true';}?>> <?php echo $lang['inform_state_handled'];?> </option>
          </select></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" onclick="submit_search_form()" value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th colspan="2"><?php echo $lang['inform_goods_name'];?></th>
        <th class="w240">&nbsp;</th>
        <th class="w120"><?php echo $lang['inform_datetime'];?></th>
        <th class="w120"><?php echo $lang['inform_state'];?><?php echo $lang['inform_handle_type'];?></th>
        <th class="w110"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php if (count($output['list'])>0) { ?>
    <tbody>
      <?php foreach($output['list'] as $val) {?>
      <tr class="bd-line">
        <td></td>
        <td class="w50"><div class="pic-thumb"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$val['inform_goods_id']));?>" target="_blank"><img src="<?php echo cthumb($val['inform_goods_image'],60,$val['inform_store_id']);?>" onMouseOver="toolTip('<img src=<?php echo cthumb($val['inform_goods_image'],160,$val['inform_store_id']); ?>>')" onMouseOut="toolTip()"/></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$val['inform_goods_id']));?>" target="_blank"> <?php echo $val['inform_goods_name']; ?> </a></dt>
            <dd>商家：<a href="<?php echo urlShop('show_store','index',array('store_id'=>$val['inform_store_id']));?>"><?php echo $val['inform_store_name']; ?></a> </dd>
          </dl></td>
        <td class="tl"><p><?php echo $lang['inform_type'];?>：<?php echo $val['inform_subject_type_name'];?></p>
          <p><?php echo $lang['inform_subject'];?>：<?php echo $val['inform_subject_content'];?></td>
        <td><?php echo date("Y-m-d",$val['inform_datetime']);?></td>
        <td><p>
            <?php
                          if($val['inform_state']==='1') echo $lang['inform_state_unhandle'];
                          if($val['inform_state']==='2') echo $lang['inform_state_handled'];
                      ?>
          </p>
          <p>
            <?php
                          if($val['inform_handle_type']==='1') echo $lang['inform_handle_type_unuse'];
                          if($val['inform_handle_type']==='2') echo $lang['inform_handle_type_venom'];
                          if($val['inform_handle_type']==='3') echo $lang['inform_handle_type_valid'];
                      ?>
          </p></td>
        <td class="ncm-table-handle"><span><a href="index.php?act=member_inform&op=inform_info&inform_id=<?php echo $val['inform_id']; ?>" class="btn-blue"><i class="icon-eye-open"></i>
          <p><?php echo $lang['nc_view'];?></p>
          </a></span>
          <?php if($val['inform_state']==='1') { ?>
          <span><a class="btn-orange" href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['inform_cancel_confirm'];?>', 'index.php?act=member_inform&op=inform_cancel&inform_id=<?php echo $val['inform_id']; ?>');"><i class="icon-ban-circle"></i>
          <p><?php echo $lang['nc_cancel']; ?></p>
          </a></span>
          <?php } ?></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
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
