<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js" charset="utf-8"></script>
<link href="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/jcarousel/skins/personal/skin.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function() {

	//加关注
    $("[nc_type='btn_sns_addfollow']").live('click',function(){
        var btn_add = $(this);
        var btn_del = $(this).next("a");
        var follow_count = $(this).parent().parent().find("[nc_type='fan_count']");
        $.getJSON("<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&op=add_follow", {member_id:$(this).attr('member_id')}, function(json){
            if(json.result == "true") {
                btn_add.hide();
                btn_del.show();
                if(json.message != 're') {
                    follow_count.microshop_count({type:'+'});
                }
            } else {
                showError(json.message);
            }
        });
        return false;
    });
	//取消关注
	$("[nc_type='btn_sns_delfollow']").live('click',function(){
        var btn_del = $(this);
        var btn_add = $(this).prev("a");
        var follow_count = $(this).parent().parent().find("[nc_type='fan_count']");
        $.getJSON("<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&op=del_follow", {member_id:$(this).attr('member_id')}, function(json){
            if(json.result == "true") {
                btn_add.show();
                btn_del.hide();
                follow_count.microshop_count({type:'-'});
            } else {
                showError(json.message);
            }
        });
        return false;
	});

    //个人秀滚动
    $('#indexPersonal').jcarousel({auto:5,wrap:'last',scroll:4});

    //店铺
    $("[nc_type='index_store']").each(function() {
        var overall = $(this).find("li.overall");
        var simple = $(this).find("li.simple");
        overall.hide();
        overall.first().show();
        simple.first().hide();
        simple.mouseover(function(){
            simple.show();
            overall.hide();
            $(this).prev("li.overall").show();
            $(this).hide();
        });
    });
});
</script>
<div class="index">
    <div class="top-box">
        <div class="left">
            <div class="index-banner"> 
                <?php if(!empty($output['index_adv_list']) && is_array($output['index_adv_list'])) {?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        // 幻灯片广告
                        $(".index-banner").each(function(){
                            var timer;
                            $(".index-banner .mask img").click(function(){
                                var index = $(".index-banner .mask img").index($(this));	
                                changeImg(index);
                            }).eq(0).click();
                            $(this).find(".mask").animate({
                                "bottom":"0"	
                            },700);
                            $(".index-banner").hover(function(){
                                clearInterval(timer);	
                            },function(){
                                timer = setInterval(function(){
                                    var show = $(".index-banner .mask img.show").index();
                                    if (show >= $(".index-banner .mask img").length-1)
                                        show = 0;
                                    else
                                        show ++;
                                    changeImg(show);
                                },3000);
                            });
                            function changeImg (index)
                            {
                                $(".index-banner .mask img").removeClass("show").eq(index).addClass("show");
                                $(".index-banner .bigImg").parents("a").attr("href",$(".index-banner .mask img").eq(index).attr("link"));
                                $(".index-banner .bigImg").hide().attr("src",$(".index-banner .mask img").eq(index).attr("uri")).fadeIn("slow");
                            }
                            timer = setInterval(function(){
                                var show = $(".index-banner .mask img.show").index();
                                if (show >= $(".index-banner .mask img").length-1)
                                    show = 0;
                                else
                                    show ++;
                                changeImg(show);
                            },3000);
                        });

                    });
                </script>
                <a href=""><img class="bigImg"/></a>
                <div class="mask"> 
                    <?php foreach($output['index_adv_list'] as $key=>$value) {?>
                    <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.'adv'.DS.$value['adv_image'];?>" uri="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.'adv'.DS.$value['adv_image'];?>" link="<?php echo $value['adv_url'];?>"/> 
                    <?php } ?>
                </div>
                <?php } else {?>
                <img class="bigImg" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.'default_index_banner.jpg';?>"/>
                <?php }?>
            </div>
        </div>
  <div class="right">
    <div class="member-box">
      <?php if(empty($_SESSION['member_id'])) { ?>
      <div class="portrait"><img src="<?php echo $member_avatar;?>" onload="javascript:DrawImage(this,72,72);" /></div>
      <dl class="welcome">
        <dt><?php echo $lang['microshop_text_welcome'];?></dt>
        <dd><a href="<?php echo SHOP_SITE_URL.'/index.php?act=login&ref_url='.getRefUrl();?>" class="login-now"><?php echo $lang['microshop_text_login'];?></a></dd>
      </dl>
      <?php } else { ?>
      <div class="portrait"> <a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&member_id=<?php echo $_SESSION['member_id'];?>" target="_blank"> <img src="<?php echo $member_avatar;?>" onload="javascript:DrawImage(this,72,72);" /> </a> </div>
      <dl class="welcome">
        <dt> <a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&member_id=<?php echo $_SESSION['member_id'];?>" target="_blank"> <?php echo $output['member_info']['member_name'];?> </a> </dt>
        <dd><span><?php echo $lang['nc_microshop_goods'].$lang['nc_colon'];?><em><?php echo $output['member_info']['goods_count'];?></em></span><span><?php echo $lang['nc_microshop_personal'].$lang['nc_colon'];?><em><?php echo $output['member_info']['personal_count'];?></em></span></dd>
        <dd><span><?php echo $lang['microshop_text_follower'].$lang['nc_colon'];?><em><?php echo $output['member_info']['fan_count'];?></em></span></dd>
      </dl>
      <?php } ?>
    </div>
    <div class="user-box">
      <div class="title">
        <h3><?php echo $lang['microshop_text_gowu'];?><em><?php echo $lang['microshop_text_daren'];?></em><?php echo $lang['microshop_text_commend'];?></h3>
      </div>
      <?php if(!empty($output['member_list']) && is_array($output['member_list'])) {?>
      <?php foreach($output['member_list'] as $key=>$value) {?>
      <dl class="big-gun">
        <dt class="portrait"><a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&member_id=<?php echo $value['member_id'];?>" target="_blank"><img src="<?php echo getMemberAvatar($value['member_avatar']);?>" onload="javascript:DrawImage(this,60,60);" /></a></dt>
        <dd class="name"> <a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&member_id=<?php echo $value['member_id'];?>" target="_blank"> <?php echo $value['member_name'];?> </a> </dd>
        <dd><?php echo $lang['microshop_text_share'].$lang['nc_colon'];?><em><?php echo $value['goods_count']+$value['personal_count'];?></em></dd>
        <dd><?php echo $lang['microshop_text_follower'].$lang['nc_colon'];?><em nc_type="fan_count"><?php echo $value['fan_count']<=999?$value['fan_count']:'999+';?></em></dd>
        <dd class="btn">
          <?php if(isset($value['follow_flag'])) { ?>
          <a nc_type="btn_sns_addfollow" href="javascript:void(0)" member_id="<?php echo $value['member_id'];?>" <?php if(!$value['follow_flag']){ echo "style='display:none;'";}?>><?php echo $lang['microshop_text_follow_add'];?></a> <a nc_type="btn_sns_delfollow" href="javascript:void(0)" member_id="<?php echo $value['member_id'];?>" <?php if($value['follow_flag']){ echo "style='display:none;'";}?>><?php echo $lang['microshop_text_follow_del'];?></a>
          <?php } ?>
        </dd>
      </dl>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
<!--首页推荐个人秀部分-->
<div class="main-box personal">
  <div class="title">
    <h3><?php echo $lang['microshop_text_member_commend'];?><em><?php echo $lang['nc_microshop_personal'];?></em></h3>
  </div>
  <ul id="indexPersonal" class="jcarousel-skin-personal">
    <?php if(!empty($output['personal_list']) && is_array($output['personal_list'])) {?>
    <?php foreach($output['personal_list'] as $key=>$value) {?>
    <?php $personal_image_array = getMicroshopPersonalImageUrl($value,'list');?>
    <li style="background-image: url(<?php echo $personal_image_array[0];?>)"><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=personal&op=detail&personal_id=<?php echo $value['personal_id'];?>"></a>
      <div class="arrow">&nbsp;</div>
      <dl>
        <dt><img src="<?php echo getMemberAvatar($value['member_avatar']);?>" onload="javascript:DrawImage(this,30,30);" /></dt>
        <dd> <a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $value['commend_member_id'];?>"> <?php echo $value['member_name'];?> </a>
          <p><?php echo $value['commend_message'];?></p>
        </dd>
      </dl>
    </li>
    <?php } ?>
    <?php } ?>
  </ul>
</div>
<!--首页推荐随心看部分-->
<?php if(!empty($output['goods_class_root']) && is_array($output['goods_class_root'])) {?>
<?php foreach($output['goods_class_root'] as $key=>$value) {?>
<div class="main-box goods">
  <div class="title">
    <h3><?php echo $lang['nc_microshop_goods'];?><em><?php echo $value['class_name'];?></em><?php echo $lang['microshop_text_wonderful_commend'];?></h3>
  </div>
  <ul class="goods-class-pic">
    <?php if(!empty($output['goods_list'][$value['class_id']]) && is_array($output['goods_list'][$value['class_id']])) {?>
    <?php foreach($output['goods_list'][$value['class_id']] as $key_goods=>$value_goods) {?>
    <?php $image_url = cthumb($value_goods['commend_goods_image'], 240,$value_goods['commend_goods_store_id']);?>
    <li style="background-image: url(<?php echo $image_url;?>)" ><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=goods&op=detail&goods_id=<?php echo $value_goods['commend_id'];?>" title="<?php echo $value_goods['commend_goods_name'];?>">&nbsp;</a>
      <h4><?php echo $value_goods['commend_goods_name'];?></h4>
    </li>
    <?php } ?>
    <?php } ?>
  </ul>
  <div class="goods-class-list">
    <?php if(!empty($output['goods_class_menu'][$value['class_id']]) && is_array($output['goods_class_menu'][$value['class_id']])) {?>
    <?php foreach($output['goods_class_menu'][$value['class_id']] as $key_menu=>$value_menu) {?>
    <dl>
      <dt><a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=goods&goods_class_root_id=<?php echo $value['class_id'];?>&goods_class_menu_id=<?php echo $value_menu['class_id'];?>"><?php echo $value_menu['class_name'];?></a></dt>
      <?php if(!empty($value_menu['class_keyword'])) {?>
      <?php $goods_class_keyword_array = explode(',',$value_menu['class_keyword']);?>
      <dd>
        <?php foreach($goods_class_keyword_array as $key1=>$val1) {?>
        <a <?php if($_GET['keyword'] == ltrim($val1,'*')) { echo "class='selected'";} elseif(substr($val1,0,1) == '*') { echo "class='highlight'";}?> href="index.php?act=goods&goods_class_root_id=<?php echo $value['class_id'];?>&goods_class_menu_id=<?php echo $value_menu['class_id'];?>&keyword=<?php echo ltrim($val1,'*');?>"><?php echo ltrim($val1,'*');?></a>
        <?php } ?>
      </dd>
      <?php } ?>
    </dl>
    <?php } ?>
    <?php } ?>
    <div class="more"><a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=goods&goods_class_root_id=<?php echo $value['class_id'];?>"><?php echo $lang['microshop_text_all'];?>...</a></div>
  </div>
</div>
<?php } ?>
<?php } ?>
<!--店铺街推荐排行-->
<div class="main-box store">
  <div class="title">
    <h3><?php echo $lang['nc_microshop_store'];?><em><?php echo $lang['microshop_text_paihang'];?></em></h3>
  </div>
  <ul class="store-top">
    <?php $store_list_count = count($output['store_list']);?>
    <li>
      <div class="tit">
        <h4><i></i><?php echo $lang['microshop_store_hot_list'];?><span class="arrow"></span></h4>
      </div>
      <ol nc_type="index_store" style="padding-left: 7px;">
        <?php if($store_list_count > 0) {?>
        <?php $count1 = $store_list_count;?>
        <?php if($count1 > 5) $count1 = 5;?>
        <?php for($i=0;$i<$count1;$i++) { ?>
        <li class="overall"><i><?php echo $i+1;?></i>
          <dl class="store-intro">
            <dt><a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=store&op=detail&store_id=<?php echo $output['store_list'][$i]['microshop_store_id'];?>" target="_blank"><?php echo $output['store_list'][$i]['store_name'];?></a></dt>
            <dd><?php echo $lang['microshop_text_store_member_name'].$lang['nc_colon'];?><span><?php echo $output['store_list'][$i]['member_name'];?></span></dd>
            <dd><?php echo $lang['microshop_text_store_zy'].$lang['nc_colon'];?><span><?php echo $output['store_list'][$i]['store_zy'];?></span></dd>
          </dl>
        </li>
        <li class="simple"><i><?php echo $i+1;?></i><a href=""><?php echo $output['store_list'][$i]['store_name'];?></a></li>
        <?php } ?>
        <?php } ?>
      </ol>
    </li>
    <li>
      <div class="tit">
        <h4><i></i><?php echo $lang['microshop_store_click_list'];?><span class="arrow"></span></h4>
      </div>
      <ol nc_type="index_store" style="padding-left: 7px;">
        <?php if($store_list_count > 5) {?>
        <?php $count2 = $store_list_count;?>
        <?php if($count2 > 10) $count2 = 10;?>
        <?php for($i=5;$i<$count2;$i++) { ?>
        <li class="overall"><i><?php echo $i-4;?></i>
         
          <dl class="store-intro">
            <dt><a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=store&op=detail&store_id=<?php echo $output['store_list'][$i]['microshop_store_id'];?>" target="_blank"><?php echo $output['store_list'][$i]['store_name'];?></a></dt>
            <dd><?php echo $lang['microshop_text_store_member_name'].$lang['nc_colon'];?><span><?php echo $output['store_list'][$i]['member_name'];?></span></dd>
            <dd><?php echo $lang['microshop_text_store_zy'].$lang['nc_colon'];?><span><?php echo $output['store_list'][$i]['store_zy'];?></span></dd>
          </dl>
        </li>
        <li class="simple"><i><?php echo $i-4;?></i><a href=""><?php echo $output['store_list'][$i]['store_name'];?></a></li>
        <?php } ?>
        <?php } ?>
      </ol>
    </li>
    <li>
      <div class="tit">
        <h4><i></i><?php echo $lang['microshop_store_new_list'];?><span class="arrow"></span></h4>
      </div>
      <ol nc_type="index_store" style=" background: none; padding-left: 7px;">
        <?php if($store_list_count > 10) {?>
        <?php for($i=10;$i<$store_list_count;$i++) { ?>
        <li class="overall"><i><?php echo $i-9;?></i>
          
          <dl class="store-intro">
            <dt><a href="<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=store&op=detail&store_id=<?php echo $output['store_list'][$i]['microshop_store_id'];?>" target="_blank"><?php echo $output['store_list'][$i]['store_name'];?></a></dt>
            <dd><?php echo $lang['microshop_text_store_member_name'].$lang['nc_colon'];?><span><?php echo $output['store_list'][$i]['member_name'];?></span></dd>
            <dd><?php echo $lang['microshop_text_store_zy'].$lang['nc_colon'];?><span><?php echo $output['store_list'][$i]['store_zy'];?></span></dd>
          </dl>
        </li>
        <li class="simple"><i><?php echo $i-9;?></i><a href=""><?php echo $output['store_list'][$i]['store_name'];?></a></li>
        <?php } ?>
        <?php } ?>
      </ol>
    </li>
  </ul>
</div>
