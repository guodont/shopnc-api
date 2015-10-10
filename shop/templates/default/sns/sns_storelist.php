<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.jcarousel-container { width: 700px; margin: 10px 0;}
.jcarousel-container .goods-pic { width: 175px; height: 175px;}
.jcarousel-container .goods-pic a { line-height: 0; background-color: #FFF; text-align: center; vertical-align: middle; display: table-cell; *display: block; width: 175px; height: 175px; overflow: hidden;}
.jcarousel-container .goods-pic a img { max-width: 175px; max-height: 175px; margin-top:expression(175-this.height/2); *margin-top:expression(87-this.height/2)/*IE6,7*/;
}
.share-content #mycarousel-g li { width: auto !important;}
</style>
<div class="sns-main-all">
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="javascript:void(0)"><?php echo $lang['sns_share_shop'];?></a></li>
    </ul>
    <?php if($output['relation'] == '3'){?>
   	<div class="release-banner"> <span class="btn"><a href="javascript:void(0);" id="snssharestore">+ <?php echo $lang['sns_sharestore'];?></a></span></div>
    <?php }?>
  </div>

  <!-- 店铺列表 -->
  <div class="shoplist-module" id="shoplist-module">
    <?php if(!empty($output['storelist'])){?>
    <ul>
      <?php foreach($output['storelist'] as $k=>$v){?>
      <li class="shop-item" id="recordone_<?php echo $v['share_id']; ?>">
        <dl>
          <dt>
            <h3><a href="javascript:void(0)"><?php echo $v['share_membername'];?></a><?php echo date('Y-m-d', $v['share_addtime']);?></h3>
            <?php if ($output['relation'] == 3){?>
            <div class="set-btn fr" nc_type="privacydiv"><a href="javascript:void(0)" nc_type="formprivacybtn"><i></i><?php echo $lang['sns_setting'];?></a>
            <ul class="set-menu" nc_type="privacytab" style="display: none;">
              <li nc_type="privacyoption" data-param='{"sid":"<?php echo $v['share_id'];?>","v":"0","op":"store"}'><span class="<?php echo $v['share_privacy']==0?'selected':'';?>"><?php echo $lang['sns_open'];?></span></li>
              <li nc_type="privacyoption" data-param='{"sid":"<?php echo $v['share_id'];?>","v":"1","op":"store"}'><span class="<?php echo $v['share_privacy']==1?'selected':'';?>"><?php echo $lang['sns_friend'];?></span></li>
              <li nc_type="privacyoption" data-param='{"sid":"<?php echo $v['share_id'];?>","v":"2","op":"store"}'><span class="<?php echo $v['share_privacy']==2?'selected':'';?>"><?php echo $lang['sns_privacy'];?></span></li>
              <li nc_type="storedelbtn" data-param='{"sid":"<?php echo $v['share_id'];?>"}'><span class="del"><a href="javascript:void(0);"><?php echo $lang['nc_delete'];?></a></span></li>
            </ul></div>
            <?php }?>
          </dt>
          <dd><i class="pngFix"></i>
            <p><?php echo $v['share_content'] != ''?$v['share_content']:$lang['sns_shared_the_shop'];?><i class="pngFix"></i></p>
          </dd>
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
              <li><div class="goods-pic"><a href="<?php echo $g_v['goodsurl'];?>" target="_blank"><img alt="<?php echo $g_v['goods_name'];?>" src="<?php echo thumb($g_v, 240);?>"/></a></div></li>
              <?php }?>
            </ul>
            <?php }?>
          </div>
          <div class="operate">
            <ul class="status">
              <li>
                <p class="number"><?php echo $v['goods_count'];?></p>
                <p class="kind"><?php echo $lang['sns_sharestore_allgoods'];?></p>
              </li>
              <li>
                <p class="number"><?php echo $v['store_collect'];?></p>
                <p class="kind"><?php echo $lang['sns_sharestore_collectnum'];?></p>
              </li>
            </ul>
            <div class="button"><span><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$v['store_id']));?>"><?php echo $lang['sns_round_store'];?></a></span><span><a href="javascript:collect_store('<?php echo $v['store_id'];?>','count','store_collect')"><?php echo $lang['sns_collect_store'];?></a></span></div>
          </div>
          <div style="clear: both;"></div>
        </div>
      </li>
      <?php }?>
    </ul>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <?php } else{?>
    <?php if ($output['relation'] == 3){?>
    <div class="sns-norecord"><i class="store-ico pngFix"></i><span><?php echo $lang['sns_sharestore_nohave_self_1'];?><a href="index.php?act=member_favorites&op=fslist" target="_blank"><?php echo $lang['sns_sharestore_nohave_self_2'];?></a><?php echo $lang['sns_sharestore_nohave_self_3'];?></span></div>
    <?php }else {?>
    <div class="sns-norecord"><i class="store-ico pngFix"></i><span><?php echo $lang['sns_sharestore_nohave_1'];?>
      </span></div>
    <?php }?>
    <?php }?>
  </div>
  <div class="clear"></div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js"></script>
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

	//显示分享店铺页面
	$('#snssharestore').click(function(){
	    ajax_form("sharestore", '<?php echo $lang['sns_sharestore'];?>', '<?php echo SHOP_SITE_URL.DS;?>index.php?act=member_snsindex&op=sharestore', 480);
	    return false;
	});
});
</script>
