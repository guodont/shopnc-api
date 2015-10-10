<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<meta name="keywords" content="<?php echo $output['setting_config']['site_keywords']; ?>" />
<meta name="description" content="<?php echo $output['setting_config']['site_description']; ?>" />
<link href="<?php echo CIRCLE_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<!--[if IE 6]><style type="text/css">body { _behavior: url(<?php echo CIRCLE_TEMPLATES_URL;?>/css/csshover.htc);}</style><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/IE6_MAXMIX.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/IE6_PNG.js"></script>
<script>
DD_belatedPNG.fix('.pngFix');
</script>
<script>
// <![CDATA[
if((window.navigator.appName.toUpperCase().indexOf("MICROSOFT")>=0)&&(document.execCommand))
    try{
        document.execCommand("BackgroundImageCache", false, true);
   }
catch(e){}
// ]]>
</script>
<![endif]-->
<style type="text/css">
body {
	background: #FFF none no-repeat 0 0 scroll !important;
}
.msg {
	font-family: "Microsoft YaHei";
	font-size: 20px;
	color: #555;
	font-weight: 600;
	line-height: 48px;
	text-align: center;
	margin: 100px;
}
</style>
<script>COOKIE_PRE = '<?php echo COOKIE_PRE;?>';_CHARSET = '<?php echo strtolower(CHARSET);?>';SITEURL = '<?php echo SHOP_SITE_URL;?>';</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script>
<script type="text/javascript">
$(function(){
	$("#details").children('ul').children('li').click(function(){
		$(this).parent().children('li').removeClass("current");
		$(this).addClass("current");
		$('#search_act').attr("value",$(this).attr("act"));
	});
	var search_act = $("#details").find("li[class='current']").attr("act");
	$('#search_act').attr("value",search_act);
	$("#keyword").blur();
});
</script>
</head>
<body>
<?php require_once circle_template('layout/top');?>
<div class="content">
      <?php if($output['msg_type'] == 'error'){ ?>
      <p class="msg defeated">
        <?php }else { ?>
      <p class="msg success">
        <?php } ?>
        <span>
        <?php require_once($tpl_file);?>
        </span> </p>
</div>
<script type="text/javascript">
<?php if (!empty($output['url'])){
?>
	window.setTimeout("javascript:location.href='<?php echo $output['url'];?>'", <?php echo $time;?>);
<?php
}else{
?>
	window.setTimeout("javascript:history.back()", <?php echo $time;?>);
<?php
}?>
</script>
<?php
require_once circle_template('layout/footer');
?>
</body>
</html>
