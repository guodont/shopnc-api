<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>

<link href="<?php echo ADMIN_SITE_URL;?>/resource/font/css/font-awesome.min.css" rel="stylesheet">

<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/login.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.tscookie.js"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>

<script src="<?php echo ADMIN_SITE_URL;?>/resource/js/jquery.supersized.min.js" ></script>

<script src="<?php echo ADMIN_SITE_URL;?>/resource/js/jquery.progressBar.js" type="text/javascript"></script>

</head>
<body>
<?php 
require_once($tpl_file);
?>
</body>
</html>
