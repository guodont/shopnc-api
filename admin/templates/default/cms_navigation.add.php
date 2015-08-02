<?php defined('InShopNC') or exit('Access Invalid!');?>
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
            navigation_title: {
                required : true,
                maxlength : 20
            },
            navigation_link: {
                required : true,
                url : true,
                maxlength : 255
            },
            navigation_sort: {
                required : true,
                digits: true,
                max: 255,
                min: 0
            }
        },
        messages : {
            navigation_title: {
                required : "<?php echo $lang['navigation_title_error'];?>" ,
                maxlength : "<?php echo $lang['navigation_title_error'];?>"
            },
            navigation_link: {
                required : "<?php echo $lang['navigation_link_error'];?>",
                url : "<?php echo $lang['navigation_link_error'];?>",
                maxlength : "<?php echo $lang['navigation_link_error'];?>"
            },
            navigation_sort: {
                required : "<?php echo $lang['class_sort_error'];?>",
                digits: "<?php echo $lang['class_sort_error'];?>",
                max : "<?php echo $lang['class_sort_error'];?>",
                min : "<?php echo $lang['class_sort_error'];?>"
            }
        }
    });
});
</script>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_cms_navigation_manage'];?></h3>
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
  <form id="add_form" method="post" action="index.php?act=cms_navigation&op=cms_navigation_save">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="navigation_title"><?php echo $lang['cms_navigation_name'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="navigation_title" id="navigation_title" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['navigation_title_error'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="navigation_link"><?php echo $lang['cms_navigation_url'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="navigation_link" id="navigation_link" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['navigation_link_error'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="navigation_sort" class="validation"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="navigation_sort" name="navigation_sort" type="text" class="txt" value="255" /></td>
          <td class="vatop tips"><?php echo $lang['class_sort_explain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="navigation_open_type" class="validation"><?php echo $lang['cms_navigation_open_type'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform onoff">
                <label for="isuse_1" class="cb-enable selected" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
                <label for="isuse_0" class="cb-disable" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
                <input type="radio" id="isuse_1" name="navigation_open_type" value="2" >
                <input type="radio" id="isuse_0" name="navigation_open_type" value="1" >
        </td>
        <td class="vatop tips"></td>
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
