<?php defined('InShopNC') or exit('Access Invalid!');?>

  <div id="account" class="double">
    <div class="outline">
      <div class="user-account">
        <ul>
          <li id="pre-deposit"><a href="index.php?act=predeposit&op=pd_log_list" title="查看我的余额">
            <h5><?php echo $lang['nc_predepositnum'];?></h5>
            <span class="icon"></span> <span class="value">￥<em><?php echo $output['member_info']['available_predeposit'];?></em></span></a> </li>
          <li id="voucher"><a href="index.php?act=member_voucher&op=index" title="查看我的代金券">
            <h5>代金券</h5>
            <span class="icon"></span> <span class="value"><em><?php echo $output['home_member_info']['voucher_count']?$output['home_member_info']['voucher_count']:0;?></em>张</span></a> </li>
          <li id="points"><a href="index.php?act=member_points&op=index" title="查看我的积分">
            <h5><?php echo $lang['nc_pointsnum'];?></h5>
            <span class="icon"></span> <span class="value"><em><?php echo $output['member_info']['member_points'];?></em>分</span></a> </li>
        </ul>
      </div>
    </div>
  </div>
  <div id="security" class="normal">
    <div class="outline">
      <div class="SAM">
        <h5>账户安全</h5>
        <?php if ($output['home_member_info']['security_level'] <= 1) { ?>
        <div id="low" class="SAM-info"><strong>低</strong><span><em></em></span>
        <?php } elseif ($output['home_member_info']['security_level'] == 2) {?>
        <div id="normal" class="SAM-info"><strong>中</strong><span><em></em></span>
        <?php }else {?>
        <div id="high" class="SAM-info"><strong>高</strong><span><em></em></span>
        <?php } ?>
        <?php if ($output['home_member_info']['security_level'] < 3) {?>
        <a href="<?php echo urlShop('member_security','index');?>" title="安全设置">提升></a>
        <?php } ?>
        </div>
        <div class="SAM-handle"><span><i class="mobile"></i>手机：
        <?php if ($output['home_member_info']['member_mobile_bind'] == 1) {?>
        <em>已绑定</em>
        <?php  } else {?>
        <a href="<?php echo urlShop('member_security','auth',array('type'=>'modify_mobile'));?>" title="绑定手机">未绑定</a>
        <?php }?></span>
        <span><i class="mail"></i>邮箱：
        <?php if ($output['home_member_info']['member_email_bind'] == 1) {?>
        <em>已绑定</em>
        <?php  } else {?>
        <a href="<?php echo urlShop('member_security','auth',array('type'=>'modify_email'));?>" title="绑定邮箱">未绑定</a>
        <?php }?></span>
        </div>
      </div>
    </div>
  </div>