<h3><?php echo $lang['complain_detail'];?></h3>
<h4><?php echo $lang['complain_message'];?></h4>
<dl>
  <dt><?php echo $lang['complain_state'].$lang['nc_colon'];?></dt>
  <dd><?php echo $output['complain_info']['complain_state_text'];?></dd>
  <dt><?php echo $lang['complain_subject_content'].$lang['nc_colon'];?></dt>
  <dd><?php echo $output['complain_info']['complain_subject_content'];?></dd>
  <dt><?php echo $lang['complain_evidence'].$lang['nc_colon'];?></dt>
  <dd>
    <?php
                        if(empty($output['complain_info']['complain_pic1'])&&empty($output['complain_info']['complain_pic2'])&&empty($output['complain_info']['complain_pic3'])) {
                            echo $lang['complain_pic_none'];
                        }
                        else {
                            $pic_link = SHOP_SITE_URL.'/index.php?act=show_pics&type=complain&pics=';
                            if(!empty($output['complain_info']['complain_pic1'])) {
                                $pic_link .= $output['complain_info']['complain_pic1'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic2'])) {
                                $pic_link .= $output['complain_info']['complain_pic2'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic3'])) {
                                $pic_link .= $output['complain_info']['complain_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|');
                    ?>
    <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['complain_pic_view'];?></a>
    <?php } ?>
  </dd>
  <dt><?php echo $lang['complain_datetime'].$lang['nc_colon'];?></dt>
  <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['complain_datetime']);?></dd>
</dl>
<h4><?php echo $lang['complain_goods'];?></h4>
<table class="order ncsc-table-style">
  <thead>
    <tr>
      <th class="w10"></th>
      <th class="w70"></th>
      <th class="tl"><?php echo $lang['complain_goods_name'];?></th>
      <th class="w200"><?php echo $lang['complain_text_num'];?></th>
      <th class="w200"><?php echo $lang['complain_text_price'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach((array)$output['complain_goods_list'] as $complain_goods) { ?>
    <tr>
      <td class="bdl"></td>
      <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$complain_goods['goods_id']));?>" target="_blank"> <img onload="javascript:DrawImage(this,60,60);" src="<?php echo cthumb($complain_goods['goods_image'], 60,$output['order_info']['store_id']);?>"/> </a></span></div></td>
      <td>
        <a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$complain_goods['goods_id']));?>" target="_blank"> <?php echo $complain_goods['goods_name'];?> </a>
        </td>
      <td class="bdl"><?php echo $complain_goods['goods_num'];?></td>
      <td class="bdl bdr"><em class="goods-price"><?php echo $complain_goods['goods_price'];?></em></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20"></td>
    </tr>
  </tfoot>
</table>
<h4><?php echo $lang['complain_content'].$lang['nc_colon'];?></h4>
<dl>
  <dd style="width:90%; padding-left:24px;"><?php echo $output['complain_info']['complain_content'];?></dd>
</dl>
