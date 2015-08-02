<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert mt15 mb5"><strong>操作提示：</strong>
  <ul>
    <li>1、选择店铺经营的商品分类，以读取平台绑定的商品分类-规格类型，如分类：“服装”；规格：“颜色”、“尺码”等；当商品分类具有“颜色”规格时，可选择色块加以标识。</li>
    <li>2、添加所属规格下的规格值，已有规格值可以删除，新增未保存的规格值可以移除；<font color="red">新增的规格值必须填写</font>，否则该行数据不会被更新或者保存。</li>
    <li>3、可通过排序0-255改变规格值显示顺序；在发布商品时勾选已绑定的商品规格，还可对规格值进行“别名”修改操作，但不会影响规格值默认名称的设定。</li>
  </ul>
</div>
<table class="search-form">
  <tr>
    <td class="w20">&nbsp;</td>
    <td class="w120"><strong>选择经营的商品分类</strong></td>
    <td>
        <span nctype="gc1">
        <?php if (!empty($output['gc_list'])) {?>
          <select nctype="gc" data-param="{deep:1}">
            <option><?php echo $lang['nc_please_choose'];?></option>
            <?php foreach ($output['gc_list'] as $val) {?>
            <option value="<?php echo $val['gc_id']?>"><?php echo $val['gc_name'];?></option>
            <?php }?>
          </select>
        <?php }?></span>
        <span nctype="gc2"></span>
        <span nctype="gc3"></span>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
<div nctype="class_spec" class="ncsc-goods-spec">
  <div nctype="spec_ul" class="spec-tabmenu"></div>
  <div nctype="spec_iframe" class="spec-iframe">
    <div class="norecord tc">
      <div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div>
    </div>
  </div>
</div>
<script>
$(function() {
    // 查询下级分类，分类不存在显示当前分类绑定的规格
    $('select[nctype="gc"]').change(function(){
        $(this).parents('td:first').nextAll().html('');
        $('div[nctype="spec_ul"]').html('');
        $('div[nctype="spec_iframe"]').html('');
        getClassSpec($(this));
    });
});

// ajax选择商品分类
function getClassSpec($this) {
    var id = parseInt($this.val());
    var data_str = ''; eval('data_str =' + $this.attr('data-param'));
    var deep = data_str.deep;
    if (isNaN(id)) {
        // 清理分类
        clearClassHtml(parseInt(deep)+1);
    }
    $.getJSON('index.php?act=store_spec&op=ajax_class&id=' + id + '&deep=' + deep, function(data){
    	$('div[nctype="spec_iframe"]').empty();
        $('div[nctype="spec_ul"]').empty();
        if (data) {
            if (data.type == 'class') {
                nextClass(data.data, data.deep);
            } else if (data.type == 'spec') {
                specList(data.data, data.deep, data.gcid);
            }
        }
    });
}

// 下一级商品分类
function nextClass(data, deep) {
    $('span[nctype="gc' + deep + '"]').html('').append('<select data-param="{deep:' + deep + '}"></select>')
        .find('select').change(function(){
            getClassSpec($(this));
        }).append('<option><?php echo $lang['nc_please_choose'];?></option>');
    $.each(data, function(i, n){
        if (n != null) {
            $('span[nctype="gc' + deep + '"] > select').append('<option value="' + n.gc_id + '">' + n.gc_name + '</option>');
        }
    });
    // 清理分类
    clearClassHtml(parseInt(deep)+1);
}

// 列出规格信息
function specList(data, deep, gcid) {
    if (typeof(data) != 'undefined' && data != '') {
        var $_ul = $('<ul></ul>');
        $.each(data, function(i, n){
            $_ul.append('<li><a href="javascript:void(0);" nctype="editSpec" data-param="{spid:'+ n.sp_id +',gcid:' + gcid + '}">编辑' + n.sp_name + '规格</a></li>');
        });
        $_ul.find('a').click(function(){
            $_ul.find('li').removeClass('selected');
            $(this).parents('li:first').addClass('selected');
            editSpecValue($(this));
        });
        $_ul.find('a:first').click();
        $('div[nctype="spec_ul"]').append($_ul);
    } else {
        $('div[nctype="spec_ul"]').append('<div class="warning-option"><i class="icon-warning-sign"></i><span>该分类不能添加规格</span></div>');
    }
    // 清理分类
    clearClassHtml(deep);
}

// 清理二级分类信息
function clearClassHtml(deep) {
    switch (deep) {
        case 2:
            $('span[nctype="gc2"]').empty();
        case 3:
            $('span[nctype="gc3"]').empty();
            break;
    }
}

// ajax编辑规格值
function editSpecValue(o) {
    $('div[nctype="spec_iframe"]').html('');
    var data_str = '';
    eval('data_str =' + o.attr('data-param'));
    $_iframe = $('<iframe id="iframepage" name="iframepage" frameBorder=0 scrolling=no width="100%" height="630px" src="<?php echo SHOP_SITE_URL;?>/index.php?act=store_spec&op=add_spec&spid=' + data_str.spid + '&gcid=' + data_str.gcid + '" ></iframe>');
    $('div[nctype="spec_iframe"]').append($_iframe);
}

</script> 
