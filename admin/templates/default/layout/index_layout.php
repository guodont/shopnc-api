<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html;" charset="<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/skin_0.css" rel="stylesheet" type="text/css" id="cssfile"/>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.cookie.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<script>
//
$(document).ready(function () {
    $('span.bar-btn').click(function () {
	$('ul.bar-list').toggle('fast');
    });
});

$(document).ready(function(){
	var pagestyle = function() {
		var iframe = $("#workspace");
		var h = $(window).height() - iframe.offset().top;
		var w = $(window).width() - iframe.offset().left;
		if(h < 300) h = 300;
		if(w < 973) w = 973;
		iframe.height(h);
		iframe.width(w);
	}
	pagestyle();
	$(window).resize(pagestyle);
	//turn location
	if($.cookie('now_location_act') != null){
		openItem($.cookie('now_location_op')+','+$.cookie('now_location_act')+','+$.cookie('now_location_nav'));
	}else{
		$('#mainMenu>ul').first().css('display','block');
		//第一次进入后台时，默认定到欢迎界面
		$('#item_welcome').addClass('selected');
		$('#workspace').attr('src','index.php?act=dashboard&op=welcome');
	}
	$('#iframe_refresh').click(function(){
		var fr = document.frames ? document.frames("workspace") : document.getElementById("workspace").contentWindow;;
		fr.location.reload();
	});

});
//收藏夹
function addBookmark(url, label) {
    if (document.all)
    {
        window.external.addFavorite(url, label);
    }
    else if (window.sidebar)
    {
        window.sidebar.addPanel(label, url, '');
    }
}


function openItem(args){
    closeBg();
	//cookie

	if($.cookie('<?php echo COOKIE_PRE?>sys_key') === null){
		location.href = 'index.php?act=login&op=login';
		return false;
	}

	spl = args.split(',');
	op  = spl[0];
	try {
		act = spl[1];
		nav = spl[2];
	}
	catch(ex){}
	if (typeof(act)=='undefined'){var nav = args;}
	$('.actived').removeClass('actived');
	$('#nav_'+nav).addClass('actived');

	$('.selected').removeClass('selected');

	//show
	$('#mainMenu ul').css('display','none');
	$('#sort_'+nav).css('display','block');

	if (typeof(act)=='undefined'){
		//顶部菜单事件
		html = $('#sort_'+nav+'>li>dl>dd>ol>li').first().html();
		str = html.match(/openItem\('(.*)'\)/ig);
		arg = str[0].split("'");
		spl = arg[1].split(',');
		op  = spl[0];
		act = spl[1];
		nav = spl[2];
		first_obj = $('#sort_'+nav+'>li>dl>dd>ol>li').first().children('a');
		$(first_obj).addClass('selected');
		//crumbs
		$('#crumbs').html('<span>'+$('#nav_'+nav+' > span').html()+'</span><span class="arrow">&nbsp;</span><span>'+$(first_obj).text()+'</span>');
	}else{
		//左侧菜单事件
		//location
		$.cookie('now_location_nav',nav);
		$.cookie('now_location_act',act);
		$.cookie('now_location_op',op);
		$("a[name='item_"+op+act+"']").addClass('selected');
		//crumbs
		$('#crumbs').html('<span>'+$('#nav_'+nav+' > span').html()+'</span><span class="arrow">&nbsp;</span><span>'+$('#item_'+op+act).html()+'</span>');
	}
	src = 'index.php?act='+act+'&op='+op;
	$('#workspace').attr('src',src);

}

$(function(){
		bindAdminMenu();
		})
		function bindAdminMenu(){

		$("[nc_type='parentli']").click(function(){
			var key = $(this).attr('dataparam');
			if($(this).find("dd").css("display")=="none"){
				$("[nc_type='"+key+"']").slideDown("fast");
				$(this).find('dt').css("background-position","-322px -170px");
				$(this).find("dd").show();
			}else{
				$("[nc_type='"+key+"']").slideUp("fast");
				$(this).find('dt').css("background-position","-483px -170px");
				$(this).find("dd").hide();
			}
		});
	}
</script>
<script type="text/javascript">
//显示灰色JS遮罩层
function showBg(ct,content){
var bH=$("body").height();
var bW=$("body").width();
var objWH=getObjWh(ct);
$("#pagemask").css({width:bW,height:bH,display:"none"});
var tbT=objWH.split("|")[0]+"px";
var tbL=objWH.split("|")[1]+"px";
$("#"+ct).css({top:tbT,left:tbL,display:"block"});
$(window).scroll(function(){resetBg()});
$(window).resize(function(){resetBg()});
}
function getObjWh(obj){
var st=document.documentElement.scrollTop;//滚动条距顶部的距离
var sl=document.documentElement.scrollLeft;//滚动条距左边的距离
var ch=document.documentElement.clientHeight;//屏幕的高度
var cw=document.documentElement.clientWidth;//屏幕的宽度
var objH=$("#"+obj).height();//浮动对象的高度
var objW=$("#"+obj).width();//浮动对象的宽度
var objT=Number(st)+(Number(ch)-Number(objH))/2;
var objL=Number(sl)+(Number(cw)-Number(objW))/2;
return objT+"|"+objL;
}
function resetBg(){
var fullbg=$("#pagemask").css("display");
if(fullbg=="block"){
var bH2=$("body").height();
var bW2=$("body").width();
$("#pagemask").css({width:bW2,height:bH2});
var objV=getObjWh("dialog");
var tbT=objV.split("|")[0]+"px";
var tbL=objV.split("|")[1]+"px";
$("#dialog").css({top:tbT,left:tbL});
}
}

//关闭灰色JS遮罩层和操作窗口
function closeBg(){
$("#pagemask").css("display","none");
$("#dialog").css("display","none");
}
</script>
<script type="text/javascript">
$(function(){
    var $li =$("#skin li");
		$li.click(function(){
		$("#"+this.id).addClass("selected").siblings().removeClass("selected");
		$("#cssfile").attr("href","<?php echo ADMIN_TEMPLATES_URL;?>/css/"+ (this.id) +".css");
        $.cookie( "MyCssSkin" ,  this.id , { path: '/', expires: 10 });

        $('iframe').contents().find('#cssfile2').attr("href","<?php echo ADMIN_TEMPLATES_URL;?>/css/"+ (this.id) +".css");
    });

    var cookie_skin = $.cookie( "MyCssSkin");
    if (cookie_skin) {
		$("#"+cookie_skin).addClass("selected").siblings().removeClass("selected");
		$("#cssfile").attr("href","<?php echo ADMIN_TEMPLATES_URL;?>/css/"+ cookie_skin +".css");
		$.cookie( "MyCssSkin" ,  cookie_skin  , { path: '/', expires: 10 });
    }
});
function addFavorite(url, title) {
	try {
		window.external.addFavorite(url, title);
	} catch (e){
		try {
			window.sidebar.addPanel(title, url, '');
        	} catch (e) {
			showDialog("<?php echo $lang['nc_to_favorite'];?>", 'notice');
		}
	}
}
</script>

</head>

<body style="min-width: 1200px; margin: 0px; ">
<div id="pagemask"></div>
<div id="dialog" style="display:none">
  <div class="title">
    <h3><?php echo $lang['nc_admin_navigation'];?></h3>
    <span><a href="JavaScript:void(0);" onclick="closeBg();"><?php echo $lang['nc_close'];?></a></span> </div>
  <div class="content">
  <?php foreach ($output['map_nav'] as $k=>$v) {?>
  <dl>
  <dt><?php echo $v['text'];?></dt>
  	<?php foreach ($v['list'] as $key=>$value) {?>
  	<dd><a href="javascript:void(0)" onclick="openItem('<?php echo $value['args']?>')"><?php echo $value['text'];?></a></dd>
  	<?php }?>
  	 </dl>
  <?php }?>
  </div>
</div>
<table style="width: 100%;" id="frametable" height="100%" width="100%" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td colspan="2" height="90" class="mainhd"><div class="layout-header"> <!-- Title/Logo - can use text instead of image -->
          <div id="title"><a href="index.php"></a></div>
          <!-- Top navigation -->
          <div id="topnav" class="top-nav">
            <ul>
              <li class="adminid" title="<?php echo $lang['nc_hello'];?>:<?php echo $output['admin_info']['name'];?>"><?php echo $lang['nc_hello'];?>&nbsp;:&nbsp;<strong><?php echo $output['admin_info']['name'];?></strong></li>
              <li><a href="index.php?act=index&op=modifypw" target="workspace" ><span><?php echo $lang['nc_modifypw']; ?></span></a></li>
              <li><a href="index.php?act=index&op=logout" title="<?php echo $lang['nc_logout'];?>"><span><?php echo $lang['nc_logout'];?></span></a></li>
              <li><a href="<?php echo BASE_SITE_URL;?>" target="_blank" title="<?php echo $lang['nc_homepage'];?>"><span><?php echo $lang['nc_homepage'];?></span></a></li>
            </ul>
          </div>
          <!-- End of Top navigation -->
          <!-- Main navigation -->
          <nav id="nav" class="main-nav">
            <ul>
           <?php echo $output['top_nav'];?>
            </ul>
          </nav>
          <div class="loca"><strong><?php echo $lang['nc_loca'];?>:</strong>
            <div id="crumbs" class="crumbs"><span><?php echo $lang['nc_console'];?></span><span class="arrow">&nbsp;</span><span><?php echo $lang['nc_welcome_page'];?></span> </div>
          </div>
          <div class="toolbar">
            <ul id="skin" class="skin"><span><?php echo $lang['nc_skin_peeler'];?></span>
              <li id="skin_0" class="" title="<?php echo $lang['nc_default_style'];?>"></li>
              <li id="skin_1" class="" title="<?php echo $lang['nc_mac_style'];?>"></li>
            </ul>
            <div class="sitemap"><a id="siteMapBtn" href="#rhis" onclick="showBg('dialog','dialog_content');"><span><?php echo $lang['nc_sitemap'];?></span></a></div>
            <div class="toolmenu"><span class="bar-btn"></span>
              <ul class="bar-list">
                <li><a onclick="openItem('clear,cache,setting');" href="javascript:void(0)"><?php echo $lang['nc_update_cache'];?></a></li>
                <li><a href="<?php echo ADMIN_SITE_URL;?>" id="iframe_refresh"><?php echo $lang['nc_refresh'];?><?php echo $lang['nc_admincp']; ?></a></li>
                <li><a href="<?php echo ADMIN_SITE_URL;?>" title="<?php echo $lang['nc_admincp']; ?>-<?php echo $output['html_title'];?>" rel="sidebar" onclick="addFavorite('<?php echo ADMIN_SITE_URL;?>', '<?php echo $lang['nc_admincp']; ?>-<?php echo $output['html_title'];?>');return false;"><?php echo $lang['nc_favorite']; ?><?php echo $lang['nc_admincp']; ?></a></li>
                <!--//zmr>v30-->
                <li><a href="index.php?act=setting&op=exetarget" target="_blank">执行计划任务</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div > </div></td>
    </tr>
    <tr>
      <td class="menutd" valign="top" width="161"><div id="mainMenu" class="main-menu">
          <?php echo $output['left_nav'];?>
        </div><div class="copyright" style="display:none"></div></td>
      <td valign="top" width="100%"><iframe src="" id="workspace" name="workspace" style="overflow: visible;" frameborder="0" width="100%" height="100%" scrolling="yes" onload="window.parent"></iframe></td>
    </tr>
  </tbody>
</table>
</body>
</html>
