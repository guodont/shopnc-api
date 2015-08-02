<?php defined('InShopNC') or exit('Access Invalid!');?>

<script type="text/javascript">
$(document).ready(function(){

    //文件上传
    var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />";
    $(textButton).insertBefore("#adv_image");
    $("#adv_image").change(function(){
        $("#textfield1").val($("#adv_image").val());
    });

    $("#submit").click(function(){
        $("#add_form").submit();
    });

    $("input[nc_type='microshop_goods_adv_image']").live("change", function(){
		var src = getFullPath($(this)[0]);
		$(this).parent().prev().find('.low_source').attr('src',src);
		$(this).parent().find('input[class="type-file-text"]').val($(this).val());
	});

    $('#add_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parents("tr").prev().find('td:first'));
        },
        rules : {
        <?php if(empty($output['adv_info'])) { ?>
            adv_image: {
                required : true
            },
            <?php } ?>
            adv_sort: {
                required : true,
                digits: true,
                max: 255,
                min: 0
            }
        },
        messages : {
        <?php if(empty($output['adv_info'])) { ?>
            adv_image: {
                required : "<?php echo $lang['microshop_adv_image_error'];?>"
            },
            <?php } ?>
            adv_sort: {
                required : "<?php echo $lang['class_sort_required'];?>",
                digits: "<?php echo $lang['class_sort_digits'];?>",
                max : jQuery.validator.format("<?php echo $lang['class_sort_max'];?>"),
                min : jQuery.validator.format("<?php echo $lang['class_sort_min'];?>")
            }
        }
    });
});
</script>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['nc_microshop_adv_manage'];?></h3>
            <ul class="tab-base">
                <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
                <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
                <?php }  else { ?>
                <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
                <?php  } }  ?>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=microshop&op=adv_save">
        <input name="adv_id" type="hidden" value="<?php echo $output['adv_info']['adv_id'];?>" />
        <table class="table tb-type2">
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required"><label  for="adv_name"><?php echo $lang['microshop_adv_type'];?><?php $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select name="adv_type">
                            <?php if(!empty($output['adv_type_list']) && is_array($output['adv_type_list'])) {?>
                            <?php foreach($output['adv_type_list'] as $key=>$value) {?>
                            <option value="<?php echo $key;?>" <?php if($key==$output['adv_info']['adv_type']) {echo 'selected';}?>><?php echo $value;?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="vatop tips"><?php echo $lang['microshop_adv_type_explain'];?></td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label for="adv_name"><?php echo $lang['microshop_adv_name'];?><?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php if(isset($output['adv_info']['adv_name'])) echo $output['adv_info']['adv_name'];?>" name="adv_name" id="adv_name" class="txt"> 
                    </td>
                    <td class="vatop tips"></td>
                </tr>
               <tr>
                   <td colspan="2" class="required"><label class="validation" for="adv_image"><?php echo $lang['microshop_adv_image'];?><?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <span class="type-file-show">
                            <?php if(!empty($output['adv_info']['adv_image'])) { ?>
                            <img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
                            <div class="type-file-preview">
                                <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.'adv'.DS.$output['adv_info']['adv_image'];?>">
                            </div>
                            <?php } ?>
                        </span>
                        <span class="type-file-box">
                            <input name="old_adv_image" type="hidden" value="<?php echo $output['adv_info']['adv_image'];?>" />
                            <input name="adv_image" type="file" class="type-file-file" id="adv_image" size="30" hidefocus="true" nc_type="microshop_goods_adv_image">
                        </span>
                    </td>
                    <td class="vatop tips"><?php echo $lang['microshop_adv_image_explain'];?></td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label for="adv_url"><?php echo $lang['microshop_adv_url'];?><?php echo $lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php if(isset($output['adv_info']['adv_url'])) echo $output['adv_info']['adv_url'];?>" name="adv_url" id="adv_url" class="txt"> 
                    </td>
                    <td class="vatop tips"><?php echo $lang['microshop_adv_url_explain'];?></td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label for="adv_sort" class="validation"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input id="adv_sort" name="adv_sort" type="text" class="txt" value="<?php echo !isset($output['adv_info'])?'255':$output['adv_info']['adv_sort'];?>" />
                    </td>
                    <td class="vatop tips"><?php echo $lang['class_sort_explain'];?></td>
                </tr>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <a id="submit" href="javascript:void(0)" class="btn"><span><?php echo $lang['nc_submit'];?></span></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

