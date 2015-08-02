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
		<li><a href="index.php?act=live_area&op=area_add&area_id"><span><?php echo $lang['nc_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
  	<input type="hidden" name="act" value="live_area">
  	<input type="hidden" name="op" value="live_area">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="area_name">区域名称:</label></th>
          <td>
          	<input type="text" value="<?php echo $output['live_area_name'];?>" name="live_area_name" id="live_area_name" class="txt">
          </td>
		  <th><label for="first_letter">首字母:</label></th>
		  <td>
			  <select name='first_letter'>
			    <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
				<?php foreach($output['letter'] as $l){?>
				<option value='<?php echo $l;?>' <?php if($l==$output['first_letter']){ echo 'selected';}?>><?php echo $l;?></option>
				<?php }?>
			  </select>
		  </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query']; ?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
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
            <li>显示一级城市名称，可以编辑、删除一级城市，点击查看区域，可以查看该城市下区域列表</li>
			<li>可以按照区域名称、首字母进行查询</li>
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
		  <th><?php echo $lang['live_area_manage_first_letter'];?></th>
		  <th><?php echo $lang['live_area_manage_area_number'];?></th>
		  <th><?php echo $lang['live_area_manage_post'];?></th>
		  <th>显示</th>
		  <th><?php echo $lang['live_area_manage_add_time'];?></th>
          <th class="w200 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
          <td><?php echo $val['live_area_name']?>&nbsp;<a class="btn-add-nofloat marginleft" href="index.php?act=live_area&op=area_add&live_area_id=<?php echo $val['live_area_id'];?>"><span><?php echo $lang['nc_store_add_new_class'];?></span></a></td>
		  <td><?php echo $val['first_letter'];?></td>
		  <td><?php echo $val['area_number'];?></td>
		  <td><?php echo $val['post'];?></td>
		  <td>
		  <?php if($val['hot_city'] == '1'){?>
		  <?php echo $lang['nc_yes'];?>
		  <?php }else{?>
		  <?php echo $lang['nc_no'];?>
		  <?php }?>
		  </td>
		  <td><?php echo date("Y-m-d",$val['add_time']);?></td>
		  <td class='align-center'>
		  	<a href="index.php?act=live_area&op=view_area&parent_area_id=<?php echo $val['live_area_id'];?>"><?php echo $lang['live_area_manage_view_area'];?></a>
		  	|<a href="index.php?act=live_area&op=area_edit&live_area_id=<?php echo $val['live_area_id'];?>"><?php echo $lang['nc_edit'];?></a> | 
            <a href="javascript:submit_delete(<?php echo $val['live_area_id'];?>)"><?php echo $lang['nc_del'];?></a>
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
            </span>&nbsp;&nbsp; <a href="javascript:void(0)" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>
			-->
            <div class="pagination"><?php echo $output['show_page'];?></div>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>