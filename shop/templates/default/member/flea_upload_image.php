<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<style type="text/css">
body { margin: 0px; padding: 0px; font-size:12px; position:relative; z-index:0; }
.upload_wrap{ padding: 0; border: 0 }
.upload-button  { line-height: 32px; text-decoration: none; color: #555; text-align:center; background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/member/goods_pictures.gif) no-repeat 0 -70px; display: block; width:74px; height: 32px; padding: 0px; position: absolute; z-index:1; left: 0px; top: -15px;}
a:hover.upload-button { color: #06C; background-position: -74px -70px;}
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

<form action="index.php?act=member_flea&op=image_upload&upload_type=uploadedfile" method="post" enctype="multipart/form-data" id="image_form">
<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
<input type="hidden" name="item_id" value="<?php echo $_GET['item_id'];?>" />
<input type="hidden" name="file_id" value="<?php echo $_GET['file_id'];?>" />
<span style="width: 74px; height: 22px; position: absolute; left: 0; top: -10px; z-index: 999; cursor:pointer; ">
<input onChange="$('#submit_button').click();" type="file" name="file" style="width: 74px; height: 32px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" maxlength="0">
</span>
<div class="upload-button"><?php echo $lang['store_goods_img_upload'];?></div>
<input id="submit_button" style="display:none" type="button" value="<?php echo $lang['nc_submit'];?>" onClick="submit_form($(this))">
</form>
</body>
</html>