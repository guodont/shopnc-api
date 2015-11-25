<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="title"> <i></i>
  <h3><a href="<?php echo urlShop('category', 'index');?>"><?php echo $lang['nc_all_goods_class'];?></a></h3>
</div>
<div class="category">
  <ul class="menu">
    <?php if (!empty($output['show_goods_class']) && is_array($output['show_goods_class'])) { $i = 0; ?>
    <?php foreach ($output['show_goods_class'] as $key => $val) { $i++; ?>
    <li cat_id="<?php echo $val['gc_id'];?>" class="<?php echo $i%2==1 ? 'odd':'even';?>" <?php if($i>14){?>style="display:none;"<?php }?>>
      <div class="class">
        <?php if(!empty($val['pic'])) { ?>
        <span class="ico"><img src="<?php echo $val['pic'];?>"></span>
        <?php } ?>
        <h4><a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_id']));?>"><?php echo $val['gc_name'];?></a></h4>
        <span class="arrow"></span> </div>
      <div class="sub-class" cat_menu_id="<?php echo $val['gc_id'];?>">
      <div class="sub-class-content">
        <div class="recommend-class">
          <?php if (!empty($val['class3']) && is_array($val['class3'])) { ?>
          <?php foreach ($val['class3'] as $k => $v) { ?>
          <span><a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>" title="<?php echo $v['gc_name']; ?>"><?php echo $v['gc_name'];?></a></span>
          <?php } ?>
          <?php } ?>
        </div>
        <?php if (!empty($val['class2']) && is_array($val['class2'])) { ?>
        <?php foreach ($val['class2'] as $k => $v) { ?>
        <dl>
          <dt>
            <h3><a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>"><?php echo $v['gc_name'];?></a></h3>
          </dt>
          <dd class="goods-class">
            <?php if (!empty($v['class3']) && is_array($v['class3'])) { ?>
            <?php foreach ($v['class3'] as $k3 => $v3) { ?>
            <a href="<?php echo urlShop('search','index',array('cate_id'=> $v3['gc_id']));?>"><?php echo $v3['gc_name'];?></a>
            <?php } ?>
            <?php } ?>
          </dd>
        </dl>
        <?php } ?>
        <?php } ?>
        </div>
        <div class="sub-class-right">
          <div class="brands-list">
            <?php $rec_brand = Model('brand')->table('brand')->where(array('brand_recommend'=>1,'class_id'=>$val['gc_id']))->select();?>
            <?php if (!empty($rec_brand) && is_array($rec_brand)) { $n = 0; ?>
            <ul>
              <?php foreach ($rec_brand as $keys => $brand) {
				     if ($n++ < 10) {
				  ?>
              <li> <a title="<?php echo $brand['brand_name'];?>" href="<?php echo urlShop('brand','list',array('brand'=> $brand['brand_id'])); ?>"><img width="90" alt="<?php echo $brand['brand_name'];?>" heiht="30" src="<?php echo brandImage($brand['brand_pic']);?>"><span><?php echo $brand['brand_name'];?></span></a></li>
              <?php } ?>
              <?php } ?>
            </ul>
            <?php } ?>
          </div>
          <div class="adv-promotions"><!--目前没加上广告位--></div>
        </div>
      </div>
    </li>
    <?php } ?>
    <?php } ?>
  </ul>
</div>
