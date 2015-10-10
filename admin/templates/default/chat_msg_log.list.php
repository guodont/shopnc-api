<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>聊天内容</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=chat_log&op=chat_log"><span>聊天记录</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>聊天内容</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="chat_log" />
    <input type="hidden" name="op" value="msg_log" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th>关键字</th>
          <td><input type="text" class="text" name="msg" value="<?php echo trim($_GET['msg']); ?>" /></td>
          <th><label for="add_time_from"><?php echo '起止日期';?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['add_time_from'];?>" id="add_time_from" name="add_time_from">
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['add_time_to'];?>" id="add_time_to" name="add_time_to"/></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>根据“关键字”查询消息的内容，点击“详情”可查看当天的所有对话。</li>
            <li>可查询“<?php echo $output['minDate']; ?>”到“<?php echo $output['maxDate']; ?>”的90天内聊天记录。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <div class="chat-log">
    <ul class="chat-log-list">
      <?php if (is_array($output['log_list']) && !empty($output['log_list'])) { ?>
      <?php foreach ($output['log_list'] as $key => $val) { ?>
      <li class="from_log"><span class="avatar"><img src="<?php echo getMemberAvatarForID($val['f_id']);?>"/></span>
        <dl>
          <dt class="store_log">发消息会员：<?php echo $val['f_name']; ?> <span>(接收消息会员：<?php echo $val['t_name']; ?>)</span></span>
            </dt>
            <dd class="time"><?php echo date("Y-m-d H:i:s",$val['add_time']);?>
                <a href="index.php?act=chat_log&op=chat_log&f_name=<?php echo $val['f_name']; ?>&t_name=<?php echo $val['t_name']; ?>&add_time_from=<?php echo date("Y-m-d",$val['add_time']);?>&add_time_to=<?php echo date("Y-m-d",$val['add_time']);?>">详情</a></dd>
          <dd class="content"><?php echo parsesmiles($val['t_msg']);?></dd>
        </dl>
      </li>
      <?php } ?>
      <?php } else { ?>
      <div class="no_data"><?php echo $lang['no_record'];?></div>
      <?php } ?>
    </ul>
    <?php if (is_array($output['log_list']) && !empty($output['log_list'])) { ?>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <?php } ?>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd',minDate: '<?php echo $output['minDate']; ?>'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd',maxDate: '<?php echo $output['maxDate']; ?>'});
    $('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
});
</script>
