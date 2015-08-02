<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_voucher_price_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
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
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
			<li><?php echo $lang['admin_voucher_price_tip1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="list_form" action="index.php?act=voucher&op=pricedrop">
    <input type="hidden" id="voucher_price_id" name="voucher_price_id" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th><?php echo $lang['admin_voucher_price_describe'];?></th>
          <th><?php echo $lang['admin_voucher_price_title'];?>(<?php echo $lang['currency_zh'];?>)</th>
          <th><?php echo $lang['admin_voucher_price_points'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $v){ ?>
        <tr class="hover">
          <td><input type="checkbox" name='voucher_price_checkbox' value="<?php echo $v['voucher_price_id'];?>" class="checkitem"></td>
          <td><span><?php echo $v['voucher_price_describe'];?></span></td>
          <td><span><?php echo $v['voucher_price'];?></span></td>
          <td><span><?php echo $v['voucher_defaultpoints'];?></span></td>
          <td class="w96 align-center">
          	<a href="index.php?act=voucher&op=priceedit&priceid=<?php echo $v['voucher_price_id'];?>"><?php echo $lang['nc_edit'];?></a>
          	<a href="JavaScript:void(0);" onclick="submit_delete('<?php echo $v['voucher_price_id'];?>')"><?php echo $lang['nc_del'];?></a>
          </td>
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
          <td><?php if(!empty($output['list']) && is_array($output['list'])){ ?>
            <input type="checkbox" class="checkall" id="checkall_1">
            <?php } ?></td>
          <td colspan="16">
          	<label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>&nbsp;&nbsp;
          	<a href="JavaScript:void(0);" class="btn" onclick="submit_delete_batch()"><span><?php echo $lang['nc_del']?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
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
function submit_delete(voucher_price_id){
    if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
        $('#list_form').attr('method','post');
        $('#voucher_price_id').val(voucher_price_id);
        $('#list_form').submit();
    }
}
</script>