<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
<!--
.release-tab { clear:both;}
.release-tab li { display:inline-block; *display:inline;}
.release-tab li em { /* background:url(../images/member/ncus_public.png) no-repeat scroll; */ _background-image: url(../images/ie6/ncus_public.gif)/*IE6*/; float:left; height: 26px; width: 26px;}
.release-tab li.sharemood em { background-position: 0 -400px;}
.release-tab li.sharegoods em { background-position: -60px -400px;}
.release-tab li.sharestore em { background-position: -30px -400px;}
.release-tab li a { font-family:"Microsoft yahei"; font-size:1.2em; font-weight:700; text-decoration: none; line-height:20px; color:#7FB8D2; float:left; height:20px; margin: 3px 18px 3px 6px;}
.release-tab li i { line-height: 12px; border-right:dashed 1px #80B8D2; width: 1px; height: 12px; float: left; margin: 10px 20px 4px 0;}

.release-content { height: 120px; clear:both; position:relative; z-index:9;}
.release-content .arrow { /* background: url(../images/member/ncus_public.png) scroll no-repeat -90px -400px; */ _background-image: url(../images/ie6/ncus_public.gif)/*IE6*/; width: 18px; height: 10px; position: absolute; z-index: 1; top: 6px; left: 48px;}
.release-content textarea { width: 560px; height: 48px; float: left; border-radius: 5px; position: absolute; top: 14px; left: 0px; border: solid 1px #CCE2E8; background-color: #FFF; box-shadow: none;}
.release-content textarea:focus { background-color:#FFF; border-color: #CCC; box-shadow: 1px 1px 1px 0 #E7E7E7; -moz-box-shadow: 1px 1px 1px 0 #E7E7E7/* if FF*/; -webkit--box-shadow: 1px 1px 1px 0 #E7E7E7/* if Webkie*/;}
.release-content .smile { display: block; clear: both; position: absolute; z-index:9; top: 84px; left: 0px;}
.release-content .smile em { /* background: url(../images/member/ncus_public.png) no-repeat scroll -182px -380px; */ _background-image: url(../images/ie6/ncus_public.gif)/*IE6*/; width: 20px; height: 20px; float: left;}
.release-content .smile a { line-height:20px; font-weight:700; color:#7FB8D2; float: left;}
.release-content .smile i {}
.release-content span.error label { color:#FFC !important; font-weight:600; background-color: rgba(255,102,0,0.95); line-height:20px; text-align:center; border-radius:4px; position: absolute; z-index: 999; top:25px; left:200px; padding:4px 30px; box-shadow: 2px 2px 0 rgba(0,0,0,0.1); margin:0;}
.release-content .weibocharcount { position: absolute; z-index: 1; top:84px; left: 70px;}
.release-content .weiboseccode { background-color:#FFF; position: absolute; z-index: 1; top:84px; right: 90px; display: none; z-index:999;}
.release-content .handle { position: absolute; z-index: 9; top:82px; right:230px;}
.release-content .button { font-size:1.4em; line-height: 32px; font-weight:700; color:#FFF; background-color:#80B8D2; width:60px; height:32px; border:none; position: absolute; top: 80px; left: 500px; cursor:pointer;}
.release-content input[type="button"]{ border-radius: 4px;}
-->
</style>
<div class="sidebar">
<?php include template('sns/sns_sidebar_visitor');?>
<?php include template('sns/sns_sidebar_messageboard');?>
</div>
<div class="left-content">
<?php if ($output['is_owner']){ ?>
    <ul class="release-tab">
      <li class="sharemood"><em></em><a href="javascript:void(0)" style="cursor: default;">分享心情</a></li>
    </ul>
    <div class="release-content"><span class="arrow"></span>
      <form id="weiboform" method="post" action="index.php?act=member_snsindex&op=addtrace">
        <textarea name="content" id="content_weibo" nc_type="contenttxt" class="textarea"resize="none"></textarea>
        <span class="error"></span>
        <div class="smile"><em></em><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"weibo"}'>表情</a></div>
        <div id="weibocharcount" class="weibocharcount"></div>
        <div id="weiboseccode" class="weiboseccode">
          <label for="captcha" class="ml5 fl"><strong><?php echo $lang['nc_checkcode'].$lang['nc_colon'];?></strong></label>
          <input name="captcha" class="w40 fl text" type="text" id="captcha" size="4" maxlength="4"/>
          <a href="javascript:void(0)" class="ml5 fl"><img src="" title="<?php echo $lang['wrong_checkcode_change'];?>" name="codeimage" border="0" id="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()" /></a>
          <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
        </div>
        <div class="handle">
          <div nc_type="formprivacydiv" class="privacy-module"><span class="privacybtn" style="width:55px;" nc_type="formprivacybtn"><i></i>所有人</span>
            <div class="privacytab" nc_type="formprivacytab" style="display:none;">
              <ul class="menu-bd">
                <li nc_type="formprivacyoption" data-param='{"v":"0"}'><span class="selected">所有人可见</span></li>
                <li nc_type="formprivacyoption" data-param='{"v":"1"}'><span>仅好友可见</span></li>
                <li nc_type="formprivacyoption" data-param='{"v":"2"}'><span>仅自己可见</span></li>
              </ul>
            </div>
          </div>
          <input type="hidden" name="privacy" id="privacy" value="0"/>
        </div>
        <input type="text" class="text" style="display:none;" />
        <!-- 防止点击Enter键提交 -->
        <input name="<?php echo $lang['nc_snsshare'];?>" type="button" class="button" value="<?php echo $lang['nc_snsshare'];?>" id="weibobtn" />
      </form>
      <!-- 表情弹出层 -->
      <div id="smilies_div" class="smilies-module"></div>
    </div>
<?php } ?>    
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="javascript:void(0)"><?php echo $lang['sns_share_of_fresh_news'];?></a></li>
    </ul>
  </div>
  <!-- 动态列表 -->
  <div id="friendtrace"></div>
</div>
<div class="clear"></div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxdatalazy.js" charset="utf-8"></script> 
<script type="text/javascript">
var max_recordnum = '<?php echo $output['max_recordnum'];?>';
document.onclick = function(){ $("#smilies_div").html(''); $("#smilies_div").hide();};
$(function(){
	//加载好友动态分页
	$('#friendtrace').lazyinit();
	$('#friendtrace').lazyshow({url:"index.php?act=member_snshome&op=tracelist&mid=<?php echo $output['master_info']['member_id'];?>&page=1",'iIntervalId':true});
	
	//提交分享心情表单
	$("#weibobtn").bind('click',function(){			
		if($("#weiboform").valid()){
			var cookienum = $.cookie(COOKIE_PRE+'weibonum');
			cookienum = parseInt(cookienum);
			if(cookienum >= max_recordnum && $("#weiboseccode").css('display') == 'none'){
				//显示验证码
				$("#weiboseccode").show();
				$("#weiboseccode").find("#codeimage").attr('src','index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random());
			}else if(cookienum >= max_recordnum && $("#captcha").val() == ''){
				showDialog('请填写验证码');
			}else{
				ajaxpost('weiboform', '', '', 'onerror');
				//隐藏验证码
				$("#weiboseccode").hide();
				$("#weiboseccode").find("#codeimage").attr('src','');
				$("#captcha").val('');
			}
		}
		return false;
	});
	
	$('#weiboform').validate({
		errorPlacement: function(error, element){
			element.next('.error').append(error);
	    },      
	    rules : {
	    	content : {
	            required : true,
	            maxlength : 140
	        }
	    },
	    messages : {
	    	content : {
	            required : '<?php echo $lang['sns_sharemood_content_null'];?>',
	            maxlength: '<?php echo $lang['sns_content_beyond'];?>'
	        }
	    }
	});
	//心情字符个数动态计算
	$("#content_weibo").charCount({
		allowed: 140,
		warning: 10,
		counterContainerID:'weibocharcount',
		firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
		endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
		errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
	});
});
</script>