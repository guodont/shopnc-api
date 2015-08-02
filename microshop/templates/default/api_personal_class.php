<?php defined('InShopNC') or exit('Access Invalid!');?>
<ul>
    <?php if(!empty($output['class_list']) && is_array($output['class_list'])) {?>
    <?php foreach($output['class_list'] as $key=>$val) {?>
    <li>
    <a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=personal&class_id=<?php echo $val['class_id'];?>" target="_blank"><?php echo $val['class_name'];?></a>
    </li>
    <?php } ?>
    <?php } ?>
</ul>
