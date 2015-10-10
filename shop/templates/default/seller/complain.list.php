<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<form method="get" action="index.php">
  <table class="search-form">
    <input type="hidden" name='act' value='store_complain' />
    <tr>
      <td>&nbsp;</td>
      <th><?php echo $lang['complain_datetime'];?></th>
      <td class="w240"><input name="add_time_from" id="add_time_from" type="text" class="text w70" value="<?php echo $_GET['add_time_from']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label> &#8211; <input name="add_time_to" id="add_time_to" type="text" class="text w70" value="<?php echo $_GET['add_time_to']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label></td>
      <th class="w60">处理状态</th>
      <td class="w80"><select name="state">
          <option value="" <?php if($_GET['state'] == ''){?>selected<?php }?>>全部</option>
          <option value="1" <?php if($_GET['state'] == '1'){?>selected<?php }?>><?php echo $lang['complain_state_inprogress']; ?></option>
          <option value="2" <?php if($_GET['state'] == '2'){?>selected<?php }?>><?php echo $lang['complain_state_finish']; ?></option>
        </select></td>
      <th class="w120"><select name="type">
          <option value="accuser_name" <?php if($_GET['type'] == 'accuser_name'){?>selected<?php }?>><?php echo $lang['complain_accuser']; ?></option>
          <option value="complain_subject" <?php if($_GET['type'] == 'complain_subject'){?>selected<?php }?>><?php echo $lang['complain_subject_content']; ?></option>
          <option value="complain_id" <?php if($_GET['type'] == 'complain_id'){?>selected<?php }?>>投诉号</option>
        </select></th>
      <td class="w160"><input type="text" class="text" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w10"></th>
      <th class="w80 tl">投诉号</th>
      <th class="tl" colspan="2">投诉商品</th>
      <th class="tl"><?php echo $lang['complain_subject_content'];?></th>
      <th class="w160"><?php echo $lang['complain_datetime'];?></th>
      <th class="w80"><?php echo $lang['complain_state'];?></th>
      <th class="w100"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($output['list'])>0) { ?>
    <?php foreach($output['list'] as $val) {
        $goods = $output['goods_list'][$val['order_goods_id']]; ?>
    <tr class="bd-line">
      <td></td>
      <td class="tl"><?php echo $val['complain_id'];?></td>
        <td class="w50"><div class="pic-thumb"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=> $goods['goods_id'])); ?>">
            <img src="<?php echo thumb($goods,60); ?>" onMouseOver="toolTip('<img src=<?php echo thumb($goods,240); ?>>')" onMouseOut="toolTip()" /></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=> $goods['goods_id'])); ?>"><?php echo $goods['goods_name']; ?></a></dt>
            <dd><?php echo $lang['complain_accuser'];?>：<?php echo $val['accuser_name'];?></dd>
          </dl></td>
      <td class="tl"><?php echo $val['complain_subject_content'];?></td>
      <td class="goods-time"><?php echo date("Y-m-d H:i:s",$val['complain_datetime']);?></td>
      <td><?php
				if(intval($val['complain_state'])===10) echo $lang['complain_state_new'];
				if(intval($val['complain_state'])===20) echo $lang['complain_state_appeal'];
				if(intval($val['complain_state'])===30) echo $lang['complain_state_talk'];
				if(intval($val['complain_state'])===40) echo $lang['complain_state_handle'];
				if(intval($val['complain_state'])===99) echo $lang['complain_state_finish'];
				?></td>
      <td class="nscs-table-handle"><span><a href="index.php?act=store_complain&op=complain_show&complain_id=<?php echo $val['complain_id'];?>" class="btn-orange"><i class="icon-eye-open"></i>
        <p><?php echo $lang['complain_text_detail'];?></p>
        </a></span>
        </td>
    </tr>
    <?php }?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php if (count($output['list'])>0) { ?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script>
	$(function(){
	    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
	    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
