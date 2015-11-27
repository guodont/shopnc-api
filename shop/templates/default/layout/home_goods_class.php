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
	    <ul>
        <?php if (!empty($val['class2']) && is_array($val['class2'])) { ?>
        <?php foreach ($val['class2'] as $k => $v) { ?>
          <li class="twoclass">
		     <ul><a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>"><img src="../data/upload/shop/common/category-pic-<?php echo $v['gc_id'];?>.jpg"></a></ul>		  
             <ul class="twoclasstxt"><?php echo $v['gc_name'];?></ul>
          </li>
        <?php } ?>
        <?php } ?>
		</ul>
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
