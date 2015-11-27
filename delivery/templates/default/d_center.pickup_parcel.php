<?php defined('InShopNC') or exit('Access Invalid!');?>

<form method="post" action="<?php echo DELIVERY_SITE_URL?>/index.php?act=d_center&op=pickup_parcel" id="pickup_parcel_form">
  <input type="hidden" name="form_submit" value="ok" />
  <input type="hidden" name="order_id" value="<?php echo $_GET['order_id'];?>">
  <dl class="ncd-change-password" id="pickupParcel">
  <dd>
    <label class="phrases">请输入提货码</label>
    <input class="input-txt" type="text" name="pickup_code" autocomplete="off">
    <span></span>
  </dd>
  <dd>
    <input type="submit" class="submit" value="提交">
  </dd>
  </dl>
</form>
<script>
$(function(){
    //input焦点时隐藏/显示填写内容提示信息
    $("#pickupParcel .input-txt").placeholder();
    $('#pickup_parcel_form').validate({
        errorPlacement: function(error, element){
            element.next().append(error);
        },
        submitHandler:function(form){
            ajaxpost('pickup_parcel_form', '', '', 'onerror');
        },
        rules : {
            pickup_code : {
                required : true,
                digits : true,
                rangelength : [4,4]
            }
        },
        messages : {
            pickup_code : {
                required : '请输入提货码',
                digits : '请输入正确的提货码',
                rangelength : '请输入正确的提货码'
            }
        }
    });
});
</script>