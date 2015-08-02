<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
#gcategory select {margin-left:4px}
</style>
<div class="ncsc-form-default">
  <form method="post" action="index.php?act=store_info&op=bind_class_save" target="_parent" name="store_bind_class_form" id="store_bind_class_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input id="goods_class" name="goods_class" type="hidden" value="">
    <dl>
      <dt>选择分类<?php echo $lang['nc_colon'];?></dt>
      <dd id="gcategory">
          <select id="gcategory_class1" style="width: auto;">
            <option value="0">请选择</option>
            <?php if(!empty($output['gc_list']) && is_array($output['gc_list']) ) {?>
            <?php foreach ($output['gc_list'] as $gc) {?>
            <option value="<?php echo $gc['gc_id'];?>"><?php echo $gc['gc_name'];?></option>
            <?php }?>
            <?php }?>
          </select>
<span>
<label id="error_message" style="display: none" class="error" for="sn_title"><i class="icon-exclamation-sign"></i>请选择分类</label>
</span>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="button" id="btn_add_bind_class" class="submit" value="<?php echo $lang['nc_submit'];?>" /></label>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	gcategoryInit("gcategory");
	//页面输入内容验证
    $('#btn_add_bind_class').on('click', function() {
        $('#error_message').hide();
        var category_id = '';
        var validation = true;
        $('#gcategory').find('select').each(function() {
            if(parseInt($(this).val(), 10) > 0) {
                category_id += $(this).val() + ',';
            } else {
                validation = false;
            }
        });
        if(!validation) {
            $('#error_message').show();
            return false;
        }
        $('#goods_class').val(category_id);

        var rate = $('#gcategory').find('select').last().find('option:selected').attr('data-explain') + '%';
        showDialog('所选分类的分佣比例为：' + rate + ' ， 确认申请吗？', 'confirm', '', function(){
        	ajaxpost('store_bind_class_form', '', '', 'onerror')
        });
    });
});
</script> 
