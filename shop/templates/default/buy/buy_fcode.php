<?php defined('InShopNC') or exit('Access Invalid!');?>

<!-- S fcode -->
<?php if ($output['store_cart_list'][key($output['store_cart_list'])][0]['is_fcode'] == 1) { ?>

<div class="ncc-main">
  <div class="ncc-title">
    <h3>使用F码购买商品</h3>
    <h5>如果您有该商品的F码，请输入并验证您具有优先购买权。</h5>
  </div>
  <div class="ncc-receipt-info">
    <div class="fcode-form ">
      <input name="fcode" type="text" class="text" id="fcode" placeholder="输入F码" autocomplete="off" maxlength="20" />
      <input type="button" value="使用F码" id="fcode_submit" class="button" />
      <input value="" type="hidden" name="fcode_callback" id="fcode_callback">
      <input type="hidden" id="goods_commonid" name="goods_commonid" value="<?php echo $output['store_cart_list'][key($output['store_cart_list'])][0]['goods_commonid'];?>">
    </div>
    <div class="fcode-hint" id="fcode_showmsg"></div>
  </div>
</div>
<!-- E fcode --> 
<script>
$(function(){
    $('#fcode_submit').on('click',function(){
        if ($('#fcode').val() == '') {
        	showDialog('请输入F码', 'error','','','','','','','','',2);return false;
        }
        $('#fcode_callback').val('');
		$.get("index.php?act=buy&op=check_fcode", {'fcode':$('#fcode').val(),'goods_commonid':$('#goods_commonid').val()}, function(data){
            if (data == '1') {
            	$('#fcode_callback').val('1');
            	$('#fcode_submit').hide();
            	$('#fcode').hide();
            	$('#fcode_showmsg').append('<i class="icon-ok-circle"></i>'+$('#fcode').val()+'为有效的F码，您可以继续完成下单购买。');
            } else {
            	showDialog('F码错误，请重新输入', 'error','','','','','','','','',2);
            }
        });
    });

});
</script>
<?php } ?>
