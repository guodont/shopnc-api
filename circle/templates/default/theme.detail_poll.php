<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['option_list'])){?>

<div class="theme-detail-poll-content">
  <form method="post" id="poll_form" <?php if(!$output['vote_end'] && !$output['partake']){?>action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=save_votepoll&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id'];?>"<?php }?>>
    <input type="hidden" name="form_submit" value="ok" />
    <div class="poll-option-info">
      <h4>
        <?php if($output['poll_info']['poll_multiple'] == 1){echo $lang['circle_checkbox_poll'];}else{echo $lang['circle_radio_poll'];}?>
      </h4>
      <?php echo $lang['circle_owned_by_all'];?><em><?php echo $output['poll_info']['poll_voters'];?></em><?php echo $lang['circle_participate_in_the_vote'];?>
      <h5>
        <?php if($output['vote_end']){echo $lang['circle_poll_ends'];}else if($output['partake']){echo $lang['circle_have_to_vote'];}?>
      </h5>
    </div>
    <table width="100%" border=0 cellpadding="0" cellspacing="0">
      <?php $i = 0;foreach ($output['option_list'] as $val){ $i++;?>
      <tr>
        <td class="w20"><?php if($output['poll_info']['poll_multiple'] == 1){?>
          <input type="checkbox" name="pollopid[]" value="<?php echo $val['pollop_id'];?>" <?php if($output['vote_end'] || $output['partake'] || !in_array($output['identity'], array(1,2,3))){?>disabled="disabled"<?php }?> />
          <?php }else{?>
          <input type="radio" name="pollopid[]" value="<?php echo $val['pollop_id'];?>" <?php if($output['vote_end'] || $output['partake'] || !in_array($output['identity'], array(1,2,3))){?>disabled="disabled"<?php }?> />
          <?php }?></td>
        <td class="w150"><?php echo $val['pollop_option'];?></td>
        <td class="w230"><div class="poll-column">
            <p class="c<?php echo $i;?>" style="width: <?php echo intval($output['poll_info']['poll_voters']) != 0?sprintf('%.2f%%', intval($val['pollop_votes'])/intval($output['poll_info']['poll_voters'])*100):0;?>"> </p>
          <i> <?php echo intval($output['poll_info']['poll_voters']) != 0?sprintf('%.2f%%', intval($val['pollop_votes'])/intval($output['poll_info']['poll_voters'])*100):'0.00%';?></i></div></td>
        <td><?php if($val['pollop_votername'] != ''){?>
          <span><?php echo recentlyTwoVoters($val['pollop_votername']);?>&nbsp;<?php echo $lang['nc_etc'];?></span>
          <?php }?>
          <em><?php echo $val['pollop_votes'];?></em><?php echo $lang['circle_have_poll'];?></td>
      </tr>
      <?php }?>
    </table>
    <?php if(!$output['vote_end'] && !$output['partake'] && in_array($output['identity'], array(1,2,3))){?>
    <div class="bottom"><a href="javascript:void(0);" nctype="poll_submit" class="btn" ><?php echo $lang['nc_submit'];?></a><span nctype="poll-warning" class="warning"></span> </div>
    <?php }?>
  </form>
</div>
<script>
var c_id = <?php echo $output['c_id'];?>;
var t_id = <?php echo $output['t_id'];?>;
$(function(){
	<?php if(!$output['vote_end'] && !$output['partake']){?>
	$('a[nctype="poll_submit"]').click(function(){
		if(_ISLOGIN){
			if($('input[name="pollopid[]"]:checked').length == 0){
				$('span[nctype="poll-warning"]').html('<?php echo $lang['circle_vote_option_not_null'];?>').show();
				window.setTimeout(pollWarningHide,5000);	// 5 seconds after the hidden message
				return false;
			}
			ajaxpost('poll_form', CIRCLE_SITE_URL+'/index.php?act=theme&op=save_votepoll&c_id='+c_id+'&t_id='+t_id, '', 'onerror');
		}else{
			login_dialog();		
		}
	});
	<?php }?>
});
function pollWarningHide(){
	$('span[nctype="poll-warning"]').hide('slow').html('');
}
</script>
<?php }?>
