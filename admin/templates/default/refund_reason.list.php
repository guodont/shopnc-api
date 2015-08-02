<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['refund_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=refund&op=refund_manage"><span><?php echo '待处理';?></span></a></li>
        <li><a href="index.php?act=refund&op=refund_all"><span><?php echo '所有记录';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '退款退货原因';?></span></a></li>
        <li><a href="index.php?act=refund&op=add_reason"><span><?php echo '新增原因';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>系统初始化的原因不能删除</li>
            <li>排序显示规则为排序小的在前，新增的在前</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['nc_sort'];?></th>
          <th>原因</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['reason_list']) && is_array($output['reason_list'])){ ?>
        <?php foreach($output['reason_list'] as $key => $val){ ?>
        <tr class="hover">
          <td class="w48 sort"><?php echo $val['sort'];?></td>
          <td><?php echo $val['reason_info'];?></td>
          <td class="w150 align-center"><a href="index.php?act=refund&op=edit_reason&reason_id=<?php echo $val['reason_id'];?>"><?php echo $lang['nc_edit'];?></a>
            <?php if($val['reason_id'] > 99){?>
            | <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')) window.location = 'index.php?act=refund&op=del_reason&reason_id=<?php echo $val['reason_id'];?>';"><?php echo $lang['nc_del'];?></a>
            <?php } ?>
            </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['reason_list']) && is_array($output['reason_list'])){ ?>
        <tr class="tfoot">
          <td colspan="16">
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
</div>