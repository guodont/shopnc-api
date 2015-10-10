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
        $('#list_form').attr('action','index.php?act=live_area&op=area_drop');
        $('#live_area_id').val(id);
        $('#list_form').submit();
    }
}

</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>线下区域</h3>
      <ul class="tab-base">
        <li><a href="javascript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
		<li><a href="index.php?act=live_area&op=area_add&live_area_id=<?php echo $output['parent_area']['live_area_id'];?>"><span><?php echo $lang['nc_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg">
			<div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div>
		</th>
      </tr>
      <tr>
        <td>
		  <ul>
            <li><?php echo $lang['nc_admin_area_help'];?></li>
            <li><?php echo $lang['nc_admin_area_help1'];?></li>
          </ul>
		</td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="live_area_id" name="live_area_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th><?php echo $lang['live_area_manage_area_name'];?></th>
		  <th><?php echo $lang['live_area_manage_belong_to_city'];?></th>
		  <th><?php echo $lang['live_area_manage_add_time'];?></th>
          <th class="w200 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
          <td><?php echo $val['live_area_name']?>&nbsp;<a class="btn-add-nofloat marginleft" href="index.php?act=area&op=area_add&area_id=<?php echo $val['area_id'];?>"><span><?php echo $lang['nc_admin_add_area_name'];?></span></a></td>
		  <td><?php echo $output['parent_area']['live_area_name'];?></td>
		  <td><?php echo date("Y-m-d",$val['add_time']);?></td>
		  <td class='align-center'><a href="index.php?act=live_area&op=view_mall_street&parent_area_id=<?php echo $val['live_area_id'];?>"><?php echo $lang['live_area_manage_view_mall'];?></a> | <a href="index.php?act=live_area&op=area_edit&live_area_id=<?php echo $val['live_area_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:submit_delete(<?php echo $val['live_area_id'];?>)"><?php echo $lang['nc_del'];?></a></td>
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
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>