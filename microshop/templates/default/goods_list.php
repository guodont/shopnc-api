<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
	$("#gc-id1").show();
});
</script>

<div class="commend-class">
  <ul class="commend-class-root pngFix">
    <?php if(!empty($output['goods_class_root']) && is_array($output['goods_class_root'])) {?>
    <?php foreach($output['goods_class_root'] as $key=>$val) {?>
    <li <?php if($output['goods_class_root_id'] == $val['class_id'])  {echo "class='selected pngFix'";} else {echo "class='pngFix'";}?>>
   <a href="index.php?act=goods&goods_class_root_id=<?php echo $val['class_id'];?>" class="pngFix">
      <?php if(empty($val['class_image'])) $val['class_image'] = 'default_goods_class_image.gif' ?>
      <div class="picture"><img src="<?php echo MICROSHOP_IMG_URL.DS.$val['class_image'];?>" class="pngFix" alt="" onload="javascript:DrawImage(this,30,30);"/></div>
      <h3><?php echo $val['class_name'];?></h3>
      </a> </li>
    <?php } ?>
    <?php } ?>
    <div class="clear"></div>
  </ul>
  <ul class="commend-class-menu">
    <?php if(!empty($output['goods_class_menu']) && is_array($output['goods_class_menu'])) {?>
    <?php foreach($output['goods_class_menu'] as $key=>$val) {?>
    <li>
      <div class="commend-class-menu-img"><span class="thumb size60"><i></i>
        <?php if(empty($val['class_image'])) $val['class_image'] = 'default_goods_class_image.gif' ?>
        <a <?php if($output['goods_class_menu_id'] == $val['class_id']) echo "class='selected'";?> href="index.php?act=goods&goods_class_root_id=<?php echo $output['goods_class_root_id'];?>&goods_class_menu_id=<?php echo $val['class_id'];?>"> <img src="<?php echo MICROSHOP_IMG_URL.DS.$val['class_image'];?>" alt=""  onload="javascript:DrawImage(this,60,60);"/> </a></span> </div>
      <div class="commend-class-menu-item">
        <dt><a <?php if($output['goods_class_menu_id'] == $val['class_id'] && empty($_GET['keyword'])) echo "class='selected'";?> href="index.php?act=goods&goods_class_root_id=<?php echo $output['goods_class_root_id'];?>&goods_class_menu_id=<?php echo $val['class_id'];?>"><?php echo $val['class_name'];?></a></dt>
        <?php if(!empty($val['class_keyword'])) {?>
        <?php $goods_class_keyword_array = explode(',',$val['class_keyword']);?>
        <span class="cover ">&nbsp;</span>
        <?php foreach($goods_class_keyword_array as $key1=>$val1) {?>
        <dd><a <?php if($_GET['keyword'] == ltrim($val1,'*')) { echo "class='selected'";} elseif(substr($val1,0,1) == '*') { echo "class='highlight'";}?> href="index.php?act=goods&goods_class_root_id=<?php echo $output['goods_class_root_id'];?>&goods_class_menu_id=<?php echo $val['class_id'];?>&keyword=<?php echo ltrim($val1,'*');?>"><?php echo ltrim($val1,'*');?></a></dd>
        <?php } ?>
        <?php } ?>
      </div>
    </li>
    <?php } ?>
    <?php } ?>
    <div class="clear"></div>
  </ul>
</div>
<!-- 排序 -->
<?php if(!empty($output['list']) && is_array($output['list'])) {?>
<div class="microshop-order"><span><?php echo $lang['microshop_text_order'].$lang['nc_colon'];?></span>
  <ul>
    <li class="l"><a <?php if($_GET['order'] == 'new' || empty($_GET['order'])) echo "class='selected'";?> href="index.php?act=goods&goods_class_root_id=<?php echo $output['goods_class_root_id'];?>&goods_class_menu_id=<?php echo $output['goods_class_menu_id'];?>&order=new"><?php echo $lang['microshop_text_new'];?></a></li>
    <li class="r"><a <?php if($_GET['order'] == 'hot') echo "class='selected'";?> href="index.php?act=goods&goods_class_root_id=<?php echo $output['goods_class_root_id'];?>&goods_class_menu_id=<?php echo $output['goods_class_menu_id'];?>&order=hot"><?php echo $lang['microshop_text_hot'];?></a></li>
  </ul>
</div>
<?php } ?>
<?php require('widget_goods_list.php');






