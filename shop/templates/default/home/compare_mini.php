<?php defined('InShopNC') or exit('Access Invalid!');?>

<ul class="goods-list">
  <?php if($output['compare_list']){ ?>
  <?php foreach($output['compare_list'] as $k=>$v){ ?>
  <li><dl class="goods-info">
    <dt class="goods-pic"> <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name'];?>"> <img src="<?php echo cthumb($v['goods_image'], 240,$v['store_id']);?>" alt="<?php echo $v['goods_name'];?>" title="<?php echo $v['goods_name'];?>"/> </a> </dt>
    <dd class="goods-name"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><?php echo $v['goods_name'];?></a> </dd>
    <dd class="goods-price"><?php echo $lang['currency'].$v['goods_promotion_price'];?><span class="del" onclick="javascript:delCompare(<?php echo $v['goods_id'];?>,'mini');">删除</span></dd> </dl>
  </li>
  <?php } ?>
  <?php } ?>
  <?php if (intval($output['freemaxnum']) > 0){?>
  <?php for ($i=0;$i<$output['freemaxnum'];$i++){ ?>
  <li><div class="no-compare">暂无对比项</div></li>
  <?php } ?>
  <?php }?>
</ul>
<div class="btn-box">
  <?php if(count($output['compare_list'])>1){//如果对比商品大于1件则可以对比按钮可以点击 ?>
  <span style="background-color: #E74649; color: #FFFFFF; cursor: pointer; padding: 5px 10px;" onclick="javascript:window.open('index.php?act=compare&gids=<?php echo $output['goodsid_str'];?>');">对比</span>
  <?php } else {//对比商品小于等于1件则对比按钮不可用 ?>
  <span style=" background-color: #FFFFFF; border: 1px solid #DDDDDD; color: #CCCCCC; padding: 5px 10px; cursor: default;">对比</span>
  <?php }?>
  <span style="background-color: #E6E6E6; cursor: pointer; padding: 5px 10px;" onclick="javascript:delCompare('all','mini');">清空</span> </div>
