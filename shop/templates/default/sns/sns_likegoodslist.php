<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="sns-main-all">
<div class="tabmenu">
  <ul class="tab">
    <li class="normal"><a href="index.php?act=member_snshome&op=shareglist&type=share&mid=<?php echo $output['master_info']['member_id'];?>"><?php echo $lang['sns_shareofgoods'];?></a></li>
    <li class="active"><i></i><a href="index.php?act=member_snshome&op=shareglist&type=like&mid=<?php echo $output['master_info']['member_id'];?>"><?php echo $lang['sns_likeofgoods'];?></a></li>
  </ul>
  
</div>
<div class="sharelist-g mt30">
<?php if (!empty($output['goodslist'])){?>
<ul class="nc-sns-pinterest" id="snsPinterest">
<?php foreach ($output['goodslist'] as $k=>$v){ ?>
<li id="recordone_<?php echo $v['share_id'];?>" class="item">
<ul class="handle">
  <?php if ($output['relation'] == 3){//主人自己?><li class="delete" style=" margin-left: 150px;" nc_type="delbtn" data-param='{"sid":"<?php echo $v['share_id'];?>","tabtype":"like"}'><a href="javascript:void(0)"><i></i><?php echo $lang['nc_delete'];?></a></li>
    <?php } ?></ul>
  <dl>
    <dt class="goodspic"><span class="thumb size233"><i></i><a href="index.php?act=member_snshome&op=goodsinfo&type=like&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $v['snsgoods_goodsname']?>"> <img src="<?php echo cthumb($v['snsgoods_goodsimage'],240,$v['snsgoods_storeid']);?>"/> </a></span></dt>
    <dd class="pinterest-addtime goods-time"><?php echo @date('Y-m-d H:i',$v['share_likeaddtime']);?></dd>
    <dd class="pinterest-ops"> <span class="ops-like" id="likestat_<?php echo $v['share_goodsid'];?>"> <a href="javascript:void(0);" nc_type="likebtn" data-param='{"gid":"<?php echo $v['share_goodsid'];?>"}' class="<?php echo $v['snsgoods_havelike']==1?'noaction':''; ?>"><i class="<?php echo $v['snsgoods_havelike']==1?'noaction':''; ?>"></i><?php echo $lang['sns_like'];?></a><em nc_type='likecount_<?php echo $v['share_goodsid'];?>'><?php echo $v['snsgoods_likenum'];?></em> </span> <span class="ops-comment"><a href="index.php?act=member_snshome&op=goodsinfo&type=like&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $lang['sns_comment'];?>"><i></i></a><em><?php echo $v['share_commentcount'];?></em> </span> </dd>
    <div class="clear"></div>
  </dl>
  </li>
  <?php }?>
</ul>
<div class="clear"></div>
<div class="pagination mb30"><?php echo $output['show_page']; ?></div>
<div class="clear"></div>
<?php }else {?>
<?php if ($output['relation'] == 3){?>
<div class="sns-norecord"><i class="goods-ico pngFix"></i><span><?php echo $lang['sns_likegoods_nothave_self'];?></span></div>
<?php }else {?>
<div class="sns-norecord"><i class="goods-ico pngFix"></i><span><?php echo $lang['sns_likegoods_nothave'];?></span></div>
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
});
</script> 