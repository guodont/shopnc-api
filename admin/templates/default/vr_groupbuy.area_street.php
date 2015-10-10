<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
function submit_delete_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_delete(items);
    }
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_delete(id){
    if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=vr_groupbuy&op=area_drop');
        $('#area_id').val(id);
        $('#list_form').submit();
    }
}

</script>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>虚拟抢购</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=vr_groupbuy&op=class_list"><span>分类管理</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=class_add"><span>添加分类</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=area_list"><span>区域管理</span></a></li>
        <li><a href="javascript:;" class="current"><span>查看商区</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>

  <form id="list_form" method='post'>
    <input id="area_id" name="area_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>商区名称</th>
          <th>所属区域</th>
          <th>添加时间</th>
          <th class="w200 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
          <td><?php echo $val['area_name']?></td>
          <td><?php echo $output['parent_area']['area_name'];?></td>
          <td><?php echo date("Y-m-d",$val['add_time']);?></td>
          <td class='align-center'>
              <a href="index.php?act=vr_groupbuy&op=area_edit&area_id=<?php echo $val['area_id'];?>"><?php echo $lang['nc_edit'];?></a> |
              <a href="javascript:submit_delete(<?php echo $val['area_id'];?>)"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td id="batchAction" colspan="15">
            <!--
            <span class="all_checkbox">
            <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp; <a href="javascript:void(0)" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>-->
            <div class="pagination"><?php echo $output['show_page'];?></div>
          </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
