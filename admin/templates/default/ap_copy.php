<?php defined('InShopNC') or exit('Access Invalid!');?>
<dl style="padding:10px 30px;line-height:30px">
<dd>JavaScript:</dd>
  <dd >
    <input type="text" style=" width:400px;" value='<script type="text/javascript" src="<?php echo SHOP_SITE_URL;?>/index.php?act=adv&op=advshow&ap_id=<?php echo $_GET['id'];?>"></script>' />
  </dd>
  <dd>PHP:</dd>
	<input type="text" style=" width:400px;" value='&lt;?php echo loadadv(<?php echo $_GET['id'];?>);?&gt;' />  
  <dd style="border-top: dotted 1px #E7E7E7; color: #F60;"><?php echo $lang['adv_index_copy_to_clip'];?></dd>
</dl>
