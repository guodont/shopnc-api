<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>店铺帮助</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=help_store&op=help_store"><span><?php echo '帮助内容';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '帮助类型';?></span></a></li>
        <li><a href="index.php?act=help_store&op=add_type"><span><?php echo '新增类型';?></span></a></li>
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
            <li>系统初始化的类型不能删除</li>
            <li>帮助类型排序显示规则为排序小的在前，新增的在前</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['nc_sort'];?></th>
          <th>类型名称</th>
          <th class="align-center">显示</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['type_list']) && is_array($output['type_list'])){ ?>
        <?php foreach($output['type_list'] as $key => $val){ ?>
        <tr class="hover">
          <td class="w48 sort"><?php echo $val['type_sort'];?></td>
          <td><?php echo $val['type_name'];?></td>
          <td class="w150 align-center"><?php echo $val['help_show']==1 ? $lang['nc_yes'] : $lang['nc_no'];?></td>
          <td class="w150 align-center"><a href="index.php?act=help_store&op=edit_type&type_id=<?php echo $val['type_id'];?>"><?php echo $lang['nc_edit'];?></a>
            <?php if($val['help_code'] == 'auto'){?>
            |<a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')) window.location = 'index.php?act=help_store&op=del_type&type_id=<?php echo $val['type_id'];?>';"><?php echo $lang['nc_del'];?></a>
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
        <?php if(!empty($output['type_list']) && is_array($output['type_list'])){ ?>
        <tr class="tfoot">
          <td colspan="16">
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
</div>