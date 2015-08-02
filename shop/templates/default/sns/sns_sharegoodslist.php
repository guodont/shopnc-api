<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="sns-main-all">
  <div class="tabmenu"><?php if($output['relation'] == '3'){?>
    <div class="release-banner">
      
      <span class="btn"><a href="javascript:void(0);" id="snssharegoods">+ <?php echo $lang['sns_share_treasure'];?></a></span><?php if(!empty($output['goodslist'])){?><i></i><h3><?php echo $lang['sns_release_banner_h3'];?></h3><?php }?>
    </div>
    <?php }?>
    <ul class="tab">
      <li class="active"><i></i><a href="index.php?act=member_snshome&op=shareglist&type=share&mid=<?php echo $output['master_info']['member_id'];?>"><?php echo $lang['sns_shareofgoods'];?></a></li>
      <li class="normal"><i></i><a href="index.php?act=member_snshome&op=shareglist&type=like&mid=<?php echo $output['master_info']['member_id'];?>"><?php echo $lang['sns_likeofgoods'];?></a></li>
    </ul>
    
  </div>
  <div class="sharelist-g mt30">
    <?php if (!empty($output['goodslist'])){?>
    <ul class="nc-sns-pinterest" id="snsPinterest">
      <?php foreach ($output['goodslist'] as $k=>$v){ ?>
      <li id="recordone_<?php echo $v['share_id'];?>" class="item">
        <ul class="handle">
          <?php if ($output['relation'] == 3){//主人自己?>
          <li class="buyer-show"><a href="javascript:void(0)" nctype="add_share" data-param="{'sid':'<?php echo $v['share_id'];?>', 'gid':'<?php echo $v['share_goodsid'];?>'}"><i></i><?php echo $lang['sns_buyershow'];?></a></li>
          <li class="set" nc_type="privacydiv"><a href="javascript:void(0)" nc_type="formprivacybtn"><i></i><?php echo $lang['sns_setting'];?></a>
            <ul class="set-menu" nc_type="privacytab" style="display:none;">
              <li nc_type="privacyoption" data-param='{"sid":"<?php echo $v['share_id'];?>","v":"0"}'><span class="<?php echo $v['share_privacy']==0?'selected':'';?>"><?php echo $lang['sns_open'];?></span></li>
              <li nc_type="privacyoption" data-param='{"sid":"<?php echo $v['share_id'];?>","v":"1"}'><span class="<?php echo $v['share_privacy']==1?'selected':'';?>"><?php echo $lang['sns_friend'];?></span></li>
              <li nc_type="privacyoption" data-param='{"sid":"<?php echo $v['share_id'];?>","v":"2"}'><span class="<?php echo $v['share_privacy']==2?'selected':'';?>"><?php echo $lang['sns_privacy'];?></span></li>
              <li nc_type="delbtn" data-param='{"sid":"<?php echo $v['share_id'];?>","tabtype":"share"}'><span class="del"><a href="javascript:void(0);"><?php echo $lang['nc_delete'];?></a></span></li>
            </ul>
          </li>
          <?php }?>
        </ul>
        <dl>
          <dt class="goodspic"><span class="thumb size233"><i></i><a href="index.php?act=member_snshome&op=goodsinfo&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $v['snsgoods_goodsname']?>"> <img src="<?php echo cthumb($v['snsgoods_goodsimage'],240,$v['snsgoods_storeid']);?>"/></a></span>
            <?php if(isset($output['pic_list'][$v['share_id']])){?>
            <div class="ap-pic"><span class="num" title="<?php printf($lang['sns_entity_pic_count'], $output['pic_list'][$v['share_id']]['count'])?>"><i></i><?php echo $output['pic_list'][$v['share_id']]['count'];?></span><img src="<?php echo $output['pic_list'][$v['share_id']]['ap_cover']?>" /></div>
            <?php }?>
          </dt>
          <dd class="pinterest-cmt"><?php echo $v['share_content'];?></dd>
          <dd class="pinterest-addtime goods-time"><?php echo $lang['sns_at'];?>&nbsp;<?php echo @date('Y-m-d H:i',$v['share_addtime']);?>&nbsp;<?php echo $lang['nc_snsshare'];?></dd>
          <dd class="pinterest-ops"> <span class="ops-like" id="likestat_<?php echo $v['share_goodsid'];?>"> <a href="javascript:void(0);" nc_type="likebtn" data-param='{"gid":"<?php echo $v['share_goodsid'];?>"}' class="<?php echo $v['snsgoods_havelike']==1?'noaction':''; ?>"><i class="<?php echo $v['snsgoods_havelike']==1?'noaction':''; ?> pngFix"></i><?php echo $lang['sns_like'];?></a> <em nc_type="likecount_<?php echo $v['share_goodsid'];?>"><?php echo $v['snsgoods_likenum'];?></em> </span> <span class="ops-comment"><a href="index.php?act=member_snshome&op=goodsinfo&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $lang['sns_comment'];?>"><i class="pngFix"></i></a><em><?php echo $v['share_commentcount'];?></em> </span> </dd>
          <div class="clear"></div>
        </dl>
      </li>
      <?php }?>
    </ul>
    <div class="clear"></div>
    <div class="pagination  mb30"><?php echo $output['show_page']; ?></div>
    <div class="clear"></div>
    <?php }else {?>
    <?php if ($output['relation'] == 3){?>
    <div class="sns-norecord"><i class="goods-ico pngFix"></i><span><?php echo $lang['sns_sharegoods_nothave_self_1'];?><a href="index.php?act=member_order" target="_blank"><?php echo $lang['sns_sharegoods_nothave_self_2'];?></a><?php echo $lang['sns_sharegoods_nothave_self_3'];?><a href="index.php?act=member_favorites&op=fglist" target="_blank"><?php echo $lang['sns_sharegoods_nothave_self_4'];?></a><?php echo $lang['sns_sharegoods_nothave_self_5'];?></span></div>
    <?php }else {?>
    <div class="sns-norecord"><i class="goods-ico pngFix"></i><span><?php echo $lang['sns_sharegoods_nothave'];?></span></div>
    <?php }?>
    <?php }?>
  </div>
  <div class="clear">&nbsp;</div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.masonry.js" type="text/javascript"></script> 
<script type="text/javascript">
$(function(){
	$("#snsPinterest").imagesLoaded( function(){
		$("#snsPinterest").masonry({
			itemSelector : '.item'
		});
	});
    //显示分享商品页面
	$('#snssharegoods').click(function(){
	    ajax_form("sharegoods", '<?php echo $lang['sns_share_purchasedgoods'];?>', '<?php echo SHOP_SITE_URL.DS;?>index.php?act=member_snsindex&op=sharegoods', 480);
	    return false;
	});
	// 追加
	$('a[nctype="add_share"]').click(function(){
	    eval( "data_str = "+$(this).attr('data-param'));
		ajax_form('add_share', '<?php echo $lang['sns_upload_treasure_buyer_show'];?>', SITEURL+'/index.php?act=member_snshome&op=add_share&sid='+data_str.sid+'&gid='+data_str.gid, 580);
	});
	// 买家秀
	$('a[nctype="add_pic"]').click(function(){
		
	});
});
</script> 
