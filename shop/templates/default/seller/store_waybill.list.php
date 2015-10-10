<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <a title="建立模板" class="ncsc-btn ncsc-btn-green" href="<?php echo urlShop('store_waybill', 'waybill_add');?>">添加模板</a> </div>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、商家已经建立的打印模板列表</li>
    <li>2、点击右上角的添加模板按钮可以建立商家自己的模板</li>
    <li>3、点击设计按钮可以对运单模板布局进行设计，点击测试按钮可以对模板进行打印测试，点击编辑按钮可以对模板参数进行调整</li>
    <li>4、设计完成后在编辑中修改模板状态为启用后，商家就可以绑定该模板进行运单打印</li>
    <li>5、点击删除按钮可以删除现有模板，删除后该模板将自动解除绑定，请慎重操作</li>
  </ul>
</div>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w30"></th>
      <th class="w120 tl">模板名称</th>
      <th class="w120 tl">物流公司</th>
      <th class="tl">运单图例</th>
      <th class="w80">上偏移量</th>
      <th class="w80">左偏移量</th>
      <th class="w80">启用</th>
      <th class="w200"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['waybill_list']) && is_array($output['waybill_list'])){?>
    <?php foreach($output['waybill_list'] as $key => $value){?>
    <tr class="bd-line">
      <td></td>
      <td class="tl"><?php echo $value['waybill_name'];?></td>
      <td class="tl"><?php echo $value['express_name'];?></td>
      <td class="tl"><div class="waybill-img-thumb"><a class="nyroModal" rel="gal" href="<?php echo $value['waybill_image_url'];?>"><img src="<?php echo $value['waybill_image_url'];?>"></a></div>
        <div class="waybill-img-size">
          <p>宽度：<?php echo $value['waybill_width'];?>(mm)</p>
          <p>高度：<?php echo $value['waybill_height'];?>(mm)</p>
        </div></td>
        </td>
      <td><?php echo $value['waybill_top'];?></td>
      <td><?php echo $value['waybill_left'];?></td>
      <td><?php echo $value['waybill_usable_text'];?></td>
      <td class="nscs-table-handle"><span><a href="<?php echo urlShop('store_waybill', 'waybill_design', array('waybill_id' => $value['waybill_id']));?>" class="btn-orange"><i class="icon-edit"></i>
        <p>设计</p>
        </a></span><span><a href="<?php echo urlShop('store_waybill', 'waybill_test', array('waybill_id' => $value['waybill_id']));?>" class="btn-acidblue" target="_blank"><i class="icon-print"></i>
        <p>测试</p>
        </a></span><span><a href="<?php echo urlShop('store_waybill', 'waybill_edit', array('waybill_id' => $value['waybill_id']));?>" class="btn-blue"><i class="icon-edit"></i>
        <p>编辑</p>
        </a></span><span><a href="javascript:;" nctype="btn_del" data-waybill-id="<?php echo $value['waybill_id'];?>" class="btn-red"><i class="icon-trash"></i>
        <p>删除</p>
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
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
</table>
<form id="del_form" action="<?php echo urlShop('store_waybill', 'waybill_del');?>" method="post">
  <input type="hidden" id="del_waybill_id" name="waybill_id">
</form>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
    $(document).ready(function() {
        $('[nctype="btn_del"]').on('click', function() {
            if(confirm('确认删除?')) {
                $('#del_waybill_id').val($(this).attr('data-waybill-id'));
                $('#del_form').submit();
            }
        });

        //点击查看大图	
    	$('.nyroModal').nyroModal();
    });
</script> 
