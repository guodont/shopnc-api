<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['article_class_index_class'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=article_class&op=article_class"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="article_class_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="ac_name"><?php echo $lang['article_class_index_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="ac_name" id="ac_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_id"><?php echo $lang['article_class_add_sup_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="ac_parent_id" id="ac_parent_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
              <?php foreach($output['parent_list'] as $k => $v){ ?>
              <option <?php if($output['ac_parent_id'] == $v['ac_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['ac_id'];?>"><?php echo $v['ac_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"><?php echo $lang['article_class_add_sup_class_notice'];?></td>
          
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ac_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="255" name="ac_sort" id="ac_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['article_class_add_update_sort'];?></td>
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
$(function(){$("#submitBtn").click(function(){
    if($("#article_class_form").valid()){
     $("#article_class_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#article_class_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            ac_name : {
                required : true,
                remote   : {                
                url :'index.php?act=article_class&op=ajax&branch=check_class_name',
                type:'get',
                data:{
                    ac_name : function(){
                        return $('#ac_name').val();
                    },
                    ac_parent_id : function() {
                        return $('#ac_parent_id').val();
                    },
                    ac_id : ''
                  }
                }
            },
            ac_sort : {
                number   : true
            }
        },
        messages : {
            ac_name : {
                required : '<?php echo $lang['article_class_add_name_null'];?>',
                remote   : '<?php echo $lang['article_class_add_name_exists'];?>'
            },
            ac_sort  : {
                number   : '<?php echo $lang['article_class_add_sort_int'];?>'
            }
        }
    });
});
</script>