<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="personal-class">
  <ul>
    <?php if(!empty($output['class_list']) && is_array($output['class_list'])) {?>
    <?php foreach($output['class_list'] as $key=>$val) {?>
    <li><a <?php if($_GET['class_id'] == $val['class_id']) {echo "class='selected pngFix'";} else {echo "class='pngFix'";}?> href="index.php?act=personal&class_id=<?php echo $val['class_id'];?>">
      <div class="picture"><span class="thumb size30"> <i></i>
        <?php if(empty($val['class_image'])) $val['class_image'] = 'default_goods_class_image.gif' ?>
        <img src="<?php echo MICROSHOP_IMG_URL.DS.$val['class_image'];?>" alt=""  onload="javascript:DrawImage(this,30,30);"/></span></div>
      <h3><?php echo $val['class_name'];?></h3>
      </a> </li>
    <?php } ?>
    <?php } ?>
    <div class="clear"></div>
  </ul>
</div>
<!-- 排序 -->
<?php if(!empty($output['list']) && is_array($output['list'])) {?>
<div class="microshop-order"><span><?php echo $lang['microshop_text_order'].$lang['nc_colon'];?></span>
  <ul>
    <li class="l"><a <?php if($_GET['order'] == 'new' || empty($_GET['order'])) echo "class='selected'";?> href="index.php?act=personal&class_id=<?php echo $_GET['class_id'];?>&order=new"><?php echo $lang['microshop_text_new'];?></a></li>
    <li class="r"><a <?php if($_GET['order'] == 'hot') echo "class='selected'";?> href="index.php?act=personal&class_id=<?php echo $_GET['class_id'];?>&order=hot"><?php echo $lang['microshop_text_hot'];?></a></li>
  </ul>
</div>
<?php } ?>
<?php require('widget_personal_list.php');





