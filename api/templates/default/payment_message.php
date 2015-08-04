<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
    .success { width: 100%; text-align: center; padding: 200px 0 10px 0; color: green; }
    .fail { width: 100%; text-align: center; padding: 200px 0 10px 0; color: red; }
    .return { width: 100%; text-align: center; }
</style>
<script>window.demo.checkPaymentAndroid("<?php echo $output['result'];?>");</script>
<div class="<?php echo $output['result'];?>" >
<?php echo $output['message'];?>
</div>
<div class="return" >
    <a href="<?php echo WAP_SITE_URL;?>/index.php?act=member_order&op=order_list"><img src="<?php echo WAP_SITE_URL;?>/images/pay_ok.png"></a>
    <a href="<?php echo WAP_SITE_URL;?>/tmpl/member/order_list.html"><img src="<?php echo WAP_SITE_URL;?>/images/pay_ok.png"></a>
</div>
