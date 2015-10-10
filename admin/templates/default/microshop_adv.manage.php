<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    //行内ajax编辑
    $('span[nc_type="adv_sort"]').inline_edit({act: 'microshop',op: 'adv_sort_update'});
});
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
        $('#list_form').attr('action','index.php?act=microshop&op=adv_drop');
        $('#adv_id').val(id);
        $('#list_form').submit();
    }
}
</script>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_microshop_adv_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <form method="get" name="formSearch">
        <input type="hidden" value="microshop" name="act">
        <input type="hidden" value="adv_manage" name="op">
        <table class="tb-type1 noborder search">
            <tbody>
                <tr>
                    <th><label for="commend_id"><?php echo $lang['microshop_adv_type'];?></label></th>
                    <td>
                        <select name="adv_type">
                            <?php if(!empty($output['adv_type_list']) && is_array($output['adv_type_list'])) {?>
                            <?php foreach($output['adv_type_list'] as $key=>$value) {?>
                            <option value="<?php echo $key;?>" <?php if($key==$_GET['adv_type']) {echo 'selected';}?>><?php echo $value;?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                    <th><label for="adv_name"><?php echo $lang['microshop_adv_name'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['adv_name'];?>" name="adv_name" class="txt"></td>
                    <td>
                        <a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"> <div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['microshop_adv_tip1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="adv_id" name="adv_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w48"><?php echo $lang['nc_sort'];?></th>
          <th class="w200"><?php echo $lang['microshop_adv_type'];?></th>
          <th><?php echo $lang['microshop_adv_name'];?></th>
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
          <td><input type="checkbox" value="<?php echo $val['adv_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span nc_type="adv_sort" column_id="<?php echo $val['adv_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $val['adv_sort'];?></span>
          <td><?php echo $output['adv_type_list'][$val['adv_type']];?></td>
          <td><?php echo $val['adv_name'];?></td>
          <td class="align-center">
              <a href="index.php?act=microshop&op=adv_edit&adv_id=<?php echo $val['adv_id'];?>"><?php echo $lang['nc_edit'];?></a> 
              <a href="javascript:submit_delete(<?php echo $val['adv_id'];?>)"><?php echo $lang['nc_del'];?></a>
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
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp; <a href="javascript:void(0)" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['show_page'];?></div>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
