<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />


<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_pointprod'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_pointprod_list_title'];?></span></a></li>
        <li><a href="index.php?act=pointprod&op=prod_add" ><span><?php echo $lang['admin_pointprod_add_title'];?></span></a></li>
        <li><a href="index.php?act=pointorder&op=pointorder_list" ><span><?php echo $lang['admin_pointorder_list_title'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="pointprod_form" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="3"><?php echo $lang['admin_pointprod_baseinfo']; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr class-"noborder">
          <th class="required" style="line-height:normal; border-top: 1px dotted #CBE9F3;"><label for=""><?php echo $lang['admin_pointprod_goods_image'];?>:</label></th>
          <td colspan="2" class="required"><label class="validation" for="goodsname"><?php echo $lang['admin_pointprod_goods_name']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <th rowspan="6" class="picture"><div class="size-200x200"><span class="thumb size-200x200"><i></i><img src="<?php echo $output['prod_info']['pgoods_image'];?>" onerror="this.src='<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.C('default_goods_image');?>'" onload="javascript:DrawImage(this,200,200);" nc_type="goods_image" /></span></div>
          </th>
          <td class="vatop rowform"><input type="text" name="goodsname" id="goodsname" class="txt" value="<?php echo $output['prod_info']['pgoods_name']; ?>"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label class="validation" for="goodsserial"><?php echo $lang['admin_pointprod_goods_serial']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="goodsserial" id="goodsserial" class="txt" value="<?php echo $output['prod_info']['pgoods_serial']; ?>"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label class="validation" for="goodsprice"><?php echo $lang['admin_pointprod_goods_price']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="goodsprice" id="goodsprice" class="txt" value="<?php echo $output['prod_info']['pgoods_price']; ?>"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label class="validation" for="goodspoints"><?php echo $lang['admin_pointprod_goods_points']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <th style="line-height:normal;"><span class="type-file-box">
            <input name="goods_images" type="file" class="type-file-file" id="goods_images" size="30" hidefocus="true" nc_type="change_goods_image">
            </span> </th>
          <td class="vatop rowform"><input type="text" name="goodspoints" id="goodspoints" class="txt" value="<?php echo $output['prod_info']['pgoods_points']; ?>"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <th class="required"><label for="goodstag"><?php echo $lang['admin_pointprod_goods_tag']; ?>:</label></th>
          <td colspan="2" class="required"><label class="validation" for="goodsstorage"><?php echo $lang['admin_pointprod_goods_storage']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="goodstag" id="goodstag" class="txt" value="<?php echo $output['prod_info']['pgoods_tag']; ?>"/></td>
          <td class="vatop rowform"><input type="text" name="goodsstorage" id="goodsstorage" class="txt" value="<?php echo $output['prod_info']['pgoods_storage']; ?>"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="space">
          <th colspan="10"><?php echo $lang['admin_pointprod_requireinfo']; ?></th>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_limittip']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="radio" name="islimit" id="islimit_1" value="1" <?php if ($output['prod_info']['pgoods_islimit'] == 1){echo 'checked=checked';} ?>  onclick="showlimit();"/>
            <label for=""><?php echo $lang['admin_pointprod_limit_yes']; ?></label>
            <input type="radio" name="islimit" id="islimit_0" value="0" <?php if ($output['prod_info']['pgoods_islimit'] == 0){echo 'checked=checked';} ?> onclick="showlimit();"/>
            <label><?php echo $lang['admin_pointprod_limit_no']; ?></label></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="limitnum_div">
        <tr>
          <td colspan="10" class="required"><label for="limitnum"><?php echo $lang['admin_pointprod_limitnum']; ?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="limitnum" id="limitnum" class="txt" value="<?php echo $output['prod_info']['pgoods_limitnum']; ?>"/></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_limittimetip']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="radio" name="islimittime" id="islimittime_1" value="1" <?php if ($output['prod_info']['pgoods_islimittime'] == 1){echo 'checked=checked';} ?> onclick="showlimittime();"/>
            <label for="islimittime_1"><?php echo $lang['admin_pointprod_limittime_yes']; ?></label>
            <input type="radio" name="islimittime" id="islimittime_0" value="0" <?php if ($output['prod_info']['pgoods_islimittime'] == 0){echo 'checked=checked';} ?> onclick="showlimittime();"/>
            <label for="islimittime_0"><?php echo $lang['admin_pointprod_limittime_no']; ?></label></td>
          <td class="vatop tips" colspan="10"></td>
        </tr>
      </tbody>
      <tbody name="limittime_div">
        <tr>
          <td class="required"><?php echo $lang['admin_pointprod_starttime']; ?>:
            </label></td>
          <td colspan="9" class="required"><label><?php echo $lang['admin_pointprod_endtime'] ?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="starttime" id="starttime" class="txt date" style="width:100px;" value="<?php echo $output['prod_info']['pgoods_starttime']? @date('Y-m-d',$output['prod_info']['pgoods_starttime']):@date('Y-m-d',time());?>"/>
            <?php echo $lang['admin_pointprod_time_day']; ?>
            <select id="starthour" name="starthour" style="width:50px; margin-left: 8px; _margin-left: 4px;">
              <?php foreach ($output['hourarr'] as $item){ ?>
              <option value="<?php echo $item; ?>" <?php if ($item == @date('H',$output['prod_info']['pgoods_starttime'])){ echo 'selected'; } ?>><?php echo $item; ?></option>
              <?php }?>
            </select>
            <?php echo $lang['admin_pointprod_time_hour']; ?></td>
          <td class="vatop rowform"><input type="text" name="endtime" id="endtime" class="txt date" style="width:100px;" value="<?php echo $output['prod_info']['pgoods_endtime']? @date('Y-m-d',$output['prod_info']['pgoods_endtime']):@date('Y-m-d',time()); ?>"/>
            <?php echo $lang['admin_pointprod_time_day']; ?>
            <select id="endhour" name="endhour" style="width:50px; margin-left: 8px; _margin-left: 4px;">
              <?php foreach ($output['hourarr'] as $item){ ?>
              <option value="<?php echo $item; ?>" <?php if ($item == @date('H',$output['prod_info']['pgoods_endtime'])){ echo 'selected'; } ?>><?php echo $item; ?></option>
              <?php }?>
            </select>
            <?php echo $lang['admin_pointprod_time_hour']; ?></td>
          <td colspan="9" class="vatop tips">&nbsp;</td>
        </tr>
      </tbody>
      <tbody>
      	<tr>
          <td colspan="3" class="required"><label>限制参与兑换的会员级别:</label></td>
        </tr>
      	<tr class="noborder">
      		<td>
      		<select name="limitgrade">
              <?php if ($output['member_grade']){?>
              	<?php foreach ($output['member_grade'] as $k=>$v){?>
              	<option <?php if(intval($output['prod_info']['pgoods_limitmgrade']) == intval($v['level'])){ ?>selected='selected'<?php } ?> value="<?php echo $v['level'];?>">V<?php echo $v['level'];?></option>
              	<?php }?>
              <?php }?>
            </select>
            </td>
            <td colspan="2" class="vatop tips">当会员兑换积分商品时，需要达到该级别或者以上级别后才能参与兑换</td>
      	</tr>
      </tbody>
      <tbody>
        <tr class="space">
          <th colspan="10"><?php echo $lang['admin_pointprod_stateinfo']; ?></th>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_isshow']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="showstate_1" class="cb-enable <?php if ($output['prod_info']['pgoods_show'] == '1'){ ?>selected<?php } ?>"><span><?php echo $lang['admin_pointprod_yes']; ?></span></label>
            <label for="showstate_0" class="cb-disable <?php if ($output['prod_info']['pgoods_show'] == '0'){ ?>selected<?php } ?>"><span><?php echo $lang['admin_pointprod_no']; ?></span></label>
            <input id="showstate_1" name="showstate" <?php if ($output['prod_info']['pgoods_show'] == '1'){echo 'checked=checked';}?> value="1" type="radio">
            <input id="showstate_0" name="showstate" <?php if ($output['prod_info']['pgoods_show'] == '0'){echo 'checked=checked';}?> value="0" type="radio"></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_iscommend']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="commendstate_1" class="cb-enable <?php if ($output['prod_info']['pgoods_commend'] == '1'){ ?>selected<?php } ?>"><span><?php echo $lang['admin_pointprod_yes']; ?></span></label>
            <label for="commendstate_0" class="cb-disable <?php if ($output['prod_info']['pgoods_commend'] == '0'){ ?>selected<?php } ?>"><span><?php echo $lang['admin_pointprod_no']; ?></span></label>
            <input id="commendstate_1" name="commendstate" <?php if ($output['prod_info']['pgoods_commend'] == '1'){echo 'checked=checked';}?> value="1" type="radio">
            <input id="commendstate_0" name="commendstate" <?php if ($output['prod_info']['pgoods_commend'] == '0'){echo 'checked=checked';}?> value="0" type="radio"></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="forbidreason_div">
        <tr>
          <td colspan="10" class="required"><label for="forbidreason"><?php echo $lang['admin_pointprod_forbidreason']; ?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="forbidreason" id="forbidreason" rows="6"><?php echo $output['prod_info']['pgoods_close_reason']; ?></textarea></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody>
        <tr class="space">
          <th colspan="10"><?php echo $lang['admin_pointprod_seoinfo']; ?></th>
        </tr>
        <tr>
          <td colspan="10" class="required"><label for="keywords"><?php echo $lang['admin_pointprod_seokey']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="keywords" id="keywords" class="txt" value="<?php echo $output['prod_info']['pgoods_keywords']; ?>"/></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_seodescription']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="description" rows="6"><?php echo $output['prod_info']['pgoods_description']; ?></textarea></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody>
        <tr class="space">
          <th colspan="10"><?php echo $lang['admin_pointprod_otherinfo']; ?></th>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_sort']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="sort" id="sort" class="txt" value="<?php echo $output['prod_info']['pgoods_sort']; ?>"/></td>
          <td colspan="10" class="vatop tips"><?php echo $lang['admin_pointprod_sorttip']; ?></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_edit_addtime']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo @date('Y-m-d',$output['prod_info']['pgoods_add_time']); ?></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_edit_viewnum']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['prod_info']['pgoods_view']; ?></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><label><?php echo $lang['admin_pointprod_edit_salenum']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['prod_info']['pgoods_salenum']; ?></td>
          <td colspan="10" class="vatop tips"></td>
        </tr>
        <tr class="space">
          <th colspan="10"><?php echo $lang['admin_pointprod_descriptioninfo']; ?></th>
        </tr>
        <tr>
          <td colspan="10"><?php showEditor('pgoods_body',$output['prod_info']['pgoods_body'],'600px','400px','visibility:hidden;',"false",$output['editor_multimedia']);?></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><?php echo $lang['admin_pointprod_uploadimg']; ?>:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" id="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="10" class="required"><?php echo $lang['admin_pointprod_uploadimg_complete'];?>:</td>
        </tr>
        <tr class="noborder">
          <td colspan="10"><ul id="thumbnails" class="thumblists">
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['admin_pointprod_uploadimg_add'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script>

function showlimit(){
	var islimit = $(":radio[name=islimit]:checked").val();
	if(islimit == '1'){
		$("#limitnum_div").show();
	}else{ 
		$("#limitnum_div").hide();
		$("#limitnum").val('1');//为了减少提交表单的验证，所以添加一个虚假值
	}
}
function showforbidreason(){
	var forbidstate = $(":radio[name=forbidstate]:checked").val();
	if(forbidstate == '1'){
		$("#forbidreason_div").show();
	}else{
		$("#forbidreason_div").hide();
	}
}
function showlimittime(){
	var islimit = $(":radio[name=islimittime]:checked").val();
	if(islimit == '1'){
		$("[name=limittime_div]").show();
	}else{
		$("[name=limittime_div]").hide();
		$("#starttime").val('<?php echo @date('Y-m-d',time()); ?>');
		$("#endtime").val('<?php echo @date('Y-m-d',time()); ?>');
	}
}
$(function(){
	
	// 模拟上传input type='file'样式
	$(function(){
	    var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
		$(textButton).insertBefore("#goods_images");
		$("#goods_images").change(function(){
		$("#textfield1").val($("#goods_images").val());
		});
	});	
	
	$('input[nc_type="change_goods_image"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="goods_image"]').attr('src', src);
		$('input[nc_type="change_goods_image"]').removeAttr('name');
		$(this).attr('name', 'goods_image');
	});
	
	showlimit();
	showforbidreason();
	showlimittime();
	
	$('#starttime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#endtime').datepicker({dateFormat: 'yy-mm-dd'});
	//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#pointprod_form").valid()){
     $("#pointprod_form").submit();
	}
	});
});
//
    $('#pointprod_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	goodsname : {
                required   : true
            },
            goodsprice    : {
				required  : true,
                number    : true,
                min       : 0
            },
            goodspoints : {
				required   : true,
				digits     : true,
				min		   :0
            },
            goodsserial : {
                required   : true
            },
            goodsstorage  : {
				required  : true,
                digits    : true
            },
            limitnum  : {
				required   : true,
				digits     : true,
				min        : 0
            },
            starttime  : {
				required  : true,
				date      : false
            },
            endtime  : {
				required  : true,
				date      : false
            },
            sort : {
				required  : true,
				digits    : true,
				min		  :0
            }
        },
        messages : {
        	goodsname  : {
                required   : '<?php echo $lang['admin_pointprod_add_goodsname_error']; ?>'
            },
            goodsprice : {
				required: '<?php echo $lang['admin_pointprod_add_goodsprice_null_error']; ?>',
                number  : '<?php echo $lang['admin_pointprod_add_goodsprice_number_error']; ?>',
                min     : '<?php echo $lang['admin_pointprod_add_goodsprice_number_error']; ?>'
            },
            goodspoints : {
				required: '<?php echo $lang['admin_pointprod_add_goodspoint_null_error']; ?>',
				digits     : '<?php echo $lang['admin_pointprod_add_goodspoint_number_error']; ?>',
				min		   : '<?php echo $lang['admin_pointprod_add_goodspoint_number_error']; ?>'
            },
            goodsserial:{
                required : '<?php echo $lang['admin_pointprod_add_goodsserial_null_error']; ?>'
            },
            goodsstorage : {
				required: '<?php echo $lang['admin_pointprod_add_storage_null_error']; ?>',
				digits  : '<?php echo $lang['admin_pointprod_add_storage_number_error']; ?>'
            },
            limitnum : {
				required: '<?php echo $lang['admin_pointprod_add_limitnum_error']; ?>',
				digits  : '<?php echo $lang['admin_pointprod_add_limitnum_digits_error']; ?>',
				min		: '<?php echo $lang['admin_pointprod_add_limitnum_digits_error']; ?>'
            },
            starttime  : {
            	required: '<?php echo $lang['admin_pointprod_add_limittime_null_error']; ?>'
            },
            endtime  : {
            	required: '<?php echo $lang['admin_pointprod_add_limittime_null_error']; ?>'
            },
            sort : {
				required: '<?php echo $lang['admin_pointprod_add_sort_null_error']; ?>',
				digits  : '<?php echo $lang['admin_pointprod_add_sort_number_error']; ?>',
				min		: '<?php echo $lang['admin_pointprod_add_sort_number_error']; ?>'
            }
        }
    });

    // 替换图片
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=pointprod&op=pointprod_pic_upload&item_id=<?php echo $output['prod_info']['pgoods_id']; ?>',
            done: function (e,data) {
                if(data != 'error'){
                	add_uploadedfile(data.result);
                }
            }
        });
    });
});
function add_uploadedfile(file_data)
{
	var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_POINTPROD.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_POINTPROD.'/';?>' + file_data.file_name + '\');"><?php echo $lang['admin_pointprod_uploadimg_add'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('pgoods_body', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=pointprod&op=ajaxdelupload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['admin_pointprod_delfail'];?>');
        }
    });
}
</script>
