<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form method="post" id="tpl_form" name="tpl_form" action="index.php?act=store_transport&op=save">
    <input type="hidden" name="transport_id" value="<?php echo $output['transport']['id'];?>" />
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" value="<?php echo $_GET['type'];?>">
    <dl>
      <dt>
        <label for="J_TemplateTitle" class="label-like"><?php echo $lang['transport_tpl_name'].$lang['nc_colon'];?></label>
      </dt>
      <dd>
        <input type="text"  class="text"  id="title" autocomplete="off"  value="<?php echo $output['transport']['title'];?>" name="title">
        <p class="J_Message" style="display:none" error_type="title"><i class="icon-exclamation-sign"></i><?php echo $lang['transport_tpl_name_note'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['transport_type'].$lang['nc_colon'];?></dt>
      <dd><?php echo $lang['transport_type_description']?></p>
      </dd>
    </dl>

    <!-----------------------POST begin--------------------------------------->
    <dl>
      <dt></dt>
      <dd class="trans-line">
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" id="submit_tpl" class="submit" value="<?php echo $lang['transport_tpl_save'];?>" /></label>
    </div>
  </form>
  <div class="ks-ext-mask" style="position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 999; display:none"></div>
  <div id="dialog_areas" class="dialog-areas" style="display:none">
    <div class="ks-contentbox">
      <div class="title"><?php echo $lang['transport_tpl_select_area'];?><a class="ks-ext-close" href="javascript:void(0)">X</a></div>
      <form method="post">
        <ul id="J_CityList">
          <?php require(template('seller/store_transport_area'));?>
        </ul>
        <div class="bottom"> <a href="javascript:void(0);" class="J_Submit ncsc-btn ncsc-btn-green"><?php echo $lang['transport_tpl_ok'];?></a> <a href="javascript:void(0);" class="J_Cancel ncsc-btn"><?php echo $lang['transport_tpl_cancel'];?></a> </div>
      </form>
    </div>
  </div>
  <div id="dialog_batch" class="dialog-batch" style="z-index: 9999; display:none">
    <div class="ks-contentbox">
      <div class="title"><?php echo $lang['transport_tpl_pl_op'];?><a class="ks-ext-close" href="javascript:void(0)">X</a></div>
      <form method="post">
        <div class="batch"><?php echo $lang['transport_note_1'].$lang['nc_colon'];?>
        <input class="w30 mr5 text" type="text" maxlength="4" autocomplete="off" data-field="start" value="1" name="express_start">
        <?php echo $lang['transport_note_2'];?>
        <input class="w60 text" type="text" maxlength="6" autocomplete="off" value="0.00" name="express_postage" data-field="postage"><em class="add-on"> <i class="icon-renminbi"></i> </em><?php echo $lang['transport_note_3'];?>
        <input class="w30 mr5 text" type="text" maxlength="4" autocomplete="off" value="1" data-field="plus" name="express_plus">
        <?php echo $lang['transport_note_4'];?>
        <input class="w60 text" type="text" maxlength="6" autocomplete="off" value="0.00" data-field="postageplus" name="express_postageplus"><em class="add-on"> <i class="icon-renminbi"></i> </em></div>
        <div class="J_DefaultMessage"></div>
        <div class="bottom"> <a href="javascript:void(0);" class="J_SubmitPL ncsc-btn ncsc-btn-green"><?php echo $lang['transport_tpl_ok'];?></a> <a href="javascript:void(0);" class="J_Cancel ncsc-btn"><?php echo $lang['transport_tpl_cancel'];?></a> </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/transport.js"></script>
<script>
$(function(){
	$('.trans-line').append(TransTpl.replace(/TRANSTYPE/g,'kd'));
	$('.tbl-except').append(RuleHead);
	<?php if (is_array($output['extend'])){?>
	<?php foreach ($output['extend'] as $value){?>

		<?php if ($value['is_default']==1){?>

			var cur_tr = $('.tbl-except').prev();
			$(cur_tr).find('input[data-field="start"]').val('<?php echo $value['snum'];?>');
			$(cur_tr).find('input[data-field="postage"]').val('<?php echo $value['sprice'];?>');
			$(cur_tr).find('input[data-field="plus"]').val('<?php echo $value['xnum'];?>');
			$(cur_tr).find('input[data-field="postageplus"]').val('<?php echo $value['xprice'];?>');

		<?php }else{?>

			StartNum +=1;
			cell = RuleCell.replace(/CurNum/g,StartNum);
			cell = cell.replace(/TRANSTYPE/g,'kd');
			$('.tbl-except').find('table').append(cell);
			$('.tbl-attach').find('.J_ToggleBatch').css('display','').html('<?php echo $lang['transport_tpl_pl_op'];?>');

			var cur_tr = $('.tbl-except').find('table').find('tr:last');
			$(cur_tr).find('.area-group>p').html('<?php echo $value['area_name'];?>');
			$(cur_tr).find('input[type="hidden"]').val('<?php echo trim($value['area_id'],',');?>|||<?php echo $value['area_name'];?>');
			$(cur_tr).find('input[data-field="start"]').val('<?php echo $value['snum'];?>');
			$(cur_tr).find('input[data-field="postage"]').val('<?php echo $value['sprice'];?>');
			$(cur_tr).find('input[data-field="plus"]').val('<?php echo $value['xnum'];?>');
			$(cur_tr).find('input[data-field="postageplus"]').val('<?php echo $value['xprice'];?>');

		<?php }?>
	<?php }?>
	<?php }?>
});
</script>