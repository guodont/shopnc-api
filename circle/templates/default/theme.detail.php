<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo CIRCLE_TEMPLATES_URL;?>/css/ubb.css" rel="stylesheet" type="text/css">
<div class="group warp-all">
  <?php require_once circle_template('group.top');?>
  <div class="base-layout mt20">
    <div class="mainbox">
      <div class="theme-detail-header">
        <div class="member-avatar-m"><img src="<?php echo getMemberAvatarForID($output['theme_info']['member_id']);?>"/></div>
        <div class="theme-title"><i class="<?php if($output['theme_info']['is_shut'] == 1){
            	echo 'close';
            }elseif($output['theme_info']['is_stick'] == 1){
            	echo 'top';
            }elseif($output['theme_info']['is_digest'] == 1){
            	echo 'digest';
            }elseif($output['theme_info']['theme_special']==1){
				echo 'poll';
            }else{
            	echo 'normal';
            }?>" title=""></i>
          <h3><?php echo $output['theme_info']['theme_name'];?></h3>
        </div>
        <div class="theme-info-a"> <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $output['theme_info']['member_id'];?>" nctype="mcard" data-param="{'id':<?php echo $output['theme_info']['member_id'];?>}"><?php echo $output['theme_info']['member_name'];?></a><span class="floor">(<?php echo $lang['circle_landlord'];?>)</span>
          <?php echo memberLevelHtml(array('cm_level'=>intval($output['member_list'][$output['theme_info']['member_id']]['cm_level']), 'cm_levelname'=>$output['member_list'][$output['theme_info']['member_id']]['cm_levelname'], 'circle_id'=>$output['c_id']));?>
        </div>
        <div class="theme-info-b">
          <?php if($output['theme_info']['member_id'] == $_SESSION['member_id']){?>
          <span class="addtime"><?php echo $lang['circle_posted_in'];?><em><?php echo @date('Y-m-d', $output['theme_info']['theme_addtime']);?></em></span><span class="theme-edit"><i></i><a href="index.php?act=theme&op=edit_theme&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id'];?>"><?php echo $lang['nc_edit_theme'];?></a></span>
          <?php }?>
        </div>
        <div class="buttons"><a href="Javascript:history.go(-1);" class="back"><i></i><?php echo $lang['circle_return'];?></a>
          <?php if(C('circle_istalk') == 1){?>
          <div class="post-btn"><a href="index.php?act=theme&op=new_theme&c_id=<?php echo $output['c_id'];?>" class="new-theme"><i></i><?php echo $lang['circle_new_theme'];?></a>
            <div class="sub-menu"><span class="arrow"></span>
              <ul>
                <li class="new-poll"><a href="index.php?act=theme&op=new_theme&sp=1&c_id=<?php echo $output['c_id'];?>"><i></i><?php echo $lang['circle_new_poll'];?></a></li>
              </ul>
            </div>
          </div>
          <a href="#quickReply" class="reply-theme"><i></i><?php echo $lang['circle_reply'];?></a>
          <?php }?>
        </div>
      </div>
      <?php if($output['theme_info']['theme_special'] == 1){require_once circle_template('theme.detail_poll');}?>
      <div class="theme-detail-content">
        <?php if($output['theme_info']['is_closed'] == '0'){?>
        <div class="main-text"><?php echo ubb($output['theme_info']['theme_content']);?></div>
        <?php if($output['theme_info']['theme_edittime'] != ''){?>
        <div class="theme-edittime"><span><?php echo $output['theme_info']['theme_editname'];?>&nbsp;<?php echo $lang['nc_at'];?>&nbsp;<?php echo @date('Y-m-d', $output['theme_info']['theme_edittime'])?>&nbsp;<?php echo $lang['circle_last_edit'];?></span></div>
        <?php }?>
        <?php if(!empty($output['goods_list'])){?>
        <div class="theme-content-goods">
          <h4><i></i><?php echo $lang['circle_relevance_goods'];?></h4>
          <ul>
            <?php foreach($output['goods_list'] as $val){?>
            <li>
              <div class="goods-pic thumb"><a href="javascript:void(0);"><img src="<?php echo $val['image'];?>" class="t-img" /></a></div>
              <div class="goods-name"><?php echo $val['goods_name'];?></div>
              <div class="goods-price"><em><?php echo $val['goods_price'];?></em></div>
              <a href="<?php echo $val['thg_url'];?>" class="goto" target="_blank"><?php echo $lang['circle_goods_detail'];?></a> </li>
            <?php }?>
          </ul>
        </div>
        <?php }?>
        <?php if(!empty($output['affix_list'])){?>
        <div class="theme-content-file clearfix">
          <h4 class="file-hidden-btn"><i></i><?php echo $lang['nc_relevance_adjunct'];?></h4>
          <div class="file-hidden"> <i class="arrow"></i>
            <ul>
              <?php foreach($output['affix_list'] as $val){?>
              <li><a href="<?php echo themeImageUrl($val['affix_filename']);?>" class="nyroModal" rel="gal" title="<?php echo $lang['circle_affix_image_title_one'].$output['theme_info']['theme_name'].$lang['circle_affix_image_title_two'];?>"><img src="<?php echo themeImageUrl($val['affix_filethumb']);?>"/></a> </li>
              <?php }?>
            </ul>
          </div>
        </div>
        <?php }?>
        <?php }else{?>
        <div class="main-text theme-detail-nospeak"><?php echo $lang['circle_be_nospeak_member'];?></div>
        <?php }?>
        <div class="handle-bar">
          <?php if($output['super'] || in_array($output['identity'], array(1,2))){?>
          <div class="manage"> <a href="javascript:void(0);" class="manage-button"><?php echo $lang['circle_theme_manage'];?></a> <span class="manage-content"> <a href="javascript:void(0);" nctype="<?php if($output['theme_info']['is_digest'] == 0){?>themeDigestYes<?php }else{?>themeDigestNo<?php }?>">
            <?php if($output['theme_info']['is_digest'] == 0){echo $lang['circle_digest'];}else{echo $lang['circle_digest_cancel'];}?>
            </a> <a href="javascript:void(0);" nctype="<?php if($output['theme_info']['is_stick'] == 0){?>themeTopYes<?php }else{?>themeTopNo<?php }?>">
            <?php if($output['theme_info']['is_stick'] == 0){echo $lang['circle_stick'];}else{echo $lang['circle_stick_cancel'];}?>
            </a> <a href="javascript:void(0);" nctype="<?php if($output['theme_info']['is_closed'] == 0){?>themeCloseYes<?php }else{?>themeCloseNo<?php }?>" data-param="<?php echo $output['theme_info']['member_id'];?>">
            <?php if($output['theme_info']['is_closed'] == 0){echo $lang['circle_nospeak'];}else{echo $lang['circle_nospeak_cancel'];}?>
            </a> <a href="javascript:void(0);" nctype="<?php if($output['theme_info']['is_shut'] == 0){?>themeShutYes<?php }else{?>themeShutNo<?php }?>">
            <?php if($output['theme_info']['is_shut'] == 0){echo $lang['nc_close'];}else{echo $lang['nc_open'];}?>
            </a> <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=edit_theme&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id'];?>"><?php echo $lang['nc_edit'];?></a> <a href="javascript:void(0);" nctype="themeDelManage"><?php echo $lang['nc_delete'];?></a> </span> </div>
          <?php }?>
          <div class="normal"> <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $output['c_id']?>&t_id=<?php echo $output['t_id'];if($_GET['only_id'] == ''){?>&only_id=<?php echo $val['member_id'];}?>" class="noborder">
            <?php if($_GET['only_id'] != ''){echo $lang['circle_see_all'];}else{echo $lang['circle_see_TA'];}?>
            </a> <a href="javascript:void(0);" nctype="<?php if($output['theme_onlike'] == 1){?>themeLikeYes<?php }else{?>themeLikeNo<?php }?>">
            <?php if($output['theme_onlike'] == 1){echo $lang['circle_like'];}else{echo $lang['circle_like_cancel'];}?>
            (<em nctype="like"><?php echo $output['theme_info']['theme_likecount'];?></em>) </a>
            <a href="#quickReply"> <?php echo $lang['circle_reply'];?>(<?php echo $output['theme_info']['theme_commentcount'];?>) </a>
            <a href="javascript:void(0);" nctype="themeShare"> <?php echo $lang['circle_share'];?>(<em nctype="share"><?php echo $output['theme_info']['theme_sharecount'];?></em>) </a>
            <?php if($output['identity'] == 3){?>
            <a href="javascript:void(0);" nctype="inform"> <?php echo $lang['circle_inform']?> </a>
            <?php }?>
          </div>
        </div>
      </div>
      <?php if(!empty($output['reply_info'])){?>
      <ul class="theme-reply-list">
        <?php foreach ($output['reply_info'] as $val){?>
        <li class="reply-info" id="f<?php echo $val['reply_id'];?>">
          <dl>
            <dt class="membar-name"> <a href="javascript:void(0);" nctype="mcard" data-param="{'id':<?php echo $val['member_id'];?>}"><?php echo $val['member_name'];?></a>
              <?php echo memberLevelHtml(array('cm_level'=>intval($output['member_list'][$val['member_id']]['cm_level']), 'cm_levelname'=>$output['member_list'][$val['member_id']]['cm_levelname'], 'circle_id'=>$output['c_id']));?>
              <span class="addtime"><?php echo @date('Y-m-d H:i', $val['reply_addtime']);?></span>
              <?php if($val['reply_replyid'] != ''){?>
              <span class="reply-floor"><a href="<?php echo spellInformUrl(array('circle_id'=>$val['circle_id'], 'theme_id'=>$val['theme_id'], 'reply_id'=>$val['reply_replyid']));?>"><?php echo $lang['circle_reply'];?>&nbsp;<?php echo $val['reply_replyid'].$lang['circle_floor'];?>&nbsp;<?php echo $val['reply_replyname']?>&nbsp;<?php echo $lang['circle_of_post'];?></a></span>
              <?php }?>
            </dt>
            <?php if($val['member_id'] == $_SESSION['member_id']){?>
            <dd class="reply-manage"> <span><?php echo $lang['circle_my_manage'];?><i></i></span><span class="hidden"><a href="index.php?act=theme&op=edit_reply&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id'];?>&r_id=<?php echo $val['reply_id'];?>"><?php echo $lang['circle_edit_my_reply'];?></a><a href="Javascript: void(0)" nctype="del_reply" data-param="<?php echo $val['reply_id'];?>"><?php echo $lang['circle_delete_my_reply'];?></a></span> </dd>
            <?php }?>
            <?php if(intval($output['reply_replyid']) > 0){?>
            <dd><?php echo $lang['circle_reply'];?>&nbsp;#<?php echo $output['reply_replyid'].$lang['circle_floor'];?>#&nbsp;<?php echo $output['reply_replyname'];?>&nbsp;<?php echo $lang['circle_of_post'];?></dd>
            <?php }?>
            <dd class="member-avatar-m"><img src="<?php echo getMemberAvatarForID($val['member_id']);?>" /></dd>
            <?php if($val['is_closed'] == '0'){?>
            <dd class="reply-content"><?php echo ubb($val['reply_content']);?></dd>
            <?php if(!empty($output['reply_affix'][$val['reply_id']])){?>
            <dd class="reply-file clearfix">
              <h4><i></i><?php echo $lang['nc_relevance_adjunct'];?></h4>
              <ul>
                <?php foreach($output['reply_affix'][$val['reply_id']] as $val){?>
                <li> <a href="<?php echo themeImageUrl($val['affix_filename']);?>" class="nyroModal" rel="gal" title="<?php echo $lang['circle_reply_image_title_one'].$val['reply_id'].$lang['circle_reply_image_title_two'];?>"><img src="<?php echo themeImageUrl($val['affix_filethumb']);?>"/></a> </li>
                <?php }?>
              </ul>
            </dd>
            <?php }?>
            <?php if(!empty($output['reply_goods'][$val['reply_id']])){?>
            <dd class="reply-goods clearfix">
              <h4><i></i><?php echo $lang['circle_relevance_goods'];?></h4>
              <ul>
                <?php foreach ($output['reply_goods'][$val['reply_id']] as $val){?>
                <li>
                  <div class="goods-pic thumb size30"><a href="javascript:void(0);" class="size30"><img src="<?php echo $val['image'];?>" class="t-img" /></a></div>
                  <div class="goods-name"><?php echo $val['goods_name'];?></div>
                  <div class="goods-price"><em><?php echo $val['goods_price'];?></em></div>
                  <a href="<?php echo $val['thg_url'];?>" class="goto" target="_blank"><?php echo $lang['circle_goods_detail'];?></a> </li>
                <?php }?>
              </ul>
            </dd>
            <?php }?>
            <?php }else{?>
            <dd class="reply-content reply-nospeak"><?php echo $lang['circle_be_nospeak_member'];?></dd>
            <?php }?>
            <dd class="floor"><?php echo $val['reply_id'].$lang['circle_floor'];?></dd>
            <dd class="handle-bar">
              <?php if($output['super'] || in_array($output['identity'], array(1,2))){?>
              <div class="manage"> <a href="javascript:void(0);" class="manage-button"><?php echo $val['reply_id'].$lang['circle_floor'];?>&nbsp;<?php echo $lang['circle_reply_manage'];?></a> <span class="manage-content"> <a href="javascript:void(0);" nctype="<?php if($val['is_closed'] == 0){?>themeCloseYes<?php }else{?>themeCloseNo<?php }?>" data-param="<?php echo $val['member_id'];?>">
                <?php if($val['is_closed'] == 0){echo $lang['circle_nospeak'];}else{echo $lang['circle_nospeak_cancel'];}?>
                </a> <a href="javascript:void(0);" nctype="replyDelManage" data-param="<?php echo $val['reply_id'];?>"><?php echo $lang['nc_delete'];?></a></span> </div>
              <?php }?>
              <div class="normal"> <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $output['c_id']?>&t_id=<?php echo $output['t_id'];if($_GET['only_id'] == ''){?>&only_id=<?php echo $val['member_id'];}?>">
                <?php if($_GET['only_id'] != ''){echo $lang['circle_see_all'];}else{echo $lang['circle_see_TA'];}?>
                </a>
                <a href="<?php echo CIRCLE_SITE_URL?>/index.php?act=theme&op=reply&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id'];?>&answer_id=<?php echo $val['reply_id'];?>"><?php echo $lang['circle_reply'];?></a>
                <?php if(in_array($output['identity'], array(1,2,3))){?>
                <a href="javascript:void(0);" nctype="inform" data-param="{r_id:<?php echo $val['reply_id'];?>}"><?php echo $lang['circle_inform'];?></a>
                <?php }?>
              </div>
            </dd>
          </dl>
        </li>
        <?php }?>
      </ul>
      <div class="pagination"><?php echo $output['show_page'];?></div>
      <?php }?>
      <div class="quick-reply">
        <?php if(!intval(C('circle_istalk'))){?>
        <div class="ban"><?php echo $lang['circle_has_been_closed_reply'];?></div>
        <?php }else if($output['theme_info']['is_shut'] == 1){?>
        <div class="ban"><?php echo $lang['circle_theme_is_closed'];?></div>
        <?php }else if($_SESSION['is_login'] != 1){?>
        <div class="ban"><?php echo $lang['circle_not_login_prompt'];?><a href="javascript:void(0);" nctype="login"><?php echo $lang['nc_login'];?></a></div>
        <?php }else if(in_array($output['identity'], array(0,5))){?>
        <div class="ban"> <?php echo $lang['circle_not_join_prompt_one'];?><a href="javascript:void(0);" nctype="apply"><?php echo $lang['circle_not_join_prompt_two'];?></a><?php echo $lang['circle_not_join_prompt_three'];?></div>
        <?php }else if($output['identity'] == 4){?>
        <div class="ban"> <?php echo $lang['circle_waiting_verify_prompt'];?></div>
        <?php }else if($output['identity'] == 6){?>
        <div class="ban"><?php echo $lang['circle_nospeak_reply_prompt'];?></div>
        <?php }?>
        <div class="quick-reply-member"><a id="quickReply"></a>
          <div class="member-avatar-m"><img src="<?php echo getMemberAvatarForID($output['cm_info']['member_id']);?>"/></div>
        </div>
        <form method="post" id="reply_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=save_reply&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id'];?>">
          <input type="hidden" name="form_submit" value="ok" />
          <?php echo showMiniEditor('replycontent', '', 'hQuickReply');?>
          <div class="bottom"> <a class="submit-btn" nctype="reply_submit" href="Javascript: void(0)"><?php echo $lang['nc_release_reply'];?></a>
            <div id="warning"></div>
          </div>
        </form>
        <div class="clear"></div>
      </div>
    </div>
    <?php require_once circle_template('group.sidebar');?>
    <div class="clear"></div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/miniditor/jquery.insertsome.min.js"></script> 
<script type="text/javascript" src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/miniditor/ubb.insert.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js"></script> 
<!--[if IE 6]>
	<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/ie6.min.js"></script>
<![endif]--> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script type="text/javascript">
var c_id = <?php echo $output['c_id'];?>;
var t_id = <?php echo $output['t_id'];?>;
$(function(){
	// UBB
	$('.quick-reply').ncUBB({
		c_id : c_id,
		t_id : t_id,
		UBBContent : $('#replycontent'),
		UBBSubmit : $('a[nctype="reply_submit"]'),
		UBBform : $('#reply_form'),
		UBBfileuploadurl : 'index.php?act=theme&op=image_upload&c_id='+c_id,
		UBBcontentleast : <?php echo intval(C('circle_contentleast'));?>
	});
	//附件隐藏/显示
	$(".file-hidden-btn").click(function(){
		$(".file-hidden").slideToggle(100);
	});
	//附件放大查看
	$('.nyroModal').nyroModal();
	
//横高局中比例缩放隐藏显示图片
	
	$(".theme-content-goods .t-img").VMiddleImg({"width":60,"height":60});
	$(".reply-goods .t-img").VMiddleImg({"width":30,"height":30});
	
	// 表单验证
    $('#reply_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('reply_form', CIRCLE_SITE_URL+'/index.php?act=theme&op=save_reply&c_id='+c_id+'&t_id='+t_id, '', 'onerror');
    	},
        rules : {
        	replycontent : {
                required : true
                <?php if(intval(C('circle_contentleast')) > 0){?>
                ,minlength : <?php echo intval(C('circle_contentleast'));?>
                <?php }?>
            }
        },
        messages : {
        	replycontent  : {
                required : '<?php echo $lang['nc_content_not_null'];?>'
                <?php if(intval(C('circle_contentleast')) > 0){?>
                ,minlength : '<?php printf(L('nc_content_min_length'), intval(C('circle_contentleast')));?>'
                <?php }?>
            }
        }
    });

    $('a[nctype="del_reply"]').click(function(){
        var r_id = $(this).attr('data-param');
    	showDialog('<?php echo $lang['nc_ensure_del'];?>', 'confirm', '', function(){
    		_uri = "<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=del_reply&c_id="+c_id+"&t_id="+t_id+"&r_id="+r_id;
    		ajaxget(_uri);
    	});
	});

	// share
	$('a[nctype="themeShare"]').click(function(){
		if(_ISLOGIN){
			var _uri = CIRCLE_SITE_URL+"/index.php?act=theme_share&c_id="+c_id+"&t_id="+t_id;
			CUR_DIALOG = ajax_form('share', '<?php echo $lang['circle_share_theme'];?>', _uri, 480);
		}else{
			login_dialog();		
		}
	});
	// inform 
	$('a[nctype="inform"]').click(function(){
		if(_ISLOGIN){
			var _uri = CIRCLE_SITE_URL+"/index.php?act=theme_inform&c_id="+c_id+"&t_id="+t_id;
			var _title = '<?php echo $lang['circle_inform_theme'];?>';
			if(typeof($(this).attr('data-param')) != 'undefined'){
				var data_str = $(this).attr('data-param'); eval('data_str = ' + data_str);
				_uri += '&r_id='+data_str.r_id;
				_title = '<?php echo $lang['circle_inform_reply'];?>';
			}
			ajax_form('inform', _title, _uri, 520);
		}else{
			login_dialog();
		}
	});
});
</script> 