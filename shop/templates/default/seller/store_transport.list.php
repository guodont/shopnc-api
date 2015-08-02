<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <a class="ncsc-btn ncsc-btn-green" href="index.php?act=store_transport&op=add&type=<?php echo $_GET['type'];?>"><?php echo $lang['transport_tpl_add'];?> </a> </div>
<!-----------------list begin------------------------>
<?php if (is_array($output['list'])){?>
<table class="ncsc-default-table order">
  <thead>
    <tr>
      <th class="w120"><?php echo $lang['transport_type'];?></th>
      <th class="cell-area tl"><?php echo $lang['transport_to'];?></th>
      <th class="w100"><?php echo $lang['transport_snum'];?></th>
      <th class="w100"><?php echo $lang['transport_price'];?></th>
      <th class="w100"><?php echo $lang['transport_xnum'];?></th>
      <th class="w100"><?php echo $lang['transport_price'];?></th>
    </tr>
  </thead>
  <?php foreach ($output['list'] as $v){?>
  <tbody>
    <tr>
      <td colspan="20" class="sep-row"></td>
    </tr>
    <tr>
      <th colspan="20"><?php if ($_GET['type'] == "select"){?>
        <a class="ml5 ncsc-btn-mini ncsc-btn-orange" data-param="{name:'<?php echo $v['title'];?>',id:'<?php echo $v['id'];?>',price:'<?php echo intval($output['extend'][$v['id']]['price']);?>'}" href="javascript:void(0)"><i class="icon-truck"></i><?php echo $lang['transport_applay'];?></span></a>
        <?php }?><h3><?php echo $v['title'];?></h3>
        
        <span class="fr mr5">
        <time title="<?php echo $lang['transport_tpl_edit_time'];?>"><i class="icon-time"></i><?php echo date('Y-m-d H:i:s',$v['update_time']);?></time>
        <a class="J_Clone ncsc-btn-mini" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><i class="icon-copy"></i><?php echo $lang['transport_tpl_copy'];?></a> <a class="J_Modify ncsc-btn-mini" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><i class="icon-edit"></i><?php echo $lang['transport_tpl_edit'];?></a> <a class="J_Delete ncsc-btn-mini" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><i class="icon-trash"></i><?php echo $lang['transport_tpl_del'];?></a></span></th>
    </tr>
    <?php if (is_array($output['extend'][$v['id']]['data'])){?>
    <?php foreach ($output['extend'][$v['id']]['data'] as $value){?>
    <tr>
      <td class="bdl"><?php echo str_replace(array('kd','py','es'),array($lang['transport_type_kd'],$lang['transport_type_py'],'EMS'),$value['type']);?></td>
      <td class="cell-area tl"><?php echo $value['area_name'];?></td>
      <td><?php echo $value['snum'];?></td>
      <td><?php echo $value['sprice'];?></td>
      <td><?php echo $value['xnum'];?></td>
      <td class="bdr"><?php echo $value['xprice'];?></td>
    </tr>
    <?php }?>
    <?php }?>
  </tbody>
  <?php }?>
</table>
<?php } else {?>
<div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div>
<?php } ?>
<?php if (is_array($output['list'])){?>
<div class="pagination"><?php echo $output['show_page']; ?></div>
<?php }?>
<!-----------------list end-----------------------> 

<script>
$(function(){	
	$('a[class="J_Delete ncsc-btn-mini"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		get_confirm('<?php echo $lang['transport_del_confirm'];?>','<?php echo SHOP_SITE_URL;?>/index.php?act=store_transport&op=delete&type=<?php echo $_GET['type'];?>&id='+id);
//		$(this).attr('href','<?php echo SHOP_SITE_URL;?>/index.php?act=transport&op=delete&type=<?php echo $_GET['type'];?>&id='+id);
//		return true;
	});

	$('a[class="J_Modify ncsc-btn-mini"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		$(this).attr('href','<?php echo SHOP_SITE_URL;?>/index.php?act=store_transport&op=edit&type=<?php echo $_GET['type'];?>&id='+id);
		return true;
	});
	
	$('a[class="J_Clone ncsc-btn-mini"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		$(this).attr('href','<?php echo SHOP_SITE_URL;?>/index.php?act=store_transport&op=clone&type=<?php echo $_GET['type'];?>&id='+id);
		return true;
	});
	$('a[class="ml5 ncsc-btn-mini ncsc-btn-orange"]').click(function(){
		var data_str = '';
		eval('data_str = ' + $(this).attr('data-param'));
		$("#postageName", opener.document).css('display','inline-block').html(data_str.name);
		$("#transport_title", opener.document).val(data_str.name);
		$("#transport_id", opener.document).val(data_str.id);
		$("#g_freight", opener.document).val(data_str.price);
		window.close();
	});	

});
</script>