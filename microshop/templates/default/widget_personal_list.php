<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){

    <?php if(isset($_SESSION['member_id']) && isset($output['publish_flag'])) { ?>
    $("#btn_personal_publish").show();
    <?php } else { ?>
    $("#btn_personal_publish").remove();
    <?php } ?>


    //瀑布流
    $("#pinterest").masonry({
        // options 设置选项
        itemSelector : '.item',//class 选择器
            columnWidth : 252 ,//一列的宽度 Integer
            isAnimated:true,//使用jquery的布局变化  Boolean
            animationOptions:{queue: false, duration: 500 
            //jquery animate属性 渐变效果  Object { queue: false, duration: 500 }
            },
            gutterWidth:0,//列的间隙 Integer
            isFitWidth:true,// 适应宽度   Boolean
            isResizableL:true,// 是否可调整大小 Boolean
            isRTL:false//使用从右到左的布局 Boolean
    });

    $("img.lazy").microshop_lazyload();

    //喜欢
    $("[nc_type=microshop_like]").microshop_like({type:'personal'});
});
</script>

<div class="commend-goods-list">
  <?php if(!empty($output['list']) && is_array($output['list'])) {?>
  <ul id="pinterest">
    <li id="btn_personal_publish" class="item" style="display:none;">
      <div class="pinterest-button"><a id="btn_show_publish_div" href="javascript:void(0)" class="pngFix"><?php echo $lang['microshop_personal_publish'];?></a></div>
    </li>
    <?php foreach($output['list'] as $key=>$value) {?>
    <li class="item">
      <?php if($output['owner_flag'] === TRUE){ ?>
      <?php if($_GET['op'] == 'like_list') { ?>
      <!-- 喜欢删除按钮 -->
      <div class="del"><a nc_type="like_drop" like_id="<?php echo $value['like_id'];?>" href="javascript:void(0)"><?php echo $lang['nc_delete'];?></a></div>
      <?php } else { ?>
      <!-- 个人主页删除按钮 -->
      <div class="del"><a nc_type="home_drop" type="personal" item_id="<?php echo $value['personal_id'];?>" href="javascript:void(0)"><?php echo $lang['nc_delete'];?></a></div>
      <?php } ?>
      <?php } ?>
      <div class="picture"> <a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=personal&op=detail&personal_id=<?php echo $value['personal_id'];?>" target="_blank">
        <?php $personal_image_array = getMicroshopPersonalImageUrl($value,'list');?>
        <?php $size = getMicroshopImageSize($personal_image_array[0], 238);?>
        <img class="lazy" height="<?php echo $size['height'];?>" width="<?php echo $size['width'];?>" src="<?php echo MICROSHOP_TEMPLATES_URL;?>/images/loading.gif" data-src="<?php echo $personal_image_array[0];?>" /> </a> </div>
      <div class="handle"> <span class="like-btn"><a nc_type="microshop_like" like_id="<?php echo $value['personal_id'];?>" href="javascript:void(0)"><i class="pngFix"></i><span><?php echo $lang['microshop_text_like'];?></span><em><?php echo $value['like_count']<=999?$value['like_count']:'999+';?></em></a></span> <span class="comment"><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=personal&op=detail&personal_id=<?php echo $value['personal_id'];?>" target="_blank"><i title="<?php echo $lang['microshop_text_comment'];?>" class="pngFix">&nbsp;</i><em><?php echo $value['comment_count']<=999?$value['comment_count']:'999+';?></em></a></span> </div>
      <dl class="commentary">
        <dt><span class="thumb size30"><i></i><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $value['commend_member_id'];?>" target="_blank"> <img src="<?php echo getMemberAvatar($value['member_avatar']);?>" alt="<?php echo $value['member_name'];?>" onload="javascript:DrawImage(this,30,30);" /> </a></span></dt>
        <dd>
          <h4><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $value['commend_member_id'];?>" target="_blank"> <?php echo $value['member_name'];?> </a> </h4>
          <p> <a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=personal&op=detail&personal_id=<?php echo $value['personal_id'];?>" target="_blank"> <?php echo $value['commend_message'];?> </a> </p>
        </dd>
      </dl>
    </li>
    <?php } ?>
  </ul>
  <?php } else { ?>
  <!-- 占位用勿删 -->
  <ul id="pinterest">
  </ul>
  <div class="no-content"><i class="personal pngFix">&nbsp;</i>
    <?php if($_GET['act'] == 'personal') { ?>
    <p><?php echo $lang['microshop_personal_list_none'];?></p>
    <?php } else { ?>
    <?php if($_GET['op'] == 'like_list') { ?>
    <?php if($output['owner_flag'] === TRUE){ ?>
    <p><?php echo $lang['microshop_personal_like_list_none'];?></p>
    <?php } else { ?>
    <p><?php echo $lang['nc_quote1'];?><?php echo $output['member_info']['member_name'];?><?php echo $lang['nc_quote2'];?><?php echo $lang['microshop_personal_like_list_none_owner'];?></p>
    <?php } ?>
    <?php } else { ?>
    <?php if($output['owner_flag'] === TRUE){ ?>
    <p><?php echo $lang['microshop_personal_list_none_publish'];?></p>
    <a id="link_personal_publish" href="javascript:void(0)"><?php echo $lang['microshop_personal_publish'];?></a></div>
  <?php } else { ?>
  <p><?php echo $lang['nc_quote1'];?><?php echo $output['member_info']['member_name'];?><?php echo $lang['nc_quote2'];?><?php echo $lang['microshop_personal_list_none_publish_owner'];?></p>
  <?php } ?>
  <?php } ?>
  <?php } ?>
</div>
<?php } ?>
<?php if(!empty($output['list']) && is_array($output['list'])) {?>
<div class="pagination"> <?php echo $output['show_page'];?> </div>
<?php } ?>
<?php if(isset($_SESSION['member_id'])) { ?>
<script type="text/javascript" src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<!-- 发布个人秀 --> 
<script type="text/javascript">
$(document).ready(function(){

    $("#publish_div").microshop_form({title:'<?php echo $lang['microshop_personal_publish'];?>'});
    $("#link_personal_publish").click(function(){
        show_publish_form();
    });
    //弹出窗口
    $("#btn_show_publish_div").click(function(){
        show_publish_form();
    });
    <?php if(isset($_GET['publish'])) { ?>
        show_publish_form();
    <?php } ?>
    function show_publish_form() {
        $.getJSON("index.php?act=publish&op=personal_limit", {}, function(json){
            if(json.result == "true") {
                $("#publish_div").microshop_form_show({width:480});
            } else {
                showError(json.message);
            }
        });
    }

    //发布
    $("#commend_message").microshop_publish({
        button_item:'#btn_publish',
        allow_null:'true'
    },function(){
        if($("#personal_image").val() != "") {
            $("#publish_div").hide();
            ajaxpost('add_form', '', '', 'onerror'); 
        } else {
            show_personal_message("<?php echo $lang['microshop_text_upload_image'];?>");
        }
    });

    //图片上传
    $("#fileupload").fileupload({
        dataType: 'json',
            url: "<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=publish&op=personal_image_upload';?>",
            add: function(e,data) {
                $("#btn_personal_image").hide();
                $("#personal_image_info").show();
                data.submit();
            },
            done: function (e,data) {
                result = data.result;
                if(result.status == "success") {
                    $("#_personal_image_list img").attr("src","<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.$_SESSION['member_id'].DS;?>"+result.file);
                    $("#_personal_image_list a").attr("image_name",result.file);
                    $("#personal_image_list").append($("#_personal_image_list").html());
                    var personal_image = $("#personal_image").val();
                    if(personal_image != '') {
                        personal_image = personal_image + ","+result.file;
                    } else {
                        personal_image = result.file;
                    }
                    $("#personal_image").val(personal_image);
                } else {
                    showError(result.error);
                }
                $("#btn_personal_image").show();
                $("#personal_image_info").hide();
                $("#personal_image_notice").hide();
                var personal_image_array = $("#personal_image").val().split(",");
                if(personal_image_array.length >= 3) {
                    $("#personal_image_upload").hide();
                }
            }
    });

    //图片删除控制
    $(".personal_image_content").live({
        mouseenter:function(){
            $(this).find(".personal_image_delete").show(); 
        },mouseleave:function(){
            $(this).find(".personal_image_delete").hide(); 
        }
    });

    //图片删除按钮
    $("[nc_type='btn_personal_image_delete']").live('click',function(){
        var image_name = $(this).attr("image_name");
        $.getJSON("<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=publish&op=personal_image_delete';?>", { image_name: image_name }, function(json){
        });
        $(this).parent("div").remove();
        var personal_image_array = $("#personal_image").val().split(",");
        var index = $.inArray(image_name, personal_image_array);
        if (index >= 0) {
            personal_image_array.splice(index, 1);
        }
        if(personal_image_array.length < 3) {
            $("#personal_image_upload").show();
        }
        $("#personal_image").val(personal_image_array.join(","));
    });

    //添加购买链接
    $("#btn_personal_link").click(function(){
        $("#div_personal_image_link").show();
        $("#input_personal_image_link").focus();
    });
    $("#btn_personal_link_add").click(function() {
        $(this).parent().hide();
        var link = encodeURIComponent($("#input_personal_image_link").val());
        $("#input_personal_image_link").val('');
        if(link != '') {
            $.getJSON("<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=publish&op=personal_link_add';?>", { link: link}, function(data){
                if(data.result == "true") {
                    var link_item = '<div class="taobao-item">';
                    link_item += '<span class="taobao-item-img"><a href="'+data.url+'" target="_blank"><img src="'+data.image+'" alt="'+data.title+'" title="'+data.title+'" /></a></span>';
                    link_item += '<span class="taobao-item-title"><a href="'+data.url+'" target="_blank">'+data.title+'</a></span>';
                    link_item += '<span class="taobao-item-price"><?php echo $lang['currency'];?>'+data.price+'</span>';
                    link_item += '<span class="taobao-item-delete"><a nc_type="btn_personal_link_delete"><?php echo $lang['nc_delete'];?></a></span>';
                    link_item += '<input name="personal_buy_link[]" type="hidden" value="'+data.url+'" />';
                    link_item += '<input name="personal_buy_image[]" type="hidden" value="'+data.image+'" />';
                    link_item += '<input name="personal_buy_price[]" type="hidden" value="'+data.price+'"/>';
                    link_item += '<input name="personal_buy_title[]" type="hidden" value="'+data.title+'"/>';
                    link_item += '</div>';
                    $("#personal_link_list").append(link_item);
                    if($("[name='personal_buy_link[]']").length >= 3) {
                        $("#btn_personal_link").hide();
                    }
                } else {
                    show_personal_message(data.message);
                }
            });
        }
    });

    //删除购买链接
    $("[nc_type='btn_personal_link_delete']").live('click',function(){
        $(this).parent().parent().remove();
        var count = $("[name='personal_buy_link[]']").length;
        if($("[name='personal_buy_link[]']").length < 3) {
            $("#btn_personal_link").show();
        }
    });

    function show_personal_message(message) {
        $("#personal_image_notice").html(message);
        $("#personal_image_notice").show();
        setTimeout(function(){$("#personal_image_notice").hide()},2000);
    }
});
</script> 
<!-- 图片列表 -->
<div id="_personal_image_list" style="display:none;">
  <div class="personal_image_content"><a nc_type="btn_personal_image_delete" image_name="" href="javascript:void(0);" class="personal_image_delete" style="display:none;"><?php echo $lang['nc_delete'];?></a> <span class=" thumb size100"><i></i><img src="" onload="javascript:DrawImage(this,100,100);" /></span></div>
</div>
</div>
<!-- 发布按钮 --> 
<!-- 弹出层开始 -->
<div id="publish_div" style="display: none;">
  <form action="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=publish&op=personal_save" method="post" id="add_form" class="publish-div">
    <input id="personal_image" name="personal_image" type="hidden" />
    <div class="side-bar">
      <div id="personal_image_list" class="personal_image_list"> </div>
      <div id="personal_image_upload" class="personal-image-upload">
        <div class="upload-btn"><a href="javascript:void(0);"> <span style="width: 80px; height: 30px; position: absolute; left: 0; top: 0; z-index: 999; cursor:pointer; ">
          <input type="file" name="personal_image_ajax" id="fileupload" file_id="0" style="width:80px; height: 30px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" maxlength="0" />
          </span>
          <div class="upload-button">&nbsp;</div>
          <input id="submit_button" style="display:none" type="button" value="<?php echo $lang['microshop_text_upload_image'];?>" onClick="submit_form($(this))" />
          </a></div>
        <div id="personal_image_info" class="personal_image_info" style="display:none;" title="<?php echo $lang['microshop_text_uploading'];?>">&nbsp;</div>
      </div>
    </div>
    <div class="express">
      <dl class="type">
        <dt><?php echo $lang['microshop_text_class'];?></dt>
        <dd>
          <?php if(!empty($output['personal_class_list']) && is_array($output['personal_class_list'])) {?>
          <?php $count = 1;?>
          <?php foreach($output['personal_class_list'] as $key=>$value) {?>
          <span class="mr5">
          <input id="personal_class_list<?php echo $value['class_id'];?>" name="personal_class" type="radio" value="<?php echo $value['class_id'];?>" <?php if($count == 1) echo "checked='checked'";?> />
          <label for="personal_class_list<?php echo $value['class_id'];?>"><?php echo $value['class_name'];?></label>
          </span>
          <?php $count++;?>
          <?php } ?>
          <?php } ?>
        </dd>
      </dl>
      <dl class="intro">
        <dt><?php echo $lang['microshop_text_explain'];?></dt>
        <dd>
          <textarea cols="55" rows="3" name="commend_message" id="commend_message"></textarea>
        </dd>
      </dl>
      <dl class="url">
        <dt> <?php echo $lang['microshop_text_buy_link'];?>
          <?php if(C('taobao_api_isuse')) { ?>
          <span><?php echo $lang['microshop_personal_publish_explain_taobao'];?></span>
          <?php } else { ?>
          <span><?php echo $lang['microshop_personal_publish_explain_store'];?></span>
          <?php } ?>
        </dt>
        <dd>
          <div id="personal_link_list" class="personal_link_list"></div>
          <div id="div_personal_image_link" style="display:none;">
            <input id="input_personal_image_link" type="text" class="text" />
            <a id="btn_personal_link_add" href="javascript:void(0);" class="add-link"><?php echo $lang['nc_add'];?></a></div>
          <div id="personal_image_link"><a id="btn_personal_link" href="javascript:void(0);" class="add-btn"><?php echo $lang['microshop_personal_add_link'];?></a> </div>
        </dd>
      </dl>
    </div>
    <div class="handle">
      <div id="personal_image_notice" class="personal_image_notice" style="display:none;"></div>
      <input id="btn_publish" type="button" value="<?php echo $lang['microshop_text_commend'];?>" />
      <!-- 站外分享 -->
      <?php require('widget_share.php');?>
    </div>
  </form>
</div>

<!-- 弹出层结束 -->
<?php } ?>
