<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert mt10"> <strong><?php echo $lang['nc_explain'].$lang['nc_colon'];?></strong> 只能查询“<?php echo $output['minDate']; ?>”到“<?php echo $output['maxDate']; ?>”的聊天记录，切换不同的选项卡选择可查看与店铺客服最近对话的会员。 </div>
<div class="tabmenu">
  <ul id="seller_list" class="tab pngFix">
    <?php if (is_array($output['seller_list']) && !empty($output['seller_list'])) { ?>
    <?php foreach ($output['seller_list'] as $key => $val) { ?>
    <li seller_id="<?php echo $val['seller_id'];?>" class="<?php echo $val['seller_id'] == $output['seller_id'] ? 'active':'normal';?>"> <a href="JavaScript:void(0);" onclick="select_seller(<?php echo $val['seller_id'];?>);" class="msg-button"><?php echo $val['seller_name'];?></a></li>
    <?php } ?>
    <?php } ?>
  </ul>
</div>
<div class="ncsc-chat-layout"><table class="search-form">
      <tr><td class="w10"></td>
        <td class="w180"><strong>最近联系人</strong></td>
        <td>&nbsp;</td>
        <th>关键字</th>
        <td class="w90"><input name="msg_key" id="msg_key" type="text" class="text w70" value="" /></td>
        <th>起止日期</th>
        <td class="w240"><input name="add_time_from" id="add_time_from" type="text" class="text w70" value="<?php echo $_GET['add_time_from']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label>&nbsp;&#8211;&nbsp;<input name="add_time_to" id="add_time_to" type="text" class="text w70" value="<?php echo $_GET['add_time_to']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="button" onclick="submit_chat_log();" class="submit" value="查询" />
          </label></td>
      </tr>
    </table>
  <div class="left" id="store_user_list"></div>
  <div class="right" id="store_chat_log">
  </div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script>
    var select_id = '';
    var chat_user = '';
    function select_seller(seller_id){
        select_id = seller_id;
        chat_user = '';
        var obj = $("#seller_list");
        obj.find("li").removeClass().addClass("normal");
        obj.find("li[seller_id='"+seller_id+"']").removeClass().addClass("active");
        var ajaxurl = 'index.php?act=store_im&op=get_user_list&seller_id='+select_id;
        $("#store_user_list").load(ajaxurl);
        $("#store_chat_log").html('<div class="warning-option"><span>从左侧对话列表中选择会员显示聊天记录，使用“起止日期”进行时间段内的查询</span></div>');
    }
    function submit_chat_log(){
        if(chat_user != '') {
            store_chat_log(chat_user);
        }
    }
    function store_chat_log(user_id){
        var ajaxurl = 'index.php?act=store_im&op=get_chat_log&seller_id='+select_id;
        $("#store_chat_log").load(ajaxurl+'&'+$.param({'add_time_from':$('#add_time_from').val(),'add_time_to':$('#add_time_to').val(),'msg_key':$('#msg_key').val(),'t_id':user_id }));
    }
    function user_chat_log(user_id,user_name){
        chat_user = user_id;
        var obj = $("#store_user_list ul");
        obj.find("li").removeClass().addClass("normal");
        obj.find("li[user_id='"+user_id+"']").removeClass().addClass("active");
        store_chat_log(user_id);
    }
	$(function(){
	    select_seller(<?php echo $output['seller_id'];?>);
        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd',minDate: '<?php echo $output['minDate']; ?>'});
        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd',maxDate: '<?php echo $output['maxDate']; ?>'});
	});
</script>
