<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.d_inline {
      display:inline;
}
</style>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store"><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_joinin"><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="index.php?act=store&op=reopen_list" ><span>续签申请</span></a></li>
        <li><a href="index.php?act=store&op=store_bind_class_applay_list" ><span>经营类目申请</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <div class="homepage-focus" nctype="editStoreContent">
    <ul class="tab-menu">
      <li class="current">店铺信息</li>
      <li>注册信息</li>
    </ul>
    <form id="store_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="store_id" value="<?php echo $output['store_array']['store_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['store_user_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['store_array']['member_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="store_name">店铺名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_name'];?>" id="store_name" name="store_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_name">开店时间:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo ($t = $output['store_array']['store_time'])?@date('Y-m-d',$t):'';?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['belongs_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="sc_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(is_array($output['class_list'])){ ?>
              <?php foreach($output['class_list'] as $k => $v){ ?>
              <option <?php if($output['store_array']['sc_id'] == $v['sc_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['sc_id']; ?>"><?php echo $v['sc_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td colspan="2" class="required"><label>
            <label for="grade_id"> <?php echo $lang['belongs_level'];?>: </label>
            </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="grade_id" name="grade_id">
              <?php if(is_array($output['grade_list'])){ ?>
              <?php foreach($output['grade_list'] as $k => $v){ ?>
              <option <?php if($output['store_array']['grade_id'] == $v['sg_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['sg_id']; ?>"><?php echo $v['sg_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['period_to'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_end_time'];?>" id="end_time" name="end_time" class="txt date"></td>
          <td class="vatop tips"><?php echo $lang['formart'];?></td>
        </tr>
<!--店铺保障开-by abc.com-->
<td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_tq">店铺保障服务开关:</label></td>
        </tr>
        <tr>
			<td width="70%">
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_baozh1" class="cb-enable <?php if($output['store_array']['store_baozh'] == '1'){ ?>selected<?php } ?>" ><span>保障</span></label>
					<label for="store_baozh0" class="cb-disable <?php if($output['store_array']['store_baozh'] == '0'){ ?>selected<?php } ?>" ><span>图标</span></label>
					<input id="store_baozh1" name="store_baozh" <?php if($output['store_array']['store_baozh'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_baozh0" name="store_baozh" <?php if($output['store_array']['store_baozh'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_baozhopen1" class="cb-enable <?php if($output['store_array']['store_baozhopen'] == '1'){ ?>selected<?php } ?>" ><span>保证金</span></label>
					<label for="store_baozhopen0" class="cb-disable <?php if($output['store_array']['store_baozhopen'] == '0'){ ?>selected<?php } ?>" ><span>图标</span></label>
					<input id="store_baozhopen1" name="store_baozhopen" <?php if($output['store_array']['store_baozhopen'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_baozhopen0" name="store_baozhopen" <?php if($output['store_array']['store_baozhopen'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
					<!--保证金-->
					&nbsp;<input type="text" value="<?php echo $output['store_array']['store_baozhrmb'];?>" id="store_tq" name="store_baozhrmb" class="txt"  style="width: 50px;color:red;font-weight:900;">元
				</div>
			</td>
		</tr>

        <tr>
          <td colspan="2" class="required"><label for="store_tq">保障内容开关:</label></td>
        </tr>		
		<tr>
			<td width="70%">
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_zhping1" class="cb-enable <?php if($output['store_array']['store_zhping'] == '1'){ ?>selected<?php } ?>" ><span>正品</span></label>
					<label for="store_zhping0" class="cb-disable <?php if($output['store_array']['store_zhping'] == '0'){ ?>selected<?php } ?>" ><span>保障</span></label>
					<input id="store_zhping1" name="store_zhping" <?php if($output['store_array']['store_zhping'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_zhping0" name="store_zhping" <?php if($output['store_array']['store_zhping'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_shiti1" class="cb-enable <?php if($output['store_array']['store_shiti'] == '1'){ ?>selected<?php } ?>" ><span>实体</span></label>
					<label for="store_shiti0" class="cb-disable <?php if($output['store_array']['store_shiti'] == '0'){ ?>selected<?php } ?>" ><span>店铺</span></label>
					<input id="store_shiti1" name="store_shiti" <?php if($output['store_array']['store_shiti'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_shiti0" name="store_shiti" <?php if($output['store_array']['store_shiti'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_qtian1" class="cb-enable <?php if($output['store_array']['store_qtian'] == '1'){ ?>selected<?php } ?>" ><span>七天</span></label>
					<label for="store_qtian0" class="cb-disable <?php if($output['store_array']['store_qtian'] == '0'){ ?>selected<?php } ?>" ><span>退换</span></label>
					<input id="store_qtian1" name="store_qtian" <?php if($output['store_array']['store_qtian'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_qtian0" name="store_qtian" <?php if($output['store_array']['store_qtian'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_tuihuo1" class="cb-enable <?php if($output['store_array']['store_tuihuo'] == '1'){ ?>selected<?php } ?>" ><span>退换</span></label>
					<label for="store_tuihuo0" class="cb-disable <?php if($output['store_array']['store_tuihuo'] == '0'){ ?>selected<?php } ?>" ><span>承诺</span></label>
					<input id="store_tuihuo1" name="store_tuihuo" <?php if($output['store_array']['store_tuihuo'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_tuihuo0" name="store_tuihuo" <?php if($output['store_array']['store_tuihuo'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_shiyong1" class="cb-enable <?php if($output['store_array']['store_shiyong'] == '1'){ ?>selected<?php } ?>" ><span>试用</span></label>
					<label for="store_shiyong0" class="cb-disable <?php if($output['store_array']['store_shiyong'] == '0'){ ?>selected<?php } ?>" ><span>中心</span></label>
					<input id="store_shiyong1" name="store_shiyong" <?php if($output['store_array']['store_shiyong'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_shiyong0" name="store_shiyong" <?php if($output['store_array']['store_shiyong'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_erxiaoshi1" class="cb-enable <?php if($output['store_array']['store_erxiaoshi'] == '1'){ ?>selected<?php } ?>" ><span>2H</span></label>
					<label for="store_erxiaoshi0" class="cb-disable <?php if($output['store_array']['store_erxiaoshi'] == '0'){ ?>selected<?php } ?>" ><span>发货</span></label>
					<input id="store_erxiaoshi1" name="store_erxiaoshi" <?php if($output['store_array']['store_erxiaoshi'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_erxiaoshi0" name="store_erxiaoshi" <?php if($output['store_array']['store_erxiaoshi'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_huodaofk1" class="cb-enable <?php if($output['store_array']['store_huodaofk'] == '1'){ ?>selected<?php } ?>" ><span>货到</span></label>
					<label for="store_huodaofk0" class="cb-disable <?php if($output['store_array']['store_huodaofk'] == '0'){ ?>selected<?php } ?>" ><span>付款</span></label>
					<input id="store_huodaofk1" name="store_huodaofk" <?php if($output['store_array']['store_huodaofk'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_huodaofk0" name="store_huodaofk" <?php if($output['store_array']['store_huodaofk'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
				<div class="onoff" style="float:left;margin-right:10px;">
					<label for="store_xiaoxie1" class="cb-enable <?php if($output['store_array']['store_xiaoxie'] == '1'){ ?>selected<?php } ?>" ><span>消费者</span></label>
					<label for="store_xiaoxie0" class="cb-disable <?php if($output['store_array']['store_xiaoxie'] == '0'){ ?>selected<?php } ?>" ><span>保障</span></label>
					<input id="store_xiaoxie1" name="store_xiaoxie" <?php if($output['store_array']['store_xiaoxie'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
					<input id="store_xiaoxie0" name="store_xiaoxie" <?php if($output['store_array']['store_xiaoxie'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
				</div>
			</td>
		</tr>
<!--店铺保障- by abc.com -->	
        <tr>
          <td colspan="2" class="required"><label>
            <label for="state"><?php echo $lang['state'];?>:</label>
            </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="store_state1" class="cb-enable <?php if($output['store_array']['store_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="store_state0" class="cb-disable <?php if($output['store_array']['store_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="store_state1" name="store_state" <?php if($output['store_array']['store_state'] == '1'){ ?>checked="checked"<?php } ?> onclick="$('#tr_store_close_info').hide();" value="1" type="radio">
            <input id="store_state0" name="store_state" <?php if($output['store_array']['store_state'] == '0'){ ?>checked="checked"<?php } ?> onclick="$('#tr_store_close_info').show();" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="tr_store_close_info">
        <tr >
          <td colspan="2" class="required"><label for="store_close_info"><?php echo $lang['close_reason'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="store_close_info" rows="6" class="tarea" id="store_close_info"><?php echo $output['store_array']['store_close_info'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
    </form>
  <form id="joinin_form" enctype="multipart/form-data" method="post" action="index.php?act=store&op=edit_save_joinin" style="display:none;">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="member_id" value="<?php echo $output['joinin_detail']['member_id'];?>" />
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">公司及联系人信息</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th class="w150">公司名称：</th>
        <td colspan="20"><input type="text" class="txt" name="company_name" value="<?php echo $output['joinin_detail']['company_name'];?>"></td>
      </tr>
      <tr>
        <th>公司所在地：</th>
        <td colspan="20">
          <input type="hidden" name="company_address" id="company_address" value="<?php echo $output['joinin_detail']['company_address'];?>">
        </td>
      </tr>
      <tr>
        <th>公司详细地址：</th>
        <td colspan="20"><input type="text" class="txt w300" name="company_address_detail" value="<?php echo $output['joinin_detail']['company_address_detail'];?>"></td>
      </tr>
      <tr>
        <th>公司电话：</th>
        <td><input type="text" class="txt" name="company_phone" value="<?php echo $output['joinin_detail']['company_phone'];?>"></td>
        <th>员工总数：</th>
        <td><input type="text" class="txt w72" name="company_employee_count" value="<?php echo $output['joinin_detail']['company_employee_count'];?>">&nbsp;人</td>
        <th>注册资金：</th>
        <td><input type="text" class="txt w72" name="company_registered_capital" value="<?php echo $output['joinin_detail']['company_registered_capital'];?>">&nbsp;万元 </td>
      </tr>
      <tr>
        <th>联系人姓名：</th>
        <td><input type="text" class="txt" name="contacts_name" value="<?php echo $output['joinin_detail']['contacts_name'];?>"></td>
        <th>联系人电话：</th>
        <td><input type="text" class="txt" name="contacts_phone" value="<?php echo $output['joinin_detail']['contacts_phone'];?>"></td>
        <th>电子邮箱：</th>
        <td><input type="text" class="txt" name="contacts_email" value="<?php echo $output['joinin_detail']['contacts_email'];?>"></td>
      </tr>
    </tbody>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">营业执照信息（副本）</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th class="w150">营业执照号：</th>
        <td><input type="text" class="txt" name="business_licence_number" value="<?php echo $output['joinin_detail']['business_licence_number'];?>"></td></tr><tr>
      
        <th>营业执照所在地：</th>
        <td><input type="hidden" name="business_licence_address" id="business_licence_address" value="<?php echo $output['joinin_detail']['business_licence_address'];?>"></td></tr><tr>
      
        <th>营业执照有效期：</th>
        <td><input type="text" class="txt" name="business_licence_start" id="business_licence_start" value="<?php echo $output['joinin_detail']['business_licence_start'];?>"> - <input type="text" class="txt" name="business_licence_end" id="business_licence_end" value="<?php echo $output['joinin_detail']['business_licence_end'];?>"></td>
      </tr>
      <tr>
        <th>法定经营范围：</th>
        <td colspan="20"><input type="text" class="txt w300" name="business_sphere" value="<?php echo $output['joinin_detail']['business_sphere'];?>"></td>
      </tr>
      <tr>
        <th>营业执照<br />
电子版：</th>
        <td colspan="20">
          <a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['business_licence_number_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['business_licence_number_electronic']);?>" alt="" /> </a>
          <input class="w200" type="file" name="business_licence_number_electronic">
        </td>
      </tr>
    </tbody>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">组织机构代码证</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>组织机构代码：</th>
        <td colspan="20"><input type="text" class="txt w300" name="organization_code" value="<?php echo $output['joinin_detail']['organization_code'];?>"></td>
      </tr>
      <tr>
        <th>组织机构代码证<br/>          电子版：</th>
        <td colspan="20">
          <a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['organization_code_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['organization_code_electronic']);?>" alt="" /> </a>
          <input type="file" name="organization_code_electronic">
        </td>
      </tr>
    </tbody>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">一般纳税人证明：</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>一般纳税人证明：</th>
        <td colspan="20">
          <a nctype="nyroModal" href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['general_taxpayer']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['general_taxpayer']);?>" alt="" /> </a>
          <input type="file" name="general_taxpayer">
        </td>
      </tr>
    </tbody>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">开户银行信息：</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th class="w150">银行开户名：</th>
        <td><input type="text" class="txt w300" name="bank_account_name" value="<?php echo $output['joinin_detail']['bank_account_name'];?>"></td>
      </tr><tr>
        <th>公司银行账号：</th>
        <td><input type="text" class="txt w300" name="bank_account_number" value="<?php echo $output['joinin_detail']['bank_account_number'];?>"></td></tr>
      <tr>
        <th>开户银行支行名称：</th>
        <td><input type="text" class="txt w300" name="bank_name" value="<?php echo $output['joinin_detail']['bank_name'];?>"></td>
      </tr>
      <tr>
        <th>支行联行号：</th>
        <td><input type="text" class="txt w300" name="bank_code" value="<?php echo $output['joinin_detail']['bank_code'];?>"></td>
      </tr><tr>
        <th>开户银行所在地：</th>
        <td colspan="20"><input type="hidden" name="bank_address" id="bank_address" value="<?php echo $output['joinin_detail']['bank_address'];?>"></td>
      </tr>
      <tr>
        <th>开户银行许可证<br/>电子版：</th>
        <td colspan="20">
          <a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['bank_licence_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['bank_licence_electronic']);?>" alt="" /> </a>
          <input type="file" name="bank_licence_electronic">
        </td>
      </tr>
    </tbody>
    
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">结算账号信息：</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th class="w150">银行开户名：</th>
        <td><input type="text" class="txt w300" name="settlement_bank_account_name" value="<?php echo $output['joinin_detail']['settlement_bank_account_name'];?>"></td>
      </tr>
      <tr>
        <th>公司银行账号：</th>
        <td><input type="text" class="txt w300" name="settlement_bank_account_number" value="<?php echo $output['joinin_detail']['settlement_bank_account_number'];?>"></td>
      </tr>
      <tr>
        <th>开户银行支行名称：</th>
        <td><input type="text" class="txt w300" name="settlement_bank_name" value="<?php echo $output['joinin_detail']['settlement_bank_name'];?>"></td>
      </tr>
      <tr>
        <th>支行联行号：</th>
        <td><input type="text" class="txt w300" name="settlement_bank_code" value="<?php echo $output['joinin_detail']['settlement_bank_code'];?>"></td>
      </tr>
      <tr>
        <th>开户银行所在地：</th>
        <td><input type="hidden" name="settlement_bank_address" id="settlement_bank_address" value="<?php echo $output['joinin_detail']['settlement_bank_address'];?>"></td>
      </tr>
    </tbody>
    
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">税务登记证</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th class="w150">税务登记证号：</th>
        <td><input type="text" class="txt w300" name="tax_registration_certificate" value="<?php echo $output['joinin_detail']['tax_registration_certificate'];?>"></td>
      </tr>
      <tr>
        <th>纳税人识别号：</th>
        <td><input type="text" class="txt w300" name="taxpayer_id" value="<?php echo $output['joinin_detail']['taxpayer_id'];?>"></td>
      </tr>
      <tr>
        <th>税务登记证号<br />
电子版：</th>
        <td>
          <a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['tax_registration_certificate_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['tax_registration_certificate_electronic']);?>" alt="" /> </a>
          <input type="file" name="tax_registration_certificate_electronic">
        </td>
      </tr>
    </tbody>
  </table>
  <div><a id="btn_fail" class="btn" href="JavaScript:void(0);"><span><?php echo $lang['nc_submit'];?></span></a></div>
</form>
</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
var SHOP_SITE_URL = '<?php echo SHOP_SITE_URL;?>';
$(function(){
    $("#company_address").nc_region();
    $("#business_licence_address").nc_region();
    $("#bank_address").nc_region();
    $("#settlement_bank_address").nc_region();
    $('#end_time').datepicker();
    $('#business_licence_start').datepicker();
    $('#business_licence_end').datepicker();
    $('a[nctype="nyroModal"]').nyroModal();
    $('input[name=store_state][value=<?php echo $output['store_array']['store_state'];?>]').trigger('click');

    //按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
        if($("#store_form").valid()){
            $("#store_form").submit();
        }
    });

    $("#btn_fail").click(function(){
        $("#joinin_form").submit();
    });

    $('#store_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parentsUntil('tr').parent().prev().find('td:first'));
        },
		ignore:"#end_time",
        rules : {
             store_name: {
                 required : true,
                 remote : '<?php echo urlAdmin('store', 'ckeck_store_name', array('store_id' => $output['store_array']['store_id']))?>'
              }
        },
        messages : {
            store_name: {
                required: '<?php echo $lang['please_input_store_name'];?>',
                remote : '店铺名称已存在'
            }
        }
    });

    $('div[nctype="editStoreContent"] > ul').find('li').click(function(){
        $(this).addClass('current').siblings().removeClass('current');
        var _index = $(this).index();
        var _form = $('div[nctype="editStoreContent"]').find('form');
        _form.hide();
        _form.eq(_index).show();
    });
});
</script>