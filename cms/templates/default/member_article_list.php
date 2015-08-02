<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="cms-member-layout">
  <div class="cms-member-sidebar">
    <?php require('member_sidebar.php');?>
    <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=publish&op=publish_article" class="contribute-btn"><?php echo $lang['cms_article_publish'];?></a>
    <ul class="cms-member-menu">
      <li <?php echo $_GET['op']=='article_list'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=article_list"><i class="a"></i><?php echo $lang['cms_my_article'];?></a></li>
      <li <?php echo $_GET['op']=='draft_list'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=draft_list"><i class="b"></i><?php echo $lang['cms_text_draft'];?></a></li>
      <li <?php echo $_GET['op']=='recycle_list'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=recycle_list"><i class="c"></i><?php echo $lang['cms_text_recycle'];?></a></li>
    </ul>
  </div>
  <div class="cms-member-main">
    <table class="cms-member-table">
      <thead>
        <tr>
          <th class="w30"><?php echo $lang['cms_text_id'];?></th>
          <th><?php echo $lang['cms_text_article'];?></th>
          <th class="w90"><?php echo $lang['cms_text_date'];?></th>
          <th class="w90"><?php echo $lang['cms_text_state'];?></th>
          <th class="w60"><?php echo $lang['cms_text_click_count'];?></th>
          <th class="w90"><?php echo $lang['cms_text_op'];?></th>
        </tr>
        <tr>
          <td colspan="10"><form action="" method="get">
              <input name="act" type="hidden" value="member_article" />
              <input name="op" type="hidden" value="<?php echo $_GET['op'];?>" />
              <?php if($_GET['op'] == 'article_list') { ?>
              <select name="article_state">
                <option value=""><?php echo $lang['cms_text_all'];?></option>
                <option value="3" <?php echo $_GET['article_state'] == '3'?'selected':'';?>><?php echo $lang['cms_text_published'];?></option>
                <option value="2" <?php echo $_GET['article_state'] == '2'?'selected':'';?>><?php echo $lang['cms_text_verify'];?></option>
              </select>
              <?php } ?>
              <input name="keyword" type="text" value="<?php echo $_GET['keyword'];?>" placeholder="<?php echo $lang['cms_article_keyword'];?>" class="text" />
              <input type="submit" class="search-btn" value="<?php echo $lang['cms_text_search'];?>" />
            </form></td>
        </tr>
      </thead>
      <?php if(!empty($output['article_list']) && is_array($output['article_list'])) {?>
      <tbody>
        <?php foreach($output['article_list'] as $value) {?>
        <?php $article_url = getCMSArticleUrl($value['article_id']);?>
        <tr>
          <td><?php echo $value['article_id'];?></td>
          <td><dl class="article-info">
              <dt class="title" title="<?php echo $value['article_title'];?>"><a href="<?php echo $article_url;?>" target="_blank"><?php echo $value['article_title'];?></a></dt>
              <dd class="thumb" title="<?php echo $lang['cms_cover'];?>"><a href="<?php echo $article_url;?>" target="_blank"> <img src="<?php echo getCMSArticleImageUrl($value['article_attachment_path'], $value['article_image']);?>" alt="" class="t-img"/></a></dd>
              <dd class="abstract" title="<?php echo $lang['cms_article_abstract'];?><?php echo $lang['nc_colon'];?><?php echo $value['article_abstract'];?>"><?php echo $value['article_abstract'];?></dd>
            </dl></td>
          <td><?php echo date('Y-m-d',$value['article_publish_time']);?></td>
          <td><?php echo $output['article_state_list'][$value['article_state']];?></td>
          <td><?php echo $value['article_click'];?></td>
          <td class="handle">
            <?php if($value['article_state'] != '3') {?>
              <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=article&op=article_detail&article_id=<?php echo $value['article_id'];?>" target="_blank" style="color:#06C;"><?php echo $lang['cms_text_view'];?></a>
              <?php } else { ?>
              <a href="<?php echo $article_url;?>" target="_blank" style="color:#06C;"><?php echo $lang['cms_text_view'];?></a>
              <?php } ?>
            <?php if($_GET['op'] == 'draft_list') {?>
            <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=article_publish&article_id=<?php echo $value['article_id'];?>" onclick="javascript:return confirm('<?php echo $lang['cms_publish_confirm'];?>')" style="color:#390;"><?php echo $lang['cms_text_publish'];?></a> <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=article_edit&article_id=<?php echo $value['article_id'];?>" style="color:#F90;" ><?php echo $lang['cms_text_edit'];?></a> <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=article_recycle&article_id=<?php echo $value['article_id'];?>" style="color:#F36;"><?php echo $lang['cms_text_remove'];?></a>
            <?php } ?>
            <?php if($_GET['op'] == 'recycle_list') {?>
            <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=article_draft&article_id=<?php echo $value['article_id'];?>" style="color:#639;"><?php echo $lang['cms_text_back'];?></a> <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_article&op=article_drop&article_id=<?php echo $value['article_id'];?>" onclick="javascript:return confirm('<?php echo $lang['cms_delete_confirm'];?>')" style="color:#F00;"><?php echo $lang['cms_delete'];?></a>
            <?php } ?></td>
        </tr>
            <?php if($_GET['op'] == 'draft_list') {?>
            <?php if(!empty($value['article_verify_reason'])) { ?>
            <tr>
                <td colspan="20"><strong class="fl" style="color: #F00;">审核结果：未通过平台审核，<?php echo $value['article_verify_reason'];?>。请根据审核意见进行修改编辑后再次提交。</strong></td>
            </tr>
            <?php } ?>
            <?php } ?>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } else { ?>
      <tbody>
        <tr>
          <td colspan="20"><div class="no-record"><i></i><?php echo $lang['no_record'];?></div></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
  </div>
</div>
<script type="text/javascript">
$(window).load(function() {
	$(".article-info .t-img").VMiddleImg({"width":40,"height":32});
});
</script> 
