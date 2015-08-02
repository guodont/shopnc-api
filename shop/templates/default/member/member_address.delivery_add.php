<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div class="adds">
    <div class="alert alert-success">
      <ul>
        <li>当您需要对自己的收货地址保密或担心收货时间冲突时可使用该业务。添加后可在购物车中作为收货地址进行选择，货品将直接发送至自提服务站。 到货后短信、站内消息进行通知，届时您可使用“自提码”至该服务站兑码取货。</li>
      </ul>
    </div>
    <div id="warning"></div>
    <form method="post" action="index.php?act=member_address&op=delivery_add" id="address_form" target="_parent">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="address_id" value="<?php echo $output['address_info']['address_id'];?>" />
      <dl>
        <dt><i class="required">*</i>地区选择：</dt>
        <dd>查找 <span id="region">
          <input type="hidden" value="<?php echo $output['address_info']['city_id'];?>" name="city_id" id="city_id">
          <select>
          </select>
          </span>范围内的自提服务站。</dd>
      </dl>
      <div class="ncmc-delivery" id="zt_address"></div>
      <dl>
        <dt><i class="required">*</i>收货人姓名<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w100" name="true_name" value="<?php echo $output['address_info']['true_name'];?>"/>
          <p class="hint"></p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i>电话号码<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w200" name="tel_phone" value="<?php echo $output['address_info']['tel_phone'];?>"/>
          <p class="hint">区号 - 电话号码 - 分机</p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i>手机<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w200" name="mob_phone" value="<?php echo $output['address_info']['mob_phone'];?>"/>
        </dd>
      </dl>
      <div class="bottom">
        <label class="submit-border">
          <input type="submit" class="submit" value="保存" />
        </label>
        <a class="ncm-btn ml5" href="javascript:DialogManager.close('daisou');">取消</a> </div>
    </form>
  </div>
</div>
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(document).ready(function(){
	regionInit("region");
    $('#address_form').validate({
    	submitHandler:function(form){
    		if ($('input[type="radio"]:checked').size() == 1) {
    			ajaxpost('address_form', '', '', 'onerror');
            }
    	},

        rules : {
            true_name : {
                required : true
            },
            tel_phone : {
                required : check_phone,
                minlength : 6,
				maxlength : 20
            },
            mob_phone : {
                required : check_phone,
                minlength : 11,
				maxlength : 11,                
                digits : true
            }
        },
        messages : {
            true_name : {
                required : '请填写收货人姓名'
            },
            tel_phone : {
                required : '手机和电话至少填写一个',
                minlength: '请正确填写电话号码',
				maxlength: '请正确填写电话号码'
            },
            mob_phone : {
                required : '手机和电话至少填写一个',
                minlength: '请正确填写手机号',
				maxlength: '请正确填写手机号',
                digits : '请正确填写手机号'
            }
        },
        groups : {
            phone:'tel_phone mob_phone'
        }
    });
    $('#address_form').on('change','select',function(){
        area_id = $('#address_form').find('select').last().val();
        if (area_id != '-请选择-') {
        	$('#zt_address').load("<?php echo SHOP_SITE_URL;?>/index.php?act=member_address&op=delivery_list&dlyp_id=<?php echo $output['address_info']['dlyp_id'];?>&area_id="+area_id);
        }
    });

    <?php if (intval($_GET['id'])) { ?>
    $('#zt_address').load("<?php echo SHOP_SITE_URL;?>/index.php?act=member_address&op=delivery_list&dlyp_id=<?php echo $output['address_info']['dlyp_id'];?>&area_id=<?php echo $output['address_info']['area_id']?>");
    setTimeout("$('select').eq(0).val(<?php echo $output['address_info']['province_id']?>).change();",500);
    setTimeout("$('select').eq(1).val(<?php echo $output['address_info']['city_id']?>).change();",1000);
    setTimeout("$('select').eq(2).val(<?php echo $output['address_info']['area_id']?>);",1500);
    <?php } ?>
});
function check_phone(){
    return ($('input[name="tel_phone"]').val() == '' && $('input[name="mob_phone"]').val() == '');
}
</script>