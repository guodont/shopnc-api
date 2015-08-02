<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul>
    <li>1. 店铺到期前 30 天可以申请店铺续签。</li>
    <?php if (empty($output['reopen_list'])) { ?>
    <li>2. 您的店铺已签约至 <?php echo date('Y-m-d',$output['store_info']['store_end_time']);?>，自 <?php echo date('Y-m-d',$output['store_info']['allow_applay_date']);?> 起的 30 天内可以申请续签。</li>
    <?php } ?>
  </ul>
</div>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w10"></th>
      <th>申请时间</th>
      <th>收费标准(元/年)</th>
      <th>续签时长(年)</th>
      <th>付款金额(元)</th>
      <th>续签起止有效期</th>
      <th>付款凭证</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($output['reopen_list'])) { ?>
    <?php foreach($output['reopen_list'] as $val) { ?>
    <tr class="bd-line">
      <td></td>
      <td><?php echo date('Y-m-d',$val['re_create_time']); ?></td>
      <td><?php echo $val['re_grade_price']; ?> ( <?php echo $val['re_grade_name'];?> )</td>
      <td><?php echo $val['re_year']?></td>
      <td><?php echo $val['re_pay_amount'] == 0 ? '免费' : $val['re_pay_amount'];?></td>
      <td>
      <?php if ($val['re_start_time'] != '') {?>
      <?php echo date('Y-m-d',$val['re_start_time']).' ~ '.date('Y-m-d',$val['re_end_time']);?>
      <?php  } ?>
      </td>
      <td>
      <?php if ($val['re_pay_cert'] != '') {?>
      <a href="<?php echo getStoreJoininImageUrl($val['re_pay_cert']);?>" target="_blank">查看</a>
      <?php }?>
      </td>
      <td><?php echo str_replace(array('0','1','2'),array('待付款','待审核','通过审核'),$val['re_state']);?></td>
      <td class="nscs-table-handle">
      <?php if ($val['re_state'] == '0') {?>
      <span><a href="javascript:void(0)" class="btn-red" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store_info&op=reopen_del&re_id=<?php echo $val['re_id']; ?>');"><i class="icon-trash"></i><p><?php echo $lang['nc_del'];?></p></a></span>
     <?php } ?>
      </td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="ncsc-form-default">
<?php if ($output['upload_cert']) {?>
  <form method="post" action="index.php?act=store_info&op=reopen_upload" name="upload_form" id="upload_form" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="re_id" value="<?php echo $output['reopen_info']['re_id'];?>">
    <dl>
      <dt>缴费金额<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <?php echo $output['reopen_info']['re_pay_amount'];?> 元
      </dd>
    </dl>
    <dl>
      <dt>上传付款凭证<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input name="re_pay_cert" type="file">
      </dd>
    </dl>
    <dl>
      <dt>备注<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <textarea name="re_pay_cert_explain" rows="10" cols="30"></textarea>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="button" id="btn_upload_reopen"  class="submit" value="<?php echo $lang['nc_submit'];?>" /></label>
    </div>
  </form>
<?php } ?>

<?php if ($output['applay_reopen']) {?>
  <form method="post" action="index.php?act=store_info&op=reopen_add" name="add_form" id="add_form">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt>申请店铺等级<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <select name="re_grade_id" style="width: auto;">
            <?php if(!empty($output['grade_list']) && is_array($output['grade_list']) ) {?>
            <?php foreach ($output['grade_list'] as $val) {?>
            <option <?php if ($val['sg_id'] == $output['current_grade_id']) echo 'selected'; ?> value="<?php echo $val['sg_id'];?>"><?php echo $val['sg_name'];?> <?php echo floatval($val['sg_price'])>0 ? $val['sg_price'].' 元/年' : '免费';?></option>
            <?php }?>
            <?php }?>
          </select>
      </dd>
    </dl>
    <dl>
      <dt>申请续签时长<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <select name="re_year">
            <option value="1">1 年</option>
            <option value="2">2 年</option>
          </select>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="button" id="btn_add_reopen"  class="submit" value="<?php echo $lang['nc_submit'];?>" /></label>
    </div>
  </form>
<?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	//页面输入内容验证
    $('#btn_add_reopen').on('click', function() {
        ajaxpost('add_form', '', '', 'onerror')
    });

    $('#upload_form').validate({
		submitHandler:function(form){
			ajaxpost('upload_form', '', '', 'onerror');
		},
        rules : {
        	re_pay_cert: {
                required: true
            },
            re_pay_cert_explain: {
                maxlength: 100 
            }
        },
        messages : {
        	re_pay_cert: {
                required: '请选择付款凭证'
            },
            re_pay_cert_explain: {
                maxlength: jQuery.validator.format("最多{0}个字")
            }
        }
    });

    $('#btn_upload_reopen').on('click', function() {
    	$('#upload_form').submit();
    });
});
</script>