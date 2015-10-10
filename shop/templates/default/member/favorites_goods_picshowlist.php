<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <table class="ncm-default-table">
    <thead>
      <tr nc_type="table_header">
        <td><input type="checkbox" id="all" class="checkall"/>
          <label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncm-btn-mini" uri="index.php?act=member_favorites&op=delfavorites&type=goods" name="fav_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a>
          <div class="model-switch-btn"><?php echo $lang['favorite_view_mode'].$lang['nc_colon'] ;?><a href="index.php?act=member_favorites&op=fglist&show=list" title="<?php echo $lang['favorite_view_mode_list'];?>"><i class="icon-list"></i></a><a href="index.php?act=member_favorites&op=fglist&show=pic" class="current" title="<?php echo $lang['favorite_view_mode_pic'];?>"><i class="icon-picture"></i></a><a href="index.php?act=member_favorites&op=fglist&show=store" title="<?php echo $lang['favorite_view_mode_shop'];?>"><i class="icon-home"></i></a></div></td>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){ ?>
      <tr>
        <td colspan="2" class="pic-model"><ul>
            <?php foreach($output['favorites_list'] as $key=>$favorites){?>
            <li class="favorite-pic-list">
              <div class="favorite-goods-thumb"><a href="index.php?act=goods&goods_id=<?php echo $favorites['goods']['goods_id'];?>" target="_blank"><img src="<?php echo thumb($favorites['goods'], 240);?>" /></a></div>
              <div class="favorite-goods-info">
                <dl>
                  <dt>
                    <input type="checkbox" class="checkitem" value="<?php echo $favorites['goods']['goods_id'];?>"/>
                    <a href="index.php?act=goods&goods_id=<?php echo $favorites['goods']['goods_id'];?>" target="_blank"><?php echo $favorites['goods']['goods_name'];?></a></dt>
                  <dd><span><strong><?php echo ncPriceFormat($favorites['goods']['goods_price']);?></strong><?php echo $lang['currency_zh'];?></span><a href="javascript:void(0)"  nc_type="sharegoods" data-param='{"gid":"<?php echo $favorites['goods']['goods_id'];?>"}' class="sns-share" title="<?php echo $lang['favorite_snsshare_goods'];?>"><i class="icon-share"></i><?php echo $lang['nc_snsshare'];?></a></dd>
                  <dd><span><?php echo $lang['favorite_selled'].$lang['nc_colon'] ;?><em><?php echo $favorites['goods']['goods_salenum'];?></em><?php echo $lang['piece'];?></span><span>(<em><?php echo $favorites['goods']['evaluation_count'];?></em><?php echo $lang['favorite_number_of_consult'] ;?>)</span><span><?php echo $lang['favorite_popularity'].$lang['nc_colon'];?><?php echo $favorites['goods']['goods_collect'];?></span><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=member_favorites&op=delfavorites&type=goods&fav_id=<?php echo $favorites['fav_id'];?>');" class="ncm-btn-mini" title="<?php echo $lang['nc_del'];?>"><?php echo $lang['nc_del'];?></a></dd>
                  </dd>
                </dl>
              </div>
            </li>
            <?php }?>
          </ul></td>
      </tr>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php }?>
    </tfoot>
  </table>
  
  <!-- 猜你喜欢 -->
  <div id="guesslike_div" style="width:980px;"></div>
  
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" charset="utf-8"></script> 
<script>
//鼠标经过弹出图片信息
$(document).ready(function() {
	$(".favorite-pic-list div").hover(function() {
		$(this).animate({
			"top": "-40px"
		},
		400, "swing");
	},
	function() {
		$(this).stop(true, false).animate({
			"top": "0"
		},
		400, "swing");
	});

	//猜你喜欢
	$('#guesslike_div').load('<?php echo urlShop('search', 'get_guesslike', array()); ?>', function(){
        $(this).show();
    });
});
</script> 
