<?php defined('InShopNC') or exit('Access Invalid!');?>

      <div class="title">
	  <i></i>
        <h3><a href="<?php echo urlShop('category', 'index');?>"><?php echo $lang['nc_all_goods_class'];?></a></h3>
        </div>
      <div class="category">
        <ul class="menu">
          <?php if (!empty($output['show_goods_class']) && is_array($output['show_goods_class'])) { $i = 0; ?>
          <?php foreach ($output['show_goods_class'] as $key => $val) { $i++; ?>
          <li cat_id="<?php echo $val['gc_id'];?>" class="<?php echo $i%2==1 ? 'odd':'even';?>" <?php if($i>8){?>style="display:none;"<?php }?>>
            <div class="class">
              <?php if(!empty($val['pic'])) { ?>
              <span class="ico"><img src="<?php echo $val['pic'];?>"></span>
              <?php } ?>
              <h4><a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_id']));?>"><?php echo $val['gc_name'];?></a></h4>
              <span class="recommend-class">
              <?php if (!empty($val['class3']) && is_array($val['class3'])) { ?>
              <?php foreach ($val['class3'] as $k => $v) { ?>
              <a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>" title="<?php echo $v['gc_name']; ?>"><?php echo $v['gc_name'];?></a>
              <?php } ?>
              <?php } ?>
              </span><span class="arrow"></span> </div>
            <div class="sub-class" cat_menu_id="<?php echo $val['gc_id'];?>">
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
                <?php if (!empty($v['brands']) && is_array($v['brands'])) { $n = 0; ?>
                <dd class="brands-class">
                  <h5><?php echo $lang['nc_brand'].$lang['nc_colon'];?></h5>
                  <?php foreach ($v['brands'] as $k3 => $v3) {
                    if ($n++ < 10) {
                    ?>
                    <a href="<?php echo urlShop('brand','list',array('brand'=> $v3['brand_id'])); ?>"><?php echo $v3['brand_name'];?></a>
                  <?php } ?>
                  <?php } ?>
                </dd>
                <?php } ?>
              </dl>
              <?php } ?>
              <?php } ?>
            </div>
          </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>