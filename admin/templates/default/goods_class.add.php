<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_class_index_class'];?></h3>
      <?php echo $output['top_link'];?> </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="goods_class_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="gc_name"><?php echo $lang['goods_class_index_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="gc_name" id="gc_name" maxlength="20" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="pic"><?php echo '分类图片';?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="pic" type="file" class="type-file-file" id="pic" size="30" hidefocus="true" nc_type="change_pic">
            </span></td>
          <td class="vatop tips">只有第一级分类可以上传图片，建议用16px * 16px，超出后自动隐藏</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>发布虚拟商品:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><label>
              <input type="checkbox" name="gc_virtual" id="gc_virtual" value="1">
              允许</label></td>
          <td class="vatop tips">勾选允许发布虚拟商品后，在发布该分类的商品时可选择交易类型为“虚拟兑换码”形式。</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation">分佣比例:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="commis_rate" class="w60" type="text" value="" name="commis_rate">
            %</td>
          <td class="vatop tips">必须为0-100的整数</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_id"><?php echo $lang['goods_class_add_sup_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="gc_parent_id" id="gc_parent_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
              <?php foreach($output['parent_list'] as $k => $v){ ?>
              <option <?php if($output['gc_parent_id'] == $v['gc_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"><?php echo $lang['goods_class_add_sup_class_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="gc_name"><?php echo $lang['goods_class_add_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" id="gcategory"><select class="class-select">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['gc_list'])){ ?>
              <?php foreach($output['gc_list'] as $k => $v){ ?>
              <?php if ($v['gc_parent_id'] == 0) {?>
              <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </select>
            <?php echo $lang['nc_quickly_targeted'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="hidden" name="t_name" id="t_name" value="" />
            <div id="type_div" class="goods-sort-type">
              <div class="container">
                <dl>
                  <dd>
                    <input type="radio" name="t_id" value="0" checked="checked" />
                    <?php echo $lang['goods_class_null_type'];?> </dd>
                </dl>
                <?php if(!empty($output['type_list'])){?>
                <?php foreach($output['type_list'] as $k=>$val){?>
                <?php if(!empty($val['type'])){?>
                <dl>
                  <dt id="type_dt_<?php echo $k;?>"><?php echo $val['name']?></dt>
                  <?php foreach($val['type'] as $v){?>
                  <dd>
                    <input type="radio" name="t_id" value="<?php echo $v['type_id']?>" />
                    <span><?php echo $v['type_name'];?></span></dd>
                  <?php }?>
                </dl>
                <?php }?>
                <?php }?>
                <?php }?>
              </div>
            </div></td>
          <td class="vatop tips"><?php echo $lang['goods_class_add_type_desc_one'];?><a onclick="window.parent.openItem('type,type,goods')" href="JavaScript:void(0);"><?php echo $lang['nc_type_manage'];?></a><?php echo $lang['goods_class_add_type_desc_two'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="0" name="gc_sort" id="gc_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['goods_class_add_update_sort'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){

    $('#type_div').perfectScrollbar();
    
	$("#submitBtn").click(function(){
		if($("#goods_class_form").valid()){
			$("#goods_class_form").submit();
		}
	});
	
	$("#pic").change(function(){
		$("#textfield1").val($(this).val());
	});
	$('input[type="radio"][name="t_id"]').click(function(){
		if($(this).val() == '0'){
			$('#t_name').val('');
		}else{
			$('#t_name').val($(this).next('span').html());
		}
	});
	
	$('#goods_class_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            gc_name : {
                required : true,
                remote   : {                
                url :'index.php?act=goods_class&op=ajax&branch=check_class_name',
                type:'get',
                data:{
                    gc_name : function(){
                        return $('#gc_name').val();
                    },
                    gc_parent_id : function() {
                        return $('#gc_parent_id').val();
                    },
                    gc_id : ''
                  }
                }
            },
            commis_rate : {
            	required :true,
                max :100,
                min :0,
                digits :true
            },
            gc_sort : {
                number   : true
            }
        },
        messages : {
            gc_name : {
                required : '<?php echo $lang['goods_class_add_name_null'];?>',
                remote   : '<?php echo $lang['goods_class_add_name_exists'];?>'
            },
            commis_rate : {
            	required : '<?php echo $lang['goods_class_add_commis_rate_error'];?>',
                max :'<?php echo $lang['goods_class_add_commis_rate_error'];?>',
                min :'<?php echo $lang['goods_class_add_commis_rate_error'];?>',
                digits :'<?php echo $lang['goods_class_add_commis_rate_error'];?>'
            },
            gc_sort  : {
                number   : '<?php echo $lang['goods_class_add_sort_int'];?>'
            }
        }
    });

	// 所属分类
    $("#gc_parent_id").live('change',function(){
    	type_scroll($(this));
    });
    // 类型搜索
    $("#gcategory > select").live('change',function(){
    	type_scroll($(this));
    });
});
var typeScroll = 0;
function type_scroll(o){
	var id = o.val();
	if(!$('#type_dt_'+id).is('dt')){
		return false;
	}
	$('#type_div').scrollTop(-typeScroll);
	var sp_top = $('#type_dt_'+id).offset().top;
	var div_top = $('#type_div').offset().top;
	$('#type_div').scrollTop(sp_top-div_top);
	typeScroll = sp_top-div_top;
}
gcategoryInit('gcategory');
</script> 
