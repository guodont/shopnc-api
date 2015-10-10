<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>线下抢分类</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=live_class" ><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=live_class&op=add_class">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="live_class_name"><?php echo $lang['live_groupbuy_class_name'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="live_class_name" id="live_class_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_class_id"><?php echo $lang['live_groupbuy_parent_class_name'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="parent_class_id" name="parent_class_id" class="valid" >
              <option value="0"><?php echo $lang['nc_common_pselect'];?></option>
              <?php if(!empty($output['list']) && is_array($output['list'])) {?>
              <?php foreach($output['list'] as $key=>$val) {?>
              <option value="<?php echo $val['live_class_id'];?>" <?php if($output['parent_class_id']==$val['live_class_id']){echo 'selected';}?>><?php echo $val['live_class_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="live_class_sort" class="validation"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="live_class_sort" name="live_class_sort" type="text" class="txt" /></td>
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
<script type="text/javascript">
$(document).ready(function(){
	$('#submit').click(function(){
		$('#add_form').submit();
	});
	
    $('#add_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
        	live_class_name: {
                required : true,
                maxlength : 10
            },
            live_class_sort: {
                required : true,
                digits: true,
                max: 255,
                min: 0
            }
        },
        messages : {
        	live_class_name: {
                required : "<?php echo $lang['live_groupbuy_class_name_is_not_null'];?>",
                maxlength : jQuery.validator.format("<?php echo $lang['live_groupbuy_class_name_length'];?>")
            },
            live_class_sort: {
                required : "<?php echo $lang['live_groupbuy_class_sort_is_not_null'];?>",
                digits: "<?php echo $lang['live_groupbuy_class_sort_is_number'];?>",
                max : jQuery.validator.format("<?php echo $lang['live_groupbuy_class_sort_is_number'];?>"),
                min : jQuery.validator.format("<?php echo $lang['live_groupbuy_class_sort_is_number'];?>")
            }
        }
    });
});
</script> 
