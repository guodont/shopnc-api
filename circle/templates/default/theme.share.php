<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="circle-share">
  <form method="post" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme_share&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id'];?>" id="share_form" class="feededitor">
    <input type="hidden" name="form_submit" value="ok"/>
    <dl class="share-target">
      <dt class="title"><?php echo $output['theme_info']['theme_name'];?></dt>
      <dd class="cover">
        <?php if(!empty($output['affix_list'])){?>
        <?php foreach($output['affix_list'] as $val){?>
        <a href="Javascript: void(0);"><img src="<?php echo themeImageUrl($val['affix_filethumb']);?>"/></a>
        <?php }?>
        <?php }?>
      </dd>
      <dd class="sub"><span id="_share_publisher">作者：<?php echo $output['theme_info']['member_name'];?></span><span id="_share_origin">来自：<?php echo $output['theme_info']['circle_name'];?></span></dd>
      <dd class="abstract"><?php echo removeUBBTag($output['theme_info']['theme_content']);?></dd>
    </dl>
    <!-- 站外分享 -->
    <?php if (C('share_isuse') == 1 && !empty($output['app_arr'])){?>
    <div class="share-widget"> <span class="title"><?php echo $lang['sharebind_alsoshareto'];?></span> <span class="s-app">
      <?php foreach ($output['app_arr'] as $k=>$v){?>
      <label nc_type="appitem_<?php echo $k;?>" title="<?php echo $v['name'];?>" class="<?php echo $v['isbind']?'checked':'disable';?>"> <i class="i-<?php echo $k;?>" nc_type="bindbtn" data-param='{"apikey":"<?php echo $k;?>","apiname":"<?php echo $v['name'];?>"}' attr_isbind="<?php echo $v['isbind']?'1':'0';?>"></i>
        <input type="hidden" id="checkapp_<?php echo $k;?>" name="checkapp_<?php echo $k;?>" value="<?php echo $v['isbind']?'1':'0';?>" />
      </label>
      <?php }?>
      <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_sharemanage"><?php echo $lang['sharebind_alsosharesetting'];?></a> </span> </div>
    <?php }?>
    <div class="share-content">
      <textarea placeholder="<?php echo $lang['sns_sharegoods_contenttip2'];?>" name="content" id="content_sgweibo" resize="none"></textarea>
    </div>
    <input type="text" style="display:none;" />
    <!-- 防止点击Enter键提交 -->
    <div class="handle">
      <div id="sgcharcount" class="count"></div>
      <div class="error form-error"></div>
      <input name="<?php echo $lang['nc_snsshare'];?>" type="button" class="button" value="<?php echo $lang['nc_snsshare'];?>" id="share_button" />
    </div>
    <input type="hidden" name="gprivacy" id="gprivacy" value="0"/>
  </form>
</div>
<textarea id="bindtooltip_module" style="display:none;">
<div class="eject_con"><dl><dt style="width:25%"><img src="<?php echo CIRCLE_TEMPLATES_URL;?>/images/shareicon/shareicon_@apikey.png" width="40" height="40" class="mt5 mr20"></dt><dd style="width:75%"><p><?php echo $lang['sharebind_list_popup_tip1'];?><strong class="ml5 mr5">@apiname</strong><?php echo $lang['sharebind_list_popup_tip2'];?></p><p class="red"><?php echo $lang['sharebind_list_popup_tip3'];?>@apiname<?php echo $lang['sharebind_list_popup_tip4'];?></p></dd></dl>
<dl class="bottom"><dt style="width:25%">&nbsp;</dt>
        <dd style="width:75%"><a href="javascript:void(0);" nc_type="finishbtn" data-param='{"apikey":"@apikey"}' class="ncu-btn2 mr10"><?php echo $lang['sharebind_list_finishbind'];?></a><span><?php echo $lang['sharebind_list_unfinishedbind'];?><a target="_blank" href="<?php echo CIRCLE_SITE_URL;?>/api.php?act=sharebind&type=@apikey" class="ml5"><?php echo $lang['sharebind_list_againbind'];?></a></span></dd>
      </dl>
</div>
</textarea>
<script type="text/javascript">
var max_recordnum = '<?php echo $output['max_recordnum'];?>';
$(function(){
	$(".thumb-cut .t-img").VMiddleImg({"width":100,"height":100});
	
	// Char Count
	$.getScript("<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js" ,function(){
		$("#content_sgweibo").charCount({
			allowed: 140,
			warning: 10,
			counterContainerID:'sgcharcount',
			firstCounterText:'<?php echo $lang['charCount_firsttext'];?>',
			endCounterText:'<?php echo $lang['charCount_endtext'];?>',
			errorCounterText:'<?php echo $lang['charCount_errortext'];?>'
		});
	});
	// form validate
	$('#share_form').validate({
		errorPlacement: function(error, element){
			$('.form-error').append(error);
	    },      
	    rules : {
	    	content : {
	            maxlength : 140
	        }
	    },
	    messages : {
	    	content : {
	            maxlength: '<?php echo $lang['sharebind_content_not_null'];?>'
	        }
	    }
	});
	$("[nc_type='bindbtn']").bind('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    // Determine whether the binding
	    var isbind = $(this).attr('attr_isbind');
	    if(isbind == '1'){// Is binding
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
		    // replace keywords
		    html = html.replace(/@apikey/g,data_str.apikey);
		    html = html.replace(/@apiname/g,data_str.apiname);
		    html_form("bindtooltip", "<?php echo $lang['sharebind_list_accountconnect'];?>", html, 360, 0);	    
		    window.open('api.php?act=sharebind&type='+data_str.apikey);
		}
	});
	$("[nc_type='finishbtn']").live('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
		// check binding
		var url = 'index.php?act=share&op=checkbind';
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

	$("#share_button").click(function(){
		if($("#share_form").valid()){
			ajaxpost('share_form', '', '', 'onerror');
		}
	});
});
</script>