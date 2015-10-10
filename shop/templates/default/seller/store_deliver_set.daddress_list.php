<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <a href="javascript:void(0)" class="ncsc-btn ncsc-btn-green" nc_type="dialog" dialog_title="<?php echo $lang['store_daddress_new_address'];?>" dialog_id="my_address_add"  uri="index.php?act=store_deliver_set&op=daddress_add" dialog_width="550" title="<?php echo $lang['store_daddress_new_address'];?>"><?php echo $lang['store_daddress_new_address'];?></a></div>
<div></div>
<table class="ncsc-default-table" >
  <thead>
    <tr>
      <th class="w70">是否默认</th>
      <th class="w90"><?php echo $lang['store_daddress_receiver_name'];?></th>
      <th class="tl"><?php echo $lang['store_daddress_deliver_address'];?></th>
      <th class="w150"><?php echo $lang['store_daddress_phone'];?></th>
      <th class="w110"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['address_list']) && is_array($output['address_list'])){?>
    <?php foreach($output['address_list'] as $key=>$address){?>
    <tr class="bd-line">
      <td>
        <label for="is_default_<?php echo $address['address_id'];?>"><input type="radio" id="is_default_<?php echo $address['address_id'];?>" name="is_default" <?php if ($address['is_default'] == 1) echo 'checked';?> value="<?php echo $address['address_id'];?>">
        <?php echo $lang['store_daddress_default'];?></label>
      </td>
      <td><?php echo $address['seller_name'];?></td>
      <td class="tl"><?php echo $address['area_info'];?>&nbsp;<?php echo $address['address'];?></td>
      <td><span class="tel"><?php echo $address['telphone'];?></span> <br/>
      <td class="nscs-table-handle"><span><a href="javascript:void(0);" dialog_id="my_address_edit" dialog_width="640" dialog_title="<?php echo $lang['store_daddress_edit_address'];?>" nc_type="dialog" uri="index.php?act=store_deliver_set&op=daddress_add&address_id=<?php echo $address['address_id'];?>" class="btn-blue"><i class="icon-edit"></i>
        <p><?php echo $lang['nc_edit'];?></p>
        </a></span><span> <a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store_deliver_set&op=daddress_del&address_id=<?php echo $address['address_id'];?>');" class="btn-red"><i class="icon-trash"></i>
        <p><?php echo $lang['nc_del'];?></p>
        </a></span></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script> 
<script>
$(function (){
	$('input[name="is_default"]').on('click',function(){
		$.get('index.php?act=store_deliver_set&op=daddress_default_set&address_id='+$(this).val(),function(result){})
	});
});
</script> 
