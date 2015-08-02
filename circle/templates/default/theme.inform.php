<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="eject_con inform-reason">
  <div id="apply_warning"></div>
  <form id="inform_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme_inform&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id']; if(isset($_GET['r_id'])){echo '&r_id='.$_GET['r_id'];}?>" method="post" onsubmit="ajaxpost('inform_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme_inform&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id']; if(isset($_GET['r_id'])){echo '&r_id='.$_GET['r_id'];}?>', '', 'onerror');">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['circle_inform_reason'];?></dt>
      <dd>
        <h5>
          <p><?php echo $lang['circle_inform_choosable_reason'].$lang['nc_colon'];?></p>
          <ul nctype="selectable">
            <li style="display:blank;"><?php echo $lang['circle_inform_reason_1'];?></li>
            <li style="display:blank;"><?php echo $lang['circle_inform_reason_2'];?></li>
            <li style="display:blank;"><?php echo $lang['circle_inform_reason_3'];?></li>
            <li style="display:blank;"><?php echo $lang['circle_inform_reason_4'];?></li>
            <li style="display:blank;"><?php echo $lang['circle_inform_reason_5'];?></li>
          </ul>
        </h5>
        <p><textarea name="content" class="textarea" id="i_content"></textarea></p>
        <p><span class="count" id="i_contentcharcount"></span></p>
      </dd>
    </dl>
    <div class="bottom">
      <a class="submit-btn" nctype="inform_submit" href="Javascript: void(0)"><?php echo $lang['nc_submit'];?></a>
      <a class="cancel-btn" nctype="inform_cancel" href="Javascript: void(0)"><?php echo $lang['nc_cancel'];?></a>
    </div>
  </form>
</div>
<script>
$(function(){
	$('a[nctype="inform_submit"]').click(function(){
		$("#inform_form").submit();
	});
	$('a[nctype="inform_cancel"]').click(function(){
		DialogManager.close('inform');
	});
	$('ul[nctype="selectable"] > li').click(function(){
		$('#i_content').val($(this).html());
	});

   	$.getScript('<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js', function(){
	    $("#i_content").charCount({
			allowed: 255,
			warning: 10,
			counterContainerID:'i_contentcharcount',
			firstCounterText:'<?php echo $lang['charCount_firsttext'];?>',
			endCounterText:'<?php echo $lang['charCount_endtext'];?>',
			errorCounterText:'<?php echo $lang['charCount_errortext'];?>'
		});
   	});
});
</script>