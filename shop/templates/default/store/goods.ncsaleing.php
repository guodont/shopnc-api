<script type="text/javascript">
$(document).ready(function(){
	$('#cosulting_demo').find('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
		target:'#cosulting_demo'
	});
});
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" type="text/javascript" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<?php if(!empty($output['consult_list'])) { ?>
  <?php foreach($output['consult_list'] as $k=>$v){ ?>
  <div class="ncs-cosult-list">
    <dl class="asker">
      <dt>咨询网友<?php echo $lang['nc_colon'];?></dt>
      <dd>
	  <?php if($v['member_id']== '0') echo $lang['nc_guest']; else if($v['isanonymous'] == 1){?>
        <?php echo str_cut($v['cmember_name'],2).'***';?>
        <?php }else{?>
        <a href="index.php?act=member_snshome&mid=<?php echo $v['member_id'];?>" target="_blank" data-param="{'id':<?php echo $v['member_id'];?>}" nctype="mcard"><?php echo str_cut($v['cmember_name'],8);?></a>
        <?php }?>        
        <time datetime="<?php echo date("Y-m-d H:i:s",$v['consult_addtime']);?>" pubdate="pubdate" class="ml20"><?php echo date("Y-m-d H:i:s",$v['consult_addtime']);?></time>
      </dd></dl>
      <dl class="ask-con"><dt><?php echo $lang['goods_index_consult_content'];?><?php echo $lang['nc_colon'];?></dt>
      <dd><p><?php echo nl2br($v['consult_content']);?></p></dd>
    </dl>
    <?php if($v['consult_reply']!=""){?>
    <dl class="reply">
      <dt><?php echo $lang['goods_index_seller_reply'];?></dt>
      <dd>
        <p><?php echo nl2br($v['consult_reply']);?></p>
        <time datetime="<?php echo date("Y-m-d H:i:s",$v['consult_reply_time']);?>" pubdate="pubdate">[<?php echo date("Y-m-d H:i:s",$v['consult_reply_time']);?>]</time>
      </dd>
    </dl>
    <?php }?>
  </div> 
  <?php }?>
  <div class="tr pr5 pb5"><div class="pagination"> <?php echo $output['show_page'];?> </div></div>
  

<?php } else { ?>
<div class="ncs-norecord"><?php echo $lang['goods_index_no_reply'];?></div>
<?php } ?>
<?php if($output['consult_able']) { ?>
<form method="post" id="message" action="index.php?act=goods&op=save_consult&id=<?php echo $_GET['id']; ?>">
<?php Security::getToken();?>
<input type="hidden" name="form_submit" value="ok" />
<input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
  <?php if($output['type_name']==''){?>
  <input type="hidden" name="goods_id" value="<?php echo $_GET['goods_id']; ?>"/>
  <?php }?>
  <div class="ncs-consult-form">
    <div class="asker-info">
      <?php if($_SESSION['member_id']){ ?>
      <label><strong><?php echo $lang['goods_index_member_name'].$lang['nc_colon'];?></strong><?php echo $_SESSION['member_name'];?><input type="hidden" name="email" id="gbTextfield" value="<?php echo $_SESSION['member_email']; ?>" /></label>
      
      <label for="gbCheckbox"><input type="checkbox" class="checkbox" name="hide_name" value="hide" id="gbCheckbox"><?php echo $lang['goods_index_anonymous_publish'];?></label>
      <?php }else{ ?>
      <label for="gbTextfield"><strong><?php echo $lang['goods_index_email'];?></strong>
        <input type="text" name="email" id="gbTextfield" class="text w300" placeholder="非会员可输入邮件进行咨询，以便客服人员给您回执。" value="" /><span></span>
      </label>
      <?php }?>
      <?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
      <label for="captcha"><strong><?php echo $lang['goods_index_checkcode'];?></strong>
        <input name="captcha" class="text w60" type="text" id="captcha" size="4" autocomplete="off" maxlength="4"/><span></span>
        <img src="index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" name="codeimage" border="0" id="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/><span><?php echo $lang['goods_index_change_checkcode'];?></span></label>
      <?php } ?>
    </div>
    <div class="ask-content"> <strong>咨询内容：</strong>
      <textarea name="goods_content" id="textfield3" class="textarea w700 h60"></textarea><span></span>
    </div>
    <div class="bottom"><a href="JavaScript:void(0);" nc_type="consult_submit" title="<?php echo $lang['goods_index_publish_consult'];?>" class="ncs-btn ncs-btn-red"><?php echo $lang['goods_index_publish_consult'];?></a><span id="consultcharcount"></span></div>
  </div>
</form>
<script type="text/javascript">
$(function(){
	$('a[nc_type="consult_submit"]').click(function(){
	    if($("#message").valid()){
			$.getJSON('index.php?act=goods&op=save_consultajax',{
				'form_submit':'ok','formhash':$('input[name="formhash"]').val(),
					<?php if($output['type_name']==''){?>
		    		'goods_id':'<?php echo $_GET['goods_id']; ?>',
					<?php }?>
					'email':$("#gbTextfield").val()
					<?php if($_SESSION['member_id']){ ?>
					,'hide_name':$("#message input:checked").val()
					<?php }?>
					<?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
					,'captcha':$("#captcha").val()
					,'nchash':'<?php echo getNchash();?>'
					<?php }?>
					,'goods_content':$("#textfield3").val()
				}, function(data){
					if(data.done == 'true'){
						$("#cosulting_demo").load('index.php?act=goods&op=cosulting&goods_id=<?php echo $_GET['goods_id']; ?>');
					}else{
						document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random(); 
						alert(data.msg);
					}
		    	});
	   	}else{
	   		document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();
		}
	});
	$('#message').validate({
		errorPlacement: function(error, element){
			var error_td = element.next('span');
			error_td.next('.field_notice').hide();
			error_td.append(error);
	    },      
	    rules : {
	    	goods_content : {
	            required : true,
	            maxlength : 120
	        },
	        email : {
	            email : true          
	        }
	        <?php if(C('captcha_status_goodsqa') == '1') { ?>
	        	,captcha: {
	        		required : true,
	        		minlength : 4,
	        		remote   : {
	                    url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
	                    type:'get',
	                    data:{
	                    	captcha : function(){
	                            return $('#captcha').val();
	                        }
	                    }
	                }
	        	}
	        <?php }?>
	    },
	    messages : {
	    	goods_content : {
	            required : '<?php echo $lang['goods_index_cosult_not_null'];?>',
	            maxlength: '<?php echo $lang['goods_index_max_120'];?>'
	        },
	        email : {
	            email : '<?php echo $lang['goods_index_cosult_email_error'];?>'
	        }
	        <?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
	        	,captcha: {
	        		required : '<?php echo $lang['goods_index_captcha_no_noll'];?>',
	        		minlength : '<?php echo $lang['goods_index_captcha_error'];?>',
	        		remote   : '<?php echo $lang['goods_index_captcha_error'];?>'
	            }
	        <?php }?>
	    }
	});

	// textarea 字符个数动态计算
	$("#textfield3").charCount({
		allowed: 120,
		warning: 10,
		counterContainerID:'consultcharcount',
		firstCounterText:'<?php echo $lang['goods_index_textarea_note_one'];?>',
		endCounterText:'<?php echo $lang['goods_index_textarea_note_two'];?>',
		errorCounterText:'<?php echo $lang['goods_index_textarea_note_three'];?>'
	});
});
</script>
<?php } ?>
	

