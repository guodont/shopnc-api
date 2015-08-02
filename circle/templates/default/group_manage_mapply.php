<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-layout">
  <div class="mainbox">
    <?php include circle_template('group_manage_top');?>
    <table class="base-table-style">
      <thead>
        <tr>
          <th class="w30"></th>
          <th class="tl"><?php echo $lang['circle_member'];?></th>
          <th class="w70"><?php echo $lang['circle_level'];?></th>
          <th class="w70"><?php echo $lang['circle_apply_time'];?></th>
          <th class="w380"><?php echo $lang['circle_apply_reason'];?></th>
          <th class="w120"><?php echo $lang['nc_handle'];?></th>
        </tr>
        <tr>
          <?php if(!empty($output['mapply_list'])){?>
          <td class="tc"><input id="all" class="checkall" type="checkbox" /></td>
          <td colspan="5" class="batches"><label for="all" class="handle-btn"><i class="ac0"></i><?php echo $lang['nc_check_all'];?></label>
            <a href="javascript:void(0);" class="handle-btn" nctype="batchbutton" uri="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_mapply&op=mapply_pass&c_id=<?php echo $output['c_id'];?>" name="cm_id" confirm="<?php echo $lang['circle_manage_confirm_one'].C('circle_managesum').$lang['circle_manage_confirm_two'];?>" title="<?php echo $lang['circle_manage_title'];?>"><i class="ac1"></i><?php echo $lang['circle_pass'];?></a>
            <a href="javascript:void(0);" class="handle-btn" nctype="batchbutton" uri="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_mapply&op=del&c_id=<?php echo $output['c_id'];?>" name="cm_id" confirm="<?php echo $lang['nc_ensure_del'];?>" title="<?php echo $lang['circle_manage_title'];?>"><i class="ac5"></i><?php echo $lang['nc_delete'];?></a>
          <?php }?>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['mapply_list'])){?>
        <?php foreach ($output['mapply_list'] as $val){?>
        <tr>
          <td><input class="checkitem" type="checkbox" value="<?php echo $val['member_id'];?>"></td>
          <td><dl class="member-base"><dt class="member-name"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_snshome&mid=<?php echo $val['member_id'];?>" target="_blank"><?php echo $val['member_name'];?></a><?php echo memberIdentity($val['is_identity']);?></dt><dd class="member-avatar-s"><img src="<?php echo getMemberAvatarForID($val['member_id']);?>" /><?php if($val['is_star']){echo '<dd class="member-star" title="'.$lang['circle_stat_member'].'"></dd>';}?></dd>
          </dl></td>
          <td><?php echo $val['cm_level'];?></td>
          <td><?php echo @date('Y-m-d', $val['mapply_time']);?></td>
          <td class="time"><?php echo $val['mapply_reason'];?></td>
          <td class="handle">
            <a href="javascript:void(0);" onclick="mapplyPass(<?php echo $val['member_id'];?>);"><?php echo $lang['circle_pass'];?></a>
            |&nbsp;<a href="javascript:void(0)" onclick="mapplyDel(<?php echo $val['member_id'];?>);"><?php echo $lang['nc_delete'];?></a>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
          <td colspan="20" class="noborder"><p class="no-record"><?php echo $lang['no_record'];?></p></td>
        </tr>
        <?php }?>
      </tbody>
      <?php if(!empty($output['mapply_list'])){?>
      <tfoot>
        <tr>
          <th class="tc"><input id="all" class="checkall" type="checkbox" /></th>
          <th colspan="20" class="batches"><label for="all" class="handle-btn"><i class="ac0"></i><?php echo $lang['nc_check_all'];?></label>
            <a href="javascript:void(0);" class="handle-btn" nctype="batchbutton" uri="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_mapply&op=mapply_pass&c_id=<?php echo $output['c_id'];?>" name="cm_id" confirm="<?php echo $lang['circle_manage_confirm_one'].C('circle_managesum').$lang['circle_manage_confirm_two'];?>" title="<?php echo $lang['circle_manage_title'];?>"><i class="ac1"></i><?php echo $lang['circle_pass'];?></a>
            <a href="javascript:void(0);" class="handle-btn" nctype="batchbutton" uri="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_mapply&op=del&c_id=<?php echo $output['c_id'];?>" name="cm_id" confirm="<?php echo $lang['nc_ensure_del'];?>" title="<?php echo $lang['circle_manage_title'];?>"><i class="ac5"></i><?php echo $lang['nc_delete'];?></a>
        </tr>
        <tr><td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td></tr>
      </tfoot>
      <?php }?>
    </table>
  </div>
  <div class="sidebar">
    <?php include circle_template('group_manage_sidebar');?>
  </div>
</div>
<script src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/circle_manage.js"></script> 
<script>
function mapplyPass(id){
	showDialog('<?php echo $lang['circle_manage_confirm_one'].C('circle_managesum').$lang['circle_manage_confirm_two'];?>', 'confirm', '', function(){
		_uri = "<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_mapply&op=mapply_pass&c_id=<?php echo $output['c_id'];?>&cm_id="+id;
		ajaxget(_uri);
	});
}

function mapplyDel(id){
	showDialog('<?php echo $lang['nc_ensure_del'];?>', 'confirm', '', function(){
		_uri = "<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_mapply&op=del&c_id=<?php echo $output['c_id'];?>&cm_id="+id;
		ajaxget(_uri);
	});
}
</script>