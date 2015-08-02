<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['complain_appeal_detail'];?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th><?php echo $lang['complain_appeal_message'];?></th>
    </tr>
    <tr class="noborder">
      <td><ul>
          <li><strong><?php echo $lang['complain_accused'];?>:</strong><?php echo $output['complain_info']['accused_name'];?></li>
          <li><strong><?php echo $lang['complain_appeal_evidence'];?>:</strong>
            <?php
                        if(empty($output['complain_info']['appeal_pic1'])&&empty($output['complain_info']['appeal_pic2'])&&empty($output['complain_info']['appeal_pic3'])) {
                            echo $lang['complain_pic_none'];
                        }
                        else {
                            $pic_link = 'index.php?act=show_pics&type=complain&pics=';
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
          </li>
          <li><strong><?php echo $lang['complain_appeal_datetime'];?>:</strong><?php echo date('Y-m-d H:i:s',$output['complain_info']['appeal_datetime']);?></li>
        </ul></td>
    </tr>
    <tr>
      <th><?php echo $lang['complain_appeal_content'];?></th>
    </tr>
    <tr class="noborder">
      <td><?php echo $output['complain_info']['appeal_message'];?></td>
    </tr>
  </tbody>
</table>
