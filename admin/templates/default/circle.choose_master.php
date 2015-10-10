<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <input type="hidden" name="form_submit" value="ok" />
  <table class="table tb-type2">
    <tbody>
      <tr class="noborder">
        <td colspan="2" class="required"><label for="searchname"><?php echo $lang['nc_member_name'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform">
          <input type="text" name="searchname" id="searchname" class="txt" style="width:190px;" />
          <input type="submit" nctype="cm_s" value="<?php echo $lang['nc_search'];?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['nc_result'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td colspan="2" class="vatop rowform">
          <select id="searchresult" class="w300" style=" height:140px;" size="7" name="searchresult"></select>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="confirmBtn"><span><?php echo $lang['nc_ok'];?></span></a></td>
      </tr>
    </tfoot>
  </table>
</div>
<script>
var searchUrl = '<?php echo $output['search_url'];?>';
$(function(){
	$('#searchname').focus();
	$('input[nctype="cm_s"]').click(function(){
		$.getJSON(searchUrl,{name:$('#searchname').val()},function(data){
			$('#searchresult').html('');
			if(data && data.length != 0){
				for(var i=0 ; i<data.length ; i++){
					$('#searchresult').append('<option value=\'{"id":"'+data[i].member_id+'","name":"'+data[i].member_name+'"}\'>'+data[i].member_name+'</option>');
				}
			}else{
				$('#searchresult').append('<option><?php echo $lang['circle_choose_master_result_null'];?></option>');
				$('#confirmBtn').unbind().click(function(){DialogManager.close('choose_master');});
			}
		});
	});
	$('#confirmBtn').click(function(){
		var data = $('#searchresult').val();
		if(data == null){
			return false;
		}
	    eval( "data = "+data);
	    chooseReturn(data);
	    DialogManager.close('choose_master');
	});
});
</script>