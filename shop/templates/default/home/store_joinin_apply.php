<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="breadcrumb"><span class="icon-home"></span><span><a href="<?php echo SHOP_SITE_URL;?>">首页</a></span> <span class="arrow">></span> <span>商家入驻申请</span> </div>
<div class="main">
  <div class="sidebar">
    <div class="title">
      <h3>商家入驻申请</h3>
    </div>
    <div class="content">
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <?php foreach($output['list'] as $key => $val){ ?>
      <dl show_id="<?php echo $val['type_id'];?>">
        <dt onclick="show_list('<?php echo $val['type_id'];?>');" style="cursor: pointer;"> <i class="hide"></i><?php echo $val['type_name'];?></dt>
        <dd style="display:none;">
          <ul>
            <?php if(!empty($val['help_list']) && is_array($val['help_list'])){ ?>
            <?php foreach($val['help_list'] as $k => $v){ ?>
            <li> <i></i>
              <?php if(empty($v['help_url'])){ ?>
              <a href="<?php echo urlShop('show_help', 'index', array('t_id' => $v['type_id'],'help_id' => $v['help_id']));?>" target="_blank"><?php echo $v['help_title'];?></a>
              <?php }else { ?>
              <a href="<?php echo $v['help_url'];?>" target="_blank"><?php echo $v['help_title'];?></a>
              <?php } ?>
            </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </dd>
      </dl>
      <?php } ?>
      <?php } ?>
      <dl>
        <dt class="<?php echo $output['sub_step'] == 'step0' ? 'current' : '';?>"> <i class="hide"></i>签订入驻协议</dt>
      </dl>
      <dl show_id="0">
        <dt onclick="show_list('0');" style="cursor: pointer;"> <i class="show"></i>提交申请</dt>
        <dd>
          <ul>
            <li class="<?php echo $output['step'] == '1' ? 'current' : '';?>"><i></i>公司资质信息</li>
            <li class="<?php echo $output['step'] == '2' ? 'current' : '';?>"><i></i>财务资质信息</li>
            <li class="<?php echo $output['step'] == '3' ? 'current' : '';?>"><i></i>店铺经营信息</li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt class="<?php echo $output['step'] == '4' ? 'current' : '';?>"> <i class="hide"></i>合同签订及缴费</dt>
      </dl>
      <dl>
        <dt> <i class="hide"></i>店铺开通</dt>
      </dl>
    </div>
    <div class="title">
      <h3>平台联系方式</h3>
    </div>
    <div class="content">
      <ul>
        <?php
			if(is_array($output['phone_array']) && !empty($output['phone_array'])) {
				foreach($output['phone_array'] as $key => $val) {
			?>
        <li><?php echo '电话'.($key+1).$lang['nc_colon'];?><?php echo $val;?></li>
        <?php
				}
			}
			 ?>
        <li><?php echo '邮箱'.$lang['nc_colon'];?><?php echo C('site_email');?></li>
      </ul>
    </div>
  </div>
  <div class="right-layout">
    <div class="joinin-step">
      <ul>
        <li class="step1 <?php echo $output['step'] >= 0 ? 'current' : '';?>"><span>签订入驻协议</span></li>
        <li class="<?php echo $output['step'] >= 1 ? 'current' : '';?>"><span>公司资质信息</span></li>
        <li class="<?php echo $output['step'] >= 2 ? 'current' : '';?>"><span>财务资质信息</span></li>
        <li class="<?php echo $output['step'] >= 3 ? 'current' : '';?>"><span>店铺经营信息</span></li>
        <li class="<?php echo $output['step'] >= 4 ? 'current' : '';?>"><span>合同签订及缴费</span></li>
        <li class="step6"><span>店铺开通</span></li>
      </ul>
    </div>
    <div class="joinin-concrete">
      <?php require('store_joinin_apply.'.$output['sub_step'].'.php'); ?>
    </div>
  </div>
</div>
