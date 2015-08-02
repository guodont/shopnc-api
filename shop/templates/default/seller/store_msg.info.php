<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-form-default">
  <dl>
    <dt>发送时间<?php echo $lang['nc_colon']; ?></dt>
    <dd>
      <p><?php echo date('Y-m-d H:i:d', $output['msg_list']['sm_addtime']);?></p>
    </dd>
  </dl>
  <dl>
    <dt>消息内容<?php echo $lang['nc_colon'];?></dt>
    <dd>
      <p><?php echo $output['msg_list']['sm_content']; ?></p>
    </dd>
  </dl>
  <div class="bottom pt10 pb10"><a class="ncsc-btn" href="javascript:void(0);" onclick="CUR_DIALOG.close();">关闭窗口</a></div>
</div>
