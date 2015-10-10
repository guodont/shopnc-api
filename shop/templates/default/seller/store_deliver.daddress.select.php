<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div class="adds" style=" min-height:240px;">
    <table class="ncsc-default-table">
    <?php if (is_array($output['address_list']) && !empty($output['address_list'])){?>
      <thead>
        <tr>
          <th class="w80"><?php echo $lang['store_deliver_man'];?></th>
          <th><?php echo $lang['store_deliver_daddress'];?></th>
          <th class="w100"><?php echo $lang['store_deliver_telphone'];?></th>
          <th class="w80"><?php echo $lang['nc_common_button_operate'];?></th>
        </tr>
      </thead>
      
      <tbody>
        <?php foreach ($output['address_list'] as $key => $value) {?>
        <tr class="bd-line">
          <td class="tc"><?php echo $value['seller_name'];?></td>
          <td><?php echo $value['area_info'];?> <?php echo $value['address'];?></td>
          <td class="tc"><?php echo $value['telphone'];?></td>
          <td class="tc"><a href="javascript:void(0);" nc_type="select" class="ncsc-btn" address_id="<?php echo $value['address_id'];?>" address_value="<?php echo $value['seller_name'].'&nbsp;'.$value['telphone'].'&nbsp;'.$value['area_info'].'&nbsp;'.$value['address'];?>"><?php echo $lang['nc_common_button_select'];?></a></td>
        </tr>
        <?php }?>
        <tr class="bd-line">
          <td colspan="20"></td>
        </tr>
      </tbody>
      <?php } else {?>
      <tboby><tr><td colspan="5"><?php echo $lang['store_deliver_none_set'];?></td></tr></tboby>
      <?php }?>
    </table>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('a[nc_type="select"]').on('click',function(){
        var daddress_id = $(this).attr('address_id');
        var address_value = $(this).attr('address_value');
        $.post(
            "<?php echo urlShop('store_deliver', 'send_address_save');?>", 
            {order_id: <?php echo $output['order_id'];?>, daddress_id: daddress_id}
        )
        .done(function(data) {
            if(data == 'true') {
                $('#daddress_id').val(daddress_id);
                $('#seller_address_span').html(address_value);
                DialogManager.close('modfiy_daddress');
            } else {
                showError('修改失败');
            }
        }); 
	});
});
</script>
