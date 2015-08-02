<?php defined('InShopNC') or exit('Access Invalid!');?>
<ul>
  <?php foreach($output['inv_list'] as $k=>$val){ ?>
  <li class="inv_item <?php echo $k == 0 ? 'ncc-selected-item' : null; ?>">
    <input content="<?php echo $val['content'];?>" id="inv_<?php echo $val['inv_id']; ?>" nc_type="inv" type="radio" name="inv" value="<?php echo $val['inv_id']; ?>" <?php echo $k == 0 ? 'checked' : null; ?>/>
    <label for="inv_<?php echo $val['inv_id']; ?>">&nbsp;&nbsp;<?php echo $val['content']; ?></label>
    &emsp;&emsp;&emsp;<a href="javascript:void(0);" onclick="delInv(<?php echo $val['inv_id']?>);" class="del">[ <?php echo $lang['nc_delete'];?> ]</a> </li>
  <?php } ?>
  <li class="inv_item">
    <?php if (count($output['inv_list']) < 10) {?>
    <input value="0" nc_type="inv" id="add_inv" type="radio" name="inv">
    <label for="add_inv">&nbsp;&nbsp;使用新的发票信息</label>
    <?php } else {?>
    最多允许保存10条发票信息，请先删除部分不常用发票后再添加
    <?php }?>
  </li>
  <div id="add_inv_box" style="display:none">
    <form method="POST" id="inv_form" action="index.php">
      <input type="hidden" value="buy" name="act">
      <input type="hidden" value="add_inv" name="op">
      <input type="hidden" name="form_submit" value="ok"/>
      <div class="ncc-form-default">
        <dl>
          <dt>发票类型<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <label>
              <input type="radio" checked name="invoice_type" value="1">
              普通发票</label>
            &emsp;&emsp;
            <?php if (!$output['vat_deny']) {?>
            <label>
              <input type="radio" name="invoice_type" value="2">
              增值税发票</label>
            <?php }?>
          </dd>
        </dl>
      </div>
      <div id="invoice_panel" class="ncc-form-default">
        <dl>
          <dt>发票抬头<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <select name="inv_title_select">
              <option value="person">个人</option>
              <option value="company">单位</option>
            </select>
            <input class="text w200" style="display:none" name="inv_title" id="inv_title" placeholder="单位名称" value="">
          </dd>
        </dl>
        <dl>
          <dt>发票内容<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <select id="inv_content" name="inv_content">
              <option selected value="明细">明细</option>
              <option value="酒">酒</option>
              <option value="食品">食品</option>
              <option value="饮料">饮料</option>
              <option value="玩具">玩具</option>
              <option value="日用品">日用品</option>
              <option value="装修材料">装修材料</option>
              <option value="化妆品">化妆品</option>
              <option value="办公用品">办公用品</option>
              <option value="学生用品">学生用品</option>
              <option value="家居用品">家居用品</option>
              <option value="饰品">饰品</option>
              <option value="服装">服装</option>
              <option value="箱包">箱包</option>
              <option value="精品">精品</option>
              <option value="家电">家电</option>
              <option value="劳防用品">劳防用品</option>
              <option value="耗材">耗材</option>
              <option value="电脑配件">电脑配件</option>
            </select>
          </dd>
        </dl>
      </div>
      <div id="vat_invoice_panel" class="ncc-form-default" style="display:none">
        <dl>
          <dt><i class="required">*</i>单位名称<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_company" value="">
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>纳税人识别号<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_code" value="">
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>注册地址<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_reg_addr" value="">
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>注册电话<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_reg_phone" value="">
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>开户银行<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_reg_bname" value="">
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>银行账户<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_reg_baccount" value="">
          </dd>
        </dl>
        <dl>
          <dt></dt>
          <dd>如您是首次开具增值税专用发票，请您填写纳税人识别号等开票信息，并上传 加盖公章的营业执照副本、税务登记证副本、一般纳税人资格证书及银行开户 许可证扫描件邮寄给我们，收到您的开票资料后，我们会尽快审核。 </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>发票内容<?php echo $lang['nc_colon'];?></dt>
          <dd>明细</dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>收票人姓名<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_rec_name" value="">
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>收票人手机号<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_rec_mobphone" value="">
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>收票人省份<?php echo $lang['nc_colon'];?></dt>
          <dd id="region">
            <select>
            </select>
            <input type="hidden" value="" name="city_id" id="city_id">
            <input type="hidden" name="area_id" id="area_id" class="area_ids"/>
            <input type="hidden" name="area_info" id="area_info" class="area_names"/>
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>送票地址<?php echo $lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" maxlength="50" name="inv_goto_addr" value="">
          </dd>
        </dl>
      </div>
    </form>
  </div>
</ul>
<div class="hr16"> <a id="hide_invoice_list" class="ncc-btn ncc-btn-red" href="javascript:void(0);"><?php echo $lang['cart_step1_invoice_submit'];?></a> <a id="cancel_invoice" class="ncc-btn ml10" href="javascript:void(0);">不需要发票</a></div>
<script>
var postResult = false;
function delInv(id){
    $('#invoice_list').load(SITEURL+'/index.php?act=buy&op=load_inv&vat_hash<?php echo $_GET['vat_hash'];?>&del_id='+id);
}
$(function(){
    $.ajaxSetup({async : false});
    //不需要发票
    $('#cancel_invoice').on('click',function(){
        $('#invoice_id').val('');
        hideInvList('不需要发票');
    });
    //使用新的发票信息
    $('input[nc_type="inv"]').on('click',function(){
       	regionInit("region");
        if ($(this).val() == '0') {
            $('.inv_item').removeClass('ncc-selected-item');
            $('#add_inv_box').show();
        } else {
            $('.inv_item').removeClass('ncc-selected-item');
            $(this).parent().addClass('ncc-selected-item');
            $('#add_inv_box').hide();
        }
    });
    <?php if (empty($output['inv_list'])) {?>
    //$('input[nc_type="inv"]').click();
    <?php } ?>
    //保存发票信息
    $('#hide_invoice_list').on('click',function(){
        var content = '';
        if ($('input[name="inv"]:checked').size() == 0){
        	$('#cancel_invoice').click();
        	return false;
        }
        if ($('input[name="inv"]:checked').val() != '0'){
            //如果选择已保存过的发票信息
            content = $('input[name="inv"]:checked').attr('content');
            $('#invoice_id').val($('input[name="inv"]:checked').val());
            hideInvList(content);
            return false;
        }
        //如果是新增发票信息
        if ($('input[name="invoice_type"]:checked').val() == 1){
            //如果选择普通发票
            if ($('select[name="inv_title_select"]').val() == 'person'){
                content = '普通发票 个人 ' + $('select[name="inv_content"]').val();
            }else if($.trim($('#inv_title').val()) == '' || $.trim($('#inv_title').val()) == '单位名称'){
                showDialog('请填写单位名称', 'error','','','','','','','','',2);return false;
            }else{
                content = '普通发票 ' + $.trim($('#inv_title').val())+ ' ' + $('#inv_content').val();
            }
        }else{
            content = '增值税发票 ' + $.trim($('input[name="inv_company"]').val()) + ' ' + $.trim($('input[name="inv_code"]').val()) + ' ' + $.trim($('input[name="inv_reg_addr"]').val());
            //验证增值税发票表单
            if (!$('#inv_form').valid()){
                return false;
            }
        }
        var datas=$('#inv_form').serialize();
        
        $.post('index.php',datas,function(data){
            if (data.state=='success'){
                $('#invoice_id').val(data.id);
                postResult = true;
            }else{
                showDialog(data.msg, 'error','','','','','','','','',2);
                postResult = false;
            }
        },'json');
        if (postResult){
            hideInvList(content);
        }
    });
	$('input[name="invoice_type"]').on('click',function(){
		if ($(this).val() == 1) {
			$('#invoice_panel').show();
			$('#vat_invoice_panel').hide();
		} else {
			$('#invoice_panel').hide();
			$('#vat_invoice_panel').show();
		}
	});
	$('select[name="inv_title_select"]').on('change',function(){
	    if ($(this).val()=='company') {
	        $('#inv_title').show();
	    } else {
	        $('#inv_title').hide();
	    }
	});

    $('#inv_form').validate({
        rules : {
            inv_company : {
                required : true
            },
            inv_code : {
                required : true
            },
            inv_reg_addr : {
                required : true
            },
			inv_reg_phone : {
				required : true
			},
            inv_reg_bname : {
                required : true
            },
            inv_reg_baccount : {
                required : true
            },
            inv_rec_name : {
                required : true
            },
            inv_rec_mobphone : {
                required : true
            },            
            area_id : {
                required : true,
                min   : 1,
                checkarea:true
            },
            inv_goto_addr : {
                required : true
            }
        },
        messages : {
            inv_company : {
                required : '<i class="icon-exclamation-sign"></i>单位名称不能为空'
            },
            inv_code : {
                required : '<i class="icon-exclamation-sign"></i>纳税人识别号不能为空'
            },
            inv_reg_addr : {
                required : '<i class="icon-exclamation-sign"></i>注册地址不能为空'
            },
			inv_reg_phone : {
				required : '<i class="icon-exclamation-sign"></i>注册电话不能为空'
			},
            inv_reg_bname : {
                required : '<i class="icon-exclamation-sign"></i>开户银行不能为空'
            },
            inv_reg_baccount : {
                required : '<i class="icon-exclamation-sign"></i>银行账户不能为空'
            },
            inv_rec_name : {
                required : '<i class="icon-exclamation-sign"></i>收票人姓名不能为空'
            },
            inv_rec_mobphone : {
                required : '<i class="icon-exclamation-sign"></i>收票人手机号不能为空'
            },
            area_id : {
                required : '<i class="icon-exclamation-sign"></i>请选择地区',
                min : '<i class="icon-exclamation-sign"></i>请选择地区',
                checkarea:'<i class="icon-exclamation-sign"></i>请选择地区'
            },
            inv_goto_addr : {
                required : '<i class="icon-exclamation-sign"></i>送票地址不能为空'
            }
        }
    });
});
</script>