<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
    <!-- 页面导航 -->
    <div class="fixed-bar">
        <div class="item-title">
            <h3>运单模板</h3>
            <ul class="tab-base">
                <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
                <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
                <?php }  else { ?>
                <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
                <?php  } }  ?>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form id="add_form" method="post" action="<?php echo urlAdmin('waybill', 'waybill_save');?>" enctype="multipart/form-data">
        <?php if($output['waybill_info']) { ?>
        <input type="hidden" name="waybill_id" value="<?php echo $output['waybill_info']['waybill_id'];?>">
        <input type="hidden" name="old_waybill_image" value="<?php echo $output['waybill_info']['waybill_image'];?>">
        <?php } ?>
        <table class="table tb-type2">
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_name">模板名称<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_name']:'';?>" name="waybill_name" id="waybill_name" class="txt"></td>
                    <td class="vatop tips">运单模板名称，最多10个字</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_name">物流公司<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select name="waybill_express">
                            <?php if(!empty($output['express_list']) && is_array($output['express_list'])) {?>
                            <?php foreach($output['express_list'] as $value) {?>
                            <option value="<?php echo $value['id'];?>|<?php echo $value['e_name'];?>" <?php if($value['selected']) { echo 'selected'; }?> ><?php echo $value['e_name'];?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="vatop tips">模板对应的物流公司</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_width">宽度<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_width']:'';?>" name="waybill_width" id="waybill_width" class="txt"></td>
                    <td class="vatop tips">运单宽度，单位为毫米(mm)</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_height">高度<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_height']:'';?>" name="waybill_height" id="waybill_height" class="txt"></td>
                    <td class="vatop tips">运单高度，单位为毫米(mm)</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_top">上偏移量<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_top']:'0';?>" name="waybill_top" id="waybill_top" class="txt"></td>
                    <td class="vatop tips">运单模板上偏移量，单位为毫米(mm)</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_left">左偏移量<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_left']:'0';?>" name="waybill_left" id="waybill_left" class="txt"></td>
                    <td class="vatop tips">运单模板左偏移量，单位为毫米(mm)</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_image">模板图片<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <span class="type-file-show">
                            <?php if($output['waybill_info']) { ?>
                            <img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
                            <div class="type-file-preview"><img width="500" src="<?php echo $output['waybill_info']['waybill_image_url'];?>"></div>
                            <?php } ?>
                        </span>
                        <span class="type-file-box">
                            <input type='text' name='waybill_image_name' id='waybill_image_name' class='type-file-text' />
                            <input type='button' name='button' id='button1' value='' class='type-file-button' />
                            <input name="waybill_image" type="file" class="type-file-file" id="waybill_image" size="30" hidefocus="true" nc_type="change_seller_center_logo">
                        </span>
                    </td>
                    <td class="vatop tips">请上传扫描好的运单图片，图片尺寸必须与快递单实际尺寸相符</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="waybill_image">启用<?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                    <?php
                    if(!empty($output['waybill_info']) && $output['waybill_info']['waybill_usable'] == '1') { 
                        $usable = 1;
                    } else {
                        $usable = 0;
                    }
                    ?>
                    <input id="waybill_usable_1" type="radio" name="waybill_usable" value="1" <?php echo $usable ? 'checked' : '';?>>
                    <label for="waybill_usable_1">是</label>
                    <input id="waybill_usable_0" type="radio" name="waybill_usable" value="0" <?php echo $usable ? '' : 'checked';?>>
                    <label for="waybill_usable_0">否</label>
                    <td class="vatop tips">请首先设计并测试模板然后再启用，启用后商家可以使用</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><a id="submit" href="javascript:void(0)" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#waybill_image").change(function(){
		$("#waybill_image_name").val($(this).val());
	});

    $("#submit").click(function(){
        $("#add_form").submit();
    });
    $('#add_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parents('tr').prev().find('td:first'));
        },
        rules : {
            waybill_name: {
                required : true,
                maxlength : 10
            },
            waybill_width: {
                required : true,
                digits: true 
            },
            waybill_height: {
                required : true,
                digits: true 
            },
            waybill_top: {
                required : true,
                number: true 
            },
            waybill_left: {
                required : true,
                number: true 
            },
            waybill_image: {
                <?php if(!$output['waybill_info']) { ?>
                required : true,
                <?php } ?>
                accept: "jpg|jpeg|png"
            }
        },
        messages : {
            waybill_name: {
                required : "模板名称不能为空",
                maxlength : "模板名称最多10个字" 
            },
            waybill_width: {
                required : "宽度不能为空",
                digits: "宽度必须为数字"
            },
            waybill_height: {
                required : "高度不能为空",
                digits: "高度必须为数字"
            },
            waybill_top: {
                required : "上偏移量不能为空",
                number: "上偏移量必须为数字"
            },
            waybill_left: {
                required : "左偏移量不能为空",
                number: "左偏移量必须为数字"
            },
            waybill_image: {
                <?php if(!$output['waybill_info']) { ?>
                required : '图片不能为空',
                <?php } ?>
                accept: '图片类型不正确' 
            }
        }
    });
});
</script>

