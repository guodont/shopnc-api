<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div class="adds">
    <div id="warning"></div>
    <form method="post" action="index.php?act=member_address&op=address" id="address_form" target="_parent">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="id" value="<?php echo $output['address_info']['address_id'];?>" />
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_receiver_name'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w100" name="true_name" value="<?php echo $output['address_info']['true_name'];?>"/>
          <p class="hint"><?php echo $lang['member_address_input_name'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_location'].$lang['nc_colon'];?></dt>
        <dd>
          <div id="region">
            <input type="hidden" value="<?php echo $output['address_info']['city_id'];?>" name="city_id" id="city_id">
            <input type="hidden" name="area_id" id="area_id" value="<?php echo $output['address_info']['area_id'];?>" class="area_ids" />
            <input type="hidden" name="area_info" id="area_info" value="<?php echo $output['address_info']['area_info'];?>" class="area_names" />
            <?php if(!empty($output['address_info']['area_id'])){?>
            <span><?php echo $output['address_info']['area_info'];?></span>
            <input type="button" value="<?php echo $lang['nc_edit'];?>" class="edit_region" />
            <select style="display:none;">
            </select>
            <?php }else{?>
            <select>
            </select>
            <?php }?>
          </div>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_address'].$lang['nc_colon'];?></dt>
        <dd>
          <input class="text w300" type="text" name="address" value="<?php echo $output['address_info']['address'];?>"/>
          <p class="hint"><?php echo $lang['member_address_not_repeat'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_phone_num'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w200" name="tel_phone" value="<?php echo $output['address_info']['tel_phone'];?>"/>
          <p class="hint"><?php echo $lang['member_address_area_num'];?> - <?php echo $lang['member_address_phone_num'];?> - <?php echo $lang['member_address_sub_phone'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['member_address_mobile_num'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text w200" name="mob_phone" value="<?php echo $output['address_info']['mob_phone'];?>"/>
        </dd>
      </dl>
      <?php if (!intval($output['address_info']['dlyp_id'])) { ?>
      <dl>
        <dt><em class="pngFix"></em>设为默认地址<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="checkbox" class="checkbox vm mr5" <?php if ($output['address_info']['is_default']) echo 'checked';?> name="is_default" id="is_default" value="1" />
          <label for="is_default">设置为默认收货地址</label>
        </dd>
      </dl>
      <?php } ?>
      <?php if (C('delivery_isuse')) { ?>
      <dl>
        <dt>&nbsp;</dt>
        <dd> <a href="javascript:void(0);" class="ncm-btn-mini ncm-btn-orange" id="zt"><i class="icon-flag"></i>使用自提服务站</a>
        <p class="hint">当您需要对自己的收货地址保密或担心收货时间冲突时可使用该业务，<br/>添加后可在购物车中作为收货地址进行选择，货品将直接发送至自提服务站，<br/>到货后短信、站内消息进行通知，届时您可使用“自提码”至该服务站兑码取货。</p> </dd>
      </dl>
      <?php } ?>
      <div class="bottom">
        <label class="submit-border">
          <input type="submit" class="submit" value="<?php if($output['type'] == 'add'){?><?php echo $lang['member_address_new_address'];?><?php }else{?><?php echo $lang['member_address_edit_address'];?><?php }?>" />
        </label>
        <a class="ncm-btn ml5" href="javascript:DialogManager.close('my_address_edit');">取消</a> </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(document).ready(function(){
	regionInit("region");
    $('#address_form').validate({
    	submitHandler:function(form){
    		if ($('select[class="valid"]').eq(1).val()>0) $('#city_id').val($('select[class="valid"]').eq(1).val());
    		ajaxpost('address_form', '', '', 'onerror');
    	},
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
            true_name : {
                required : true
            },
            area_id : {
                required : true,
                min   : 1,
                checkarea : true
            },
            address : {
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
                required : '<?php echo $lang['member_address_input_receiver'];?>'
            },
            area_id : {
                required : '<?php echo $lang['member_address_choose_location'];?>',
                min  : '<?php echo $lang['member_address_choose_location'];?>',
                checkarea  : '<?php echo $lang['member_address_choose_location'];?>'
            },
            address : {
                required : '<?php echo $lang['member_address_input_address'];?>'
            },
            tel_phone : {
                required : '<?php echo $lang['member_address_phone_and_mobile'];?>',
                minlength: '<?php echo $lang['member_address_phone_rule'];?>',
				maxlength: '<?php echo $lang['member_address_phone_rule'];?>'
            },
            mob_phone : {
                required : '<?php echo $lang['member_address_phone_and_mobile'];?>',
                minlength: '<?php echo $lang['member_address_wrong_mobile'];?>',
				maxlength: '<?php echo $lang['member_address_wrong_mobile'];?>',
                digits : '<?php echo $lang['member_address_wrong_mobile'];?>'
            }
        },
        groups : {
            phone:'tel_phone mob_phone'
        }
    });
    $('#zt').on('click',function(){
    	DialogManager.close('my_address_edit');
    	ajax_form('daisou','使用代收货（自提）', 'index.php?act=member_address&op=delivery_add', '900',0);
    });
});
function check_phone(){
    return ($('input[name="tel_phone"]').val() == '' && $('input[name="mob_phone"]').val() == '');
}
</script>