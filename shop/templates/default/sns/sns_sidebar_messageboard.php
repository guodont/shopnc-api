<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="side-message">
  <div class="title">
    <h4><?php if ($output['relation'] == 3){echo $lang['sns_visitor_messages']; }else {echo $lang['sns_leave_a_message']; }?></h4>
  </div>
  <?php if($output['relation'] != 3){?>
  <div class="guest-form">
    <form id="send_form" action='index.php?act=member_message&op=savemsg&type=sns_board' method="post">
      <input type="hidden" value="ok" name="form_submit">
      <input type="hidden" name="msg_type" value="2" />
      <input type="hidden" value="<?php echo $output['master_info']['member_name'];?>" name="to_member_name">
      <textarea id="content_msg" name="msg_content" placeholder="<?php echo $lang['sns_message_content_placeholder'];?>@<?php echo !empty($output['master_info']['member_truename'])?$output['master_info']['member_truename']:$output['master_info']['member_name'];?><?php echo $lang['sns_talk'];?>~" class="msg-content"></textarea>
      <div class="action"> <a class="face" href="javascript:void(0);" data-param='{"txtid":"msg"}' nc_type="smiliesbtn"><?php echo $lang['sns_smiles'];?></a><a href="javascript:void(0);" nctype="commentbtn" class="btn"><?php echo $lang['sns_speak'];?></a><span class="charcount"><em id="commentcharcount"></em>/140</span></div>
    </form>
  </div>
  <?php }?>
  <div nctype="message_list" class="message-list">
    <?php if(!empty($output['message_list'])){?>
    <?php foreach($output['message_list'] as $val){?>
    <dl nctype="dl<?php echo $val['message_id'];?>">
      <dt><a href="index.php?act=member_snshome&mid=<?php echo $val['from_member_id'];?>" data-param="{'id':<?php echo $val['from_member_id'];?>}" nctype="mcard"><?php echo $val['from_member_name'].$lang['nc_colon'];?></a><span><?php echo parsesmiles($val['message_body']);?></span></dt>
      <dd data-param="{'msgid':'<?php echo $val['message_id'];?>','fname':'<?php echo $val['from_member_name'];?>'}"><span class="time"><?php echo $val['message_time'];?></span><span class="handle">
        <?php if($output['relation'] == 3){?>
        <a href="javascript:void(0);" nctype="reply_msg"><?php echo $lang['sns_reply'];?></a>|
        <?php }?>
        <?php if($output['relation'] == 3 || $val['from_member_id'] == $_SESSION['member_id']){?>
        <a  onclick="ajax_get_confirm('<?php echo $lang['nc_common_op_confirm'];?>', 'index.php?act=member_message&op=dropcommonmsg&drop_type=sns_msg&message_id=<?php echo $val['message_id'];?>');" href="javascript:void(0);"><?php echo $lang['nc_delete'];?></a>
        <?php }?>
        </span> </dd>
      <?php if(isset($output['rmessage_list'][$val['message_id']])){?>
      <dd>
        <?php foreach ($output['rmessage_list'][$val['message_id']] as $v){?>
        <dl class="re-content">
          <dt><a href="index.php?act=member_snshome&mid=<?php echo $v['from_member_id'];?>"><?php echo $v['from_member_name'];?><?php echo $lang['sns_reply'].$lang['nc_colon'];?></a><span><?php echo parsesmiles($v['message_body']);?></span></dt>
          <dd data-param="{'msgid':'<?php echo $v['message_id'];?>'}"><span class="time"><?php echo $v['message_time'];?></span></dd>
        </dl>
        <?php }?>
      </dd>
      <?php }?>
    </dl>
    <?php }?>
    <?php }else{?>
      <div><?php echo $lang['sns_message_null'];?></div>
    <?php }?>
  </div>
</div>
<script >
$(function(){
	$("[nc_type='visitmodule']").bind('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    $("[nc_type='visitmodule']").removeClass('active');
	    $("[nc_type='visitmodule']").addClass('normal');
	    $(this).removeClass('normal');
	    $(this).addClass('active');
	    $("[nc_type='visitlist']").hide();
	    $("#"+data_str.name).show();
	});

	// 回复提交
	$("[nctype='commentbtn']").live('click',function(){
		if($("#send_form").valid()){
			ajaxpost('send_form', '', '', 'onerror');
		}
		return false;
	});
	$('#send_form').validate({
		errorPlacement: function(error, element){
			element.after(error);
		},      
		rules : {
			msg_content : {
				required : true,
				maxlength: 140
			}
		},
		messages : {
			msg_content : {
				required : '<?php echo $lang['sns_message_content_not_null'];?>',
				maxlength: '<?php echo $lang['sns_message_content_max_140'];?>'
			}
		}
	});

	//评论字符个数动态计算
	$("#content_msg").charCount({
		allowed: 140,
		warning: 10,
		counterContainerID:'commentcharcount',
		errortype: 'negative'
	});

	// 回复
	$('a[nctype="reply_msg"]').live('click', function(){
		var p_dd = $(this).parents('dd:first');
		var data; eval('data = ' + p_dd.attr('data-param'));
		if(!p_dd.next().is('dd[nctyoe="replyform"]')){
			$('<dd nctyoe="replyform" class="re-msg"></dd>')
				.append('<i></i>')
				.append('<form id="replyform'+data.msgid+'" action="index.php?act=member_message&op=savereply" method="post"></form>').children('form')
				.append('<input type="hidden" value="ok" name="form_submit"><input type="hidden" value="'+data.msgid+'" name="message_id">')
				.append('<textarea class="re-msg-content" name="msg_content" id="content_msg'+data.msgid+'" placeholder="<?php echo $lang['sns_reply'];?>@'+data.fname+'~"></textarea><div class="action"></div>').children('div')
				.append('<a class="face" nc_type="smiliesbtn" data-param=\'{"txtid":"msg'+data.msgid+'"}\' href="javascript:void(0);"><?php echo $lang['sns_smiles'];?></a>')
				.append('<a nc_type="commentbtn'+data.msgid+'" class="btn" href="javascript:void(0);"><?php echo $lang['nc_submit'];?></a>')
				.append('<span class="charcount"><em id="commentcharcount'+data.msgid+'"></em>/140</span>')
				.end().end().insertAfter(p_dd);
			//评论字符个数动态计算
			$("#content_msg"+data.msgid).charCount({
				allowed: 140,
				warning: 10,
				counterContainerID:'commentcharcount'+data.msgid,
				errortype: 'negative'
			});
			// 回复提交
			$("[nc_type='commentbtn"+data.msgid+"']").live('click',function(){
				if($("#content_msg"+data.msgid).val().length <= 140){
					ajaxpost("replyform"+data.msgid, '', '', 'onerror');
				}
				return false;
			});
		}
	});
});

function leaveMsgSuccess(data){
	$('<dl></dl>')
		.append('<dt><a href="index.php?act=member_snshome&mid='+data.from_member_id+'">'+data.from_member_name+'<?php echo $lang['nc_colon'];?></a><span>'+data.msg_content+'</span></dt>')
		.append('<dd data-param="{\'msgid\':\''+data.msg_id+'\',\'fname\':\''+data.from_member_name+'\'}"><span class="time"><?php echo $lang['sns_just'];?></span><span class="handle"><a href="javascript:void(0);"onclick="ajax_get_confirm(\'<?php echo $lang['nc_common_op_confirm'];?>\', \'index.php?act=member_message&op=dropcommonmsg&drop_type=sns_msg&message_id='+data.msg_id+'\');"><?php echo $lang['nc_delete'];?></a></span></dd>')
		.prependTo('div[nctype="message_list"]');
	$('div[nctype="message_list"]').children('div').hide();
}

function replyMsgSuccess(data){
	$('dd[nctyoe="replyform"]').remove();
	var to = $('dl[nctype="dl'+data.message_parent_id+'"]').children('dd:last');
	$('<dl class="re-content"></dl>')
		.append('<dt><a href="index.php?act=member_snshome&mid='+data.from_member_id+'">'+data.from_member_name+'<?php echo $lang['sns_reply'].$lang['nc_colon'];?></a><span>'+data.msg_content+'</span></dt>')
		.append('<dd data-param="{\'msgid\':\''+data.msg_id+'\'}"><span class="time"><?php echo $lang['sns_just'];?></span></dd>')
		.appendTo(to);
}
</script>