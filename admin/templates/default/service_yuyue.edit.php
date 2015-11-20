<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>预约安排</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=service&op=service_yuyue"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>安排</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>预约服务</th>
          <th>用户</th>		  
          <th>服务单位</th>
		  <th class="align-center">起止时间</th>		  
		  <th class="align-center">支付情况</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover edit">
          <td class="goods-name w170"><?php echo $output['service_yuyue_array']['yuyue_id']; ?></td>
          <td><?php echo $output['service_yuyue_array']['yuyue_member_name']; ?></td>		  
          <td><?php echo $output['service_yuyue_array']['yuyue_company']; ?></td>
          <td class="goods-name w270 align-center"><?php echo date('Y-m-d',$output['service_yuyue_array']['yuyue_start_time']);?>——<?php echo date('Y-m-d',$output['service_yuyue_array']['yuyue_end_time']);?></td>			  
          <td class="align-center">支付方式：<?php echo $output['service_yuyue_array']['yuyue_pay_way']; ?>——支付状态：<?php echo $output['service_yuyue_array']['yuyue_pay_status']; ?><?php if($output['service_yuyue_array']['yuyue_pay_status']==1){ ?>——单号：<?php echo $output['service_yuyue_array']['yuyue_pay_number']; ?><?php } ?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td>其他要求</td>
          <td colspan="16"><?php echo $output['service_yuyue_array']['yuyue_content']; ?></td>
        </tr>		
      </tfoot>
    </table>
  <form id="service_yuyue_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="yuyue_id" value="<?php echo $output['service_yuyue_array']['yuyue_id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="yuyue_company_id">服务单位:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="yuyue_company_id" id="yuyue_company_id">
              <?php if(!empty($output['company_list']) && is_array($output['company_list'])){ ?>
              <?php foreach($output['company_list'] as $k => $v){ ?>
              <option <?php if($output['company_array']['company_id'] == $v['yuyue_company_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['company_id'];?>"><?php echo $v['company_title'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>		
		<?php if($output['service_yuyue_array']['yuyue_pay_status']==0){ ?>					
        <tr>
          <td colspan="2" class="required"><label for="serviceform">合同单号</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['service_yuyue_array']['yuyue_order_number'];?>" name="service_price" id="service_price" class="txt"></td>
          <td class="vatop tips">若选择支付，合同单号不能为空</td>
        </tr>		
		<?php } ?>				
        <tr>
          <td colspan="2" class="required"><label class="validation" for="cate_id">服务状态:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><label class="mr10">
              <input name="yuyue_status" type="radio" value="1" <?php if($output['service_yuyue_array']['yuyue_status'] == '1') echo 'checked';?> />
              已确认</label>
            <label class="mr10">
              <input name="yuyue_status" type="radio" value="2" <?php if($output['service_yuyue_array']['yuyue_status'] == '2') echo 'checked';?>/>
              已安排</label>
            <label class="mr10">
              <input name="yuyue_status" type="radio" value="3" <?php if($output['service_yuyue_array']['yuyue_status'] == '3') echo 'checked';?>/>
              已完成</label>
            <label class="mr10">
              <input name="yuyue_status" type="radio" value="4" <?php if($output['service_yuyue_array']['yuyue_status'] == '4') echo 'checked';?>/>
              已取消</label>
            </select></td>
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#service_yuyue_form").valid()){
     $("#service_yuyue_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#service_yuyue_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            yuyue_status : {
                required   : true
            }
        },
        messages : {
            yuyue_status : {
                required   : '<?php echo $lang['service_name_null'];?>'
            }
        }
    });

});
</script>