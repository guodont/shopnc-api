<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--//zmr>v20-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_pointsmanage']?></h3>
      <ul class="tab-base">
       <li><a href="index.php?act=predeposit&op=predeposit"><span><?php echo $lang['admin_predeposit_rechargelist']?></span></a></li>
        <li><a href="index.php?act=predeposit&op=pd_cash_list"><span><?php echo $lang['admin_predeposit_cashmanage']; ?></span></a></li>    
        <li><a href="index.php?act=predeposit&op=pd_log_list"><span><?php echo $lang['nc_member_predepositlog'];?></span></a></li>
        <li><a href="index.php?act=predeposit&op=predeposit_add"  class="current"><span>调节预存款</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="points_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
   
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">会员名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="member_name" id="member_name" class="txt" onchange="javascript:checkmember();">
            <input type="hidden" name="member_id" id="member_id" value='0'/></td>
          <td class="vatop tips"><?php echo $lang['member_index_name']?></td>
        </tr>
        <tr id="tr_memberinfo">
          <td colspan="2" style="font-weight:bold;" id="td_memberinfo"></td>
        </tr>
        <tr>
          <td colspan="2" class="required">增减类型:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="operatetype" name="operatetype">
              <option value="1">增加</option>
              <option value="2">减少</option>
               <option value="3">冻结</option>
               <option value="4">解冻</option>
               
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation">金额:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="pointsnum" name="pointsnum" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['member_index_email']?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>描述信息:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="pointsdesc" rows="6" class="tarea"></textarea></td>
          <td class="vatop tips">描述信息将显示在预存款明细相关页，会员和管理员都可见</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
function checkmember(){
	var membername = $.trim($("#member_name").val());
	if(membername == ''){
		$("#member_id").val('0');
		alert(请输入会员名);
		return false;
	}
	$.getJSON("index.php?act=predeposit&op=checkmember", {'name':membername}, function(data){
	        if (data)
	        {
		        $("#tr_memberinfo").show();
				var msg= " "+ data.name + ", 当前预存款数为" + data.available_predeposit+", 当前预存款冻结金额数为" + data.freeze_predeposit;;
				$("#member_name").val(data.name);
				$("#member_id").val(data.id);
		        $("#td_memberinfo").text(msg);
	        }
	        else
	        {
	        	$("#member_name").val('');
	        	$("#member_id").val('0');
		        alert("会员信息错误");
	        }
	});
}
$(function(){
	$("#tr_memberinfo").hide();
	
    $('#points_form').validate({
        rules : {
        	member_name: {
				required : true
			},
			member_id: {
				required : true
            },
            pointsnum   : {
                required : true,
                min : 1
            }
        },
        messages : {
			member_name: {
				required : '请输入会员名'
			},
			member_id : {
				required : '会员信息错误，请重新填写会员名'
            },
            pointsnum  : {
                required : '请添加预存款',
                min : '预存款必须大于0'
            }
        }
    });
});
</script>