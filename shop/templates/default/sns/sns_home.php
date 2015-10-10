<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.jcarousel-container { width: 640px; margin: 10px 0;}
.jcarousel-container li { width: 160px; height: 160px;}
.jcarousel-container .goods-pic { width: 160px; height: 160px;}
.jcarousel-container .goods-pic a { line-height: 0; background-color: #FFF; text-align: center; vertical-align: middle; display: table-cell; *display: block; width: 160px; height: 160px; overflow: hidden;}
.jcarousel-container .goods-pic a img { max-width: 160px; max-height: 160px; margin-top:expression(160-this.height/2); *margin-top:expression(80-this.height/2)/*IE6,7*/;
}
</style>
<div class="sidebar">
<?php include template('sns/sns_sidebar_visitor');?>
<?php include template('sns/sns_sidebar_messageboard');?>
</div>
<div class="left-content">
  <!-- 分享商品 START -->
  <?php if (!empty($output['goodslist'])){?>
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="index.php?act=member_snshome&op=shareglist<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {?>TA<?php }echo $lang['sns_share_of_goods'];?></a></li>
    </ul><span class="more"><a href="index.php?act=member_snshome&op=shareglist<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php echo $lang['nc_more'];?></a></span>
  </div>
  <ul class="sns-home-share">
    <?php foreach ($output['goodslist'] as $k=>$v){ ?>
    <li id="recordone_<?php echo $v['share_id'];?>"><a href="index.php?act=member_snshome&op=goodsinfo&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $v['snsgoods_goodsname']?>" class="pic" style=" background-image:url(<?php echo cthumb($v['snsgoods_goodsimage'],240,$v['snsgoods_storeid']);?>)"> </a>
      <p class="pinterest-cmt"><?php echo $v['share_content'];?></p>
      <div class="ops"> <span class="ops-like" id="likestat_<?php echo $v['share_goodsid'];?>"> <a href="javascript:void(0);" nc_type="likebtn" data-param='{"gid":"<?php echo $v['share_goodsid'];?>"}' class="<?php echo $v['snsgoods_havelike']==1?'noaction':''; ?>"><i class="<?php echo $v['snsgoods_havelike']==1?'noaction':''; ?> pngFix"></i><?php echo $lang['sns_like'];?></a> <em nc_type="likecount_<?php echo $v['share_goodsid'];?>"><?php echo $v['snsgoods_likenum'];?></em> </span> <span class="ops-comment"><a href="index.php?act=member_snshome&op=goodsinfo&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $lang['sns_comment'];?>"><i class="pngFix"></i></a><em><?php echo $v['share_commentcount'];?></em> </span> </div>
    </li>
    <?php }?>
  </ul>
  <?php }?>
  <!-- 分享商品 END -->
  <!-- 分享图片 START -->
  <?php if(!empty($output['pic_list'])){?>
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="index.php?act=sns_album<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {?>TA<?php }echo $lang['sns_of_album'];?></a></li>
    </ul><span class="more"><a href="index.php?act=sns_album<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php echo $lang['nc_more'];?></a></span>
  </div>
  <ul class="sns-home-album" >
    <?php foreach($output['pic_list'] as $v){?>
    <li><a href="index.php?act=sns_album&op=album_pic_info&id=<?php echo $v['ap_id'];?>&class_id=<?php echo $v['ac_id']?>&mid=<?php echo $output['master_id'];?><?php if(!empty($_GET['sort'])){?>&sort=<?php echo $_GET['sort']; }?>" title="<?php echo $v['ap_name']?>" style=" background-image:url(<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.str_ireplace('.', '_240.', $v['ap_cover']);?>)"> </a>
      <p><?php echo $lang['sns_upload_time'].$lang['nc_colon'].date("Y-m-d",$v['upload_time'])?> </p>
    </li>
    <?php }?>
  </ul>
  <?php }?>
  <!-- 分享图片 END -->
  <!-- 分享店铺 START -->
  <?php if(!empty($output['storelist'])){?>
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="index.php?act=member_snshome&op=storelist<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {?>TA<?php }echo $lang['sns_share_of_store'];?></a></li>
    </ul>
    <span class="more"><a href="index.php?act=member_snshome&op=storelist<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php echo $lang['nc_more'];?></a></span>
  </div>
  <div class="sns-home-store">
    <ul>
      <?php foreach($output['storelist'] as $k=>$v){?>
      <li id="recordone_<?php echo $v['share_id']; ?>">
        <dl>
          <dt>
            <h3><a href="javascript:void(0)"><?php echo $v['share_membername'];?></a><?php echo date('Y-m-d', $v['share_addtime']);?></h3>
          </dt>
          <dd><i class="pngFix"></i>
            <p><?php echo $v['share_content'] != ''?$v['share_content']:$lang['sns_shared_the_shop'];?><i class="pngFix"></i></p>
          </dd>
          <div class="clear">&nbsp;</div>
        </dl>
        <div class="shop-content">
          <div class="arrow pngFix">&nbsp;</div>
          <div class="info">
            <div class="title"><a title="<?php echo $v['store_name'];?>" href="<?php echo urlShop('show_store', 'index', array('store_id'=>$v['store_id']));?>"><i class="ico" ></i><?php echo $v['store_name'];?></a>
            </div>
          </div>
          <div class="detail">
            <?php if (!empty($v['goods'])){?>
            <ul nc_type="mycarousel" class="jcarousel-skin-tango">
              <?php foreach((array)$v['goods'] as $g_k=>$g_v){?>
              <li><div class="goods-pic"><a href="<?php echo $g_v['goodsurl'];?>" target="_blank" title="<?php echo $g_v['goods_name'];?>"><img alt="<?php echo $g_v['goods_name'];?>" src="<?php echo thumb($g_v,240);?>" /></a></div></li>
              <?php }?>
            </ul>
            <?php }?>
          </div>
          <div style="clear: both;"></div>
        </div>
      </li>
      <?php }?>
    </ul>
  </div>
  <?php }?>
  <!-- 分享店铺 END -->
  <!-- 新鲜事 START -->
  <?php if (!empty($output['tracelist'])){ ?>
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="index.php?act=member_snshome&op=trace<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {?>TA<?php }echo $lang['sns_of_fresh_news'];?></a></li>
    </ul><span class="more"><a href="index.php?act=member_snshome&op=trace<?php if(!empty($output['master_id'])){ echo '&mid='.$output['master_id']; }?>"><?php echo $lang['nc_more'];?></a></span>
  </div>
  <ul class="fd-list" id="friendtrace">
    <?php foreach ($output['tracelist'] as $k=>$v){?>
    <li nc_type="tracerow_<?php echo $v['trace_id']; ?>">
      <dl class="fd-wrap">
        <dt><img src="<?php echo getMemberAvatarForID($v['trace_memberid']);?>"  data-param="{'id':<?php echo $v['trace_memberid'];?>}" nctype="mcard">
          <h3><a href="index.php?act=member_snshome&mid=<?php echo $v['trace_memberid'];?>" target="_blank" data-param="{'id':<?php echo $v['trace_memberid'];?>}" nctype="mcard"><?php echo $v['trace_membername'];?><?php echo $lang['nc_colon'];?></a><?php echo parsesmiles($v['trace_title']);?></h3>
        </dt>
        <dd>
          <?php if ($v['trace_originalid'] > 0 || $v['trace_from'] == '2'){//转帖内容?>
          <div class="fd-forward">
            <?php if ($v['trace_originalstate'] == 1){ echo $lang['sns_trace_originaldeleted'];}else{?>
            <?php echo parsesmiles($v['trace_content']);?>
            <?php if($v['trace_from'] == 'shop'){?>
            <div class="stat"><span><?php echo $lang['sns_original_forward']; ?><?php echo $v['trace_orgcopycount']>0?"({$v['trace_orgcopycount']})":''; ?></span>&nbsp;&nbsp; <span><a href="index.php?act=member_snshome&op=traceinfo&mid=<?php echo $v['trace_originalmemberid'];?>&id=<?php echo $v['trace_originalid'];?>" target="_blank"><?php echo $lang['sns_original_comment']; ?><?php echo $v['trace_orgcommentcount']>0?"({$v['trace_orgcommentcount']})":''; ?></a></span> </div>
            <?php }?>
            <?php }?>
          </div>
          <?php } else {?>
          <?php echo parsesmiles($v['trace_content']);?>
          <?php }?>
        </dd>
        <dd>
          <span class="goods-time fl"><?php echo date('Y-m-d H:i',$v['trace_addtime']);?></span>
          <span class="fl ml10"><?php echo snsShareFrom($v['trace_from']);?></span>
          <span class="fr"><a href="javascript:void(0);" nc_type="fd_forwardbtn" data-param='{"txtid":"<?php echo $v['trace_id'];?>"}'><?php echo $lang['sns_forward']; ?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" nc_type="fd_commentbtn" data-param='{"txtid":"<?php echo $v['trace_id'];?>","mid":"<?php echo $v['trace_memberid'];?>"}'><?php echo $lang['sns_comment']; ?><?php echo $v['trace_commentcount']>0?"({$v['trace_commentcount']})":'';?></a></span>
        </dd>
        <!-- 评论模块start -->
        <div id="tracereply_<?php echo $v['trace_id'];?>" style="display:none;"></div>
        <!-- 评论模块end -->
        <!-- 转发模块start -->
        <div id="forward_<?php echo $v['trace_id'];?>" style="display:none;">
          <div class="forward-widget">
            <div class="forward-edit">
              <form id="forwardform_<?php echo $v['trace_id'];?>" method="post" action="index.php?act=member_snsindex&op=addforward&type=<?php echo $output['type'];?>&irefresh=1">
                <input type="hidden" name="originaltype" value="0"/>
                <input type="hidden" name="originalid" value="<?php echo $v['trace_id'];?>"/>
                <div class="forward-add">
                  <textarea resize="none" id="content_forward<?php echo $v['trace_id'];?>" name="forwardcontent"><?php echo $v['trace_title_forward'];?></textarea>
                  <span class="error"></span>
                  <!-- 验证码 -->
                  <div id="forwardseccode<?php echo $v['trace_id'];?>" class="seccode" style="display: none;">
                    <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon']; ?></label>
                    <input name="captcha" class="text" type="text" size="4" maxlength="4"/>
                    <img src="" title="<?php echo $lang['wrong_checkcode_change']; ?>" name="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/> <span><?php echo $lang['wrong_seccode'];?></span>
                    <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
                  </div>
                  <input type="text" style="display:none;" />
                  <!-- 防止点击Enter键提交 -->
                  <div class="act"> <span class="skin-blue"><span class="btn"><a href="javascript:void(0);" nc_type="forwardbtn" data-param='{"txtid":"<?php echo $v['trace_id'];?>"}'><?php echo $lang['sns_forward'];?></a></span></span> <span id="forwardcharcount<?php echo $v['trace_id'];?>" style="float:right;"></span> <a class="face" nc_type="smiliesbtn" data-param='{"txtid":"forward<?php echo $v['trace_id'];?>"}' href="javascript:void(0);" ><?php echo $lang['sns_smiles'];?></a> </div>
                </div>
              </form>
            </div>
            <ul class="forward-list">
            </ul>
          </div>
        </div>
        <!-- 转发模块end -->
        <div class="clear"></div>
      </dl>
    </li>
    <?php }?>
  </ul>
  <?php }?>
  <!-- 新鲜事 END -->
  <!-- 为空提示 START -->
  <?php if( empty($output['goodslist']) && empty($output['pic_list']) && empty($output['storelist']) && empty($output['tracelist'])){?>
  <div class="sns-norecord"><i class="store-ico pngFix"></i><span><?php echo $lang['sns_regrettably'];?><br />
    <?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {?>TA<?php } echo $lang['sns_of_sns_without_any_share'];?></span></div>
  <?php }?>
  <!-- 为空提示 END -->
</div>
<div class="clear"></div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxdatalazy.js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	//图片轮换
    $('[nc_type="mycarousel"]').jcarousel({visible: 4});
  	//删除分享的店铺
	$("[nc_type='storedelbtn']").live('click',function(){
		var data_str = $(this).attr('data-param');
        eval( "data_str = "+data_str);
        showDialog('<?php echo $lang['nc_common_op_confirm'];?>','confirm', '', function(){
        	ajax_get_confirm('','index.php?act=member_snsindex&op=delstore&id='+data_str.sid);
			return false;
		});
	});
});
</script>
