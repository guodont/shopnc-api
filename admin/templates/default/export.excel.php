<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo L('download_lang');?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_export'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="tb-type1">
      <tbody>
      <tr><td>&nbsp;</td></tr>
        <tr>
          <td>
          <?php foreach($output['list'] as $k=>$v){?>
          	<a href="index.php?<?php echo $_SERVER['QUERY_STRING'].'&curpage='.$k;?>"><?php echo $lang['nc_download'];?><?php echo $k;?> (<?php echo $v;?>)</a> | 
          <?php }?>
          </td>
        </tr>
    </table>
</div>
