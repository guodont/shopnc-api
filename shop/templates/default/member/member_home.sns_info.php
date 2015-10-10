<?php defined('InShopNC') or exit('Access Invalid!');?>

  <div id="friendsShare" class="normal">
    <div class="outline">
      <div class="title">
        <h3>好友动态</h3>
      </div>
      <?php if (!empty($output['follow_list']) && is_array($output['follow_list'])) { ?>
       <div class="ncm-friends-share">
            <ul id="friendsShareList" class="jcarousel-skin-tango">
            <?php foreach($output['follow_list'] as $k => $v){ ?>
              <li>
                <div class="ncm-friend-avatar"><a href="index.php?act=member_snshome&op=trace&mid=<?php echo $v['member_id'];?>" target="_blank"><img  src="<?php if ($v['member_avatar']!='') { echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR.DS.$v['member_avatar']; } else { echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('default_user_portrait'); } ?>"></a></div>
                <dl>
                  <dt class="ncm-friend-name"><a href="index.php?act=member_snshome&op=trace&mid=<?php echo $v['member_id'];?>" target="_blank"><?php echo $v['friend_tomname']; ?></a></dt>
                  <dd>动态<?php echo $output['tracelist'][$v['member_id']];?>条</dd>
                </dl>
              </li>
            <?php } ?>
            </ul>
            <div class="more"><a target="_blank" href="<?php echo SHOP_SITE_URL?>/index.php?act=member_snsfriend&op=follow">查看我的全部好友</a></div>
          </div>
     <?php } else { ?>
      <dl class="null-tip">
        <dt></dt>
        <dd>
          <h4>您的好友最近没有什么动静</h4>
          <h5>关注其他用户成为好友可将您的动态进行分享</h5>
          <p><a target="_blank" href="<?php echo SHOP_SITE_URL?>/index.php?act=member_snsfriend&op=follow" class="ncm-btn-mini" >查看我的全部好友</a></p>
        </dd>
      </dl>
    <?php } ?>  
    </div>
  </div>
  <div id="circle" class="normal">
    <div class="outline">
      <div class="title">
        <h3>我的圈子</h3>
      </div>
    <?php if(!empty($output['circle_list'])){?>
      <div class="ncm-circle">
            <ul id="circleList" class="jcarousel-skin-tango">
              <?php foreach($output['circle_list'] as $val){?>
              <li>
                <div class="ncm-circle-pic"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>" target="_blank"><img alt="" src="<?php echo circleLogo($val['circle_id']);?>"></a></div>
                <dl>
                  <dt><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>" target="_blank"><?php echo $val['circle_name']?></a></dt>
                  <dd><?php echo $val['circle_mcount'];?>个成员</dd>
                </dl>
              </li>
            <?php } ?>
            </ul>
            <div class="more"><a target="_blank" href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=p_center&op=my_group">查看我的所有圈子</a></div>
          </div>
      <?php } else {?>
      <dl class="null-tip">
        <dt></dt>
        <dd>
          <h4>您还没有自己的圈子</h4>
          <h5>您可以创建或加入感兴趣的社交圈子</h5>
          <p><a target="_blank" href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=index&op=add_group" class="ncm-btn-mini">创建圈子</a></p>
        </dd>
      </dl>
      <?php } ?>
    </div>
  </div>
  <div id="browseMark" class="normal">
    <div class="outline">
      <div class="title">
        <h3>我的足迹</h3>
      </div>
      <?php if (!empty($output['viewed_goods']) && is_array($output['viewed_goods'])) { ?>
      <div class="ncm-browse-mark">
            <ul id="browseMarkList" class="jcarousel-skin-tango">
            <?php foreach($output['viewed_goods'] as $goods_id => $goods_info) { ?>
              <li>
                <div class="ncm-goods-pic"><a href="<?php echo $goods_info['url'];?>" target="_blank"><img alt="" src="<?php echo $goods_info['goods_image'];?>"></a></div>
                <dl>
                  <dt class="ncm-goods-name"><a href="<?php echo $goods_info['url'];?>" title="<?php echo $goods_info['goods_name'];?>" target="_blank"><?php echo $goods_info['goods_name'];?></a></dt>
                  <dd class="ncm-goods-price"><em>￥<?php echo $goods_info['goods_promotion_price'];?></em></dd>
                </dl>
              </li>
            <?php } ?>
            </ul>
            <div class="more"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_goodsbrowse&op=list" target="_blank">查看所有商品</a></div>
          </div>
       <?php } else { ?>
          <dl class="null-tip">
            <dt></dt>
            <dd>
              <h4>您的商品浏览记录为空</h4>
              <h5>赶紧去商城看看促销活动吧</h5>
              <p><a target="_blank" href="<?php echo SHOP_SITE_URL;?>" class="ncm-btn-mini">浏览商品</a></p>
            </dd>
          </dl>
       <?php } ?>
    </div>
  </div>
<script>
//信息轮换
$.getScript("<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js", function(){
    $('#favoritesGoodsList').jcarousel({visible: 4,itemFallbackDimension: 300});
	$('#favoritesStoreList').jcarousel({visible: 3,itemFallbackDimension: 300});
	$('#friendsShareList').jcarousel({visible: 3,itemFallbackDimension: 300});
	$('#circleList').jcarousel({visible: 3,itemFallbackDimension: 300});
	$('#browseMarkList').jcarousel({visible: 3,itemFallbackDimension: 300});
});
</script>
