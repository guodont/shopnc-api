<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncp-member-info">
  <div class="avatar"><img src="<?php if ($output['member_info']['member_avatar']!='') { echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR.DS.$output['member_info']['member_avatar']; } else { echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON. DS.C('default_user_portrait'); } ?>"/>
    <div class="frame"></div>
  </div>
  <dl>
    <dt>Hi, <?php echo $_SESSION['member_name'];?></dt>
    <dd>当前等级：<strong><?php echo $output['member_info']['level_name'];?></strong></dd>
    <dd>当前经验值：<strong><?php echo $output['member_info']['member_exppoints'];?></strong></dd>
  </dl>
</div>
<div class="ncp-member-grade">
  <?php if ($output['member_info']['level'] !== -1){ ?>
  <div class="progress-bar"><em title="<?php echo $output['member_info']['downgrade_name'];?>需经验值<?php echo $output['member_info']['downgrade_exppoints'];?>"><?php echo $output['member_info']['downgrade_name'];?></em><span title="<?php echo $output['member_info']['exppoints_rate'];?>%"><i style="width:<?php echo $output['member_info']['exppoints_rate'];?>%;"></i></span><em title="<?php echo $output['member_info']['upgrade_name'];?>需经验值<?php echo $output['member_info']['upgrade_exppoints'];?>"><?php echo $output['member_info']['upgrade_name'];?></em></div>
  <div class="progress">
    <?php if ($output['member_info']['less_exppoints'] > 0){?>
    还差<em><?php echo $output['member_info']['less_exppoints'];?></em>经验值即可升级成为<?php echo $output['member_info']['upgrade_name'];?>等级会员
    <?php } else {?>
    已达到最高会员级别，继续加油保持这份荣誉哦！
    <?php }?>
  </div>
  <?php } else { ?>
  暂无等级
  <?php } ?>
  <div class="links">
    <div class="links"> <a href="<?php echo urlShop('pointgrade','index');?>" target="_blank">我的成长进度</a> <a href="<?php echo urlShop('pointgrade','exppointlog');?>" target="_blank">经验值明细</a> </div>
  </div>
</div>
<div class="ncp-member-point">
  <dl style="border-left: none 0;">
    <a href="index.php?act=member_points" target="_blank">
    <dt><strong><?php echo $output['member_info']['member_points'];?></strong>分</dt>
    <dd>我的积分</dd>
    </a>
  </dl>
  <?php if (C('voucher_allow')==1){ ?>
  <dl>
    <a href="index.php?act=member_voucher&op=index" target="_blank">
    <dt><strong><?php echo $output['vouchercount']; ?></strong>张</dt>
    <dd>可用代金券</dd>
    </a>
  </dl>
  <?php } ?>
  <?php if (C('pointprod_isuse')==1){?>
  <dl>
    <a href="index.php?act=member_pointorder&op=orderlist" target="_blank">
    <dt><strong><?php echo $output['pointordercount'];?></strong>个</dt>
    <dd>已兑换礼品</dd>
    </a>
  </dl>
  <?php }?>
</div>
<?php if (C('pointprod_isuse')==1){?>
<div class="ncp-memeber-pointcart"> <a href="index.php?act=pointcart" class="btn">礼品兑换购物车<?php if ($output['pointcart_count'] > 0){?><em><?php echo $output['pointcart_count']; ?></em><?php } ?></a></div>
<?php }?>
