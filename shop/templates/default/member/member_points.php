<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="alert alert-block">
  <h4>积分获得规则</h4>
<ul><li>成功注册会员：增加<em><?php echo C('points_reg');?></em>积分；会员每天登录：增加<em><?php echo C('points_login');?></em>积分；评价完成订单：增加<em><?php echo C('points_comments');?></em>积分。</li>
<?php if (C('points_orderrate')) {?><li>购物并付款成功后将获得订单总价<?php printf('%d', 1/C('points_orderrate') * 100);?>%<?php if (C('points_ordermax')) {?>（最高限额不超过<?php echo C('points_ordermax');?>）<?php }?>积分。</li><?php }?>
<li>如订单发生退款、退货等问题时，积分将不予退还。</li></ul>
  </div>
  <form method="get" action="index.php">
    <table class="ncm-search-table">
      <input type="hidden" name="act" value="member_points" />
      <tr><td class="w10">&nbsp;</td>
        <td><strong><?php echo $lang['points_log_pointscount']; ?></strong><strong style="color: #F00;"><?php echo $output['member_info']['member_points']; ?></strong></td>        
        <th><?php echo $lang['points_addtime'] ?></th>
        <td class="w240"><input type="text" id="stime" name="stime" class="text w70" value="<?php echo $_GET['stime'];?>"><label class="add-on"><i class="icon-calendar"></i></label>&nbsp;&#8211;&nbsp;<input type="text" id="etime" name="etime" class="text w70" value="<?php echo $_GET['etime'];?>"><label class="add-on"><i class="icon-calendar"></i></label></td>
        <th><?php echo $lang['points_stage']; ?></th>
        <td class="w100"><select name="stage">
            <option value="" <?php if (!$_GET['stage']){echo 'selected=selected';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="regist" <?php if ($_GET['stage'] == 'regist'){echo 'selected=selected';}?>><?php echo $lang['points_stage_regist']; ?></option>
            <option value="login" <?php if ($_GET['stage'] == 'login'){echo 'selected=selected';}?>><?php echo $lang['points_stage_login']; ?></option>
            <option value="comments" <?php if ($_GET['stage'] == 'comments'){echo 'selected=selected';}?>><?php echo $lang['points_stage_comments']; ?></option>
            <option value="order" <?php if ($_GET['stage'] == 'order'){echo 'selected=selected';}?>><?php echo $lang['points_stage_order']; ?></option>
            <option value="system" <?php if ($_GET['stage'] == 'system'){echo 'selected=selected';}?>><?php echo $lang['points_stage_system']; ?></option>
            <option value="pointorder" <?php if ($_GET['stage'] == 'pointorder'){echo 'selected=selected';}?>><?php echo $lang['points_stage_pointorder']; ?></option>
            <option value="app" <?php if ($_GET['stage'] == 'app'){echo 'selected=selected';}?>><?php echo $lang['points_stage_app']; ?></option>
          </select></td>
        <th><?php echo $lang['points_pointsdesc']; ?></th>
        <td class="w160"><input type="text" class="text w150" id="description" name="description" value="<?php echo $_GET['description'];?>"></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w200"><?php echo $lang['points_addtime']; ?></th>
        <th class="w150"><?php echo $lang['points_pointsnum']; ?></th>
        <th class="w300"><?php echo $lang['points_stage']; ?></th>
        <th class="tl"><?php echo $lang['points_pointsdesc']; ?></th>
      </tr>
    </thead>
    <tbody>
      <?php  if (count($output['list_log'])>0) { ?>
      <?php foreach($output['list_log'] as $val) { ?>
      <tr class="bd-line">
        <td class="goods-time"><?php echo @date('Y-m-d',$val['pl_addtime']);?></td>
        <td class="goods-price"><?php echo ($val['pl_points'] > 0 ? '+' : '').$val['pl_points']; ?></td>
        <td><?php 
	              	switch ($val['pl_stage']){
	              		case 'regist':
	              			echo $lang['points_stage_regist'];
	              			break;
	              		case 'login':
	              			echo $lang['points_stage_login'];
	              			break;
	              		case 'comments':
	              			echo $lang['points_stage_comments'];
	              			break;
	              		case 'order':
	              			echo $lang['points_stage_order'];
	              			break;
	              		case 'system':
	              			echo $lang['points_stage_system'];
	              			break;
	              		case 'pointorder':
	              			echo $lang['points_stage_pointorder'];
	              			break;
	              		case 'app':
	              			echo $lang['points_stage_app'];
	              			break;
	              	}
	              ?></td>
        <td class="tl"><?php echo $val['pl_desc'];?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list_log'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script language="javascript">
$(function(){
	$('#stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#etime').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>