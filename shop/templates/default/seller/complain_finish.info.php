
<h3><?php echo $lang['final_handle_detail'];?></h3>
<h4><?php echo $lang['final_handle_message'];?></h4>
<dl>
  <dd><?php echo $output['complain_info']['final_handle_message'];?>&nbsp;
    (<?php echo $lang['final_handle_datetime'].$lang['nc_colon'];?>
    <?php echo date('Y-m-d H:i:s',$output['complain_info']['final_handle_datetime']);?>)</dd>
</dl>
