<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- 站外分享 -->
<script type="text/javascript">
$(document).ready(function(){
    //表情
    $("#btn_show_smilies").smilies({smilies_input:"#comment_message"});
    /**
     * 评论
     **/
    var url_comment_list = "index.php?act=comment&op=comment_list&type=<?php echo $output['comment_type'];?>&comment_id=<?php echo $output['comment_id'];?>";
    var url_comment_save = "index.php?act=comment&op=comment_save&type=<?php echo $output['comment_type'];?>";

    $("#comment_message").microshop_publish({
        button_item: "#btn_publish_comment"
    },function(){
        $.post(url_comment_save, $("#add_form").serialize(),
            function(data){
                if(data.result == 'true') {
                    $("#comment_list").prepend($("#_comment_list_template").html());
                    var first_comment = $("#comment_list dl").first();
                    first_comment.hide();
                    first_comment.find("dd a.comment_member_info").text(data.member_name);
                    first_comment.find("a.comment_member_info").attr("href",data.member_link);
                    first_comment.find("img").attr("src",data.member_avatar);
                    first_comment.find("img").attr("alt",data.member_member_name);
                    first_comment.find("dd span").html(data.comment_message);
                    first_comment.find("em").text(data.comment_time);
                    first_comment.find("a[nc_type=comment_drop]").attr('comment_id',data.comment_id);
                    first_comment.show('slow');
                    if($("#comment_list dl").length >= 5) {
                        $("#comment_list dl").last().remove();
                    }
                    $("#comment_count").microshop_count({type:'+'});
                } else {
                    showError(data.message);
                }
            }, "json");
    });
    //初始加载评论
    $("#comment_list").load(url_comment_list);
    //评论翻页
    $("#comment_list .demo").live('click',function(e){
        $("#comment_list").load($(this).attr('href'));
        return false;
    });

    //评论删除
    $("[nc_type=comment_drop]").live('click',function(){
        if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
            var item = $(this).parents("dl");
            $.getJSON("index.php?act=comment&op=comment_drop&type=<?php echo $output['comment_type'];?>", { comment_id: $(this).attr("comment_id")}, function(json){
                if(json.result == "true") {
                    $("#comment_count").microshop_count({type:'-'});
                    item.remove();
                } else {
                    showError(json.message);
                }
            });
        }
    });
});
</script>

<div id="widgetcommenttitle" class="widget-comment-title">
  <h3><?php echo $lang['microshop_comment_title'];?></h3>
  <em>(<span id="comment_count"><?php echo $output['detail']['comment_count']<=999?$output['detail']['comment_count']:'999+';?></span>)</em> </div>
<?php if(!empty($_SESSION['member_id'])) { ?>
<dl class="widget-comment">
<dt class="head-portrait"><span class="thumb size30"><i></i><img src="<?php echo $member_avatar;?>" onload="javascript:DrawImage(this,30,30);" /></span></dt>
<dd>
<form id="add_form">
  <input id="comment_id" name="comment_id" type="hidden" value="<?php echo $output['comment_id'];?>" />
  <textarea id="comment_message" name="comment_message" class="comment-message"></textarea>
  <div><a id="btn_show_smilies" href="javascript:void(0)" class="smile"><?php echo $lang['microshop_comment_smiles'];?></a> 
    <!-- 站外分享 -->
    <?php require('widget_share.php');?>
  <input id="btn_publish_comment" class="input-button" type="button" value="<?php echo $lang['microshop_text_publish'];?>" />
  </div>
</form>
</dd>
<div class="clear">&nbsp;</div>
</dl>
<?php } else { ?>
<div class="login"> <?php echo $lang['no_login'];?> <a href="<?php echo SHOP_SITE_URL.'/index.php?act=login&ref_url='.getRefUrl();?>"><?php echo $lang['nc_login'];?></a> </div>
<?php } ?>
<div id="comment_list" class="comment_list"></div>
<div id="_comment_list_template" style="display:none;">
  <dl>
    <dt class="head-portrait"> <span class="thumb"><i></i> <a class="comment_member_info" href="" target="_blank"> <img src="" alt=""  /> </a> </span> </dt>
    <dd> <a class="comment_member_info" href="" target="_blank"></a> <span></span>
      <p><em></em> <a nc_type="comment_drop" comment_id="" href="javascript:void(0)" class="del pngFix"><?php echo $lang['nc_delete'];?></a></p>
    </dd>
  </dl>
</div>
