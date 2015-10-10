<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w30"></th>
      <th class="w180 tl">模板名称</th>
      <th class="w180 tl">物流公司</th>
      <th class="tl">运单图例</th>
      <th class="w180">模板类型</th>
      <th class="w110"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['waybill_list']) && is_array($output['waybill_list'])){?>
    <?php foreach($output['waybill_list'] as $key => $value){?>
    <tr class="bd-line">
      <td></td>
      <td class="tl"><?php echo $value['waybill_name'];?></td>
      <td class="tl"><?php echo $output['express_info']['e_name'];?></td>
      <td class="tl"><div class="waybill-img-thumb"><a class="nyroModal" rel="gal" href="<?php echo $value['waybill_image_url'];?>"><img src="<?php echo $value['waybill_image_url'];?>"></a></div>
        <div class="waybill-img-size">
          <p>宽度：<?php echo $value['waybill_width'];?>(mm)</p>
          <p>高度：<?php echo $value['waybill_height'];?>(mm)</p>
        </div></td>
      <td><?php echo $value['waybill_type_text'];?></td>
      <td class="nscs-table-handle"><span><a href="<?php echo urlShop('store_waybill', 'waybill_test', array('waybill_id' => $value['waybill_id']));?>" class="btn-acidblue" target="_blank"><i class="icon-print"></i>
        <p>测试</p>
        </a></span><span><a href="javascript:;" nctype="btn_bind" class="btn-green" data-waybill-id="<?php echo $value['waybill_id'];?>"><i class="icon-link"></i>
        <p>绑定</p>
        </a></span></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span>还没有可用的运单模板，<a href="<?php echo urlShop('store_waybill', 'waybill_add');?>">去建立模板</a></span></div></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
</table>
<form id="bind_form" action="<?php echo urlShop('store_waybill', 'waybill_bind_save');?>" method="post">
  <input type="hidden" name="express_id" value="<?php echo $output['express_info']['id'];?>">
  <input type="hidden" id="waybill_id" name="waybill_id" value="">
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_bind"]').on('click', function() {
            $('#waybill_id').val($(this).attr('data-waybill-id'));
            $('#bind_form').submit();
        });
    });
</script> 
