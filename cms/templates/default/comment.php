<?php defined('InShopNC') or exit('Access Invalid!');?>
<link type="text/css" rel="stylesheet" href="<?php echo SHOP_SITE_URL;?>/templates/default/css/home_login.css">
<script type="text/javascript">
$(document).ready(function(){
    var url_comment_list = "<?php echo CMS_SITE_URL.DS;?>index.php?act=comment&op=comment_list&type=<?php echo $_GET['act'];?>&comment_object_id=<?php echo $output['detail_object_id'];?>&comment_all=<?php echo $output['comment_all'];?>";
    $("#btn_comment_submit").click(function(){
        if($("#input_comment_message").val() != '') {
        $.post("<?php echo CMS_SITE_URL.DS.'index.php?act=comment&op=comment_save';?>", $("#add_form").serialize(),
            function(data){
                if(data.result == 'true') {
                    $("#input_comment_message").val("");
                    $("#comment_list").load(url_comment_list);
                    $("#comment_list dl").first().hide().fadeIn("fast");
                } else {
                    showError(data.message);
                }
            }, "json");
        }
    });

    //初始加载评论
    $("#comment_list").load(url_comment_list);

    //评论翻页
    $("#comment_list .demo").live('click',function(e){
        $("#comment_list").load($(this).attr('href'));
        return false;
    });

    //评论删除
    $("[nctype=comment_drop]").live('click',function(){
        if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
            var item = $(this).parents("dl");
            $.post("index.php?act=comment&op=comment_drop&type=<?php echo $_GET['act'];?>", { comment_id: $(this).attr("comment_id")}, function(json){
                if(json.result == "true") {
                    item.remove();
                } else {
                    showError(json.message);
                }
            },'json');
        }
    });

    <?php if($_SESSION['is_login'] != '1'){?>
    //登陆窗口
    $("#btn_login").nc_login({
        nchash:'<?php echo getNchash();?>',
        formhash:'<?php echo Security::getTokenValue();?>',
        anchor:'cms_comment_flag'
    });
    <?php } ?>

    $('#comment_list').on('click', '[nctype="comment_quote"]', function() {
        <?php if($_SESSION['is_login'] != '1'){?>
        //登陆窗口
        $.show_nc_login({
            nchash:'<?php echo getNchash();?>',
            formhash:'<?php echo Security::getTokenValue();?>',
            anchor:'cms_comment_flag'
        });
        <?php } else { ?>
        var $comment = $(this).parents('p').next('.comment-quote');
        if($comment.length > 0) {
            $comment.remove();
        } else {
            $(this).parents('p').after('<p class="comment-quote">' + $('#comment_quote').html() + '<input name="comment_id" value="' + $(this).attr('comment_id') + '" type="hidden" />' + '</p>');
        }
        <?php } ?>
    });

    //回复
    $('#comment_list').on('click', '[nctype="btn_comment_quote_publish"]', function() {
        var comment_id = $(this).parents('p').find('input').val();
        var comment_object_id = $('#input_comment_object_id').val();
        var comment_type = $('#input_comment_type').val();
        var comment_message = $(this).parents('p').find('textarea').val();
        $.post("<?php echo CMS_SITE_URL.DS.'index.php?act=comment&op=comment_save';?>", {comment_id:comment_id, comment_object_id:comment_object_id, comment_type:comment_type, comment_message:comment_message},
            function(data){
                if(data.result == 'true') {
                    $("#input_comment_message").val("");
                    $("#comment_list").load(url_comment_list);
                    $("#comment_list dl").first().hide().fadeIn("fast");
                } else {
                    showError(data.message);
                }
            }, "json");
    });

    $('#comment_list').on('click', '[nctype="btn_comment_quote_cancel"]', function() {
        $(this).parents('p').remove();
    });

    $('#comment_list').on('click', '[nctype="comment_up"]', function() {
        <?php if($_SESSION['is_login'] != '1'){?>
        //登陆窗口
        $.show_nc_login({
            nchash:'<?php echo getNchash();?>',
            formhash:'<?php echo Security::getTokenValue();?>',
            anchor:'cms_comment_flag'
        });
        <?php } else { ?>
        var comment_id = $(this).attr('comment_id');
        var $count = $(this).find('em');
        $.post("<?php echo CMS_SITE_URL.DS.'index.php?act=comment&op=comment_up';?>", {comment_id:comment_id},
            function(data){
                if(data.result == 'true') {
                    var old_count = parseInt($count.text());
                    $count.text(old_count + 1);
                } else {
                    showError(data.message);
                }
         }, "json");
        <?php } ?>
    });

});
</script>

<div id="cms_comment_flag" class="article-comment-title">
  <h3></h3>
  <span><?php echo $lang['cms_comment1'];?><a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=<?php echo $_GET['act'];?>&op=<?php echo $_GET['act'];?>_comment_detail&<?php echo $_GET['act'];?>_id=<?php echo $output['detail_object_id'];?>"><em><?php echo $output[$_GET['act'].'_detail'][$_GET['act'].'_comment_count'];?></em></a><?php echo $lang['cms_comment2'];?><em><?php echo $output[$_GET['act'].'_detail'][$_GET['act'].'_click'];?></em><?php echo $lang['cms_comment3'];?></span> </div>
<form id="add_form" action="" class="article-comment-form">
  <input id="input_comment_type" name="comment_type" type="hidden" value="<?php echo $_GET['act'];?>" />
  <input id="input_comment_object_id" name="comment_object_id" type="hidden" value="<?php echo $output['detail_object_id'];?>" />
  <textarea id="input_comment_message" name="comment_message" class="article-comment-textarea"></textarea>
  <input id="btn_comment_submit" type="button" class="article-comment-btn" value="发布" />
  <?php if($_SESSION['is_login'] != '1'){?>
  <div class="article-comment-login"><?php echo $lang['cms_comment4'];?><a id="btn_login" href="###">[<?php echo $lang['cms_login'];?>]</a><?php echo $lang['cms_comment5'];?></div>
  <?php }?>
</form>
<div id="comment_list" class="article-comment-list"></div>
<div id="comment_quote" style="display:none;"><a nctype="btn_comment_quote_cancel" href="JavaScript:;" class="cancel-btn" title="取消"></a>
  <textarea name="comment_quote" rows="3" cols="30"></textarea>
  <a nctype="btn_comment_quote_publish" href="JavaScript:;" class="publish-btn">发布</a></div>
