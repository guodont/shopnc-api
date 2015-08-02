<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if((!empty($output['bundling_array']) && !empty($output['b_goods_array'])) || !empty($output['gcombo_list'])){?>

<div class="ncs-goods-title-nav" nctype="gbc_nav">
  <ul>
    <?php if ((!empty($output['bundling_array']) && !empty($output['b_goods_array']))) {?>
    <li class="current"><a href="javascript:void(0);">优惠套装</a></li>
    <?php $current = true;}?>
    <?php if (!empty($output['gcombo_list'])) {?>
    <li <?php if (!$current) {?>class="current"<?php }?>><a href="javascript:void(0);">推荐组合</a></li>
    <?php }?>
  </ul>
</div>
<div class="ncs-goods-info-content" nctype="gbc_content">
  <?php if (!empty($output['bundling_array']) && !empty($output['b_goods_array'])) {?>
  <!--S 组合销售 -->
  <div class="ncs-bundling-container">
    <div class="F-center">
      <?php $i=0;foreach($output['bundling_array'] as $val){?>
      <?php if(!empty($output['b_goods_array'][$val['id']]) && is_array($output['b_goods_array'][$val['id']])){$i++;?>
      <div class="ncs-bundling-list">
        <ul>
          <?php ksort($output['b_goods_array'][$val['id']]);foreach($output['b_goods_array'][$val['id']] as $v){?>
          <li>
            <div class="goods-thumb"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['id']));?>" target="block"><img src="<?php echo $v['image'];?>" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>"/></a></div>
            <dl>
              <dt title="<?php echo $v['name'];?>"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['id']));?>" target="block"><?php echo $v['name'];?></a></dt>
              <dd>原&nbsp;&nbsp;&nbsp;&nbsp;价：<em class="o-price"><?php echo $lang['currency'].$v['shop_price'];?></em></dd>
              <dd>优惠价：<em class="b-price"><?php echo $lang['currency'].$v['price'];?></em></dd>
            </dl>
          </li>
          <?php }?>
        </ul>
      </div>
      <div class="ncs-bundling-price">
        <dl>
          <dt><?php echo $val['name'];?></dt>
          <dd class="tcj">原 价：<span><?php echo $lang['currency'].ncPriceFormat($val['cost_price']);?></span></dd>
          <dd class="tcj">套装价：<span><?php echo $lang['currency'].$val['price'];?></span></dd>
          <dd class="js"><?php echo $lang['bundling_save'];?><span><?php echo $lang['currency'].ncPriceFormat(floatval($val['cost_price'])-floatval($val['price']));?></span></dd>
          <?php if ($val['freight'] > 0) {?>
          <dd class="">运&emsp;费：<span><?php echo $lang['currency'].$val['freight'];?></span></dd>
          <?php }?>
          <dd class="mt5"><a href="javascript:void(0);"  nctype="addblcart_submit" bl_id="<?php echo $val['id']?>" class="ncs-btn ncs-btn-red"><i class="icon-th-large"></i><?php echo $lang['bundling_buy'];?></a></dd>
        </dl>
      </div>
      <?php }?>
      <?php }?>
    </div>
    <?php if(count($output['bundling_array']) != 1){?>
    <div class="F-prev">&nbsp;</div>
    <div class="F-next">&nbsp;</div>
    <?php }?>
  </div>
  <!--E 组合销售 --><script>
            $(function(){
            	$('#ncs-bundling').show();
            	$('.ncs-bundling-container').F_slider({len:<?php echo $i;?>});
                $('a[nctype="addblcart_submit"]').click(function(){
                    addblcart($(this).attr('bl_id'));
                 });	
            });
            
            /* add one bundling to cart */ 
            function addblcart(bl_id)
            {
            	<?php if ($_SESSION['is_login'] !== '1'){?>
            	   login_dialog();
                <?php } else {?>
                    var url = 'index.php?act=cart&op=add';
                    $.getJSON(url, {'bl_id':bl_id}, function(data){
                    	if(data != null){
                    		if (data.state)
                            {
                                $('#bold_num').html(data.num);
                                $('#bold_mly').html(price_format(data.amount));
                                $('.ncs-cart-popup').fadeIn('fast');
                                // 头部加载购物车信息
                                load_cart_information();
								$("#rtoolbar_cartlist").load('index.php?act=cart&op=ajax_load&type=html');
                            }
                            else
                            {
                                showDialog(data.msg, 'error','','','','','','','','',2);
                            }
                    	}
                    });
                <?php } ?>
            }
            </script>
  <?php }?>
  <?php if (!empty($output['gcombo_list'])) {?>
  <div class="ncs-combo-container" <?php if ($current) {?>style="display:none;"<?php }?>>
    <div class="default-goods">
      <div class="goods-thumb"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['goods_info']['goods_id']));?>" target="block"><img src="<?php echo thumb($output['goods_info'], 240);?>" title="<?php echo $output['goods_info']['goods_name'];?>" alt="<?php echo $output['goods_info']['goods_name'];?>"/></a></div>
      <dl>
        <dt title="<?php echo $output['goods_info']['goods_name'];?>"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['goods_info']['goods_id']));?>" target="block"><?php echo $output['goods_info']['goods_name'];?></a></dt>
        <dd class="goods-price">商城价<?php echo $lang['nc_colon'].$lang['currency'].$output['goods_info']['goods_promotion_price'];?></dd>
      </dl>
    </div>
    <div class="combo-goods-list" nctype="combo_list">
      <ul>
        <?php $j=0;foreach ($output['gcombo_list'] as $combo) {?>
        <li <?php if ($j == 0) {?>class="combo-goods-first"<?php $j++;}?>>
          <div class="goods-thumb"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $combo['goods_id']));?>" target="block"><img src="<?php echo thumb($combo, 240);?>" title="<?php echo $combo['goods_name'];?>" alt="<?php echo $combo['goods_name'];?>" onload="javascript:DrawImage(this,100,100);" /></a></div>
          <dl>
            <dt title="<?php echo $combo['goods_name'];?>"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $combo['goods_id']));?>" target="block"><?php echo $combo['goods_name'];?></a></dt>
            <dd>
              <input type="checkbox" class="checkbox" nctype="comb"  name="<?php echo $combo['goods_id'];?>" data-param="{price:<?php echo $combo['goods_promotion_price'];?>,marketprice:<?php echo $combo['goods_marketprice'];?>}">
              <?php echo $lang['currency'].$combo['goods_promotion_price'];?></dd>
          </dl>
        </li>
        <?php }?>
      </ul>
    </div>
    <div class="combo-price">
    <dl>
    <dt>推荐购买组合</dt>
    <dd>商城总价：<?php echo $lang['currency'];?><em nctype="gbcc_p"><?php echo $output['goods_info']['goods_promotion_price'];?></em></dd>
    <dd>市场总价：<?php echo $lang['currency'];?><em nctype="gbcc_mp"><?php echo $output['goods_info']['goods_marketprice'];?></em></dd>
    <dd class="mt5"><a class="ncs-btn ncs-btn-red" nctype="addblcart_submit_comb" data-param="<?php echo $comb_ids.$output['goods_info']['goods_id'];?>" href="javascript:void(0);"><i class="icon-th-large"></i><?php echo $lang['bundling_buy'];?></a></dd>
    </dl>
  </div>
  <script type="text/javascript">
  $(function(){
      var g_p = <?php echo $output['goods_info']['goods_promotion_price'];?>;
      var mg_p = <?php echo $output['goods_info']['goods_marketprice'];?>;
      $('div[nctype="combo_list"]').find('input[type="checkbox"]').click(function(){
          var gbcc_p = g_p;
          var gbcc_mp = mg_p;
          $('div[nctype="combo_list"]').find('input[type="checkbox"]:checked').each(function(){
              eval( 'data_str =' + $(this).attr('data-param'));
              gbcc_p += data_str.price;
              gbcc_mp += data_str.marketprice;
          });
          $('em[nctype="gbcc_p"]').html(number_format(gbcc_p,2));
          $('em[nctype="gbcc_mp"]').html(number_format(gbcc_mp,2));
      });
      $('a[nctype="addblcart_submit_comb"]').click(function(){
          addcombcart($(this).attr('data-param'));
       });
});
/* add one bundling to cart */ 
function addcombcart(goods_ids)
{
	var goods_ids = '';
	<?php if ($_SESSION['is_login'] !== '1'){?>
	   login_dialog();
    <?php } else {?>
    $('input[nctype="comb"]').each(function(){
        if ($(this).attr('checked')) {
            goods_ids = goods_ids + $(this).attr('name') + '|';
        }
    });
    goods_ids += '<?php echo $output['goods_info']['goods_id'];?>';
    var url = 'index.php?act=cart&op=add_comb';
    $.getJSON(url, {'goods_ids':goods_ids}, function(data){
    	if(data != null){
    		if (data.state)
            {
                $('#bold_num').html(data.num);
                $('#bold_mly').html(price_format(data.amount));
                $('.ncs-cart-popup').fadeIn('fast');
                // 头部加载购物车信息
                load_cart_information();
				$("#rtoolbar_cartlist").load('index.php?act=cart&op=ajax_load&type=html');
            }
            else
            {
                showDialog(data.msg, 'error','','','','','','','','',2);
            }
    	}
    });
    <?php } ?>
}
            </script>
</div>
</div>
<?php }?>
<script type="text/javascript">
$(function(){
    $('div[nctype="gbc_nav"]').find('li').click(function(){
        $('div[nctype="gbc_nav"]').find('li').removeClass('current');
        $(this).addClass('current');
        $('div[nctype="gbc_content"]').children().hide().eq($(this).index()).show();
    });
});
</script>
<?php }?>
