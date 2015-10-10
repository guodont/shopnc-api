<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
    $('#btn_apply_agreement_c2c_next').on('click', function() {
        if($('#input_apply_agreement').prop('checked')) {
            window.location.href = "index.php?act=store_joinin_c2c&op=step1";
        } else {
            alert('请阅读并同意协议');
        }
    });
    $('#btn_apply_agreement_next').on('click', function() {
        if($('#input_apply_agreement').prop('checked')) {
            window.location.href = "index.php?act=store_joinin&op=step1";
        } else {
            alert('请阅读并同意协议');
        }
    });
});
</script>

  <!-- 协议 -->
  <div id="apply_agreement" class="apply-agreement">
    <div class="title"><h3>入驻协议</h3></div>
    <div class="apply-agreement-content">
        <?php echo $output['agreement'];?>
    </div>
    <div class="apple-agreement">
      <input id="input_apply_agreement" name="input_apply_agreement" type="checkbox" checked />
      <label for="input_apply_agreement">我已阅读并同意以上协议</label>
    </div>
    <div class="bottom">
		<a id="btn_apply_agreement_c2c_next" href="javascript:;" class="btn">个人入驻</a>
		<a id="btn_apply_agreement_next" href="javascript:;" class="btn">企业入驻</a>
	</div>
  </div>
  

