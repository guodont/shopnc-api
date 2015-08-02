<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <ul class="tab">
      <?php if(is_array($output['member_menu']) and !empty($output['member_menu'])) { 
	foreach ($output['member_menu'] as $key => $val) {
		$classname = 'normal';
		if($val['menu_key'] == $output['menu_key']) {
			$classname = 'active';
		}
		if ($val['menu_key'] == 'message'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newcommon'].'</span>)</a></li>';
		}elseif ($val['menu_key'] == 'system'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newsystem'].'</span>)</a></li>';
		}elseif ($val['menu_key'] == 'close'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newpersonal'].'</span>)</a></li>';
		}else{
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'</a></li>';
		}
	}
}?>
    </ul>
  </div>
  <div class="ncm-message-send">
    <div class="ncm-message-send-form">
      <div class="ncm-default-form">
        <form method="post" id="send_form" action="index.php?act=member_message&op=savemsg">
          <input type="hidden" name="form_submit" value="ok" />
          <dl>
            <dt><i class="required">*</i><?php echo $lang['home_message_reveiver'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" class="text w500" name="to_member_name" value="<?php echo $output['member_name']; ?>" <?php if (!empty($output['member_name'])){echo "readonly";}?>/>
              <p class="hint"><?php echo $lang['home_message_separate'];?></p>
            </dd>
          </dl>
          <dl>
            <dt>消息类型：</dt>
            <dd><span class="mr10">
              <input type="radio" class="radio vm" value="2" name="msg_type" checked="checked" />
              <?php echo $lang['home_message_open'];?></span><span>
              <input type="radio" class="radio vm" name="msg_type" value="0" />
              <?php echo $lang['home_message_close'];?></span></dd>
          </dl>
          <dl>
            <dt><i class="required">*</i><?php echo $lang['home_message_content'].$lang['nc_colon'];?></dt>
            <dd>
              <textarea name="msg_content" rows="3" class="textarea w500 h100"></textarea>
              <p class ="error"></p>
            </dd>
          </dl>
          <div class="bottom">
            <label class="submit-border">
              <input type="submit" class="submit" value="<?php echo $lang['home_message_ensure_send'];?>" />
            </label>
          </div>
        </form>
      </div>
    </div>
    <div class="ncm-message-send-friend">
      <h3><?php echo $lang['home_message_friend'];?></h3>
       <?php if ($output['friend_list'] != '') { ?><ul>
       
        <?php foreach ($output['friend_list'] as $val) { ?>
        <li><a href="javascript:void(0);" id="<?php echo $val['friend_tomname']; ?>" nc_type="to_member_name">
          <div class="avatar"><img src="<?php echo getMemberAvatar($val['friend_tomavatar']);?>"></div>
          <p><?php echo $val['friend_tomname']; ?></p>
          </a></li>
        <?php } ?>
        
      </ul><?php } else { ?>
        <div class="nomessage"><p><?php echo $lang['home_message_no_friends'];?></p>
        <a href="index.php?act=member_snsfriend&op=find" class="ncm-btn-mini" target="_blank">添加好友</a>
        </div>
        <?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('a[nc_type="to_member_name"]').click(function (){
        var str = $('input[name="to_member_name"]').val();
        var id = $(this).attr('id');
        if(str.indexOf(id+',') < 0){
            doFriend(id+',', 'add');
        }else{
            doFriend(id, 'delete');
        }
    });
});
$(function(){
  $('#send_form').validate({
        errorPlacement: function(error, element){
            $(element).next('p').html(error);
        },
        submitHandler:function(form){
            ajaxpost('send_form', '', '', 'onerror') 
        },   
        rules : {
            to_member_name : {
                required   : true
            },
            msg_content : {
                required   : false
            }
        },
        messages : {
            to_member_name : {
                required : '<?php echo $lang['home_message_receiver_null'];?>.'
            },
            msg_content : {
                required   : '<?php echo $lang['home_message_content_null'];?>.'
            }
        }
    });
});
function doFriend(user_name, action){
    var input_name = $("input[name='to_member_name']").val();
    var key, i = 0;
    var exist = false;
    var arrOld = new Array();
    var arrNew = new Array();
    input_name = input_name.replace(/\uff0c/g,',');
    arrOld     = input_name.split(',');
    for(key in arrOld){
        arrOld[key] = $.trim(arrOld[key]);
        if(arrOld[key].length > 0){
            arrOld[key] == user_name &&  action == 'delete' ? null : arrNew[i++] = arrOld[key]; //剔除好友
            arrOld[key] == user_name ? exist = true : null; //判断好友是否已选
        }
    }
    if(action == 'delete' && arrNew !=''){
    	arrNew = arrNew+',';
    }
    if(!exist && action == 'add'){
        arrNew[i] = user_name;
    }
    $("input[name='to_member_name']").val(arrNew);
}
</script> 
