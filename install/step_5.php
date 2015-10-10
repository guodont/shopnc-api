<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $html_title;?></title>
<link href="css/install.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../data/resource/js/jquery.js"></script>
<link href="../data/resource/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../data/resource/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="../data/resource/js/jquery.mousewheel.js"></script>
</head>

<body>
<?php echo $html_header;?>
<div class="main">
  <div class="final-succeed"> <span class="ico"></span>
    <h2>程序已成功安装</h2>
    <h5>选择您要进入的页面</h5>
  </div>
  <div class="final-site-nav">
    <div class="arrow"></div>
    <ul>
      <li class="shop">
        <div class="ico"></div>
        <h5><a href="<?php echo substr($auto_site_url,0,-8);?>/shop" target="_blank">商城</a></h5>
        <h6>线上购物、开店、交易...</h6>
      </li>
      <li class="cms">
        <div class="ico"></div>
        <h5><a href="<?php echo substr($auto_site_url,0,-8);?>/cms" target="_blank">资讯</a></h5>
        <h6>CMS资讯、画报、专题...</h6>
      </li>
      <li class="circle">
        <div class="ico"></div>
        <h5><a href="<?php echo substr($auto_site_url,0,-8);?>/circle" target="_blank">圈子</a></h5>
        <h6>主题、圈友、商品...</h6>
      </li>
      <li class="microshop">
        <div class="ico"></div>
        <h5><a href="<?php echo substr($auto_site_url,0,-8);?>/microshop" target="_blank">微商城</a></h5>
        <h6>随心看、个人秀、店铺街</h6>
      </li>
      <li class="admin">
        <div class="ico"></div>
        <h5><a href="<?php echo substr($auto_site_url,0,-8);?>/admin" target="_blank">系统管理</a></h5>
        <h6>电商系统后台</h6>
      </li>
    </ul>
  </div>
  <div class="final-intro">
    <p><strong>系统管理默认地址:&nbsp;</strong><a href="<?php echo substr($auto_site_url,0,-8);?>/admin" target="_blank"><?php echo substr($auto_site_url,0,-8);?>/admin</a></p>
    <p><strong>网站首页默认地址:&nbsp;</strong><a href="<?php echo substr($auto_site_url,0,-8);?>" target="_blank"><?php echo substr($auto_site_url,0,-8);?></a></p>
     <p><strong>商家中心默认地址:&nbsp;</strong><a href="<?php echo substr($auto_site_url,0,-8);?>/shop/index.php?act=seller_login&op=show_login" target="_blank"><?php echo substr($auto_site_url,0,-8);?>/shop/index.php?act=seller_login&op=show_login</a></p>
        </p>
  </div>
</div>
<?php echo $html_footer;?>
<script type="text/javascript">
$(document).ready(function(){
	//自定义滚定条
	$('#text-box').perfectScrollbar();
});
</script>
</body>
</html>
