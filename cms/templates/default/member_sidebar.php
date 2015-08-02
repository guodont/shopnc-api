<?php defined('InShopNC') or exit('Access Invalid!');?>
<dl class="member-info">
  <dt class="avatar">
    <?php if($output['publisher_info']['type'] === 2) { ?>
    <img src="<?php echo CMS_TEMPLATES_URL;?>/images/admin.gif" />
    <?php } else { ?>
    <img src="<?php echo getMemberAvatar($output['publisher_info']['avator']);?>" alt="<?php echo $output['publisher_info']['name'];?>" />
    <?php } ?>
  </dt>
  <dd class="username"><?php echo $output['publisher_info']['name'];?></dd>
  <dd class="type">（<?php echo $output['publisher_info']['type'] === 2?$lang['cms_article_type_admin']:$lang['cms_article_type_member'];?>）</dd>
</dl>
