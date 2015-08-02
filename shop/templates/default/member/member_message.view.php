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
  <div class="ncm-default-form">
    <?php if(!empty($output['message_list'])) { ?>
    <?php foreach ($output['message_list'] as $k=>$v){?>
    <dl>
      <dt>
        <?php if ($output['drop_type'] == 'msg_seller'){?>
        <?php echo $v['from_member_name']; ?> <?php echo $lang['home_message_speak']; }elseif ($output['drop_type'] == 'msg_system') {
        	echo $v['from_member_name'];
        	} else {
        		echo $v['from_member_name'].$lang['home_message_speak'];} ?><?php echo $lang['nc_colon'];?></dt>
      <dd>
        <p><?php echo nl2br(parsesmiles($v['message_body'])); ?></p>
        <p class="hint">(<?php echo date("Y-m-d H:i",$v['message_time']); ?>)</p>
      </dd>
    </dl>
    <?php } ?>
    <?php } ?>
    <?php if($_GET['drop_type'] == 'msg_list' && $output['isallowsend']){?>
    <form id="replyform" method="post" action="index.php?act=member_message&op=savereply">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="message_id" value="<?php echo $output['message_id']; ?>" />
      <dl class="bottom">
        <dt><?php echo $lang['home_message_reply'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <textarea name="msg_content" rows="3" class="textarea w500"></textarea>
          </p>
          <p> </p>
        </dd>
      </dl>
      <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <label class="submit-border">
          <input type="submit" class="submit" value="<?php echo $lang['home_message_submit'];?>" />
        </label></dd>
      </dl>
    </form>
    <script type="text/javascript">
    $(function(){
    	  $('#replyform').validate({
    	        errorPlacement: function(error, element){
    	            $(element).parent().next('p').html(error);
    	        },
    	        rules : {
    	        	msg_content : {
    	                required   : true
    	            }
    	        },
    	        messages : {
    	            msg_content : {
    	                required   : '<?php echo $lang['home_message_reply_content_null'];?>.'
    	            }
    	        }
    	    });
    });
    </script>
    <?php }?>
  </div>
</div>
