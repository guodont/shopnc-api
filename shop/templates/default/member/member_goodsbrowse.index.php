<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
.pricetag{
    background-color: #D93600;
    color: #FFFFFF;
    height: 14px;
    line-height: 14px;
    margin-right: 2px;
    padding-bottom: 1px;
    padding-left: 3px;
    padding-right: 3px;
    padding-top: 1px;
    vertical-align: middle;
}
</style>
<div class="wrap">
  <div class="tabmenu">
    <ul id="listpj" class="tab">
      <li class="active"><a href="index.php?act=member_goodsbrowse&op=list">我的足迹</a></li>
    </ul>
    <a class="ncm-btn ncm-btn-red" href="javascript:void(0);" nc_type="delbtn" data-param='{"goods_id":"all"}'><i class="icon-trash"></i>清空全部足迹</a>
  </div>
  
  <div class="ncm-browse">
    <div class="ncm-browse-left">
      <?php if (is_array($output['browselist']) && !empty($output['browselist'])) { ?>
      <ul class="ncm-browse-list">
        <?php foreach ((array)$output['browselist'] as $k=>$v){?>
        <li id="browserow_<?php echo $v['goods_id']; ?>">
          <div class="browse-timeline">&nbsp;</div>
          <div class="browse-time"><?php echo $v['browsetime_text'];?></div>
          <div class="browse-goods">
            <div class="goods-thumb"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$v['goods_id'])); ?>" target="_blank"><img src="<?php echo cthumb($v['goods_image'], 60);?>" /></a> </div>
            <dl class="goods-info">
              <dt><a target="_blank" href="<?php echo urlShop('goods', 'index', array('goods_id'=>$v['goods_id'])); ?>"><?php echo $v['goods_name'];?></a></dt>
              <dd>商城价：
              <!-- <?php if ($v['goods_promotion_type'] == 1){?>
              <span class="pricetag">抢购</span>
              <?php } elseif ($v['goods_promotion_type'] == 2){ ?>
              <span class="pricetag">限时折扣</span>
              <?php }?> -->
              <em class="sale-price"><?php echo $lang['currency'];?><?php echo $v['goods_promotion_price'];?></em>
              <em class="market-price" title="市场价"><?php echo $lang['currency'];?><?php echo $v['goods_marketprice'];?></em>
              </dd>
            </dl>
            <a class="ncm-btn ncm-btn-orange" href="javascript:addcart(<?php echo $v['goods_id'];?>,1,'');"><i class="icon-shopping-cart"></i>加入购物车</a>
            <br/><br/>
            <a class="ncm-btn" href="javascript:void(0);" nc_type="delbtn" data-param='{"goods_id":<?php echo $v['goods_id'];?>}'><i class="icon-trash"></i>删除该记录</a>
         </div>
        </li>
        <?php }?>
      </ul>
      <div class="pagination"><?php echo $output['show_page']; ?></div>
      <?php } else { ?>
      <div class="norecord">
        <div class="warning-option"><i></i><span><?php echo $lang['no_record'];?></span></div>
      </div>
      <?php } ?>
    </div>
    <div class="ncm-browse-class">
      <div class="title"><a href="index.php?act=member_goodsbrowse&op=list" class="<?php echo !$_GET['gc_id']?'selected':''; ?>"> 全部浏览历史</a></div>
      <ul id="sidebarMenu">
        <?php foreach ((array)$output['browseclass_arr'] as $k=>$v){ ?>
        <li class="side-menu"> <a href="index.php?act=member_goodsbrowse&op=list&gc_id=<?php echo $k;?>" class="<?php echo $_GET['gc_id'] == $k?'selected':''; ?>"><i></i><?php echo $v['gc_name'];?></a>
          <ul style="<?php echo $_GET['gc_id'] == $k || in_array($_GET['gc_id'],array_keys($v['sonclass']))?'display: block;':'display: none;'; ?>">
            <?php foreach ($v['sonclass'] as $k_son=>$v_son){ ?>
            <li class="<?php echo $_GET['gc_id'] == $k_son?'selected':''; ?>"><a href="index.php?act=member_goodsbrowse&op=list&gc_id=<?php echo $k_son;?>"><?php echo $v_son['gc_name'];?></a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
<form id="buynow_form" method="post" action="<?php echo SHOP_SITE_URL;?>/index.php" target="_blank">
  <input id="act" name="act" type="hidden" value="buy" />
  <input id="op" name="op" type="hidden" value="buy_step1" />
  <input id="goods_id" name="cart_id[]" type="hidden"/>
</form>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
    $('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        score: function() {
          return $(this).attr('data-score');
        }
    });

   $('a[nctype="nyroModal"]').nyroModal();
   //清除单条浏览记录
   $("[nc_type='delbtn']").bind('click',function(){
	   if(confirm("确实要删除吗？")){
		   var data_str = $(this).attr('data-param');
		   eval( "data_str = "+data_str);
		   $.getJSON('index.php?act=member_goodsbrowse&op=del&goods_id='+data_str.goods_id,function(data){
				if(data.done == true){
					if(data_str.goods_id == 'all'){
						location.reload(true);
					} else {
						$("#browserow_"+data_str.goods_id).hide();
				    }
				}else{
					showDialog(data.msg);
				}
			});
	   }
   });
   
   //立即购买
   $('a[nctype="buy_now"]').click(function(){
       eval('var data_str = ' + $(this).attr('data-param'));
       $("#goods_id").val(data_str.goods_id+'|1');
       $("#buynow_form").submit();
   });
});
</script> 
