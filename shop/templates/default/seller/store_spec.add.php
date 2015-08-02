<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/seller_center.css" rel="stylesheet" type="text/css">
<link href="<?php echo RESOURCE_SITE_URL;?>/js/colorpicker/evol.colorpicker.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
  <link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css" rel="stylesheet" type="text/css">
<![endif]-->
<style type="text/css">
body {
	background-color: transparent;
}
.evo-colorind, .evo-colorind-ie, .evo-colorind-ff {
	width: 21px;
	height: 28px;
	border: solid #CCC;
	border-width: 1px 1px 1px 0;
	float: right;
}
.iframe-box {
	width: 100%;
	max-height: 550px;
	overflow: hidden;
	position: relative;
}
.iframe-content {
	width: 100%;
}
</style>
</head>

<body>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<form id="spec_form" method="post" action="<?php echo SHOP_SITE_URL;?>/index.php?act=store_spec&op=save_spec">
  <input type="hidden" name="form_submit" value="ok" />
  <input type="hidden" name="sp_id" value="<?php echo $output['sp_info']['sp_id'];?>" />
  <input type="hidden" name="gc_id" value="<?php echo $output['gc_info']['gc_id'];?>" />
  <div class="ncsc-spec-info" style=" width: 960px;"><span>规格名称：<?php echo $output['sp_info']['sp_name'];?></span><span>所属分类：<?php echo $output['gc_info']['gc_name'];?></span><a href="javascript:void(0);" nctype="add_sv" class="ncsc-btn"><i class="icon-th-list"></i>添加规格值</a></div>
  <table class="ncsc-default-table" style="width: 960px;">
    <thead>
      <tr>
        <th class="w80">排序</th>
        <th class="tl">规格值名称</th>
        <?php if ($output['sp_info']['sp_id'] == DEFAULT_SPEC_COLOR_ID) {?>
        <th class="w300 tl">颜色色块</th>
        <?php }?>
        <th class="w110">操作</th>
      </tr>
    </thead>
  </table>
  <div id="iframe" class="iframe-box" style=" width: 960px;">
    <div class="iframe-content">
      <table class="ncsc-default-table">
        <tbody nctype="spec_tbody">
          <?php if(!empty($output['sp_value_list'])){?>
          <?php foreach ($output['sp_value_list'] as $value) {?>
          <tr class="bd-line">
            <td class="w80"><input type="text" class="text w40" name="sv[old][<?php echo $value['sp_value_id'];?>][sort]" value="<?php echo $value['sp_value_sort'];?>" /></td>
            <td class="tl"><input type="text" class="text w250" name="sv[old][<?php echo $value['sp_value_id'];?>][name]" value="<?php echo $value['sp_value_name'];?>" /></td>
            <?php if ($output['sp_info']['sp_id'] == DEFAULT_SPEC_COLOR_ID) {?>
            <td class="w300 tl"><input type="text" class="text w100" name="sv[old][<?php echo $value['sp_value_id'];?>][color]" value="<?php echo $value['sp_value_color'];?>" nctype="spec_color" /></td>
            <?php }?>
            <td class="w110 nscs-table-handle"><span><a href="javascript:void(0);" class="btn-red" nctype="spec_del" data-param="{id:<?php echo $value['sp_value_id'];?>}"><i class="icon-trash"></i>
              <p>删除</p>
              </a></span></td>
          </tr>
          <?php }?>
          <?php } else {?>
          <tr class="bd-line">
            <td class="w80"><input type="text" class="text w40" name="sv[new][1][sort]" value="0" /></td>
            <td class="tl"><input type="text" class="text w250" name="sv[new][1][name]" /></td>
            <?php if ($output['sp_info']['sp_id'] == DEFAULT_SPEC_COLOR_ID) {?>
            <td class="w300 tl"><input type="text" class="text w100" name="sv[new][1][color]" nctype="spec_color" /></td>
            <?php }?>
            <td class="w110 nscs-table-handle"><span><a href="javascript:void(0);" class="btn-orange" nctype="tr_remove"><i class="icon-minus-sign"></i>
              <p>移除</p>
              </a></span></td>
          </tr>
          <?php }?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="20" class="bottom"><a href="javascript:void(0);" nctype="submit-btn" class="submit mt20">提交保存规格值</a></td></tr><tr>
            <td colspan="20" class="h200"></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</form>
</body>
</html>
<script>
var SITEURL = "<?php echo SHOP_SITE_URL;?>";
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/colorpicker/evol.colorpicker.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/perfect-scrollbar.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script>
$(function(){
    // 提交表单
    $('a[nctype="submit-btn"]').click(function(){
        var _submit = true;
        $('#spec_form').find('input[name$="[name]"]').each(function(){
            if ($(this).val() == '') {
                _submit = false;
                if (!$(this).hasClass('error')) {
                    $(this).addClass('error').parents('td:first').append('<label class="error"><i class="icon-exclamation-sign"></i>请填写内容</label>');
                }
            }
        });
        if (_submit) {
            ajaxpost('spec_form', '<?php echo SHOP_SITE_URL;?>/index.php?act=store_spec&op=save_spec', '', 'onerror');
        }
    });

    // 颜色选择器
    $('input[nctype="spec_color"]').colorpicker({showOn:'both'}).removeAttr('nctype');

    // 移除
    $('a[nctype="tr_remove"]').click(function(){
        $(this).parents('tr:first').remove();
    });

    // 删除
    $('a[nctype="spec_del"]').click(function(){
        var $this = $(this);
        eval('data_str = ' + $this.attr('data-param'));
        $.getJSON('index.php?act=store_spec&op=ajax_delspec&id='+data_str.id, function(data){
            if(data){
                $this.parents('tr:first').remove();
            }
        });
    });

    // 添加规格值
    var i = 2;  // 自增，防止冲突
    $('a[nctype="add_sv"]').click(function(){
        var _tr = $('<tr class="bd-line"></tr>');
		$('<td class="w80"><input type="text" class="text w40" name="sv[new]['+ i +'][sort]" value="0" /></td>').appendTo(_tr);   // 排序
        $('<td class="tl"><input type="text" class="text w250" name="sv[new]['+ i +'][name]" /></td>').appendTo(_tr);      // 规格名称
        <?php if ($output['sp_info']['sp_id'] == DEFAULT_SPEC_COLOR_ID) {?>
        $('<td class="w300 tl"><input type="text" class="text w100" name="sv[new]['+ i +'][color]" nctype="spec_color" /></td>').appendTo(_tr);  // 颜色色块
        <?php }?>
        
        $('<td class="w110 nscs-table-handle"><span><a href="javascript:void(0);" class="btn-orange"><i class="icon-minus-sign"></i><p>移除</p></a</span></td>').find('a').click(function(){
            $(this).parents('tr:first').remove();
        }).end().appendTo(_tr);   // 操作
        _tr.appendTo('tbody[nctype="spec_tbody"]');
        // 颜色选择器
        $('tbody[nctype="spec_tbody"]').find('input[nctype="spec_color"]').colorpicker({showOn:'both'}).removeAttr('nctype');
        i++;
    });
});
//超出父级页面iframe设定高度时滚动条
$(document).ready(function() {
	$('#iframe').perfectScrollbar();
});
</script>
