<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
/* 分享对话框
---------------------------------------- */
.dialog-share { width: 478px; margin: 0;}
.dialog-share a { text-decoration: none; color: #07B;}
/*分享设定部分*/
.dialog-share .share-set { display: block; height: 24px; padding: 10px 20px;}

/*同步*/
.dialog-share .share-widget { float: left;}
.dialog-share .share-widget .s-app { font-size: 0; *word-spacing:-1px/*IE6、7*/; vertical-align: middle; display: inline-block; height: 24px; *display: inline/*IE7*/; position: relative; z-index: 2; *zoom: 1/*IE7*/;}
.dialog-share .share-widget .s-app li { vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; width: 24px; height: 24px; margin-right: 5px; *display: inline/*IE7*/; *zoom: 1/*IE7*/;}
.dialog-share .share-widget .s-app i { background: url("<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicons.png") no-repeat 0 0; display: block; width: 24px; height: 24px; cursor: pointer;}
.dialog-share .share-widget .s-app .i-qqzone { background-position: 0 -24px;}
.dialog-share .share-widget .s-app .disable .i-qqzone { background-position: 0 -48px;}
.dialog-share .share-widget .s-app .i-qqweibo { background-position: 0 -72px;}
.dialog-share .share-widget .s-app .disable .i-qqweibo { background-position: 0 -96px;}
.dialog-share .share-widget .s-app .i-sinaweibo { background-position: 0 -120px;}
.dialog-share .share-widget .s-app .disable .i-sinaweibo { background-position: 0 -144px;}
.dialog-share .share-widget .s-app .tip { font-size: 12px; color: #FD6D26; background-color: #FEF1D5; white-space: nowrap; padding: 0 9px; border: solid 1px #FFC66D; position: absolute; z-index: 1; top: 30px; left: -76px;}
.dialog-share .share-widget .s-app .tip .arrow { background: url("<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicons.png") no-repeat -36px 0; display: block; width: 11px; height: 6px; position: absolute; z-index: 2; top: -6px; left: 20px;}
.dialog-share .share-widget .s-app a { font-size: 12px; line-height: 24px; color: #07B; display: inline-block; margin-left: 30px; *display: inline/*IE7*/; *zoom: 1/*IE7*/;}

/* 可见 */
.share-privacy { line-height: 22px; display:block; height: 24px; float: right; position: relative; z-index: 1; cursor: pointer;}
.share-privacy a { display: block;}
.share-privacy a i { font-size: 14px; margin-right: 4px;}
.share-privacy .privacytab { background-color: #FFF; border: solid 1px #EEE; position: absolute; z-index: 1; top: 24px; right: -10px;}
.share-privacy .privacytab .arrow { background: url("<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicons.png") no-repeat -24px 0; display: block; width: 11px; height: 6px; margin-right: -6px; position: absolute; z-index: 2; top: -6px; right: 50%;}
.share-privacy .privacytab ul { }
.share-privacy .privacytab ul li { color: #666; width: 90px; height: 20px; padding: 5px;}
.share-privacy .privacytab ul li span { vertical-align: middle; display: inline-block; width: 16px; height: 16px; margin-right: 5px; }
.share-privacy .privacytab ul li .selected { background: url("<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicons.png") no-repeat -32px -20px;}
.share-privacy .privacytab ul li:hover { background-color: #f0f0f0;}

/*用户分享内容*/
.dialog-share .share-content { display: block; padding: 0 20px;}
.dialog-share .share-content .textarea-count { color: #999; text-align: right; height: 20px; padding: 5px 0;}
.dialog-share .share-content .textarea-count em { font: 600 italic 16px/20px Georgia, Arial; color: #555; margin: 0 4px;}
.dialog-share .share-content .textarea-count em.warning { color: #F60; background-color: transparent; width: auto; padding: 0; border: none;}
.dialog-share .share-content .textarea-count em.exceeded { color: #F00;}
.dialog-share .share-content .avatar { width: 40px; height: 40px; float: left; margin-top: 5px; position: relative; z-index: 1;}
.dialog-share .share-content .avatar img { max-width: 40px; max-height: 40px; border-radius: 5px;}
.dialog-share .share-content .avatar i { background: url("<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicons.png") no-repeat -30px -50px; width: 10px; height: 10px; position: absolute; z-index: 1; top: 10px; right: -15px;}
.dialog-share .share-content .textarea { line-height: 18px; width: 374px; height: 54px; padding: 4px; float: right; border-color: #CCC #DDD #DDD; box-shadow: none; resize: none;}
.dialog-share .share-content .textarea:focus { color: #333; border-color: #CCC #DDD #DDD;}

/*分享的商品*/
.dialog-share .jcarousel-skin-tango { clear: both; height: 92px; padding: 10px 0;}
.dialog-share .jcarousel-container-horizontal { height: 92px;}
.dialog-share .jcarousel-item a { line-height: 0; background-color: #FFF; text-align: center; display: block; width: 90px; height: 90px; border: solid 1px #FFF; position: relative; z-index: 1; overflow: hidden;}
.dialog-share .jcarousel-item a img { max-width: 90px; max-height: 90px; }
.dialog-share .jcarousel-item a.selected { border: solid 1px #D93500;}
.dialog-share .jcarousel-item a .extra { line-height: 20px; filter:progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr='#BFD93600', endColorstr='#BFD93600');background:rgba(217,54,0,0.75); color: #FFF; display: none; width: 90px; height: 20px; position: absolute; z-index: 1; bottom: 0; left: 0;}
.dialog-share .jcarousel-item a.selected .extra { display: block;}
.dialog-share .jcarousel-prev { left: -12px !important;}
.dialog-share .jcarousel-next { right: -12px !important;}
.dialog-share .sns-norecord { color: #999; display: block; text-align: center; width: auto; padding: 50px 0; margin: 0; clear: both;}

.dialog-share .seccode { background: #FFFFBF; display: none; padding: 8px; margin: 0; border-top: solid 1px #EEE;}
.dialog-share .seccode input.text { vertical-align: middle; display: inline-block; *display: inline/*IE*/; width: 50px; padding: 2px 4px; *zoom: 1; }
.dialog-share .seccode img { vertical-align: middle; display: inline-block; *display: inline/*IE*/; cursor: pointer; *zoom: 1;}
.dialog-share .seccode span { color: #F60; margin-left: 10px;}

.dialog-share label.error { font-size: 12px; color: #F00; line-height: 24px;}
.dialog-share .bottom { background: #FAFAFA; text-align: center; padding: 10px 0; border-top: solid 1px #EEE;}
.dialog-share .bottom .button { color: #FFF; background-color: #D93600; height: 28px; width: 80px; border: solid 1px #B22D00; cursor: pointer;}
.dialog-share .bottom .cancel { color: #555; background-color: #EEE; vertical-align: top; display: inline-block; *display: inline; height: 20px; padding: 3px 10px; border: solid 1px #CCC; margin-left: 5px; *zoom:1;}

/*绑定工具提示*/
.bindtooltip { background-color: #FFF; overflow: hidden;}
.bindtooltip dl {  font-size: 0; *word-spacing: -1px/*IE6、7*/;}
.bindtooltip dl dt { font-size: 12px; vertical-align: top; letter-spacing: normal; word-spacing: normal; text-align: right; display: inline-block; *display: inline/*IE*/; width: 23%; padding: 10px 0; margin: 0; *zoom: 1;}
.bindtooltip dl dt img { width: 40px; height: 40px; margin: 5px 0 0;}
.bindtooltip .hint { color: #F33;}
.bindtooltip dl dd { font-size: 12px; vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; *display: inline/*IE*/; width: 74%; padding: 10px 0 10px 3% ; *zoom: 1;}
.bindtooltip .bottom { background-color: #F9F9F9; text-align: center; padding: 12px 0; border-top: 1px solid #EAEAEA; }
a.mini-btn { font: normal 12px/20px arial; color: #FFF;  background-color: #5BB75B; text-align: center; vertical-align: middle; display: inline-block; *display: inline/*IE*/; height: 20px; padding: 0 10px; margin-right: 8px; border-style: solid; border-width: 1px; border-color: #52A452 #52A452 #448944 #52A452; *zoom: 1; cursor: pointer;}
a:hover.mini-btn { text-decoration: none; color: #FFF; background-color: #51A351; border-color: #499249 #499249 #3D7A3D #499249;}
.bindtooltip .bottom span a { color: #0077BB; text-decoration: underline; margin-left: 8px;}
</style>
<div class="dialog-share">
  <form method="post" action="index.php?act=member_snsindex&op=sharegoods<?php if($_GET['irefresh'] == 1){?>&irefresh=1<?php }?>" id="sharegoods_form">
    <input type="hidden" name="form_submit" value="ok"/>
    <!-- 分享范围 -->
    <div class="share-set">
      <div class="share-widget">同步分享到：
        <ul class="s-app">
          <li title="个人中心"><i></i></li>
          <?php if (C('share_isuse') == 1){?>
          <?php if (!empty($output['app_arr'])){?>
          <?php foreach ($output['app_arr'] as $k=>$v){?>
          <li nc_type="appitem_<?php echo $k;?>" title="<?php echo $v['name'];?>" class="<?php echo $v['isbind']?'checked':'disable';?>"> <i class="i-<?php echo $k;?>" nc_type="bindbtn" data-param='{"apikey":"<?php echo $k;?>","apiname":"<?php echo $v['name'];?>"}' attr_isbind="<?php echo $v['isbind']?'1':'0';?>"></i>
            <input type="hidden" id="checkapp_<?php echo $k;?>" name="checkapp_<?php echo $k;?>" value="<?php echo $v['isbind']?'1':'0';?>" />
          </li>
          <?php }?>
          <?php }?>
          <div class="tip"><span class="arrow"></span>点亮图标分享商品到热门社交网络去~<a target="_blank" href="index.php?act=member_sharemanage"><?php echo $lang['sharebind_alsosharesetting'];?></a></div>
          <?php }?>
        </ul>
      </div>
      <div nc_type="formprivacydiv" class="share-privacy"><a href="javascript:void(0);" nc_type="formprivacybtn"><i class="icon-group"></i>可见范围</a>
        <div class="privacytab" nc_type="formprivacytab" style="display:none;"> <span class="arrow"></span>
          <ul>
            <li nc_type="formprivacyoption" data-param='{"v":"0","hiddenid":"gprivacy"}'><span class="selected"></span><?php echo $lang['sns_weiboprivacy_all'];?></li>
            <li nc_type="formprivacyoption" data-param='{"v":"1","hiddenid":"gprivacy"}'><span></span><?php echo $lang['sns_weiboprivacy_friend'];?></li>
            <li nc_type="formprivacyoption" data-param='{"v":"2","hiddenid":"gprivacy"}'><span></span><?php echo $lang['sns_weiboprivacy_self'];?></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="share-content">
      <div id="sgcharcount" class="textarea-count"></div>
      <div class="avatar"><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']);?>"><i></i></div>
      <textarea placeholder="<?php echo $lang['sns_sharegoods_contenttip'];?>" class="textarea" name="comment" id="content_sgweibo" resize="none"></textarea>      
      <!-- 商品图片start -->
      <?php if (!empty($output['goods_list'])){?>
      <ul id="mycarousel-s" class="snsgoodsimglist jcarousel-skin-tango">
        <?php foreach ($output['goods_list'] as $v) {?>
        <li><a href="javascript:void(0);" value="<?php echo $v['goods_id'] ?>">
          <?php if($v['order']){?>
          <i class="b"></i>
          <?php }?>
          <?php if($v['favorites']){?>
          <i class="f"></i>
          <?php }?>
          <img title="<?php echo $v['goods_name']?>" src="<?php echo thumb($v, 240);?>" width="90px" height="90px"/>
          <p class="extra"><?php echo $lang['sns_selected'];?></p>
          </a></li>
        <?php }?>
      </ul>
      <?php } else{?>
      <div class="sns-norecord"><?php echo $lang['sns_sharegoods_notbuygoods'];?></div>
      <?php }?>
      <input type="hidden" id="choosegoodsid" name="choosegoodsid" value="<?php echo intval($output['goods_list'][0]['goods_id']);?>" />      
      <!-- 商品图片end --> 
    <div class="error form-error"></div>
    </div>
    <!-- 验证码 -->
    <div id="sg_seccode" class="seccode">
      <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon']; ?></label>
      <input name="captcha" type="text" class="text" size="4" maxlength="4"/>
      <img src="" title="<?php echo $lang['wrong_checkcode_change'];?>" name="codeimage" border="0" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/> <span><?php echo $lang['wrong_seccode'];?></span>
      <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
    </div>
    <input type="text" style="display:none;" />
    <!-- 防止点击Enter键提交 -->
    <div class="bottom">
      <input name="<?php echo $lang['nc_snsshare'];?>" type="button" class="button" value="<?php echo $lang['nc_snsshare'];?>" id="weibobtn_goods" />
      <a href="javascript:DialogManager.close('sharegoods');" class="cancel">取消</a>
      <input type="hidden" name="gprivacy" id="gprivacy" value="0"/>
    </div>
  </form>
</div>
<textarea id="bindtooltip_module" style="display:none;">
<div class="bindtooltip"><dl><dt><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicon_@apikey.png"></dt><dd><p><?php echo $lang['sharebind_list_popup_tip1'];?><strong class="ml5 mr5">@apiname</strong><?php echo $lang['sharebind_list_popup_tip2'];?></p><p class="hint"><?php echo $lang['sharebind_list_popup_tip3'];?>@apiname<?php echo $lang['sharebind_list_popup_tip4'];?></p></dd></dl><div class="bottom"><a href="javascript:void(0);" nc_type="finishbtn" data-param='{"apikey":"@apikey"}' class="mini-btn"><?php echo $lang['sharebind_list_finishbind'];?></a><span><?php echo $lang['sharebind_list_unfinishedbind'];?><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/api.php?act=sharebind&type=@apikey"><?php echo $lang['sharebind_list_againbind'];?></a></span></div></div></textarea>
<script type="text/javascript">
$(function(){
	//图片轮换
	$.getScript("<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js", function(){
	    $('#mycarousel-s').jcarousel({visible: 4,itemFallbackDimension: 300});
	});
	//初始化选择的商品
	$(".snsgoodsimglist").find('a').eq(0).addClass("selected");
	//商品列表绑定事件
	$(".snsgoodsimglist").find('a').bind("click",function(){
		$(".snsgoodsimglist").find('a').removeClass('selected');
		$(this).addClass("selected");
		var gid = $(this).attr('value');
		$("#choosegoodsid").val(gid);
	});
	//分享商品评论字符个数计算
	$("#content_sgweibo").charCount({
		allowed: 140,
		warning: 10,
		counterContainerID:'sgcharcount',
		firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
		endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
		errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
	});
	//分享商品表单验证
	$('#sharegoods_form').validate({
		errorPlacement: function(error, element){
			element.next('.error').append(error);
	    },      
	    rules : {
	    	choosegoodsid:{
	    		min:1
	    	},
	    	comment : {
	            maxlength : 140
	        }
	    },
	    messages : {
	    	choosegoodsid:{
	    		min:'<?php echo $lang['sns_sharegoods_choose'];?>'
	    	},
	    	comment : {
	            maxlength: '<?php echo $lang['sns_content_beyond'];?>'
	        }
	    }
	});
	$("[nc_type='bindbtn']").bind('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    //判断是否已经绑定
	    var isbind = $(this).attr('attr_isbind');
	    if(isbind == '1'){//已经绑定
		    if($("#checkapp_"+data_str.apikey).val() == '1'){
			    $("[nc_type='appitem_"+data_str.apikey+"']").removeClass('checked');
		    	$("[nc_type='appitem_"+data_str.apikey+"']").addClass('disable');
            	$("#checkapp_"+data_str.apikey).val('0');
			}else{
				$("[nc_type='appitem_"+data_str.apikey+"']").removeClass('disable');
            	$("[nc_type='appitem_"+data_str.apikey+"']").addClass('checked');
            	$("#checkapp_"+data_str.apikey).val('1');
			}
		}else{
			var html = $("#bindtooltip_module").text();
		    //替换关键字
		    html = html.replace(/@apikey/g,data_str.apikey);
		    html = html.replace(/@apiname/g,data_str.apiname);
		    html_form("bindtooltip", "<?php echo $lang['sharebind_list_accountconnect'];?>", html, 360, 0);	    
		    window.open('api.php?act=sharebind&type='+data_str.apikey);
		}
	});
	$("[nc_type='finishbtn']").live('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
		//验证是否绑定成功
		var url = 'index.php?act=member_sharemanage&op=checkbind';
        $.getJSON(url, {'k':data_str.apikey}, function(data){
        	DialogManager.close('bindtooltip');
            if (data.done)
            {
            	$("[nc_type='appitem_"+data_str.apikey+"']").addClass('check');
            	$("[nc_type='appitem_"+data_str.apikey+"']").removeClass('disable');
            	$('#checkapp_'+data_str.apikey).val('1');
            	$("[nc_type='appitem_"+data_str.apikey+"']").find('i').attr('attr_isbind','1');
            }
            else
            {
            	showDialog(data.msg, 'notice');
            }
        });
	});
});
</script> 
