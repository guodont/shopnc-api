<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
body { background:#f6f6f6; }
.full_module { background:#fff; border:1px solid #ccc; margin-top:20px; min-height:300px; margin-bottom:20px; }
.full_module h2 { height: 38px; line-height: 38px; background: none repeat scroll 0% 0% #F5F5F5; color: #666; font-size: 16px; padding-left: 14px; font-family: Arial, "microsoft yahei"; font-weight: normal; }
.full_module h2 span { float:right; font-size:12px; font-weight:normal}
.shop_plink span { background-color: #FFF; border: 1px solid #D8D8D8; width: 88px; height: 31px; display: inline; float: left; padding: 2px; margin: 5px 13px 5px 0; }
.shop_plink { margin: 10px 0 10px 15px }
.shop_tlink { clear: both; margin: 0 auto; background:#fff; padding: 10px; border-top:1px dashed #ddd; }
.shop_tlink a { margin-right: 20px; color: #222; }
.shop_txt { padding-bottom: 10px; color: #666; margin-top:5px; }
.shop_txt i { color:#ff3c00; font-weight:600 }
</style>
<div class="clear"></div>
<div class="full_module wrapper">
  <h2><span>申请友情链接请发邮箱：<?php echo $GLOBALS['setting_config']['site_email']; ?>，注明：友情链接。</span><b><?php echo $lang['index_index_link'];?></b></h2>
  <div class="shop_plink">
  <h3>图片链接：</h3>
    <?php if(is_array($output['$link_list']) && !empty($output['$link_list'])) {
		  	foreach($output['$link_list'] as $val) {
		  		if($val['link_pic'] != ''){
		  ?>
    <span><a href="<?php echo $val['link_url']; ?>" target="_blank"><img src="<?php echo $val['link_pic']; ?>" title="<?php echo $val['link_title']; ?>" alt="<?php echo $val['link_title']; ?>" width="88" height="31" ></a></span>
    <?php
		  		}
		 	}
		 }
		 ?>
    <div class="clear"></div>
  </div>
  <div class="shop_tlink">
   <h3>文字链接：</h3>
    <?php 
		  if(is_array($output['$link_list']) && !empty($output['$link_list'])) {
		  	foreach($output['$link_list'] as $val) {
		  		if($val['link_pic'] == ''){
		  ?>
    <span><i></i><a href="<?php echo $val['link_url']; ?>" target="_blank" title="<?php echo $val['link_title']; ?>"><?php echo str_cut($val['link_title'],16);?></a></span>
    <?php
		  		}
		 	}
		 }
		 ?>
    <div class="clear"></div>
  </div>
</div>
