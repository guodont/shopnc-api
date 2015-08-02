<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_thememanage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_theme&op=theme_list"><span><?php echo $lang['circle_theme_list'];?></span></a></li>
        <li><a href="index.php?act=circle_theme&op=theme_info&t_id=<?php echo $output['t_id'];?>"><span><?php echo $lang['circle_theme_info'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['circle_reply_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
          <ul>
            <li></li>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
  <form method='post'>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="t_id" value="<?php echo $output['t_id'];?>" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['circle_reply_content'];?></th>
          <th><?php echo $lang['circle_member_name'];?></th>
          <th class="align-center"><?php echo $lang['circle_reply_time'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['reply_list']) && is_array($output['reply_list'])){ ?>
        <?php foreach($output['reply_list'] as $val){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="check_reply_id[]" value="<?php echo $val['reply_id'];?>" class="checkitem"></td>
          <td class="w50pre"><?php echo removeUBBTag($val['reply_content']);?></td>
          <td class="align-center"><?php echo $val['member_name'];?></td>
          <td><?php echo @date('Y-m-d H:i', $val['reply_addtime']);?></td>
          <td class="w84"><a href="javascript:void(0);" nctype="replyDetail"><?php echo $lang['circle_reply_check_info'];?></a> | <a href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=circle_theme&op=theme_replydel&t_id=<?php echo $output['t_id'];?>&r_id=<?php echo $val['reply_id'];?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <tr style="display: none">
          <td></td>
          <td colspan="20"><?php echo ubb($val['reply_content']);?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['reply_list']) && is_array($output['reply_list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#submit_type').val('batchdel');$('form:first').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['page'];?></div>
            </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script>
$(function(){
	$('a[nctype="replyDetail"]').toggle(
		function(){
			$(this).parents('tr:first').next().show();
		},function(){
			$(this).parents('tr:first').next().hide();
		}
	);
});
</script>