<?php defined('InShopNC') or exit('Access Invalid!');?>

<div id="chatLogList" class="ncsc-chat-log-list">
  <?php if (is_array($output['list']) && !empty($output['list'])) { ?>
  <ul>
    <?php foreach ($output['list'] as $key => $val) { ?>
    <li class="<?php echo $val['f_id'] == $output['seller']['member_id'] ? 'store_log':'user_log';?>">
      <div class="member">
        <?php if ($val['f_id'] == $output['seller']['member_id']) { ?>
        客服：<?php echo $output['seller']['seller_name']; ?><em>( 会员ID：<?php echo $val['f_name']; ?>)</em>
        <?php } else { ?>
        会员：<?php echo $val['f_name']; ?>
        <?php } ?><span class="time"><?php echo date("Y-m-d H:i:s",$val['add_time']);?></span></div>
      <div class="content"><?php echo parsesmiles($val['t_msg']);?></div>
    </li>
    <?php } ?>
  </ul>
  <?php } else { ?>
  <div class="warning-option"><i class="icon-warning-sign">&nbsp;</i><span><?php echo $lang['no_record'];?></span></div>
  <?php } ?>
</div>
  <?php if (is_array($output['list']) && !empty($output['list'])) { ?>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
  <?php } ?>
<script type="text/javascript">
	$('#store_chat_log .demo').ajaxContent({
		target:'#store_chat_log'
	});
	//自定义滚定条
	$('#chatLogList').perfectScrollbar();
</script>