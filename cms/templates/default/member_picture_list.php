<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="cms-member-layout">
  <div class="cms-member-sidebar">
    <?php require('member_sidebar.php');?>
    <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=publish&op=publish_picture" class="contribute-btn"><?php echo $lang['cms_picture_publish'];?></a>
    <ul class="cms-member-menu">
      <li <?php echo $_GET['op']=='picture_list'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=picture_list"><i class="a"></i><?php echo $lang['cms_my_picture'];?></a></li>
      <li <?php echo $_GET['op']=='draft_list'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=draft_list"><i class="b"></i><?php echo $lang['cms_text_draft'];?></a></li>
      <li <?php echo $_GET['op']=='recycle_list'?' class="current"':'';?>><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=recycle_list"><i class="c"></i><?php echo $lang['cms_text_recycle'];?></a></li>
    </ul>
  </div>
  <div class="cms-member-main">
    <div> </div>
    <table class="cms-member-table">
      <thead>
        <tr>
          <th class="w30"><?php echo $lang['cms_text_id'];?></th>
          <th><?php echo $lang['cms_picture'];?></th>
          <th class="w90"><?php echo $lang['cms_text_date'];?></th>
          <th class="w90"><?php echo $lang['cms_text_state'];?></th>
          <th class="w60"><?php echo $lang['cms_text_click_count'];?></th>
          <th class="w90"><?php echo $lang['cms_text_op'];?></th>
        </tr>
        <tr>
          <td colspan="10"><form action="" method="get">
              <input name="act" type="hidden" value="member_picture" />
              <input name="op" type="hidden" value="<?php echo $_GET['op'];?>" />
              <?php if($_GET['op'] == 'picture_list') { ?>
              <select name="picture_state">
                <option value=""><?php echo $lang['cms_text_all'];?></option>
                <option value="3" <?php echo $_GET['picture_state'] == '3'?'selected':'';?>><?php echo $lang['cms_text_published'];?></option>
                <option value="2" <?php echo $_GET['picture_state'] == '2'?'selected':'';?>><?php echo $lang['cms_text_verify'];?></option>
              </select>
              <?php } ?>
              <input name="keyword" type="text" value="<?php echo $_GET['keyword'];?>" placeholder="<?php echo $lang['cms_article_keyword'];?>" class="text" />
              <input type="submit" value="<?php echo $lang['cms_text_search'];?>" />
            </form></td>
        </tr>
      </thead>
      <?php if(!empty($output['picture_list']) && is_array($output['picture_list'])) {?>
      <tbody>
        <?php foreach($output['picture_list'] as $value) {?>
        <?php $picture_url = getCMSPictureUrl($value['picture_id']);?>
        <tr>
          <td><?php echo $value['picture_id'];?></td>
          <td><dl class="picture-info">
              <dt class="title" title="<?php echo $value['picture_title'];?>"><a href="<?php echo $picture_url;?>" target="_blank"><?php echo $value['picture_title'];?></a><span class="count">（<?php echo $lang['cms_text_gong'];?><em><?php echo $value['picture_image_count'];?></em><?php echo $lang['cms_text_zhang'];?>）</span></dt>
              <dd class="cover thumb" title="<?php echo $lang['cms_cover'];?>"><a><img src="<?php echo getCMSArticleImageUrl($value['picture_attachment_path'], $value['picture_image']);?>" alt="<?php echo $value['picture_title'];?>" class="t-img"/></a></dd>
              <dd class="pic-list" title="<?php echo $lang['cms_picture_list'];?>">
              <ul>
                  <?php if(!empty($output['picture_image_list'][$value['picture_id']]) && is_array($output['picture_image_list'][$value['picture_id']])) {?>
                  <?php $image_count = 0;?>
                  <?php foreach($output['picture_image_list'][$value['picture_id']] as $image_value) {?>
                  <li class="thumb"><a href="Javascript: void(0)"><img src="<?php echo getCMSArticleImageUrl($value['picture_attachment_path'], $image_value);?>" alt="<?php echo $value['picture_title'];?>" class="t-img"/></a></li>
                  <?php $image_count++;?>
                  <?php if($image_count >=8) break;?>
                  <?php } ?>
                  <li class="thumb"><a href="<?php echo $picture_url;?>" target="_blank">...</a></li>
                  <?php } ?>
              </ul>
              </dd>
            </dl></td>
          <td><?php echo date('Y-m-d',$value['picture_publish_time']);?></td>
          <td><?php echo $output['picture_state_list'][$value['picture_state']];?></td>
          <td><?php echo $value['picture_click'];?></td>
          <td class="handle">
            <?php if($value['picture_state'] != '3') {?>
              <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=picture&op=picture_detail&picture_id=<?php echo $value['picture_id'];?>" target="_blank" style="color:#06C;"><?php echo $lang['cms_text_view'];?></a>
              <?php } else { ?>
              <a href="<?php echo $picture_url;?>" target="_blank" style="color:#06C;"><?php echo $lang['cms_text_view'];?></a>
              <?php } ?>
            <?php if($_GET['op'] == 'draft_list') {?>
            <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=picture_publish&picture_id=<?php echo $value['picture_id'];?>" onclick="javascript:return confirm('<?php echo $lang['cms_publish_confirm'];?>')" style="color:#390;"><?php echo $lang['cms_text_publish'];?></a> <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=picture_edit&picture_id=<?php echo $value['picture_id'];?>" target="_blank" style="color:#F90;" ><?php echo $lang['cms_text_edit'];?></a> <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=picture_recycle&picture_id=<?php echo $value['picture_id'];?>" style="color:#F36;"><?php echo $lang['cms_text_remove'];?></a>
            <?php } ?>
            <?php if($_GET['op'] == 'recycle_list') {?>
            <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=picture_draft&picture_id=<?php echo $value['picture_id'];?>" style="color:#639;"><?php echo $lang['cms_text_back'];?></a> <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=member_picture&op=picture_drop&picture_id=<?php echo $value['picture_id'];?>" onclick="javascript:return confirm('<?php echo $lang['cms_delete_confirm'];?>')" style="color:#F00;"><?php echo $lang['cms_delete'];?></a>
            <?php } ?></td>
        </tr>
            <?php if($_GET['op'] == 'draft_list') {?>
            <?php if(!empty($value['picture_verify_reason'])) { ?>
            <tr>
                <td colspan="20"><strong class="fl" style="color: #F00;">审核结果：未通过平台审核，<?php echo $value['picture_verify_reason'];?>。请根据审核意见进行修改编辑后再次提交。</strong></td>
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
	$(".cover .t-img").VMiddleImg({"width":40,"height":40});
	$(".pic-list .t-img").VMiddleImg({"width":20,"height":20});
	
});
</script> 
