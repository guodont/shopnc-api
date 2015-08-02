<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-layout">
  <div class="mainbox">
    <form method="post" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_inform&op=inform&c_id=<?php echo $output['c_id'];?>" id="inform_form" onsubmit="ajaxpost('inform_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_inform&op=inform&c_id=<?php echo $output['c_id'];?>', '', 'onerror');">
      <input type="hidden" name="form_submit" value="ok" />
      <?php include circle_template('group_manage_top');?>
      <table class="base-table-style">
        <thead>
          <tr>
            <th class="w30"></th>
            <th class="tl"><?php echo $lang['circle_inform_info'];?></th>
            <th class="w120"><?php echo $lang['circle_informer'];?></th>
            <th class="w120"><?php echo $lang['circle_handle'];?></th>
          </tr>
          <tr>
            <td class="tc"><input id="all" class="checkall" type="checkbox" /></td>
            <td colspan="20"><label for="all" class="handle-btn"><i class="ac0"></i><?php echo $lang['nc_check_all'];?></label>
              <a href="javascript:void(0);" class="handle-btn" nctype="batchHandle"><i class="ac10"></i><?php echo $lang['circle_handle'];?></a></td>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($output['inform_list'])){?>
          <?php foreach ($output['inform_list'] as $val){?>
          <tr>
            <td><input type="checkbox" class="checkitem" name="i_id[]" value="<?php echo $val['inform_id'];?>" /></td>
            <td class="tl"><dl class="inform"><dt><strong><?php echo $lang['circle_inform_url'].$lang['nc_colon'];?></strong><a href="<?php echo $val['url'];?>" target="_blank"><?php echo $val['title'];?></a></dt>
            <dd><strong><?php echo $lang['circle_inform_content'].$lang['nc_colon'];?></strong><span class="tip" title="<?php echo $val['inform_content'];?>"><?php echo $val['inform_content'];?></span></dd></dl></td>
            <td><?php echo $val['member_name'];?></td>
            <td><?php echo $lang['circle_rewards'].$lang['nc_colon'];?>
                <select name="i_rewards[<?php echo $val['inform_id'];?>]">
                  <option value="3">+3</option>
                  <option value="2">+2</option>
                  <option value="1">+1</option>
                  <option value="0" selected="selected"><?php echo $lang['circle_no_rewards'];?></option>
                  <option value="-1">-1</option>
                  <option value="-2">-2</option>
                  <option value="-3">-3</option>
                </select>
              </td>
          </tr>
          <tr>
            <td colspan="4" class="inform-note">
              <strong><?php echo $lang['circle_message'].$lang['nc_colon'].$val['inform_opresult'];?></strong><input type="text" class="text w600" placeholder="可以在这里输入对此次举报的处理原因、结果或其它意见给被举报人" name="i_result[<?php echo $val['inform_id'];?>]" />            </td>
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
              <a href="javascript:void(0);" class="handle-btn" nctype="batchHandle"><i class="ac10"></i><?php echo $lang['circle_handle'];?></a> </th>
          </tr>
          <tr>
            <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
          </tr>
        </tfoot>
        <?php }?>
      </table>
    </form>
  </div>
  <div class="sidebar">
    <?php include circle_template('group_manage_sidebar');?>
  </div>
</div>
<script src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/circle_manage.js"></script> 
<script>
$(function(){
	$('a[nctype="batchHandle"]').click(function(){
		if($('.checkitem:checked').length == 0){    // no choice
            return false;
        }
		$('#inform_form').submit();
	});
});
//Ajax提示
$(function(){
	$('.tip').poshytip({
		className: 'tip-yellowsimple',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'center',
		alignY: 'top',
		offsetY: 5,
		allowTipHover: false
	});
});
</script>