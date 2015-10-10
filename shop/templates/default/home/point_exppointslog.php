<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_point.css" rel="stylesheet" type="text/css">

<div class="ncp-container">
  <div class="ncp-base-layout">
    <div class="ncp-member-left">
      <?php include_once BASE_TPL_PATH.'/home/pointshop.minfo.php'; ?>
    </div>
    <div class="ncp-member-right">
      <table class="ncp-table-style">
        <thead>
          <tr>
            <th class="w200">添加时间</th>
            <th class="w100">获得经验</th>
            <th class="w200">操作阶段</th>
            <th class="tl">描述</th>
          </tr>
        </thead>
        <tbody>
          <?php  if (count($output['list_log'])>0) { ?>
          <?php foreach($output['list_log'] as $val) { ?>
          <tr class="">
            <td class=""><?php echo @date('Y-m-d',$val['exp_addtime']);?></td>
            <td class=""><?php echo ($val['exp_points'] > 0 ? '' : '-').$val['exp_points']; ?></td>
            <td><?php 
        	              	switch ($val['exp_stage']){
        	              		case 'login':
        	              			echo '会员登录';
        	              			break;
        	              		case 'comments':
        	              			echo '商品评论';
        	              			break;
        	              		case 'order':
        	              			echo '订单消费';
        	              			break;
        	              	}
        	              ?></td>
            <td class="tl"><?php echo $val['exp_desc'];?></td>
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
  </div>
</div>
