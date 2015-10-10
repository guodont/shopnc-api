<?php defined('InShopNC') or exit('Access Invalid!');?>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<?php ob_end_clean();
ob_start();
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
@header("Content-type: text/xml; charset=".CHARSET);
echo '<?xml version="1.0" encoding="'.CHARSET.'"?>'."\r\n";?>
<root><![CDATA[<?php require_once($tpl_file);?>]]></root>