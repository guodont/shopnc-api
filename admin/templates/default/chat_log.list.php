<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>聊天记录</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>聊天记录</span></a></li>
        <li><a href="index.php?act=chat_log&op=msg_log"><span>聊天内容</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="chat_log" />
    <input type="hidden" name="op" value="chat_log" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th>发送人</th>
          <td><input type="text" class="text" name="f_name" value="<?php echo trim($_GET['f_name']); ?>" /></td>
          <th>回复人</th>
          <td><input type="text" class="text" name="t_name" value="<?php echo trim($_GET['t_name']); ?>" /></td>
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
            <li>发送人即发出消息的会员，回复人为收到消息的会员，如果是店铺的客服或管理员可显示所属店铺名称。</li>
            <li>为使查询信息更准确，请输入聊天双方的完整会员名——登录账号。</li>
            <li>可查询“<?php echo $output['minDate']; ?>”到“<?php echo $output['maxDate']; ?>”的90天内聊天记录。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <div class="chat-log">
    <ul class="chat-log-list">
      <?php if (is_array($output['log_list']) && !empty($output['log_list'])) { ?>
      <?php foreach ($output['log_list'] as $key => $val) { ?>
      <?php if ($val['f_id'] == $output['f_member']['member_id']) { ?>
      <li class="from_log"><span class="avatar"><img src="<?php echo getMemberAvatarForID($val['f_id']);?>"/></span>
        <?php if ($output['f_member']['store_id'] > 0) { ?>
        <dl>
          <dt class="store_log"><?php echo $output['f_member']['store_name']; ?>客服：<?php echo $output['f_member']['seller_name']; ?> <span>(会员ID：<?php echo $val['f_name']; ?>)</span>
            </dt>
            <dd class="time"><?php echo date("Y-m-d H:i:s",$val['add_time']);?></dd>
          <dd class="content"><?php echo parsesmiles($val['t_msg']);?></dd>
        </dl>
        <?php } else { ?>
        <dl>
          <dt class="user_log">会员：<?php echo $val['f_name']; ?></dt>
          <dd class="time"><?php echo date("Y-m-d H:i:s",$val['add_time']);?></dd>
          <dd class="content"><?php echo parsesmiles($val['t_msg']);?></dd>
        </dl>
        <?php } ?>
      </li>
      <?php } else { ?>
      <li class="to_log"><span class="avatar"><img src="<?php echo getMemberAvatarForID($val['f_id']);?>"/></span>
        <?php if ($output['t_member']['store_id'] > 0) { ?>
        <dl>
          <dt class="store_log"><?php echo $output['t_member']['store_name']; ?>客服：<?php echo $output['t_member']['seller_name']; ?> <span>(会员ID：<?php echo $val['f_name']; ?>)</span>
            </dt>
            <dd class="time"><?php echo date("Y-m-d H:i:s",$val['add_time']);?></dd>
          <dd class="content"><?php echo parsesmiles($val['t_msg']);?></dd>
        </dl>
        <?php } else { ?>
        <dl>
          <dt class="user_log">会员：<?php echo $val['f_name']; ?></dt>
          <dd class="time"><?php echo date("Y-m-d H:i:s",$val['add_time']);?></dd>
          <dd class="content"><?php echo parsesmiles($val['t_msg']);?></dd>
        </dl>
        <?php } ?>
      </li>
      <?php } ?>
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
