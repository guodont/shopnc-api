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
                  <!--<dl show_id="99">
        <dt onclick="show_list('99');" style="cursor: pointer;"> <i class="hide"></i>入驻流程</dt>
        <dd style="display:none;">
          <ul>
                                    <li> <i></i>
                            <a href="index.php?act=show_help&op=index&t_id=99&help_id=101" target="_blank">签署入驻协议</a>
                          </li>
                        <li> <i></i>
                            <a href="index.php?act=show_help&op=index&t_id=99&help_id=102" target="_blank">商家信息提交</a>
                          </li>
                        <li> <i></i>
                            <a href="index.php?act=show_help&op=index&t_id=99&help_id=103" target="_blank">平台审核资质</a>
                          </li>
                        <li> <i></i>
                            <a href="index.php?act=show_help&op=index&t_id=99&help_id=104" target="_blank">商家缴纳费用</a>
                          </li>
                        <li> <i></i>
                            <a href="index.php?act=show_help&op=index&t_id=99&help_id=105" target="_blank">店铺开通</a>
                          </li>
                                  </ul>
        </dd>
      </dl>-->
                  <dl>
        <dt class="<?php echo $output['sub_step'] == 'step0' ? 'current' : '';?>"> <i class="hide"></i>签订入驻协议</dt>
      </dl>
      <dl show_id="0">
        <dt onclick="show_list('0');" style="cursor: pointer;"> <i class="show"></i>提交申请</dt>
        <dd>
          <ul>
            <li class="<?php echo $output['sub_step'] == 'step1' ? 'current' : '';?>"><i></i>店铺资质信息</li>
            <li class="<?php echo $output['sub_step'] == 'step2' ? 'current' : '';?>"><i></i>财务资质信息</li>
            <li class="<?php echo $output['sub_step'] == 'step3' ? 'current' : '';?>"><i></i>店铺经营信息</li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt class="<?php echo $output['sub_step'] == 'pay' ? 'current' : '';?>"> <i class="hide"></i>合同签订及缴费</dt>
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
                <li>电话：<?php echo C('site_phone');?></li>
                <li>邮箱：<?php echo C('site_email');?></li>
      </ul> 
    </div>
  </div>
  <div class="right-layout">
    <div class="joinin-step">
      <ul>
        <li class="step1 <?php echo $output['sub_step'] >= 'step0' ? 'current' : '';?><?php echo $output['sub_step'] == 'pay' ? 'current' : '';?>"><span>签订入驻协议</span></li>
        <li class="<?php echo $output['sub_step'] >= 'step1' ? 'current' : '';?><?php echo $output['sub_step'] == 'pay' ? 'current' : '';?>"><span>店铺资质信息</span></li>
        <li class="<?php echo $output['sub_step'] >= 'step2' ? 'current' : '';?><?php echo $output['sub_step'] == 'pay' ? 'current' : '';?>"><span>财务资质信息</span></li>
        <li class="<?php echo $output['sub_step'] >= 'step3' ? 'current' : '';?><?php echo $output['sub_step'] == 'pay' ? 'current' : '';?>"><span>店铺经营信息</span></li>
        <li class="<?php echo $output['sub_step'] >= 'step4' ? 'current' : '';?><?php echo $output['sub_step'] == 'pay' ? 'current' : '';?>"><span>合同签订及缴费</span></li>
        <li class="step6"><span>店铺开通</span></li>
      </ul>
    </div>
    <div class="joinin-concrete">
      
<!-- 协议 -->
<?php require('store_joinin_c2c_apply.'.$output['sub_step'].'.php'); ?>
   </div>
  </div>
</div>