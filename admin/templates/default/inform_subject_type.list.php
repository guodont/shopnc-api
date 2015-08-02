<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['inform_manage_title'];?></h3>
      <ul class="tab-base">
        <?php  foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php } else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['inform_help4'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="list_form" action="index.php?act=voucher_price&op=voucher_price_drop">
    <input type="hidden" id="inform_type_id" name="inform_type_id" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['inform_type'];?></th>
          <th><?php echo $lang['inform_type_desc'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $v){ ?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" name='voucher_price_checkbox' value="<?php echo $v['inform_type_id'];?>" class="checkitem"></td>
          <td><?php echo $v['inform_type_name'];?></td>
          <td><?php echo $v['inform_type_desc'];?></td>
          <td class="w72 align-center"><a href="JavaScript:void(0);" onclick="submit_delete('<?php echo $v['inform_type_id'];?>')"><?php echo $lang['nc_del'];?></a></td>
          <?php } ?>
          <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr class="tfoot">
          <td><?php if(!empty($output['list']) && is_array($output['list'])){ ?>
            <input type="checkbox" class="checkall" id="checkall_1">
            <?php } ?></td>
          <td colspan="16"><label for="checkall_1"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_delete_batch()"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.goods_class.js" charset="utf-8"></script> 
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
}
function submit_delete(inform_type_id){
    if(confirm('<?php echo $lang['inform_type_delete_confirm'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=inform&op=inform_subject_type_drop');
        $('#inform_type_id').val(inform_type_id);
        $('#list_form').submit();
    }
}
</script> 
