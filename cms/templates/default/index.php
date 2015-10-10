<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="cms-content">
<?php 
$index_file = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'index_html'.DS.'index.html';
if(is_file($index_file)) {
    require($index_file);
}
?>
</div>
