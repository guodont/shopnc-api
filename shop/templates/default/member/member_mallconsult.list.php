<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
    <a class="ncm-btn ncm-btn-orange" href="<?php echo urlShop('member_mallconsult', 'add_mallconsult');?>"><i class="icon-comments-alt"></i>平台客服</a></div>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="tl">咨询内容</th>
        <th class="w150">咨询时间</th>
        <th class="w150">状态</th>
        <th class="w110">操作</th>
      </tr>
    </thead>
    <tbody>
      <?php  if (!empty($output['consult_list'])) { ?>
      <?php foreach($output['consult_list'] as $val) { ?>
      <tr class="bd-line">
        <td></td>
        <td class="tl"><?php echo $val['mc_content'];?></td>
        <td><?php echo date('Y-m-d H:i:s', $val['mc_addtime']);?></td>
        <td class=""><?php echo $output['state'][$val['is_reply']];?></td>
        <td class="ncm-table-handle">
          <span><a href="<?php echo urlShop('member_mallconsult', 'mallconsult_info', array('id' => $val['mc_id']));?>" class="btn-blue"><i class="icon-eye-open"></i><p>查看</p></a></span>
          <span><a href="javascript:void(0);" onclick="ajax_get_confirm('<?php echo $lang['nc_common_op_confirm'];?>', '<?php echo urlShop('member_mallconsult', 'del_mallconsult', array('id' => $val['mc_id']));?>');" class="btn-blue"><i class="icon-trash"></i><p>删除</p></a></span>
        </td>
      </tr>
      <?php } ?>
      <?php } else {?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (!empty($output['consult_list'])) { ?>
      <tr>
        <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
