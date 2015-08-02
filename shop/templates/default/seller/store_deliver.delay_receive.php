<div class="eject_con">
<div id="warning"></div>
<?php if ($output['order_info']) {?>

  <form id="changeform" method="post" action="index.php?act=store_deliver&op=delay_receive&order_id=<?php echo $output['order_info']['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['store_order_sn'].$lang['nc_colon'];?></dt>
      <dd><span class="num"><?php echo $output['order_info']['order_sn']; ?></span></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_order_buyer_with'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['order_info']['buyer_name']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo '最晚收货时间'.$lang['nc_colon'];?></dt>
      <dd><?php echo date('Y-m-d H:i:s',$output['order_info']['delay_time']);?><br/>如果超过该时间买家未点击收货，系统将自动更改为收货状态 </dd>
    </dl>
    <dl>
      <dt><?php echo '延迟'.$lang['nc_colon'];?></dt>
      <dd>
      <select name="delay_date">
      <option value="5">5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      </select> 天
      </dd>
    </dl>
    <div class="bottom">
        <label class="submit-border"><input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" /></label>
    </div>
  </form>
<?php } else { ?>
<p style="line-height:80px;text-align:center">该订单并不存在，请检查参数是否正确!</p>
<?php } ?>
</div>
<script type="text/javascript">
$(function(){
    $('#changeform').validate({
    	errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors){ $('#warning').show();}else{ $('#warning').hide(); }
        },
     	submitHandler:function(form){
    		ajaxpost('changeform', '', '', 'onerror'); 
    	},    
	    rules : {
        	order_amount : {
	            required : true,
	            number : true
	        }
	    },
	    messages : {
	    	order_amount : {
	    		required : '<?php echo $lang['store_order_modify_price_gpriceerror'];?>',
            	number : '<?php echo $lang['store_order_modify_price_gpriceerror'];?>'
	        }
	    }
	});
});
</script>