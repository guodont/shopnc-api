<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php require CMS_BASE_TPL_PATH.'/layout/top.php';?>
<style type="text/css">
.search-cms { display: none !important;}
#topHeader .warp-all { height: 80px !important;}
#topHeader .cms-logo { top: 8px !important;}
</style>


<div class="cms-member-nav-bar"> 
  <!-- CMS用户中心导航 -->
  <ul class="cms-member-nav">
    <li <?php echo $_GET['act']=='member_article'&&$_GET['op']!='article_edit'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=article_list" ><i class="a"></i><?php echo $lang['cms_article_list'];?></a></li>
    <li <?php echo $_GET['op']=='publish_article'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=publish&op=publish_article"><i class="b"></i><?php echo $lang['cms_article_publish'];?></a></li>
    <li <?php echo $_GET['act']=='member_picture'&&$_GET['op']!='picture_edit'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=picture_list"><i class="c"></i><?php echo $lang['cms_picture_list'];?></a></li>
    <li <?php echo $_GET['op']=='publish_picture'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=publish&op=publish_picture"><i class="d"></i><?php echo $lang['cms_picture_publish'];?></a></li>
    <li><a href="<?php echo CMS_SITE_URL;?>/index.php?act=login&op=loginout"><i class="e"></i><?php echo $lang['cms_loginout'];?></a></li>
  </ul></div>
  <?php require_once($tpl_file);?>

<?php require CMS_BASE_TPL_PATH.'/layout/footer.php';?>
