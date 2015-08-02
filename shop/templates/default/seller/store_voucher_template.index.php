<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
    <?php include template('layout/submenu');?>

<?php if ($output['isOwnShop']) { ?>
    <a class="ncsc-btn ncsc-btn-green" href="<?php echo urlShop('store_voucher', 'templateadd');?>"><i class="icon-plus-sign"></i><?php echo $lang['voucher_templateadd']; ?></a>

<?php } else { ?>
    <?php if(!empty($output['current_quota'])) { ?>
    <a class="ncsc-btn ncsc-btn-green" style="right:100px" href="<?php echo urlShop('store_voucher', 'templateadd');?>"><i class="icon-plus-sign"></i><?php echo $lang['voucher_templateadd']; ?></a>
    <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_voucher', 'quotaadd');?>" title=""><i class="icon-money"></i>套餐续费</a>
    <?php } else { ?>
    <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_voucher', 'quotaadd');?>" title=""><i class="icon-money"></i>购买套餐</a>
    <?php } ?>

<?php } ?>
</div>

<?php if ($output['isOwnShop']) { ?>
  <div class="alert alert-block mt10 mb10">
      <ul>
          <li><?php echo $lang['voucher_template_list_tip1'];?></li>
          <li><?php echo $lang['voucher_template_list_tip2'];?></li>
    </ul>
  </div>
<?php } else { ?>
  <div class="alert alert-block mt10 mb10">
      <?php if(!empty($output['current_quota'])) { ?>
      <strong>套餐过期时间<?php echo $lang['nc_colon'];?></strong><strong style="color:#F00;"><?php echo date('Y-m-d H:i:s', $output['current_quota']['quota_endtime']);?></strong>
      <?php } else { ?>
      <strong>当前没有可用套餐，请先购买套餐</strong>
      <?php } ?>
      <ul>
          <li><?php echo $lang['voucher_template_list_tip1'];?></li>
          <li><?php echo $lang['voucher_template_list_tip2'];?></li>
          <li>3、<strong style="color: red">相关费用会在店铺的账期结算中扣除</strong>。</li>
    </ul>
  </div>
<?php } ?>

  <form method="get">
    <table class="search-form">
      <input type="hidden" id='act' name='act' value='store_voucher' />
      <input type="hidden" id='op' name='op' value='templatelist' />
      <tr>
        <td>&nbsp;</td>

        <th><?php echo $lang['voucher_template_enddate'];?></th>
        <td class="w240">
        	<input type="text" class="text w70"  readonly="readonly" value="<?php echo $_GET['txt_startdate'];?>" id="txt_startdate" name="txt_startdate"/><label class="add-on">
<i class="icon-calendar"></i>
</label>
        	&#8211;
        	<input type="text" class="text w70"  readonly="readonly" value="<?php echo $_GET['txt_enddate'];?>" id="txt_enddate" name="txt_enddate"/><label class="add-on">
<i class="icon-calendar"></i>
</label>
        </td>
        <th><?php echo $lang['nc_status'];?></th>
        <td class="w120"><select class="w80" name="select_state">
            <option value="0" <?php if (!$_GET['select_state'] == '0'){ echo 'selected=true';}?>><?php echo $lang['nc_please_choose'];?></option>
            <?php if (!empty($output['templatestate_arr'])){?>
            <?php foreach ($output['templatestate_arr'] as $k=>$v){?>
            <option value="<?php echo $v[0]; ?>" <?php if ($_GET['select_state'] == $v[0]){echo 'selected=true';}?>><?php echo $v[1];?></option>
            <?php }?>
            <?php }?>
          </select></td><th class="w60"><?php echo $lang['voucher_template_title'];?></th>
        <td class="w160"><input type="text" class="text w150"  value="" id="txt_keyword" name="txt_keyword" /></td>
        <td class="tc w70"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </table>
  </form>
  <table class="ncsc-default-table">
    <thead>
      <tr>

        <th class="w50"></th>
        <th class="tl"><?php echo $lang['voucher_template_title']; ?></th>
        <th class="w100"><?php echo $lang['voucher_template_orderpricelimit'];?></th>
        <th class="w60"><?php echo $lang['voucher_template_price'];?></th>
        <th class="w200"><?php echo $lang['voucher_template_enddate'];?></th>
        <th class="w60"><?php echo $lang['nc_status'];?></th>
        <th class="w100"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
        <td><div class="pic-thumb"><img src="<?php echo $val['voucher_t_customimg'];?>"/></div></td>
        <td class="tl"><?php echo $val['voucher_t_title'];?></td>
        <td>￥<?php echo $val['voucher_t_limit'];?></td>
        <td class="goods-price">￥<?php echo $val['voucher_t_price'];?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$val['voucher_t_start_date']).'~'.date("Y-m-d",$val['voucher_t_end_date']);?></td>
        <td><?php if($val['voucher_t_state']== $output['templatestate_arr']['usable'][0]) echo $output['templatestate_arr']['usable'][1];
                  if($val['voucher_t_state']== $output['templatestate_arr']['disabled'][0]) echo $output['templatestate_arr']['disabled'][1]; ?></td>
        <td class="nscs-table-handle">
        	<?php if($val['voucher_t_state']==$output['templatestate_arr']['usable'][0] && !$val['voucher_t_giveout']) {//代金券模板有效并且没有领取时可以编辑?>
        		<span>
        		  <a class="btn-blue" href="index.php?act=store_voucher&op=templateedit&tid=<?php echo $val['voucher_t_id'];?>">
        		      <i class="icon-edit"></i><p>编辑</p>
        		  </a>
        	   </span>
        	<?php }else {//代金券模板失效或者有领取时可以查看?>
        		<span>
        		  <a class="btn-blue" href="index.php?act=store_voucher&op=templateinfo&tid=<?php echo $val['voucher_t_id'];?>"><i class="icon-th-list"></i>
        		      <p>详细</p>
        		  </a>
        	   </span>
        	<?php }?>
        	<?php if (!$val['voucher_t_giveout']){//该模板没有发放过代金券时可以删除?>
        	<span>
        	   <a class="btn-red" href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>','index.php?act=store_voucher&op=templatedel&tid=<?php echo $val['voucher_t_id'];?>');">
        	       <i class="icon-trash"></i><p>删除</p>
        	   </a>
        	</span>
        	<?php }?>
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
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#txt_startdate').datepicker();
	$('#txt_enddate').datepicker();
});
</script>
