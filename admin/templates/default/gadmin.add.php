<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_limit_manage'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="admin_name"><?php echo $lang['gadmin_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="gname" maxlength="40" name="gname" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2"><table class="table tb-type2 nomargin">
              <thead>
                <tr class="space">
                  <th> <input id="limitAll" id="limitAll" value="1" type="checkbox">&nbsp;&nbsp;<?php echo $lang['admin_set_limt'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach((array)$output['limit'] as $k => $v) { ?>
                <tr>
                  <td>
                  <label style="width:100px"><?php echo (!empty($v['nav'])) ? $v['nav'] : '&nbsp;'; ?></label>
                  <input id="limit<?php echo $k;?>" type="checkbox" onclick="selectLimit('limit<?php echo $k;?>')">
                    <label for="limit<?php echo $k;?>"><b><?php echo $v['name'];?></b>&nbsp;&nbsp;</label>
                      <?php foreach($v['child'] as $xk => $xv) { ?>
                        <label><input nctype='limit' class="limit<?php echo $k;?>" type="checkbox" name="permission[]" value="<?php echo $xv['op'];?>">
                        <?php echo $xv['name'];?>&nbsp;</label>
                      <?php } ?>
                    </td>
                </tr>
                <?php } ?>
              </tbody>
            </table></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
function selectLimit(name){
    if($('#'+name).attr('checked')) {
        $('.'+name).attr('checked',true);
    }else {
        $('.'+name).attr('checked',false);
    }
}
$(document).ready(function(){
	//按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
	    if($("#add_form").valid()){
	     $("#add_form").submit();
		}
	});

	$('#limitAll').click(function(){
		$('input[type="checkbox"]').attr('checked',$(this).attr('checked') == 'checked');
	});
	
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            gname : {
                required : true,
				remote	: {
                    url :'index.php?act=admin&op=ajax&branch=check_gadmin_name',
                    type:'get',
                    data:{
                    	gname : function(){
                            return $('#gname').val();
                        }
                    }
                }
            }
        },
        messages : {
            gname : {
                required : '<?php echo $lang['nc_none_input'];?>',
                remote	 : '<?php echo $lang['admin_add_admin_not_exists'];?>'
            }
        }
	});
});
</script>