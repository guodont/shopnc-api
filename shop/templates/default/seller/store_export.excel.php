<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>数据分段下载</h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="tb-type1">
      <tbody>
      <tr><td>&nbsp;</td></tr>
        <tr>
          <td>
          <?php foreach($output['list'] as $k=>$v){?>
          	<a target="_blank" href="index.php?<?php echo $_SERVER['QUERY_STRING'].'&curpage='.$k;?>"><?php echo $lang['nc_download'];?><?php echo $k;?> (<?php echo $v;?>)</a> | 
          <?php }?>
          </td>
        </tr>
    </table>
</div>
