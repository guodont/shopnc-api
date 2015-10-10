<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="comment-widget">
  <div class="comment-edit">
    <form id="commentform_<?php echo $output['tid'];?>" method="post" action="index.php?act=member_snsindex&op=addcomment">
      <input type="hidden" name="originaltype" value="<?php echo $output['type'];?>"/>
      <input type="hidden" name="originalid" value="<?php echo $output['tid'];?>"/>
      <input type="hidden" name="showtype" value="<?php echo $output['showtype'];?>"/>
      <div class="comment-add">
        <textarea placeholder="<?php echo $lang['sns_comment_contenttip'];?>" resize="none" id="content_comment<?php echo $output['tid'];?>" name="commentcontent"></textarea>
        <span class="error"></span> 
        <!-- 验证码 -->
        <div id="commentseccode<?php echo $output['tid'];?>" class="seccode" style="display: none;">
          <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon'];?></label>
          <input name="captcha" class="text" type="text" size="4" maxlength="4"/>
          <img src="" title="<?php echo $lang['wrong_checkcode_change'];?>" name="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/> <span><?php echo $lang['wrong_seccode'];?></span>
          <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
        </div>
        <input type="text" style="display:none;" />
        <!-- 防止点击Enter键提交 -->
        <div class="act"> <span class="skin-blue"><span class="btn"><a href="javascript:void(0);" nc_type="commentbtn" data-param='{"txtid":"<?php echo $output['tid'];?>"}'><?php echo $lang['sns_comment'];?></a></span></span> <span id="commentcharcount<?php echo $output['tid'];?>" style="float:right;"></span> <a class="face" nc_type="smiliesbtn" data-param='{"txtid":"comment<?php echo $output['tid'];?>"}' href="javascript:void(0);" ><?php echo $lang['sns_smiles'];?></a> </div>
      </div>
    </form>
  </div>
  <div class="clear"></div>
  <?php if (count($output['commentlist'])>0){ ?>
  <ul class="comment-list">
    <?php foreach ((array)$output['commentlist'] as $k=>$v){?>
    <li nc_type="commentrow_<?php echo $v['comment_id']; ?>"> <a target="_blank" href="index.php?act=member_snshome&mid=<?php echo $v['comment_memberid'];?>"><img width="30" height="30" class="clogo" src="<?php if ($v['comment_memberavatar']!='') { echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR.DS.$v['comment_memberavatar']; } else {  echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('default_user_portrait'); } ?>" onload="javascript:DrawImage(this,30,30);"></a>
      <div class="detail">
        <p class="words"><a target="_blank" href="index.php?act=member_snshome&mid=<?php echo $v['comment_memberid'];?>" class="name"><?php echo $v['comment_membername'];?></a><?php echo $lang['nc_colon']; ?><?php echo parsesmiles($v['comment_content']);?></p>
        <p class="other">
          <?php if ($_SESSION['member_id'] == $v['comment_memberid']){?>
          <span class="opt"><a href="javascript:void(0);" nc_type="comment_del" data-param='{"cid":"<?php echo $v['comment_id'];?>"}'><?php echo $lang['nc_delete'];?></a></span>
          <?php }?>
          <span class="time"><?php echo @date('Y-m-d H:i',$v['comment_addtime']);?> - <?php echo $output['countnum']-$k;?>&nbsp;<?php echo $lang['sns_comment_floor'];?></span> </p>
      </div>
    </li>
    <?php }?>
  </ul>
  <?php if ($output['showtype']==1 && $output['showmore'] == '1'){//展示更多连接?>
  <div class="more"><a target="_blank" href="index.php?act=member_snshome&op=traceinfo&mid=<?php echo $output['master_info']['member_id'];?>&id=<?php echo $output['tid'];?>"><?php echo $lang['sns_comment_more'];?></a></div>
  <?php } elseif (!$output['showtype']){//展示分页?>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
  <?php } ?>
  <?php } ?>
  <div style="clear:both;"></div>
</div>
<script type="text/javascript">
$(function(){
	//删除评论
	$("[nc_type='comment_del']").live('click',function(){
		var obj = $(this);
		showDialog('<?php echo $lang['nc_common_op_confirm'];?>','confirm', '', function(){
			var data_str = $(obj).attr('data-param');
	        eval("data_str = "+data_str);
	        ajax_get_confirm('','index.php?act=member_snsindex&op=delcomment&id='+data_str.cid);
			return false;
		});
	});
	//评论提交
	$("[nc_type='commentbtn']").die().live('click',function(){
		var data = $(this).attr('data-param');
        eval("data = "+data);
		if($("#commentform_"+data.txtid).valid()){			
			var cookienum = $.cookie('<?php echo COOKIE_PRE;?>commentnum');
			cookienum = parseInt(cookienum);
			if(cookienum >= <?php echo $output['max_recordnum'];?> && $("#commentseccode"+data.txtid).css('display')=="none"){
				//显示验证码
				$("#commentseccode"+data.txtid).show();
				var nchash = $("#commentseccode"+data.txtid).find("[name='nchash']").val();
				$("#commentseccode"+data.txtid).find("[name='codeimage']").attr('src','index.php?act=seccode&op=makecode&nchash='+nchash+'&t=' + Math.random());
			}else if(cookienum >= <?php echo $output['max_recordnum'];?> && $("#commentseccode"+data.txtid).find("[name='captcha']").val() == ''){
				showDialog('<?php echo $lang['wrong_null'];?>');
			}else{
				ajaxpost('commentform_'+data.txtid, '', '', 'onerror');
				//隐藏验证码
				$("#commentseccode"+data.txtid).hide();
				$("#commentseccode"+data.txtid).find("[name='codeimage']").attr('src','');
				$("#commentseccode"+data.txtid).find("[name='captcha']").val('');
			}
		}
		return false;
	});
	$('#commentform_<?php echo $output['tid'];?>').validate({
		errorPlacement: function(error, element){
			element.next('.error').append(error);
	    },      
	    rules : {
	    	commentcontent : {
	            required : true,
	            maxlength : 140
	        }
	    },
	    messages : {
	    	commentcontent : {
	            required : '<?php echo $lang['sns_comment_null'];?>',
	            maxlength: '<?php echo $lang['sns_content_beyond'];?>'
	        }
	    }
	});
	<?php if (!$output['showtype']==1){?>
	//分页绑定异步加载事件
	$('#tracereply_<?php echo $output['tid'];?>').find('.demo').ajaxContent({
		event:'click',
		loaderType:"img",
		loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
		target:'#tracereply_<?php echo $output['tid'];?>'
	});
	<?php }?>
	//评论字符个数动态计算
	$("#content_comment<?php echo $output['tid'];?>").charCount({
		allowed: 140,
		warning: 10,
		counterContainerID:'commentcharcount<?php echo $output['tid'];?>',
		firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
		endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
		errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
	});
});
</script>