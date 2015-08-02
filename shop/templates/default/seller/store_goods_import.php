<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/store_goods_add.step2.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>



<script>
function pre_submit()
{
	var sels=$("#gcategory").find("select");
	var i=0;
	var txt="";
	 sels.each(function(){
		 i++;
		 $(this).attr("name","cls_"+i);
		 var tmp=$(this).find("option:selected").text();
		 if(i!=3)tmp+="&gt;";
		 txt+=tmp;
		
	 });
	 $("#cate_name").val(txt);
	 return true;
}
</script>
<!-- S setp -->
<ul class="add-goods-step">
  <li style="width:32%;" class="<?php $output['step']=="1" ? print "current" : print "";?>"><i class="icon icon-list-alt"></i>
    <h6>STIP.1</h6>
    <h2><?php echo $lang['store_goods_import_step1'];?></h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li style="width:32%;" class="<?php $output['step']=="4" ? print "current" : print "";?>"><i class="icon icon-camera-retro "></i>
    <h6>STIP.2</h6>
    <h2><?php echo $lang['store_goods_import_step2'];?></h2>
</ul>
<!--S 分类选择区域-->
<!--S 分类选择区域-->
<div class="alert mt15 mb5"><strong>操作提示：</strong>
  <ul>
    <li><?php echo $lang['store_goods_import_csv_desc'];?></li>
  </ul>
</div>
<form method="post" action="index.php?act=taobao_import&op=index" enctype="multipart/form-data" id="goods_form" onsubmit="return pre_submit();">
  <div class="ncsc-form-goods"  <?php if($output['step'] != '1'){?> style="display:none"<?php }?>>
    <dl>
      <dt><i class="required">*</i>CSV文件：</dt>
      <dd>
        <div class="handle">
        <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="15"  name="csv" id="csv">
          </span></a></div>
          </div>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_index_goods_class'].$lang['nc_colon'];?></dt>
      <dd id="gcategory"> <span nctype="gc1">
        <?php if (!empty($output['gc_list'])) {?>
        <select nctype="gc" data-param="{deep:1}">
          <option><?php echo $lang['nc_please_choose'];?></option>
          <?php foreach ($output['gc_list'] as $val) {?>
          <option value="<?php echo $val['gc_id']?>"><?php echo $val['gc_name'];?></option>
          <?php }?>
        </select>
        <?php }?>
        </span> <span nctype="gc2"></span> <span nctype="gc3"></span>
        <p>请选择商品分类（必须选到最后一级）</p>
        <input type="hidden" id="gc_id" name="gc_id" value="" class="mls_id" />
        <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names"/>
        </dd>
    </dl>
    
    <!--transport info begin-->
    
    <dl>
      <dt><?php echo $lang['store_goods_index_goods_szd'].$lang['nc_colon']?></dt>
      <dd>
        <p id="region">
          <select class="d_inline" name="province_id" id="province_id">
          </select>
        </p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_index_store_goods_class'].$lang['nc_colon'];?></dt>
      <dd><span class="new_add"><a href="javascript:void(0)" id="add_sgcategory" class="ncsc-btn"><?php echo $lang['store_goods_index_new_class'];?></a> </span>
        <?php if (!empty($output['store_class_goods'])) { ?>
        <?php foreach ($output['store_class_goods'] as $v) { ?>
        <select name="sgcate_id[]" class="sgcategory">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php foreach ($output['store_goods_class'] as $val) { ?>
          <option value="<?php echo $val['stc_id']; ?>" <?php if ($v==$val['stc_id']) { ?>selected="selected"<?php } ?>><?php echo $val['stc_name']; ?></option>
          <?php if (is_array($val['child']) && count($val['child'])>0){?>
          <?php foreach ($val['child'] as $child_val){?>
          <option value="<?php echo $child_val['stc_id']; ?>" <?php if ($v==$child_val['stc_id']) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
          <?php }?>
          <?php }?>
          <?php } ?>
        </select>
        <?php } ?>
        <?php } else { ?>
        <select name="sgcate_id[]" class="sgcategory">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php if (!empty($output['store_goods_class'])){?>
          <?php foreach ($output['store_goods_class'] as $val) { ?>
          <option value="<?php echo $val['stc_id']; ?>"><?php echo $val['stc_name']; ?></option>
          <?php if (is_array($val['child']) && count($val['child'])>0){?>
          <?php foreach ($val['child'] as $child_val){?>
          <option value="<?php echo $child_val['stc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
          <?php }?>
          <?php }?>
          <?php } ?>
          <?php } ?>
        </select>
        <?php } ?>
        <p class="hint"><?php echo $lang['store_goods_index_belong_multiple_store_class'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_import_unicode'];?></dt>
      <dd>
        <p>unicode </p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_import_file_type'];?></dt>
      <dd>
        <p><?php echo $lang['store_goods_import_file_csv'];?></p>
      </dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['store_goods_import_submit'];?>" />
      </dd>
    </dl>
    </ul>
  </div>


</form>
<!--step4-->
<?php 
$storeid= $_SESSION['store_id'];
$src = APP_SITE_URL."/tbimport/index/index.php?storeid=".$storeid;
?>
<iframe <?php if($output['step']=="4"){echo 'style="display:block"';}else{echo 'style="display:none"';} ?>  id="uploadwjc" src="<?php echo $src; ?>" height="800" width='100%' frameborder="0" >
</iframe>

<script>

$(function() {

	function sgcInit(){
	var sgcate	= $("select[name='stc_id[]']").clone();
	$("select[name='stc_id[]']").remove();
	sgcate.clone().appendTo('#div_sgcate');
	$("#add_sgcategory").click(function(){
		sgcate.clone().appendTo('#div_sgcate');
	});
}
		sgcInit();
	
    // 查询下级分类，分类不存在显示当前分类绑定的规格
    $('select[nctype="gc"]').change(function(){
        $(this).parents('td:first').nextAll().html('');

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
	document.getElementById('gc_id').value=id;
    $.getJSON('index.php?act=store_spec&op=ajax_class&id=' + id + '&deep=' + deep, function(data){
  
        if (data) {
            if (data.type == 'class') {
                nextClass(data.data, data.deep);
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
			  document.getElementById('gc_id').value=n.gc_id;
    });
    // 清理分类
    clearClassHtml(parseInt(deep)+1);
	
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

</script> 