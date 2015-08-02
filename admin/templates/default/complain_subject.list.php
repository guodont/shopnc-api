<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['complain_manage_title'];?></h3>
      <ul class="tab-base">
        <?php
            foreach($output['menu'] as $menu) {
                if($menu['menu_type'] == 'text') {
        ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php
                }
                else {
        ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php
               }
           }
        ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method='post' id="list_form" action="">
    <input type="hidden" id="complain_subject_id" name="complain_subject_id" value="" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th><?php echo $lang['complain_subject_content'];?></th>
          <th><?php echo $lang['complain_subject_desc'];?></th>
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $v){ ?>
        <tr class="hover">
          <td><input type="checkbox" name='voucher_price_checkbox' value="<?php echo $v['complain_subject_id'];?>" class="checkitem"></td>
          <td><?php echo $v['complain_subject_content'];?></td>
          <td><?php echo $v['complain_subject_desc'];?></td>
          <td class="align-center"><a href="JavaScript:void(0);" onclick="submit_delete('<?php echo $v['complain_subject_id'];?>')"><?php echo $lang['nc_del'];?></a></td>
          <?php } ?>
          <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
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
            &nbsp;&nbsp;<a href="JavaScript:void(0);" id="btn_batch_drop" class="btn" onclick="submit_delete_batch()"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
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
function submit_delete(complain_subject_id){
    if(confirm('<?php echo $lang['confirm_delete'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=complain&op=complain_subject_drop');
        $('#complain_subject_id').val(complain_subject_id);
        $('#list_form').submit();
    }
}
</script>