<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>线下区域</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=live_area&op=live_area"><span><?php echo $lang['nc_manage'];?></span></a></li>
		<li><a href="javascript:void(0);" class='current'><span><?php echo $lang['nc_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="index.php?act=live_area&op=area_add">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="live_area_name"><?php echo $lang['live_area_manage_area_name'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="live_area_name" id="live_area_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        
		<tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="first_letter"><?php echo $lang['live_area_manage_first_letter'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
			<select name='first_letter'>
				<?php foreach($output['letter'] as $lk=>$lv){?>
				<option value='<?php echo $lv;?>'><?php echo $lv;?></option>
				<?php }?>
			</select>
		  </td>
        </tr>

		<tr class="noborder">
          <td colspan="2" class="required"><label for="area_number"><?php echo $lang['live_area_manage_area_number'].$lang['nc_colon'];?></label></td>
        </tr>
		<tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="area_number" id="area_number" class="txt"></td>
        </tr>

		<tr class="noborder">
          <td colspan="2" class="required"><label for="post"><?php echo $lang['live_area_manage_post'].$lang['nc_colon'];?></label></td>
        </tr>
		<tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="post" id="post" class="txt"></td>
        </tr>

		<tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="area_class"><?php echo $lang['live_area_manage_up_area'].$lang['nc_colon'];?></label></td>
        </tr>
		<tr class="noborder">
          <td class="vatop rowform">
			<?php echo $output['live_area_name'];?><input type='hidden' name='parent_area_id' value="<?php echo $output['live_area_id'];?>">
		  </td>
        </tr>
        
        <?php if($output['live_area_id'] == '0'){?>
  		<tr class="noborder">
          <td colspan="2" class="required"><label for="area_class">显示<?php echo $lang['nc_colon'];?></label></td>
        </tr>    
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="hot1" class="cb-enable" ><span><?php echo $lang['open'];?></span></label>
            <label for="hot0" class="cb-disable selected" ><span><?php echo $lang['close'];?></span></label>
            <input id="hot1" name="is_hot"  value="1" type="radio">
            <input id="hot0" name="is_hot"  checked="checked" value="0" type="radio">
          </td>
        </tr>  
        <?php }?> 
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
    $("#submit").click(function(){
        $("#add_form").submit();
    });

    $('#add_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            live_area_name: {
                required : true
            },
			area_number:{
				number: true	
			},
			post:{
				number: true	
			}
        },
        messages : {
        	live_area_name: {
                required : '<?php echo $lang['live_area_manage_area_name_is_not_null'];?>'
            },
			area_number:{
				number:'<?php echo $lang['live_area_manage_number_is_number'];?>'
			},
			post:{
				number:'<?php echo $lang['live_area_manage_post_is_number'];?>'
			}
        }
    });
});
</script> 
