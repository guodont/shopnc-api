<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-layout">
  <div class="mainbox">
    <?php include circle_template('group_manage_top');?>
    <table class="base-table-style">
      <thead>
        <tr>
          <th class="w30"></th>
          <th class="tl"><?php echo $lang['nc_name'];?></th>
          <th class="w120"><?php echo $lang['nc_sort'];?></th>
          <th class="w120"><?php echo $lang['nc_status'];?></th>
          <th class="w120"><?php echo $lang['nc_handle'];?></th>
        </tr>
        <tr>
          <?php if(!empty($output['thclass_list'])){?>
          <td class="tc"><input id="all" class="checkall" type="checkbox" /></td>
          <td colspan="3"><label for="all" class="handle-btn"><i class="ac0"></i><?php echo $lang['nc_check_all'];?></label>
            <a href="javascript:void(0);" class="handle-btn" nctype="batchbutton" uri="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=class_del&c_id=<?php echo $output['c_id'];?>" name="thc_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><i class="ac5"></i><?php echo $lang['nc_delete'];?></a></td>
          <?php }?>
          <td colspan="20" class="tr"><?php if(count($output['thclass_list']) <10){?><a href="javascript:void(0);" nctype="add_thclass" class="add-group-class-btn mr10"><?php echo $lang['circle_tclass_add'];?></a><?php }else{echo $lang['circle_tclass_add_max_10'];}?></td>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['thclass_list'])){?>
        <?php foreach ($output['thclass_list'] as $val){?>
        <tr>
          <td><input type="checkbox" class="checkitem" value="<?php echo $val['thclass_id'];?>" /></td>
          <td class="tl"><?php echo $val['thclass_name'];?></td>
          <td><?php echo $val['thclass_sort'];?></td>
          <td><?php if($val['thclass_status'] == 1){echo $lang['nc_open'];}else{echo $lang['nc_close'];}?></td>
          <td class="handle"><a href="javascript:void(0);" onclick="edit_thclass(<?php echo $val['thclass_id'];?>)"><?php echo $lang['nc_edit'];?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="del_thclass(<?php echo $val['thclass_id'];?>)"><?php echo $lang['nc_delete'];?></a></td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
          <td colspan="20" class="noborder"><p class="no-record"><?php echo $lang['no_record'];?></p></td>
        </tr>
        <?php }?>
      </tbody>
      <?php if(!empty($output['thclass_list'])){?>
      <tfoot>
        <tr>
          <th class="tc"><input id="all" class="checkall" type="checkbox" /></th>
          <th colspan="20"><label for="all" class="handle-btn"><i class="ac0"></i><?php echo $lang['nc_check_all'];?></label>
            <a href="javascript:void(0);" class="handle-btn" nctype="batchbutton" uri="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=class_del&c_id=<?php echo $output['c_id'];?>" name="thc_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><i class="ac5"></i><?php echo $lang['nc_delete'];?></a> </th>
        </tr>
      </tfoot>
      <?php }?>
    </table>
  </div>
  <div class="sidebar">
    <?php include circle_template('group_manage_sidebar');?>
  </div>
</div>
<script src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/circle_manage.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script>
$(function(){
    // 添加分类
    $('a[nctype="add_thclass"]').click(function(){
    	_uri = "<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=class_add&inajax=1&c_id=<?php echo $output['c_id'];?>";
    	CUR_DIALOG = ajax_form('add_thclass', '<?php echo $lang['circle_tclass_add'];?>', _uri, 520);
	});
});
function edit_thclass(id){
	_uri = "<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=class_edit&inajax=1&c_id=<?php echo $output['c_id'];?>&thc_id="+id;
	CUR_DIALOG = ajax_form('edit_thclass', '<?php echo $lang['circle_tclass_edit'];?>', _uri, 520);
}
function del_thclass(id){
	showDialog('<?php echo $lang['nc_ensure_del'];?>', 'confirm', '', function(){
		_uri = "<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=class_del&inajax=1&c_id=<?php echo $output['c_id'];?>&thc_id="+id;
		ajaxget(_uri);
	});
}
</script>