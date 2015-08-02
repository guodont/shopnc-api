<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_activity.css" rel="stylesheet" type="text/css">
<script type="text/javascript" >
	$(document).ready(function(){
		$('#sale').children('ul').children('li').bind('mouseenter',function(){
			$('#sale').children('ul').children('li').attr('class','c1');
			$(this).attr('class','c2');
		});
	
		$('#sale').children('ul').children('li').bind('mouseleave',function(){
			$('#sale').children('ul').children('li').attr('class','c1');
		});
})
</script>
<div class="nch-activity">
  <div id="banner_box">
    <div class="pic"><img src="<?php if(is_file(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$output['activity']['activity_banner'])){echo UPLOAD_SITE_URL."/".ATTACH_ACTIVITY."/".$output['activity']['activity_banner'];}else{echo SHOP_TEMPLATES_URL."/images/sale_banner.jpg";}?>"/></div>
    
  </div>
  <div class="sale" id="sale">
    <ul class="list_pic">
      <?php if(is_array($output['list']) and !empty($output['list'])){?>
      <?php foreach ($output['list'] as $v) {?>
      <li class="c1">
        <dl>
          <dt class="goodspic"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$v['goods_id']));?>" target="_blank"><img src="<?php echo thumb($v, 240);?>"/></a></dt>
          <dd class="goodsname"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$v['goods_id']));?>" target="_blank" title="<?php echo $v['goods_name'];?>"><?php echo $v['goods_name'];?></a></dd>
          <dd class="price">
            <h4><?php echo ncPriceFormatForList($v['goods_price']);?></h4>
          </dd>
        </dl>
      </li>
      <?php }?>
      <?php }?>
    </ul>
  </div>
</div>
