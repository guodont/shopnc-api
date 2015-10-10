<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>开店首页</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store_joinin&op=edit_info"><span><?php echo '图片及提示';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '入驻指南';?></span></a></li>
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
            <li>排序显示规则为排序小的在前</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['nc_sort'];?></th>
          <th>标题</th>
          <th class="align-center">更新时间</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['help_list']) && is_array($output['help_list'])){ ?>
        <?php foreach($output['help_list'] as $key => $val){ ?>
        <tr class="hover">
          <td class="w48 sort"><?php echo $val['help_sort'];?></td>
          <td><?php echo $val['help_title'];?></td>
          <td class="w150 align-center"><?php echo date('Y-m-d H:i:s',$val['update_time']);?></td>
          <td class="w150 align-center"><a href="index.php?act=store_joinin&op=edit_help&help_id=<?php echo $val['help_id'];?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>