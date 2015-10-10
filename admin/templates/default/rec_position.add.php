<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['rec_position'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=rec_position&op=rec_list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a><em></em></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="rec_form" enctype="multipart/form-data" method="post" action="index.php?act=rec_position&op=rec_save">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['rec_ps_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="rtitle" id="rtitle" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['rec_ps_title_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['rec_ps_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="rec_type" id="rec_type">
              <option value="2"><?php echo $lang['rec_ps_pic'];?></option>
              <option value="1"><?php echo $lang['rec_ps_txt'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['rec_ps_type_tips'];?></td>
        </tr>
      </tbody>
      <tbody id="tr_pic_type" style="display:none">
      <tr><td colspan="2" class="required"><?php echo $lang['rec_ps_select_pic'].$lang['nc_colon']?></td></tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul>
              <li>
                <label>
                  <input name="pic_type" id="pic_type_1" type="radio" value="1" checked="checked">
                  <?php echo $lang['rec_ps_local'];?></label>
              </li>
              <li>
                <label>
                  <input type="radio" name="pic_type" id="pic_type_2" value="2">
                  <?php echo $lang['rec_ps_remote'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"><?php echo $lang['rec_ps_type_tips2'];?></td>
        </tr>
      </tbody>
    </table>
    <table id="local_txt" class="table tb-type2" style="display:none">
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation"><?php echo $lang['rec_ps_ztxt'];?>:</label></th>
        </tr>
        <tr class="noborder">
          <th><?php echo $lang['rec_ps_ztxt'];?></th>
          <th><?php echo $lang['rec_ps_gourl'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="RemoteBoxTxt">
        <tr>
          <td class="name w270"><input type="text" value="" name="txt[]" hidefocus="true"></td>
          <td class="name w270"><input type="text" value="http://" name="urltxt[]"></td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <tr>
          <td colspan="4"><a id="addRemoteTxt" class="btn-add marginleft" href="javascript:void(0);"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td>
        </tr>
      </tbody>
    </table>
    <table id="local_pic" class="table tb-type2" style="display:none">
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation"><?php echo $lang['rec_ps_selfile'];?>:</label></th>
        </tr>
        <tr class="noborder">
          <th><?php echo $lang['rec_ps_selfile_local'];?></th>
          <th><?php echo $lang['rec_ps_gourl'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="UpFileBox">
        <tr>
          <td class="vatop rowform w270"><span class="type-file-box">
            <input type="text" name="textfield" class="type-file-text" />
            <input type="button" name="button" value="" class="type-file-button" />
            <input class="type-file-file" type="file" title="" nc_type="change_default_goods_image" hidefocus="true" size="30" name="pic[]">
            </span></td>
          <td class="name w270"><input type="text" value="http://" name="urlup[]"></td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <tr>
          <td colspan="4"><a id="addUpFile" class="btn-add marginleft" href="javascript:void(0);"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td>
        </tr>
      </tbody>
    </table>
    <table id="remote_pic" class="table tb-type2" style="display:none">
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation"><?php echo $lang['rec_ps_add_remote'];?>:</label></th>
        </tr>
        <tr class="noborder">
          <th><?php echo $lang['rec_ps_remote_url'];?></th>
          <th><?php echo $lang['rec_ps_gourl'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="RemoteBox">
        <tr>
          <td class="name w270"><input type="text" value="http://" name="pic[]" hidefocus="true"></td>
          <td class="name w270"><input type="text" value="http://" name="urlremote[]"></td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <tr>
          <td colspan="4"><a id="addRemote" class="btn-add marginleft" href="javascript:void(0);"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2" id="rec_width">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['rec_ps_kcg'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $lang['rec_ps_image_width'];?>:
            <input type="text" class="txt" value="" style="width:30px" name="rwidth">
            px&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['rec_ps_image_height'];?>:
            <input type="text" class="txt" value="" style="width:30px" name="rheight">
            px</td>
          <td class="vatop tips"><?php echo $lang['rec_ps_kcg_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['rec_ps_target'];?>:</label></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2" >
      <tbody>
        <tr>
          <td class="vatop rowform"><ul>
              <li>
                <label>
                  <input name="rtarget"  type="radio" value="1" checked="checked">
                  <?php echo $lang['rec_ps_tg1'];?></label>
              </li>
              <li>
                <label>
                  <input type="radio" name="rtarget" value="2">
                  <?php echo $lang['rec_ps_tg2'];?></label>
              </li>
            </ul></td>
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
<script type="text/javascript">
//按钮先执行验证再提交表单
$(function(){
	function _check(){
		if ($('#rec_type').val() == 1){
			flag = false;
			$('input[name="txt[]"]').each(function(){
				if ($(this).val() != '') flag = true;
			});
			if (flag == false){
				alert('<?php echo $lang['rec_ps_error_ztxt'];?>');return false;
			}else{
				flag = false;
			}
		}else{
			if ($('#pic_type_1').attr('checked')){
				flag = false;
				$('#UpFileBox').find('input[name="pic[]"]').each(function(){
					if ($(this).val() != '') flag = true;
				});
				if (flag == false){
					alert('<?php echo $lang['rec_ps_error_pics'];?>');return false;
				}else{
					flag = false;
				}
			}else{
				flag = false;
				$('#RemoteBox').find('input[name="pic[]"]').each(function(){
					if ($(this).val() != '' && $(this).val() != 'http://') flag = true;
				});
				if (flag == false){
					alert('<?php echo $lang['rec_ps_error_picy'];?>');return false;
				}else{
					flag = false;
				}
			}
		}
		return true;
	}

	$("#submitBtn").click(function(){
		if(_check()){
			$("#rec_form").submit();
		}
	});
	$("#addUpFile").live('click',function(){
		if ($('#UpFileBox').find('input[name="pic[]"]').size() >= 5){
			alert('<?php echo $lang['rec_ps_error_jz'];?>');return;
		}
		$(this).parent().parent().remove();
   		$('#UpFileBox').append("<tr><td class=\"vatop rowform w270\"><span class=\"type-file-box\"><input type=\"text\" name=\"textfield\" class=\"type-file-text\" /><input type=\"button\" name=\"button\" value=\"\" class=\"type-file-button\" /><input class=\"type-file-file\" type=\"file\" title=\"\" nc_type=\"change_default_goods_image\" hidefocus=\"true\" size=\"30\" name=\"pic[]\"></span></td><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"urlup[]\"></td><td></td><td class=\"w150 align-center\"><a id=\"delUpFile\" href=\"javascript:void(0);\"><?php echo $lang['nc_del'];?></a></td></tr><tr><td colspan=\"4\"><a id=\"addUpFile\" class=\"btn-add marginleft\" href=\"javascript:void(0);\"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td></tr>");
	});
	$("#addRemote").live('click',function(){
		if ($('#RemoteBox').find('input[name="pic[]"]').size() >= 5){
			alert('<?php echo $lang['rec_ps_error_jz'];?>');return;
		}
		$(this).parent().parent().remove();
   		$('#RemoteBox').append("<tr><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"pic[]\" hidefocus=\"true\"></td><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"urlremote[]\"></td><td></td><td class=\"w150 align-center\"><a id=\"delUpFile\" href=\"javascript:void(0);\"><?php echo $lang['nc_del'];?></a></td></tr><tr><td colspan=\"4\"><a id=\"addRemote\" class=\"btn-add marginleft\" href=\"javascript:void(0);\"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td></tr>");
	});
	$("#addRemoteTxt").live('click',function(){
		if ($('#RemoteBoxTxt').find('input[name="txt[]"]').size() >= 5){
			alert('<?php echo $lang['rec_ps_error_jz'];?>');return;
		}
		$(this).parent().parent().remove();
   		$('#RemoteBoxTxt').append("<tr><td class=\"name w270\"><input type=\"text\" value=\"\" name=\"txt[]\" hidefocus=\"true\"></td><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"urltxt[]\"></td><td></td><td class=\"w150 align-center\"><a id=\"delUpFile\" href=\"javascript:void(0);\"><?php echo $lang['nc_del'];?></a></td></tr><tr><td colspan=\"4\"><a id=\"addRemoteTxt\" class=\"btn-add marginleft\" href=\"javascript:void(0);\"><span><?php echo $lang['rec_ps_addjx'];?><span></a></td></tr>");
	});	
	$('#delUpFile').live('click',function(){
		$(this).parent().parent().remove();$(this).remove();
	});
	$('input[name="pic_type"]').live('click',function(){
		if($(this).val() == 1) {
			$('#local_pic').show();$('#remote_pic').hide();
		}else{
			$('#local_pic').hide();$('#remote_pic').show();
		}
	});
	$('#rec_type').change(function(){
		if ($(this).val() == 1){
			$('#local_txt').show();$('#tr_pic_type').hide();$('#local_pic').hide();$('#remote_pic').hide();$('#rec_width').hide();
		}else{
			$('#local_txt').hide();$('#tr_pic_type').show();$('#local_pic').show();$('#pic_type_1').attr('checked',true);$('#rec_width').show();
		}
	});
	$('#local_pic').show();
	$('#tr_pic_type').show();
});
</script>
<script type="text/javascript">
$(function(){
	$('input[nc_type="change_default_goods_image"]').live("change", function(){
		$(this).parent().find('input[class="type-file-text"]').val($(this).val());
	});
});
</script> 