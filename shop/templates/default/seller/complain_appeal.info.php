
<h3><?php echo $lang['complain_appeal_detail'];?></h3>
<h4><?php echo $lang['complain_appeal_message'];?></h4>
<dl>
  <dt><?php echo $lang['complain_appeal_evidence'].$lang['nc_colon'];?></dt>
  <dd>
    <?php
                        if(empty($output['complain_info']['appeal_pic1'])&&empty($output['complain_info']['appeal_pic2'])&&empty($output['complain_info']['appeal_pic3'])) {
                            echo $lang['complain_pic_none'];
                        }
                        else {
                            $pic_link = SHOP_SITE_URL.'/index.php?act=show_pics&type=complain&pics=';
                            if(!empty($output['complain_info']['appeal_pic1'])) {
                                $pic_link .= $output['complain_info']['appeal_pic1'].'|';
                            }
                            if(!empty($output['complain_info']['appeal_pic2'])) {
                                $pic_link .= $output['complain_info']['appeal_pic2'].'|';
                            }
                            if(!empty($output['complain_info']['appeal_pic3'])) {
                                $pic_link .= $output['complain_info']['appeal_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|');
                    ?>
    <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['complain_pic_view'];?></a>
    <?php } ?>
  </dd>
  <dt><?php echo $lang['complain_appeal_datetime'].$lang['nc_colon'];?></dt>
  <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['appeal_datetime']);?></dd>
</dl>
<h4><?php echo $lang['complain_appeal_content'];?></h4>
<dl>
  <dd style="width:90%; padding-left:24px;"><?php echo $output['complain_info']['appeal_message'];?></dd>
</dl>
