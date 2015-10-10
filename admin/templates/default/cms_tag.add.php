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
            tag_name: {
                required : true,
                maxlength : 20
            },
            tag_sort: {
                required : true,
                digits: true,
                max: 255,
                min: 0
            }
        },
        messages : {
            tag_name: {
                required : "<?php echo $lang['tag_name_error'];?>" ,
                maxlength : "<?php echo $lang['tag_name_error'];?>"
            },
            tag_sort: {
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
      <h3><?php echo $lang['nc_cms_tag_manage'];?></h3>
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
  <form id="add_form" method="post" action="index.php?act=cms_tag&op=cms_tag_save">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="tag_name"><?php echo $lang['cms_tag_name'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="tag_name" id="tag_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['tag_name_error'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="tag_sort" class="validation"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="tag_sort" name="tag_sort" type="text" class="txt" value="255" /></td>
          <td class="vatop tips"><?php echo $lang['class_sort_explain'];?></td>
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
