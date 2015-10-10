<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
    <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、未绑定的物流公司后边会出现<strong>“选择模板”</strong>按钮，在选择模板页面可以绑定可用的打印模板。</li>
    <li>2、点击<strong>“设置”</strong>按钮可以设置自定义的内容，包括偏移量和需要显示的项目。</li>
    <li>3、点击<strong>“默认”</strong>按钮可以设置当前模板为默认打印模板。</li>
    <li>4、点击<strong>“解绑”</strong>按钮可以解除当前绑定，重新选择其它模板。</li>
  </ul>
</div>
<table class="ncsc-default-table">
    <thead>
        <tr>
            <th class="w30"></th>
            <th class="w180 tl">物流公司</th>            
            <th class="w180 tl">运单模板</th>
            <th class="tl">运单图例</th>
            <th class="w100 tl">默认</th>
            <th class="w150"><?php echo $lang['nc_handle'];?></th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['express_list']) && is_array($output['express_list'])){?>
        <?php foreach($output['express_list'] as $key => $value){?>
        <tr class="bd-line">
            <td></td>
            <td class="tl"><?php echo $value['e_name'];?></td>
            <td class="tl"><?php echo $value['waybill_name'];?></td>
            <td class="tl">
                <?php if($value['bind']) { ?>
                <div class="waybill-img-thumb">
                    <a class="nyroModal" rel="gal" href="<?php echo $value['waybill_image_url'];?>">
                        <img src="<?php echo $value['waybill_image_url'];?>">
                    </a>
                </div>
                <div class="waybill-img-size">
                    <p>宽度：<?php echo $value['waybill_width'];?>(mm)</p>
                    <p>高度：<?php echo $value['waybill_height'];?>(mm)</p>
                </div>
                <?php } ?>
    </td>
    <td class="tl"><?php echo $value['is_default_text'];?></td>
    <td class="nscs-table-handle">
        <span>
            <?php if($value['bind']) { ?>
            <a href="<?php echo urlShop('store_waybill', 'waybill_setting', array('store_waybill_id' => $value['store_waybill_id']));?>" class="btn-blue"><i class="icon-wrench"></i><p>设置</p></a></span><span><a href="javascript:;" nctype="btn_set_default" data-store-waybill-id="<?php echo $value['store_waybill_id'];?>" class="btn-green"><i class="icon-ok-sign"></i><p>默认</p></a></span><span><a href="javascript:;" nctype="btn_unbind" data-store-waybill-id="<?php echo $value['store_waybill_id'];?>" class="btn-red"><i class="icon-unlink"></i><p>解绑</p></a></span>
        <?php } else { ?>
                    <span><a href="<?php echo urlShop('store_waybill', 'waybill_bind', array('express_id' => $value['id']));?>" class="btn-blue"><i class="icon-ok-circle"></i><p>选择模板</p></a>
                    <?php } ?>
                </span>
            </td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
            <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i>
                    <span>您还没有选择默认物流公司，<a href="<?php echo urlShop('store_deliver_set', 'express');?>">去设置</a></span>
            </div></td>
        </tr>
        <?php }?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
        </tr>
    </tfoot>
</table>
<form id="edit_form" method="post">
    <input id="store_waybill_id" name="store_waybill_id" type="hidden" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_unbind"]').on('click', function() {
            if(confirm('确认解绑？')) {
                $('#store_waybill_id').val($(this).attr('data-store-waybill-id'));
                $('#edit_form').attr('action', "<?php echo urlShop('store_waybill', 'waybill_unbind');?>");
                $('#edit_form').submit();
            }
        });

        $('[nctype="btn_set_default"]').on('click', function() {
            $('#store_waybill_id').val($(this).attr('data-store-waybill-id'));
            $('#edit_form').attr('action', "<?php echo urlShop('store_waybill', 'waybill_set_default');?>");
            $('#edit_form').submit();
        });
    });
</script>

