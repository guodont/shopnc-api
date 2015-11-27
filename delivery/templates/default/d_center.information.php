<?php defined('InShopNC') or exit('Access Invalid!');?>

<dl>
  <dt>用&nbsp;&nbsp;户&nbsp;&nbsp;名：</dt>
  <dd><?php echo $output['delivery_info']['dlyp_name'];?></dd>
</dl>
<dl>
  <dt>登&nbsp;&nbsp;记&nbsp;&nbsp;人：</dt>
  <dd><?php echo $output['delivery_info']['dlyp_truename'];?>&nbsp;&nbsp;(身份证号码<?php echo encryptShow($output['delivery_info']['dlyp_idcard'], 2, 16);?>)</dd>
</dl>
<dl>
  <dt>登记地址：</dt>
  <dd><?php echo $output['delivery_info']['dlyp_area_info'];?>&nbsp;<?php echo $output['delivery_info']['dlyp_address'];?>(<?php echo $output['delivery_info']['dlyp_address_name'];?>)</dd>
</dl>
<dl>
  <dt>登记电话：</dt>
  <dd><?php echo $output['delivery_info']['dlyp_mobile'];?>(手机)&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $output['delivery_info']['dlyp_telephony'];?>(座机)</dd>
</dl>
<dl>
  <dt>运营状态：</dt>
  <dd><?php echo $output['delivery_state'][$output['delivery_info']['dlyp_state']];?></dd>
</dl>
<?php if ($output['delivery_info']['dlyp_fail_reason'] != '') {?>
<dl>
  <dt>失败原因：</dt>
  <dd><?php echo $output['delivery_info']['dlyp_fail_reason'];?></dd>
</dl>
<a href="index.php?act=joinin_again">再次申请</a>
<?php }?>