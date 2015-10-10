<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['groupbuy_index_manage'];?></h3>
      <ul class="tab-base">
          <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
          <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
          <?php }  else { ?>
          <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
          <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="index.php?act=groupbuy&op=price_save">
      <input name="range_id" type="hidden" value="<?php echo $output['price_info']['range_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="range_name" class="validation"><?php echo $lang['range_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['price_info']['range_name'];?>" name="range_name" id="range_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['price_range_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="range_start" class="validation"><?php echo $lang['range_start'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" value="<?php echo $output['price_info']['range_start'];?>" name="range_start" id="range_start" class="txt">
        </td>
          <td class="vatop tips"><?php echo $lang['price_range_price_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="range_end" class="validation"><?php echo $lang['range_end'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" value="<?php echo $output['price_info']['range_end'];?>" name="range_end" id="range_end" class="txt">
            </td>
          <td class="vatop tips"><?php echo $lang['price_range_price_tip'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a id="submit" href="JavaScript:void(0);" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<script type="text/javascript">
$(document).ready(function(){
    $("#submit").click(function(){
        $("#add_form").submit();
    });

	$('#add_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            range_name : {
                required : true
            },
            range_start : {
                required : true,
                digits : true
            },
            range_end : {
                required : true,
                digits : true
            }
        },
        messages : {
            range_name : {
                required :  '<?php echo $lang['range_name_error'];?>'
            },
            range_start : {
                required : '<?php echo $lang['range_start_error'];?>',
                digits : '<?php echo $lang['range_start_error'];?>'
            },
            range_end : {
                required : '<?php echo $lang['range_end_error'];?>',
                digits : '<?php echo $lang['range_end_error'];?>'
            }
        }
    });
});
</script>
