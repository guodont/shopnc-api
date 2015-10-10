<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncm-security-user">
    <h3>您的账户信息</h3>
    <div class="user-avatar"><span><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']);?>"></span></div>
    <div class="user-intro">
      <dl>
        <dt>登录账号：</dt>
        <dd><?php echo $output['member_info']['member_name'];?></dd>
      </dl>
      <dl>
        <dt>绑定邮箱：</dt>
        <dd><?php echo encryptShow($output['member_info']['member_email'],4,4);?></dd>
      </dl>
      <dl>
        <dt>手机号码：</dt>
        <dd><?php echo encryptShow($output['member_info']['member_mobile'],4,4);?></dd>
      </dl>
      <dl>
        <dt>上次登录：</dt>
        <dd><?php echo date('Y年m月d日 H:i:s',$output['member_info']['member_old_login_time']);?>&#12288;|&#12288;IP地址:<?php echo $output['member_info']['member_old_login_ip'];?>&nbsp;<span>（不是您登录的？请立即<a href="index.php?act=member_security&op=auth&type=modify_pwd">“更改密码”</a>）。</span></dd>
      </dl>
    </div>
  </div>
  <div class="ncm-security-container">
    <div class="title">您的安全服务</div>
    <?php if ($output['member_info']['security_level'] <= 1) { ?>
    <div class="current low">当前安全等级：<strong>低</strong><span>(建议您开启全部安全设置，以保障账户及资金安全)</span></div>
    <?php } else if ($output['member_info']['security_level'] == 2) { ?>
    <div class="current normal">当前安全等级：<strong>中</strong><span>(建议您开启全部安全设置，以保障账户及资金安全)</span></div>
    <?php } else { ?>
    <div class="current high">当前安全等级：<strong>高</strong><span>(您目前账户运行很安全)</span></div>
    <?php } ?>

    <dl id="password" class="yes">
      <dt><span class="icon"><i></i></span><span class="item">
        <h4>登录密码</h4>
        <h6>已设置</h6>
        </span></dt>
      <dd><span class="explain">安全性高的密码可以使账号更安全。建议您定期更换密码，且设置一个包含数字和字母，并长度超过6位以上的密码，为保证您的账户安全，只有在您绑定邮箱或手机后才可以修改密码。</span><span class="handle"><a href="index.php?act=member_security&op=auth&type=modify_pwd" class="ncm-btn  ncm-btn-orange">修改密码</a></span></dd>
    </dl>
    <dl id="email" class="<?php echo $output['member_info']['member_email_bind'] == 1 ? 'yes' : 'no';?>">
      <dt><span class="icon"><i></i></span><span class="item">
        <h4>邮箱绑定</h4>
        <h6><?php echo $output['member_info']['member_email_bind'] == 1 ? '已绑定' : '未绑定';?></h6>
        </span></dt>
      <dd><span class="explain">进行邮箱验证后，可用于接收敏感操作的身份验证信息，以及订阅更优惠商品的促销邮件。</span><span class="handle"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_security&op=auth&type=modify_email" class="ncm-btn ncm-btn-acidblue bd">绑定邮箱</a><a href="index.php?act=member_security&op=auth&type=modify_email" class="ncm-btn ncm-btn-orange jc">修改邮箱</a></span></dd>
    </dl>
    <dl id="mobile" class="<?php echo $output['member_info']['member_mobile_bind'] == 1 ? 'yes' : 'no';?>">
      <dt><span class="icon"><i></i></span><span class="item">
        <h4>手机绑定</h4>
        <h6><?php echo $output['member_info']['member_mobile_bind'] == 1 ? '已绑定' : '未绑定';?></h6>
        </span></dt>
      <dd><span class="explain">进行手机验证后，可用于接收敏感操作的身份验证信息，以及进行积分消费的验证确认，非常有助于保护您的账号和账户财产安全。</span><span class="handle"><a href="index.php?act=member_security&op=auth&type=modify_mobile" class="ncm-btn ncm-btn-acidblue bd">绑定手机</a><a href="index.php?act=member_security&op=auth&type=modify_mobile" class="ncm-btn ncm-btn-orange jc">修改手机</a></span></dd>
    </dl>
    <dl id="paypwd" class="<?php echo $output['member_info']['member_paypwd'] != ''  ? 'yes' : 'no';?>">
      <dt><span class="icon"><i></i></span><span class="item">
        <h4>支付密码</h4>
        <h6><?php echo $output['member_info']['member_paypwd'] != '' ? '已设置' : '未设置';?></h6>
        </span></dt>
      <dd><span class="explain">设置支付密码后，在使用账户中余额时，需输入支付密码。</span><span class="handle"><a href="index.php?act=member_security&op=auth&type=modify_paypwd" class="ncm-btn ncm-btn-acidblue bd">设置密码</a><a href="index.php?act=member_security&op=auth&type=modify_paypwd" class="ncm-btn ncm-btn-orange jc">修改密码</a></span></dd>
    </dl>
  </div>
</div>
