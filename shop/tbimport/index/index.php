<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>SWFUpload上传</title>
<link href="../css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../swfupload/swfupload.js"></script>
<script type="text/javascript" src="js/swfupload.swfobject.js"></script>
<script type="text/javascript" src="js/swfupload.queue.js"></script>
<script type="text/javascript" src="js/fileprogress.js"></script>
<script type="text/javascript" src="js/handlers.js"></script>
<script type="text/javascript">
var swfu;

SWFUpload.onload = function () {
	var settings = {
		flash_url : "../swfupload/swfupload.swf",
		upload_url: "upload.php",
		post_params: {
			"storeid":"<?php echo $_GET['storeid']; ?>",
			"PHPSESSID" : "NONE",
			"HELLO-WORLD" : "Here I Am",
			".what" : "OKAY"
		},
		file_size_limit : "100 MB",//文件大小限制
		file_types : "*.tbi",
		file_types_description : "All Files",//文件类型
		file_upload_limit : 500,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button Settings
		//button_image_url : "XPButtonUploadText_61x22.png",
		button_image_url: "TestImageNoText_65x29.png",//按钮图片
		button_placeholder_id : "spanButtonPlaceholder",//按钮id
		button_text: '<span class="theFont">浏览</span>',//按钮文字
		button_text_style: ".theFont { font-size: 16; }",//按钮文字字号
		button_text_left_padding: 12,//按钮左边距
		button_text_top_padding: 3,//按钮上边距
		button_width: "65",//按钮宽
		button_height: "29",//按钮高
		//button_width: 61,
		//button_height: 22,

		// The event handler functions are defined in handlers.js
		swfupload_loaded_handler : swfUploadLoaded,
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete,	// Queue plugin event
		
		// SWFObject settings
		minimum_flash_version : "9.0.28",
		swfupload_pre_load_handler : swfUploadPreLoad,
		swfupload_load_failed_handler : swfUploadLoadFailed
	};

	swfu = new SWFUpload(settings);
}


</script>
</head>
<body>
<div id="content">

	
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		<p>点击“浏览”按钮，选择您要上传的文档文件后（可多选，数量取决于你的php配置），系统将自动上传并在完成后提示您。</p>
			<div id="divSWFUploadUI">
			<div class="fieldset  flash" id="fsUploadProgress"><span class="legend">快速上传</span></div>
			<p id="divStatus">0 个文件已上传</p>
			<p>
				<span id="spanButtonPlaceholder"></span>
				<input id="btnCancel" type="button" value="取消所有上传" disabled="disabled" style="margin-left: 2px; height: 29px; font-size: 8pt;" />
				<br />
			</p>
		</div>
		<noscript>
			<div style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px;">
				对不起，您的浏览器不支持javascript。
			</div>
		</noscript>
		<div id="divLoadingContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			SWFUpload上传组件正在载入，请稍后
		</div>
		<div id="divLongLoading" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			SWFUpload上传组件载入超时。  请确保Flash插件安装正确，并且版本支持本上传组件。
		</div>
		<div id="divAlternateContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			SWFUpload不能载入.  请安装或升级Flash Player.
			点击这里 <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">Adobe website</a> 获得Flash Player.
		</div>
	</form>
</div>
</body>
</html>
