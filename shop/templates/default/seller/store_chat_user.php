<?php defined('InShopNC') or exit('Access Invalid!');?>

<div id="chatUserList" class="ncsc-chat-user-list">
  <?php if (is_array($output['list']) && !empty($output['list'])) { ?>
  <ul>
    <?php foreach ($output['list'] as $key => $val) { ?>
    <li class="normal" user_id="<?php echo $val['u_id'];?>">
        <a href="javascript:void(0)" onclick="user_chat_log('<?php echo $val['u_id'];?>','<?php echo $val['u_name']; ?>');" title="与 <?php echo $val['u_name']; ?> 的最后对话时间：<?php echo $val['time'];?>">
        <span class="avatar"><img src="<?php echo $val['avatar'];?>"/></span><?php echo $val['u_name']; ?> </a></li>
    <?php } ?>
  </ul>
  <?php } else { ?>
  <div class="warning-option"><i class="icon-warning-sign">&nbsp;</i><span><?php echo $lang['no_record'];?></span></div>
  <?php } ?>
</div>
<script type="text/javascript">
	$('#store_chat_log .demo').ajaxContent({
		target:'#store_chat_log'
	});
	//自定义滚定条
	$('#chatUserList').perfectScrollbar();
</script>
