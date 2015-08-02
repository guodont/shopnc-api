<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['groupbuy_index_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['groupbuy_price_range_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  
  <form id="list_form" method='post'>
    <input id="range_id" name="range_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['range_name'];?></th>
          <th class="align-center"><?php echo $lang['range_start'];?></th>
          <th class="align-center"><?php echo $lang['range_end'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover">
          <td class="w36"><input type="checkbox"  value="<?php echo $val['range_id'];?>" class="checkitem"></td>
          <td><?php echo $val['range_name'];?></td>
          <td class="w18pre align-center"><?php echo $val['range_start'];?></td>
          <td class="w18pre align-center"><?php echo $val['range_end'];?></td>
          <td class="w156 align-center"><a href="index.php?act=groupbuy&op=price_edit&range_id=<?php echo $val['range_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="JavaScript:void(0);" onClick="submit_delete('<?php echo $val['range_id'];?>')"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
        <tr><td colspan="20"><a href="<?php echo urlAdmin('groupbuy', 'price_add');?>" class="btn-add marginleft"><?php echo $lang['groupbuy_price_add'];?></a></td></tr>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
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
        $('#list_form').attr('action','index.php?act=groupbuy&op=price_drop');
        $('#range_id').val(id);
        $('#list_form').submit();
    }
}

</script>
