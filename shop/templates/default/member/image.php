<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<style type="text/css">
body { margin: 0px; padding: 0px; font-size:12px; }
<?php if ($output['act'] == 'remote_image') { ?>
form { margin: 0px; padding: 8px; background-color:#F9F9F9; }
<?php } ?>
input { background: #ECE9D8; }
.upload_wrap{ padding: 0; border: 0 }
</style>
<script type="text/javascript">
function submit_form(obj)
{
    obj.attr('disabled', 'disabled');
    $('#image_form').submit();
    obj.removeAttr('disabled');
}
</script>
</head>
<body>
<form action="index.php?act=store_goods&op=image_upload&upload_type=<?php echo $output['act']; ?>&instance=<?php echo $output['instance']; ?>&id=<?php echo $output['id']; ?>&belong=<?php echo $output['belong']; ?>" method="post" enctype="multipart/form-data" id="image_form">
<input type="hidden" name="id" value="<?php echo $output['id']; ?>">
<input type="hidden" name="belong" value="<?php echo $output['belong']; ?>">
<?php if ($output['act']=='uploadedfile') { ?>
<span style="height: 28px; position: absolute; left: 3px; top: 0; width: 120px; z-index: 2; ">
<input onchange="$('#submit_button').click();" type="file" name="file" style="width: 0px; height: 28px; cursor: hand; cursor: pointer;  opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true">
</span>
<div class="upload_wrap">
<ul>
<li class="btn1"><?php echo $lang['store_goods_upload_normal'];?></li>
</ul>
</div>
<?php } ?>
<?php if ($output['act']=='remote_image') { ?>
<input type="text" name="remote_url" size="27" value="http://">
<?php } ?>
<input id="submit_button" <?php if ($output['act']=='uploadedfile') { ?>style="display:none"<?php } ?> type="button" value="<?php if ($output['act']=='uploadedfile') { ?><?php echo $lang['store_goods_upload_upload'];?><?php } ?><?php if ($output['act']=='remote_image') { ?><?php echo $lang['nc_submit'];?><?php } ?>" onclick="submit_form($(this))">
</form>
</body>
</html>