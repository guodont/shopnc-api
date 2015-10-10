<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
h3 { margin-top:0;
}
</style>
<dl>
  <dt style="padding:10px 30px;">
    <input type="text" style="width:400px;" value="&lt;?php echo rec(<?php echo $_GET['rec_id'];?>);?&gt;">
  </dt>
  <dd style="border-top: dotted 1px #E7E7E7; padding:10px 30px; color: #F60;"><?php echo $lang['rec_ps_copy_clip'];?></dd>
</dl>