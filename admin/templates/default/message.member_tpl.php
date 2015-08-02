<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_message_set'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>平台可以选择开启一种或多种消息通知方式。</li>
            <li>短消息、邮件需要用户绑定手机、邮箱后才能正常接收。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form name='form1' method='post'>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['mailtemplates_index_desc'];?></th>
          <th class="align-center">站内信</th>
          <th class="align-center">短消息</th>
          <th class="align-center">邮件</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['mmtpl_list'])){?>
        <?php foreach($output['mmtpl_list'] as $val){?>
        <tr class="hover">
          <td class="w24">&nbsp;</td>
          <td class="w25pre"><?php echo $val['mmt_name']; ?></td>
          <td class="align-center"><?php echo ($val['mmt_message_switch']) ? '开启' : '关闭';?></td>
          <td class="align-center"><?php echo ($val['mmt_short_switch']) ? '开启' : '关闭';?></td>
          <td class="align-center"><?php echo ($val['mmt_mail_switch']) ? '开启' : '关闭';?></td>
          <td class="w60 align-center"><a href="<?php echo urlAdmin('message', 'member_tpl_edit', array('code' => $val['mmt_code']));?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
function go(){
	var url="index.php?act=message&op=email_tpl_ajax";
	document.form1.action = url;
	document.form1.submit();
}
</script>