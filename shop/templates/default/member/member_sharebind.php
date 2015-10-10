<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
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
<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="alert alert-block">
    <h4>提示：</h4>
    <ul>
      <li><?php echo $lang['sharebind_list_tip1'];?></li>
      <li><?php echo $lang['sharebind_list_tip2'];?></li>
    </ul>
  </div>
  <ul class="bind-account-list">
    <?php if(!empty($output['app_arr'])){?>
    <?php foreach($output['app_arr'] as $k=>$v){?>
    <li>
      <div class="account-item"><span class="website-icon"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicon_<?php echo $k;?>.png"></span>
        <dl>
          <dt><?php echo $v['name'];?></dt>
          <dd><?php echo $v['url'];?></dd>
          <dd class="operate">
            <?php if ($v['isbind']){?>
            <em><?php echo $lang['sharebind_list_bindtime'].$lang['nc_colon']; ?><?php echo @date('Y-m-d',$v['snsbind_updatetime']);?></em> <a href="javascript:void(0);" nc_type="unbindbtn" data-param='{"apikey":"<?php echo $k;?>","apiname":"<?php echo $v['name'];?>"}'><?php echo $lang['sharebind_list_unbind'];?></a>
            <?php }else {?>
            <a class="ncm-btn ncm-btn-green" nc_type="bindbtn" data-param='{"apikey":"<?php echo $k;?>","apiname":"<?php echo $v['name'];?>"}' href="javascript:void(0);"><?php echo $lang['sharebind_list_immediatelybind'];?></a>
            <?php }?>
          </dd>
        </dl>
      </div>
    </li>
    <?php }?>
    <?php }?>
  </ul>
</div>
<textarea id="bindtooltip_module" style="display:none;">
<div class="bindtooltip"><dl><dt><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/member/shareicon/shareicon_@apikey.png"></dt><dd><p><?php echo $lang['sharebind_list_popup_tip1'];?><strong>@apiname</strong><?php echo $lang['sharebind_list_popup_tip2'];?></p><p class="hint"><?php echo $lang['sharebind_list_popup_tip3'];?>@apiname<?php echo $lang['sharebind_list_popup_tip4'];?></p></dd></dl><div class="bottom"><a href="javascript:void(0);" nc_type="finishbtn" data-param='{"apikey":"@apikey"}' class="mini-btn"><?php echo $lang['sharebind_list_finishbind'];?></a><span><?php echo $lang['sharebind_list_unfinishedbind'];?><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/api.php?act=sharebind&type=@apikey"><?php echo $lang['sharebind_list_againbind'];?></a></span></div></div>
</textarea>
<script type="text/javascript">
$(function(){
	$("[nc_type='bindbtn']").bind('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    var html = $("#bindtooltip_module").text();
	    //替换关键字
	    html = html.replace(/@apikey/g,data_str.apikey);
	    html = html.replace(/@apiname/g,data_str.apiname);
	    CUR_DIALOG = html_form("bindtooltip", "<?php echo $lang['sharebind_list_accountconnect'];?>", html, 360, 0);
	    window.open('api.php?act=sharebind&type='+data_str.apikey);
	});
	$("[nc_type='unbindbtn']").bind('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    var confirm_tip = "<?php echo $lang['sharebind_list_unbind_confirmtip1'];?>"+data_str.apiname+"<?php echo $lang['sharebind_list_unbind_confirmtip2'];?>";
	    ajax_get_confirm(confirm_tip,'index.php?act=member_sharemanage&op=unbind&type='+data_str.apikey);
	});
	$("[nc_type='finishbtn']").live('click',function(){
		CUR_DIALOG.close();
		location.reload();
	});
});
</script>