<?php defined('InShopNC') or exit('Access Invalid!');?>

<Script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/slider.js" charset="utf-8"></Script>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/flea_info.css" rel="stylesheet" type="text/css">

<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/jquery.jqzoom.js" ></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/goodsinfo.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/dialog.js" id="dialog_js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL;?>/js/flea/dialog.css">
<script>
function collect_flea(fav_id){
    var url = 'index.php?act=member_flea&op=addfavorites';
    $.getJSON(url, {'fav_id':fav_id}, function(data){
        if (data.done)
        {
            alert(data.msg);
            setTimeout(slideUp_fn, 5000);
        }
        else
        {
            alert(data.msg);
        }
    });
}
function slideUp_fn()
{
    $('.ware_cen').slideUp('slow');
}
</script>
<script type="text/javascript">
function collect_goods(fav_id){
    var url = 'index.php?act=member&op=addfavorites';
    $.getJSON(url, {'fav_id':fav_id}, function(data){
        if (data.done)
        {
            alert(data.msg);
            setTimeout(slideUp_fn, 5000);
        }
        else
        {
            alert(data.msg);
        }
    });
}

$(document).ready(function(){
  $("#slider_high div").hover(
  function () {
    $(this).addClass("hightlight");
  },
  function () {
    $(this).removeClass("hightlight");
  }
);
});
</script>
<style type="text/css">
.content #slider_high .hightlight{border-color:#FD7D00;border-style:solid;border-width:2px;margin: 0 8px;}
</style>
<div class="content">
  <div id="flea_info_slider">
    <div id="slider" style="position:absolute; left:50px">
      <ul id="slider_high">
        <li class="sell_two">
        <?php if(!empty($output['goods_commend']) && is_array($output['goods_commend'])){?>
 			<?php foreach ($output['goods_commend'] as $comment_goods){?>
 			<div class="pic fn-left<?php if(intval($_GET['goods_id']) == $comment_goods['goods_id']){echo ' bor';} ?>">
            <span class="thumb size76">
              <i></i>
              <a href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $comment_goods['goods_id'];?>">
              	<img height="76" width="76" onload="javascript:DrawImage(this,76,76);" src="<?php echo $comment_goods['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$comment_goods['member_id'].DS.$comment_goods['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" title="<?php echo $comment_goods['goods_name'] ?>" />
              </a>
			</span>
            <?php if(intval($_GET['goods_id']) == $comment_goods['goods_id']){ ?>
            <span class="time"><?php echo checkTime($comment_goods['goods_add_time']);?><?php echo $lang['flea_index_front'];?></span>
            <?php }?>
			</div>
              <?php }?>
              <?php }?>
        </li>
        <li class="sell_two">
        <?php if(!empty($output['goods_commend4']) && is_array($output['goods_commend4'])){?>
      <?php foreach ($output['goods_commend4'] as $comment_goods){?>
      <div class="pic fn-left<?php if(intval($_GET['goods_id']) == $comment_goods['goods_id']){echo ' bor';} ?>">
            <span class="thumb size76">
              <i></i>
              <a href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $comment_goods['goods_id'];?>">
                <img height="76" width="76" onload="javascript:DrawImage(this,76,76);" src="<?php echo $comment_goods['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$comment_goods['member_id'].DS.$comment_goods['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" title="<?php echo $comment_goods['goods_name'] ?>" />
              </a>
      </span>
            <?php if(intval($_GET['goods_id']) == $comment_goods['goods_id']){ ?>
            <span class="time"><?php echo checkTime($comment_goods['goods_add_time']);?><?php echo $lang['flea_index_front'];?></span>
            <?php }?>
      </div>
              <?php }?>
              <?php }?>
        </li>
        <li class="sell_two">
        <?php if(!empty($output['goods_commend5']) && is_array($output['goods_commend5'])){?>
      <?php foreach ($output['goods_commend5'] as $comment_goods){?>
      <div class="pic fn-left<?php if(intval($_GET['goods_id']) == $comment_goods['goods_id']){echo ' bor';} ?>">
            <span class="thumb size76">
              <i></i>
              <a href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $comment_goods['goods_id'];?>">
                <img height="76" width="76" onload="javascript:DrawImage(this,76,76);" src="<?php echo $comment_goods['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$comment_goods['member_id'].DS.$comment_goods['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" title="<?php echo $comment_goods['goods_name'] ?>" />
              </a>
      </span>
            <?php if(intval($_GET['goods_id']) == $comment_goods['goods_id']){ ?>
            <span class="time"><?php echo checkTime($comment_goods['goods_add_time']);?><?php echo $lang['flea_index_front'];?></span>
            <?php }?>
      </div>
              <?php }?>
              <?php }?>
        </li>
      </ul>
    </div>
  </div>
  <div class="flea_info_main">
    <div class="content_780 fn-left" style="position: relative;" nc_type="jqzoom_relative">
      <h1 class="ware_title">
        <strong class="fn-left"><?php echo $output['goods_title'];?></strong>
      </h1>
      <div style=" float:left; width:302px;"> 
      
      <div class="ware_pic">
        <div class="big_pic"><i><a href="javascript:void(0)">
        	<span class="jqzoom">
        		<div class="ico" style="display:none"></div>
        		<img height="300" width="300" src="<?php if (empty($output['desc_image'])){ echo SHOP_TEMPLATES_URL.'/images/member/default_image.png'; }else{ echo $output['goods_image']['thumb_mid'];} ?>" onerror="this.src='<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png'; ?>'" onload="javascript:DrawImage(this,300,300);" jqimg="<?php echo $output['goods_image']['thumb_max'];?>" />
        		<div class='jqZoomPup'>&nbsp;</div>
        	</span>
        	<div class='zoomdiv' style='top:-9999em;'><img class='bigimg' src="<?php echo $output['goods_image']['thumb_max'];?>" /></div>
        </a></i></div>
        <div class="bottom_btn">
          <div class="ware_box">
            <ul>
              <?php if (!empty($output['desc_image'])) { 
			  	foreach($output['desc_image'] as $key => $val) {
			  ?>
              <li <?php if($key == 0) { ?>class="ware_pic_hover"<?php } ?> bigimg="<?php echo $val['thumb_max']; ?>">
              	<span class="thumb size40"><i></i><img height="40" width="40" src="<?php echo $val['thumb_small']; ?>" onerror="this.src='<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'" onload="javascript:DrawImage(this,40,40);" /></span>
              </li>
        <?php
			  	}
			  }
			  ?>
            </ul>
          </div>
        </div>
      </div>
 <div class="share">
   <span><?php echo $lang['flea_share'];?></span>
          <!-- Baidu Button BEGIN -->
          <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"> <span class="bds_more"><?php echo $lang['goods_index_share_to'];?></span> <a class="bds_tqq"></a> <a class="bds_tsina"></a> <a class="bds_renren"></a> <a class="bds_baidu"></a> <a class="bds_copy"></a> <a class="shareCount"></a> </div>
          <script type="text/javascript" id="bdshare_js" data="type=tools" ></script> 
          <script type="text/javascript" id="bdshell_js"></script> 
          <script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();
</script> 
          <!-- Baidu Button END --> 
   <span>|</span>
   <span><a href="#" class="blue" onclick="javascrit:collect_flea(<?php echo $output['goods']['goods_id'];?>);return false;"><?php echo $lang['flea_goods_collect_goods'];?></a></span>    </div>  
      </div>
      <div class="ware_info">
        <div id="property" class="fn-right">
        <ul class="item_info">
          <li class="price"><em><?php echo $lang['flea_transfer_price'];?></em><strong><?php echo $output['goods']['goods_store_price'];?></strong><em><?php echo $lang['flea_index_rmb'];?></em></li>
          <li><em><?php echo $lang['flea_transfer_area'];?>:</em><a class="orange" href="index.php?act=flea_class&area_input=<?php echo $output['goods']['flea_area_id']?>"><?php echo $output['goods']['flea_area_name']?></a></li>
          <li class="rank_new">
            <?php echo $lang['flea_old_deep'];?>:
            <span><?php checkQuality($output['goods']['flea_quality'])?></span>
            <span class="tb-tips">
               <s class="tb-tips-l"></s>
               <?php echo $lang['flea_oldnew_choose'];?>?
               <a class="ico3" style="text-decoration:none; cursor:pointer;" nc_type="dialog" dialog_id="friend_add" dialog_title="<?php echo $lang['flea_oldnew_choose'];?>" uri="index.php?act=flea_class&op=quality_inner" dialog_width="400">
          <?php echo $lang['flea_look_fineness_division'];?>
        </a>
               <s class="tb-tips-r"></s>            </span>          </li>
          <li><?php echo $lang['flea_keywords'];?>&nbsp;&nbsp;&nbsp;:
          <?php if(is_array($output['goods']['goods_tag']) and !empty($output['goods']['goods_tag'])) { 
		  	foreach($output['goods']['goods_tag'] as $val) {
		  ?>
          <a class="blue" href="index.php?act=flea_class&key_input=<?php echo urlencode($val); ?>" target="_blank"><?php echo $val?></a>
          <?php }?>
          <?php }?>
          </li>
        </ul>
        <div id="contact" class="grey-box">
          <div class="bd">
            <ul class="fn-clear">
              <li><?php echo $lang['flea_contact_person'];?>: <?php echo $output['goods']['flea_pname']?></li>
              <li><?php echo $lang['flea_contact_tel'];?>: <img style="vertical-align: middle;" src="<?php echo RESOURCE_SITE_URL;?>/pnum.php?pnum=<?php echo $output['goods']['flea_pphone']?>"></li>
            </ul>
            <p><?php echo $lang['flea_explain_before_buy'];?></p>
          </div>
        </div>
      </div>
      </div>
    </div>   
    <div class="content_208 fn-right">

    <div class="col-sub">
      <a href="index.php?act=member_flea&op=add_goods"></a>
    </div>

    <div class="flea_gray mb10">
      <div class="flea_time">
        <p><span><?php echo $lang['flea_release_time'];?>:</span><?php echo date('Y-m-d H:i:s',$output['goods']['goods_add_time'])?></p>
        <p><span><?php echo $lang['flea_view_times'];?>:</span><?php echo ($output['goods']['goods_click']+1)?></p>
      </div>
    </div>
    <div id="seller_info" class="flea_gray mb10">
      <h2 class="title"><?php echo $lang['flea_saler_info'];?></h2>
      <p><?php echo $lang['flea_store_owner'];?>:<?php echo $output['flea_member_info']['member_name'];?><a href="index.php?act=member_message&op=sendmsg&member_id=<?php echo $output['flea_member_info']['member_id'];?>" target=_blank><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/web_mail.gif"></a></p>
    </div>
    <div id="seller_info" class="flea_gray mb10">
      <h2 class="title"><?php echo $lang['flea_other_info'];?></h2>
      <div class="flea_wrap-inside">
      <?php if(!empty($output['goods_commend2']) && is_array($output['goods_commend2'])){?>
      <?php foreach ($output['goods_commend2'] as $val){?>
        <div class="flea_goods">
           <div class="pic">
             <span class="thumb size60">
               <i></i>
               <a title="<?php echo $val['goods_name']?>" href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $val['goods_id']?>"><img height="60" width="60" src="<?php echo $val['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$val['member_id'].DS.$val['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,60,60);"></a>
             </span>
           </div>
           <dl>
             <dt><a href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $val['goods_id']?>"><?php echo $val['goods_name'];?></a></dt>
             <dd><?php echo $lang['currency'];?><a href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $val['goods_id']?>"><?php echo $val['goods_store_price'];?></a></dd>
           </dl>
        </div>
        <?php }?>
        <?php }?>
        <div class="more" id="mm"><a href="#bb" style="cursor:pointer"><?php echo $lang['flea_more'];?></a></div>
      </div>
    </div>

    </div>
    <div id="Tab1">
<div class="Menubox">
<ul>
<li id="one1" onclick="setTab('one',1,3)" class="hover"><?php echo $lang['flea_goods_info'];?></li>
<li id="one2" onclick="setTab('one',2,3)"><?php echo $lang['flea_buyer_msg'];?></li>
<li id="one3" onclick="setTab('one',3,3)"><a  name="bb"><?php echo $lang['flea_sale_other_goods'];?></a></li>
</ul>
</div>
<div class="Contentbox">
<div id="con_one_1" class="hover">
<div><?php echo $output['goods']['goods_body'];?></div>
  <div class="comment-line" id="flea_message"><?php echo $lang['flea_goods_msg'];?></div>
  <div id="comments-content">
     <div class="comment-edit">
     <form method="post" id="save_consult_form1">
     <input type="hidden" name="act" value="flea_goods">
     <input type="hidden" name="op" value="save_consult">
     <input type="hidden" name="goods_id" value="<?php echo $_GET['goods_id'];?>">
     <input type="hidden" name="member_id" value="<?php echo $_SESSION['member_id'];?>">
     <input type="hidden" name="email" value="<?php echo $_SESSION['member_email'];?>">
     <input type="hidden" value="" name="type_name">
       <div class="comment-user"><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']); ?>"></div>
       <div class="comment-add"><textarea name="content" type="text"></textarea></div>
       <div class="comment-act"><a href="#" onclick="save_consult1()"><?php echo $lang['flea_index_commit'];?></a></div>
       </form>
       <script type="text/javascript">
	       function save_consult1(){
		   		$("#save_consult_form1").submit();
	   		}
       </script>
     </div> 
     <ul class="comment-list">
     <?php if(!empty($output['consult_list']) && is_array($output['consult_list'])){?>
     <?php foreach ($output['consult_list'] as $val){?>
       <li>
         <div class="comment-user"><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']); ?>"></div>
         <p class="words"><span class="user_name"><?php echo $val['member_name']?>:</span><span><?php echo $val['consult_content']?></span></p>
         <p class="time"><?php echo checkTime($val['consult_addtime']);?><?php echo $lang['flea_index_front'];?></p>
       </li>
       <?php }?>
       <?php }?>
     </ul>
  </div>
</div>
<div id="con_one_2" style="display:none">
  <div id="comments-content">
     <div class="comment-edit">
     <form method="post" id="save_consult_form2">
     <input type="hidden" name="act" value="flea_goods">
     <input type="hidden" name="op" value="save_consult">
     <input type="hidden" name="goods_id" value="<?php echo $_GET['goods_id'];?>">
     <input type="hidden" name="member_id" value="<?php echo $_SESSION['member_id'];?>">
     <input type="hidden" name="email" value="<?php echo $_SESSION['member_email'];?>">
     <input type="hidden" value="" name="type_name">
       <div class="comment-user"><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']); ?>"></div>
       <div class="comment-add"><textarea name="content" type="text"></textarea></div>
       <div class="comment-act"><a href="#" onclick="save_consult2()"><?php echo $lang['flea_index_commit'];?></a></div>
       </form>
       <script type="text/javascript">
	       function save_consult2(){
		   		$("#save_consult_form2").submit();
	   		}
       </script>
     </div> 
     <ul class="comment-list">
     <?php if(!empty($output['consult_list']) && is_array($output['consult_list'])){?>
     <?php foreach ($output['consult_list'] as $val){?>
       <li>
         <div class="comment-user"><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']); ?>"></div>
         <p class="words"><span class="user_name"><?php echo $val['member_name']?>:</span><span><?php echo $val['consult_content']?></span></p>
         <p class="time"><?php echo checkTime($val['consult_addtime']);?><?php echo $lang['flea_index_front'];?></p>
       </li>
       <?php }?>
       <?php }?>
     </ul>
  </div>
</div>

<div id="con_one_3" style="display:none">
  <ul id="other_items">
  <?php if(!empty($output['goods_commend3']) && is_array($output['goods_commend3'])){?>
  <?php foreach ($output['goods_commend3'] as $val3){?>
    <li>
      <div class="pic"> 
        <span class="thumb size160">
          <i></i>
          <a title="<?php echo $val3['goods_name'] ?>" href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $val3['goods_id']?>"><img height="160" width="160" onload="javascript:DrawImage(this,160,160);" src="<?php echo $val3['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$val3['member_id'].DS.$val3['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>"></a>
        </span>
      </div>
      <h3><a href="index.php?act=flea_goods&type=goods&goods_id=<?php echo $val3['goods_id']?>"><?php echo $val3['goods_name']?></a></h3>
      <span class="price"><?php echo $lang['currency'];?><b><?php echo $val3['goods_store_price']?></b></span>
      <span class="time"><?php echo checkTime($val3['goods_add_time']);?><?php echo $lang['flea_index_front'];?></span>
    </li>
    <?php }?>
    <?php }?>
  </ul>
</div>
    
</div>
</div>
    <div class="fn-clear"></div>
    <div>
  <div id="tb-detail-tips">
    <div id="J_tb-buy-tips" class="tb-buy-tips clearfix">
        <ul>
        	<li><?php echo $lang['flea_explain_before_buy1'];?></li>
        	<li><?php echo $lang['flea_explain_before_buy2'];?></li>
        </ul>
      <a href="index.php?act=member_flea&op=add_goods" class="tb-pub-free" target="_blank"><?php echo $lang['flea_fee_release'];?><i><?php echo $lang['flea_enter_release'];?></i></a>      </div>
</div>
	</div>
  </div>
  <div class="fn-clear"></div>
</div>


<script type="text/javascript">
function setTab(name,cursel,n){
for(i=1;i<=n;i++){
var menu=document.getElementById(name+i);
var con=document.getElementById("con_"+name+"_"+i);
menu.className=i==cursel?"hover":"";
con.style.display=i==cursel?"block":"none";
}
}
</script>
<script type="text/javascript">
		$(function(){	
			$("#slider").easySlider({
				auto: false, 
				continuous: true
			});
		});	
</script>
<script type="text/javascript">
    $(document).ready(function(){	
			$("#mm").children("a").click(function(){
			    $("#one3").addClass("hover");
				$("#one1").removeClass("hover");
				$("#one2").removeClass("hover");
				$("#con_one_1").css("display","none");
				$("#con_one_2").css("display","none");
				$("#con_one_3").css("display","block");
			});
	});
</script>
