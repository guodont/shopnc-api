<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="title">
  <h4>
    <?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {?>TA<?php } echo $lang['sns_of_other']; if($_GET['type'] == 'like'){echo $lang['sns_like']; }else{echo $lang['nc_snsshare']; }?>
  </h4>
  <span><a href="index.php?act=member_snshome&op=shareglist&type=<?php if ($_GET['type'] == 'like'){?>like<?php }else { ?>share<?php } ?>&mid=<?php echo $output['sharegoods_info']['share_memberid'];?>"><?php echo $lang['nc_more'];?></a></span></div>
<div class="side-goodslist">
  <ul>
    <?php if(!empty($output['sharegoods_list'])){?>
    <?php foreach ($output['sharegoods_list'] as $val){?>
    <li>
      <div class="goods-pic"><span class="thumb size75"><i></i><a href="index.php?act=member_snshome&op=goodsinfo<?php if($_GET['type'] == 'like') echo '&type=like';?>&mid=<?php echo $val['share_memberid'];?>&id=<?php echo $val['share_id'];?>" title="<?php echo $val['snsgoods_goodsname']?>"> <img src="<?php echo cthumb($val['snsgoods_goodsimage'], 60,$val['snsgoods_storeid']);?>"/></a></span><em class="price"><?php echo $lang['currency'].$val['snsgoods_goodsprice'];?></em></div>
    </li>
    <?php }?>
    <?php }else{?>
    <li>
      <div><span><?php echo $lang['sns_not_found_other_goods'];?></span></div>
    </li>
    <?php }?>
  </ul>
</div>