<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_config_index'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=web_config&op=web_config"><span><?php echo '板块区';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['web_config_web_edit'];?></span></a></li>
        <li><a href="index.php?act=web_config&op=code_edit&web_id=<?php echo $_GET["web_id"];?>"><span><?php echo $lang['web_config_code_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="web_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="web_id" value="<?php echo $output['web_array']['web_id']?>" />
    <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['web_config_web_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="web_name" name="web_name" value="<?php echo $output['web_array']['web_name']?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['web_config_web_name_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['web_config_style_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style=" height:48px;">
          	<input type="hidden" value="<?php echo $output['web_array']['style_name']?>" name="style_name" id="style_name">
          	<ul class="home-templates-board-style">
              <li class="red"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_red'];?></li>
              <li class="pink"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_pink'];?></li>
              <li class="orange"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_orange'];?></li>
              <li class="green"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_green'];?></li>
              <li class="blue"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_blue'];?></li>
              <li class="purple"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_purple'];?></li>
              <li class="brown"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_brown'];?></li>
              <li class="default"><em></em><i class="icon-ok"></i><?php echo $lang['web_config_style_default'];?></li>
            </ul></td>
          <td class="vatop tips"><?php echo $lang['web_config_style_name_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['nc_sort'];?>:</label>
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['web_array']['web_sort']?>" name="web_sort" id="web_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['web_config_sort_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_display'];?>:
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="show1" class="cb-enable <?php if($output['web_array']['web_show'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="show0" class="cb-disable <?php if($output['web_array']['web_show'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="show1" name="web_show" <?php if($output['web_array']['web_show'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="show0" name="web_show" <?php if($output['web_array']['web_show'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
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
<script>
//按钮先执行验证再提交表单
$(function(){
	$(".home-templates-board-style .<?php echo $output['web_array']['style_name']?>").addClass("selected");
	$("#submitBtn").click(function(){
    if($("#web_form").valid()){
     $("#web_form").submit();
		}
	});
	$(".home-templates-board-style li").click(function(){
    $(".home-templates-board-style li").removeClass("selected");
    $("#style_name").val($(this).attr("class"));
    $(this).addClass("selected");
	});
	$("#web_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            web_name : {
                required : true
            },
            web_sort : {
                required : true,
                digits   : true
            }
        },
        messages : {
            web_name : {
                required : "<?php echo $lang['web_config_add_name_null'];?>"
            },
            web_sort  : {
                required : "<?php echo $lang['web_config_sort_int'];?>",
                digits   : "<?php echo $lang['web_config_sort_int'];?>"
            }
        }
	});
});

</script> 
