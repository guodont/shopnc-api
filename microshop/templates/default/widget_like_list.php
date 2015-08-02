<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
    $("[nc_type=like_drop]").click(function(){
        if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
            var item = $(this).parent().parent();
            $.getJSON("index.php?act=like&op=like_drop", { like_id: $(this).attr("like_id")}, function(json){
                if(json.result == "true") {
                    item.remove();
                    $("#pinterest").masonry("reload");
                } else {
                    showError(json.message);
                }
            });
        }
    });
});
</script>
<ul class="user-like-nav">
    <li <?php echo $output['like_sign'] == 'goods'?'class="current"':'class="link"'; ?> style="border-left:0; padding-left:0;"><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=like_list&type=goods&member_id=<?php echo $output['member_info']['member_id'];?>"><?php echo $lang['nc_microshop_goods'];?></a></li>
    <!--
    <li <?php echo $output['like_sign'] == 'album'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=like_list&type=album&member_id=<?php echo $output['member_info']['member_id'];?>"><?php echo $lang['nc_microshop_album'];?></a></li>
    -->
    <li <?php echo $output['like_sign'] == 'personal'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=like_list&type=personal&member_id=<?php echo $output['member_info']['member_id'];?>"><?php echo $lang['nc_microshop_personal'];?></a></li>
    <li <?php echo $output['like_sign'] == 'store'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=like_list&type=store&member_id=<?php echo $output['member_info']['member_id'];?>"><?php echo $lang['nc_microshop_store'];?></a></li>
</ul>
<?php 
require("widget_{$output['like_sign']}_list.php");
?>
