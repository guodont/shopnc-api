<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="breadcrumb"><span class="icon-home"></span><span><a href="<?php echo SHOP_SITE_URL;?>">首页</a></span> <span class="arrow">></span> <span>商家帮助指南</span> </div>
<div class="main">
  <div class="sidebar">
    <div class="title">
      <h3>商家帮助指南</h3>
    </div>
    <?php require template('home/store_help_left');?>
  </div>
  <div class="right-layout">
    <div class="article-con">
      <h1><?php echo $output['help']['help_title'];?></h1>
      <h2>更新时间 <?php echo date('Y-m-d',$output['help']['update_time']);?></h2>
      <div class="default">
        <p><?php echo $output['help']['help_info']?></p>
      </div>
    </div>
  </div>
</div>