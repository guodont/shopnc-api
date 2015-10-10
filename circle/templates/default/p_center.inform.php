<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-layout">
  <div class="mainbox">
    <div class="base-tab-menu">
      <ul class="base-tabs-nav">
        <?php if(!empty($output['member_menu'])){?>
        <?php foreach ($output['member_menu'] as $val){?>
        <li <?php if($val['menu_key'] == $output['menu_key']){?>class="selected"<?php }?>><a href="<?php echo $val['menu_url'];?>"><?php echo $val['menu_name'];?></a></li>
        <?php }?>
        <?php }?>
      </ul>
    </div>
    <table class="base-table-style">
      <thead>
        <tr>
          <th class="w30"></th>
          <th class="tl"><?php echo $lang['circle_inform_info'];?></th>
          <th class="w120"><?php echo $lang['circle_come_from'];?></th>
          <th class="w210"><?php echo $lang['circle_handel_state'];?></th>
          <th class="w120"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['inform_list'])){?>
        <?php foreach ($output['inform_list'] as $val){?>
        <tr>
          <td><input type="checkbox" class="checkitem" name="i_id[]" value="<?php echo $val['inform_id'];?>" /></td>
          <td class="tl">
            <p><b><?php echo $lang['circle_inform_url'].$lang['nc_colon'];?></b><a href="<?php echo $val['url'];?>" target="_blank"><?php echo $val['title'];?></a></p>
            <p><b><?php echo $lang['circle_inform_content'].$lang['nc_colon'];?></b><?php echo $val['inform_content'];?></p>
          </td>
          <td><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name'];?></a></td>
          <td>
            <p><?php echo $lang['circle_handel_state'].$lang['nc_colon'].$val['state'];?></p>
            <?php if($val['inform_state'] != 0){?>
            <p><?php echo $lang['circle_handler'].$lang['nc_colon'].$val['inform_opname'];?></p>
            <p><?php echo $lang['circle_rewards'].$lang['nc_colon']; if($val['inform_opexp'] == '0'){ echo $lang['circle_not_rewards'];}else{ echo $val['inform_opexp'].$lang['circle_inform_exp'];}?></p>
            <p><?php echo $lang['circle_message'].$lang['nc_colon'].$val['inform_opresult'];?></p>
            <?php }?>
          </td>
          
          <td class="handle">
            <a href="javascript:void(0);" onclick="delinform(<?php echo $val['inform_id'];?>);"><?php echo $lang['nc_delete'];?></a>
          </td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
          <td colspan="20" class="noborder"><p class="no-record"><?php echo $lang['no_record'];?></p></td>
        </tr>
        <?php }?>
      </tbody>
      <?php if(!empty($output['inform_list'])){?>
      <tfoot>
        <tr>
          <th class="tc"><input id="all" class="checkall" type="checkbox" /></th>
          <th colspan="20"><label for="all" class="handle-btn"><i class="ac0"></i><?php echo $lang['nc_check_all'];?></label>
            <a href="javascript:void(0);" class="handle-btn" nctype="batchbutton" uri="<?php echo CIRCLE_SITE_URL;?>/index.php?act=p_center&op=delinform" name="i_id" confirm="<?php echo $lang['nc_ensure_del'];?>" title="<?php echo $lang['nc_delete'];?>"><i class="ac5"></i><?php echo $lang['nc_delete'];?></a>
          </th>
        </tr>
        <tr><td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td></tr>
      </tfoot>
      <?php }?>
    </table>
  </div>
  <?php include circle_template('p_center.sidebar');?>
</div>
<script src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/circle_manage.js"></script>
<script type="text/javascript">
function delinform(i_id){
	showDialog('<?php echo $lang['nc_ensure_del'];?>', 'confirm', '', function(){
		_uri = CIRCLE_SITE_URL+'/index.php?act=p_center&op=delinform&i_id='+i_id;
		ajaxget(_uri);
	});
}
</script>