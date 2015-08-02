<?php defined('InShopNC') or exit('Access Invalid!');?>

    <ul class="tabs-nav">
                  <?php if (!empty($output['code_sale_list']['code_info']) && is_array($output['code_sale_list']['code_info'])) { 
                    $i = 0;
                    ?>
                  <?php foreach ($output['code_sale_list']['code_info'] as $key => $val) { 
                    $i++;
                    ?>
        <li class="<?php echo $i==1 ? 'tabs-selected':'';?>"><i class="arrow"></i><h3><?php echo $val['recommend']['name'];?></h3></li>
                  <?php } ?>
                  <?php } ?>
    </ul>
                  <?php if (!empty($output['code_sale_list']['code_info']) && is_array($output['code_sale_list']['code_info'])) { 
                    $i = 0;
                    ?>
                  <?php foreach ($output['code_sale_list']['code_info'] as $key => $val) { 
                    $i++;
                    ?>
                          <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
                                  <div class="tabs-panel sale-goods-list <?php echo $i==1 ? '':'tabs-hide';?>">
                                    <ul>
                                    <?php foreach($val['goods_list'] as $k => $v){ ?>
                                      <li>
                                        <dl>
                                          <dt class="goods-name"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id'])); ?>" title="<?php echo $v['goods_name']; ?>">
                                          	<?php echo $v['goods_name']; ?></a></dt>
                                          <dd class="goods-thumb">
                                          	<a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id'])); ?>">
                                          	<img src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>" alt="<?php echo $v['goods_name']; ?>" />
                                          	</a></dd>
                                          <dd class="goods-price"><?php echo $lang['index_index_store_goods_price'].$lang['nc_colon'];?><em><?php echo ncPriceFormatForList($v['goods_price']); ?></em></dd>
                                        </dl>
                                      </li>
                                    <?php } ?>
                                    </ul>
                                  </div>
                          <?php } ?>
                  <?php } ?>
                  <?php } ?>