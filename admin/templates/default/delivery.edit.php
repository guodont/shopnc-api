<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>物流自提服务站管理</h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('delivery', 'index');?>"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('delivery', 'index', array('sign' => 'verify'));?>"><span>等待审核</span></a></li>
        <li><a href="<?php echo urlAdmin('delivery', 'setting');?>"><span>设置</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="delivery_form" method="post" action="<?php echo urlAdmin('delivery', 'save_edit');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="did" value="<?php echo $output['dlyp_info']['dlyp_id'];?>">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="">物流自提服务站用户名：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['dlyp_info']['dlyp_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">真实姓名：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['dlyp_info']['dlyp_truename'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">手机号：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input class="txt" type="text" name="dmobile" value="<?php echo $output['dlyp_info']['dlyp_mobile'];?>">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">座机号：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input class="txt" type="text" name="dtelephony" value="<?php echo $output['dlyp_info']['dlyp_telephony'];?>">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">自提服务站名称：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          <input class="txt" type="text" name="daddressname" value="<?php echo $output['dlyp_info']['dlyp_address_name'];?>">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">所在地区：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['dlyp_info']['dlyp_area_info'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">详细地址：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          <input class="txt" type="text" name="daddress" value="<?php echo $output['dlyp_info']['dlyp_address'];?>">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">身份证号码：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['dlyp_info']['dlyp_idcard'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">身份证图片：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><a href="<?php echo UPLOAD_SITE_URL.DS.ATTACH_DELIVERY.DS.$output['dlyp_info']['dlyp_idcard_image'];?>" target="_blank"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_DELIVERY.DS.$output['dlyp_info']['dlyp_idcard_image'];?>"></a></td>
          <td class="vatop tips">点击查看大图</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">申请时间：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo date('Y-m-d H:i:s', $output['dlyp_info']['dlyp_addtime']);?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">登录密码：</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="dpasswd"></td>
          <td class="vatop tips">不填为不修改密码</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="">状态：</label></td>
        </tr>
        <?php if (in_array($output['dlyp_info']['dlyp_state'], array(1,2))) {?>
        <tr class="noborder">
        <td class="vatop rowform onoff"><label for="site_status1" class="cb-enable <?php if($output['dlyp_info']['dlyp_state'] == '1'){ ?>selected<?php } ?>" ><span>开启</span></label>
            <label for="site_status0" class="cb-disable <?php if($output['dlyp_info']['dlyp_state'] == '0'){ ?>selected<?php } ?>" ><span>关闭</span></label>
            <input id="site_status1" name="dstate" <?php if($output['dlyp_info']['dlyp_state'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="site_status0" name="dstate" <?php if($output['dlyp_info']['dlyp_state'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php } else {?>
        <tr class="noborder">
         <td class="vatop rowform onoff"><label for="site_status1" class="cb-enable selected" ><span>通过</span></label>
            <label for="site_status20" class="cb-disable" ><span>失败</span></label>
            <input id="site_status1" name="dstate" checked="checked" value="1" type="radio">
            <input id="site_status20" name="dstate" value="20" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr style="display: none;" nctype="fail_reason">
          <td colspan="2" class="required"><label for="">审核失败原因：</label></td>
        </tr>
        <tr class="noborder" style="display: none;" nctype="fail_reason">
          <td class="vatop rowform" nctype="fail_reason">
            <textarea id="fail_reason" class="tarea" rows="6" name="fail_reason"></textarea>
          </td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(function(){
    $("#submitBtn").click(function(){
        $("#delivery_form").submit();
    });
    $('input[name="dstate"]').change(function(){
        _val = $('input[name="dstate"]:checked').val();
        if (_val == 20) {
            $('[nctype="fail_reason"]').show();
        } else {
            $('[nctype="fail_reason"]').hide();
        }
    });
});
</script>
