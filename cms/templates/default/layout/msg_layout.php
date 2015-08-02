<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php require CMS_BASE_TPL_PATH.'/layout/top.php';?>
<?php require CMS_BASE_TPL_PATH.'/layout/nav.php';?>
<div class="warp-all"><div class="no-content-b"><i class="article"></i><?php require_once($tpl_file);?></div></div>

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
<?php require CMS_BASE_TPL_PATH.'/layout/footer.php';?>
