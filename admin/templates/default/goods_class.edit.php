<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_class_index_class'];?></h3>
      <?php echo $output['top_link'];?> </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['goods_class_edit_prompts_one'];?></li>
            <li><?php echo $lang['goods_class_edit_prompts_two'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="goods_class_form" name="goodsClassForm" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="gc_id" value="<?php echo $output['class_array']['gc_id'];?>" />
    <input type="hidden" name="gc_parent_id" id="gc_parent_id" value="<?php echo $output['class_array']['gc_parent_id'];?>" />
    <input type="hidden" name="old_type_id" value="<?php echo $output['class_array']['type_id'];?>">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="gc_name validation" for="gc_name"><?php echo $lang['goods_class_index_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" maxlength="20" value="<?php echo $output['class_array']['gc_name'];?>" name="gc_name" id="gc_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if ($output['class_array']['gc_parent_id'] == 0) {?>
        <tr>
          <td colspan="2" class="required"><label for="pic"><?php echo '分类图片';?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo $output['class_array']['pic'];?>"></div>
            </span><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="pic" type="file" class="type-file-file" id="pic" size="30" hidefocus="true" nc_type="change_pic">
            </span></td>
          <td class="vatop tips"><?php echo '只有第一级分类可以上传图片，建议用16px * 16px，超出后自动隐藏';?></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="2" class="required"><label>发布虚拟商品:</label>
            <span>
            <label for="t_gc_virtual">
              <input id="t_gc_virtual" type="checkbox" class="checkbox" checked="checked" value="1" name="t_gc_virtual">
              关联到子分类</label>
            </span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><label><input type="checkbox" name="gc_virtual" id="gc_virtual" value="1" <?php if ($output['class_array']['gc_virtual'] == 1) {?>checked<?php }?>>允许</label></td>
          <td class="vatop tips">勾选允许发布虚拟商品后，在发布该分类的商品时可选择交易类型为“虚拟兑换码”形式。</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation">分佣比例:</label>
            <span>
            <label for="t_commis_rate">
              <input id="t_commis_rate" class="checkbox" type="checkbox" checked="checked" value="1" name="t_commis_rate">
              关联到子分类</label>
            </span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="commis_rate" class="w60" type="text" value="<?php echo $output['class_array']['commis_rate'];?>" name="commis_rate">
            % </td>
          <td class="vatop tips">必须为0-100的整数</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['goods_class_add_type'];?>:</label>
            <span>
            <label for="t_associated">
              <input class="checkbox" type="checkbox" name="t_associated" value="1" checked="checked" id="t_associated" />
              <?php echo $lang['goods_class_edit_related_to_subclass'];?></label>
            </span></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" id="gcategory">
            <select class="class-select">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['gc_list'])){ ?>
              <?php foreach($output['gc_list'] as $k => $v){ ?>
              <?php if ($v['gc_parent_id'] == 0) {?>
              <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </select><?php echo $lang['nc_quickly_targeted'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="hidden" name="t_name" id="t_name" value="<?php echo $output['class_array']['type_name'];?>" />
            <input type="hidden" name="t_sign" id="t_sign" value="" />
            <div id="type_div" class="goods-sort-type">
              <div class="container">
                <dl>
                  <dd>
                    <input type="radio" name="t_id" value="0" <?php if($output['class_array']['type_id'] == 0){?>checked="checked"<?php }?> />
                    <?php echo $lang['goods_class_null_type'];?></dd>
                </dl>
                <?php if(!empty($output['type_list'])){?>
                <?php foreach($output['type_list'] as $k=>$val){?>
                <?php if(!empty($val['type'])){?>
                <dl>
                  <dt id="type_dt_<?php echo $k;?>"><?php echo $val['name']?></dt>
                  <?php foreach($val['type'] as $v){?>
                  <dd>
                    <input type="radio" class="radio" name="t_id" value="<?php echo $v['type_id']?>" <?php if($output['class_array']['type_id'] == $v['type_id']){?>checked="checked"<?php }?> />
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
          <td colspan="2" class="required"><label for="gc_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['gc_sort'] == ''?0:$output['class_array']['gc_sort'];?>" name="gc_sort" id="gc_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['goods_class_add_update_sort'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script> 
<script>
$(document).ready(function(){
    $('#type_div').perfectScrollbar();
	//按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
	    if($("#goods_class_form").valid()){
	     $("#goods_class_form").submit();
		}
	});

	$("#pic").change(function(){
		$("#textfield1").val($(this).val());
	});
	$('input[type="radio"][name="t_id"]').change(function(){
		// 标记类型时候修改 修改为ok
		var t_id = <?php echo $output['class_array']['type_id'];?>;
		if(t_id != $(this).val()){
			$('#t_sign').val('ok');
		}else{
			$('#t_sign').val('');
		}
			
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
                    gc_id : '<?php echo $output['class_array']['gc_id'];?>'
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
