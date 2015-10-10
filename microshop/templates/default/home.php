<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
    $("[nc_type=home_drop]").click(function(){
        if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
            var item = $(this).parent().parent();
            $.getJSON("index.php?act=home&op=home_drop", { type: $(this).attr("type"),item_id: $(this).attr("item_id")}, function(json){
                if(json.result == "true") {
                    item.remove();
                    $("#pinterest").masonry("reload");
                } else {
                    showError(json.message);
                }
            });
        }
        return false;
    });
	//加关注
    $("#btn_sns_addfollow").live('click',function(){
        $.getJSON("<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&op=add_follow&member_id=<?php echo $output['member_info']['member_id'];?>", {}, function(json){
            if(json.result == "true") {
                $("#btn_sns_addfollow").hide();
                $("#btn_sns_delfollow").show();
                if(json.message != 're') {
                    $("#follow_count").microshop_count({type:'+'});
                }
            } else {
                showError(json.message);
            }
        });
        return false;
    });
	//取消关注
	$("#btn_sns_delfollow").live('click',function(){
        $.getJSON("<?php echo MICROSHOP_SITE_URL.DS;?>index.php?act=home&op=del_follow&member_id=<?php echo $output['member_info']['member_id'];?>", {}, function(json){
            if(json.result == "true") {
                $("#btn_sns_addfollow").show();
                $("#btn_sns_delfollow").hide();
                $("#follow_count").microshop_count({type:'-'});
            } else {
                showError(json.message);
            }
        });
        return false;
	});

});
</script>
<div class="user-page-top">
  <div class="user-info-box">
    <div class="user-avatar"><span class="thumb size100"><i></i><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']);?>" alt="<?php echo $output['member_info']['member_name'];?>" onload="javascript:DrawImage(this,120,120);" /></span></div>
    <dl class="user-intro">
      <dt>
      <h2><?php echo !empty($output['member_info']['member_truename'])?$output['member_info']['member_truename']:$output['member_info']['member_name'];?></h2>
      </dt>
      <dd> 
      <span class="sex">
          <?php if($output['member_info']['member_sex'] ==1 ){?>
          <i class="male pngFix"><?php echo $lang['microshop_text_male'];?></i>
          <?php }else if($output['member_info']['member_sex'] == 2){?>
          <i class="female pngFix"><?php echo $lang['microshop_text_female'];?></i>
          <?php } else {?>
          <?php echo $lang['microshop_text_unknow'];?>
          <?php }?>
      </span>
      <span class="location"><?php echo $output['member_info']['member_areainfo'];?></span>
      <?php if(isset($output['follow_flag'])) { ?>
      <a id="btn_sns_addfollow" href="javascript:void(0)" <?php if(!$output['follow_flag']){ echo "style='display:none;'";}?>><?php echo $lang['microshop_text_follow_add'];?></a>
      <a id="btn_sns_delfollow" href="javascript:void(0)" <?php if($output['follow_flag']){ echo "style='display:none;'";}?>><?php echo $lang['microshop_text_follow_del'];?></a>
      <?php } ?>
      </dd>
      </dl><div class="user-stat">
      <dl class="noborder">
          <dd id="follow_count"><?php echo $output['member_info']['fan_count']<=999?$output['member_info']['fan_count']:'999+';?></dd>
          <dt><?php echo $lang['microshop_text_follower'];?></dt>
      </dl>
      <dl>
          <dd><?php echo $output['member_info']['attention_count']<=999?$output['member_info']['attention_count']:'999+';?></dd>
      <dt><?php echo $lang['microshop_text_follow'];?></dt>
    </dl>
    <dl>
      <dd><?php echo $output['visit_count']<=999?$output['visit_count']:'999+';?></dd>
      <dt><?php echo $lang['microshop_text_visit'];?></dt>
    </dl>
  </div>
  </div>
  
</div>
<div class="user-page-nav">
  <ul>
    <li <?php echo $output['home_sign'] == 'goods'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=goods&member_id=<?php echo $output['member_info']['member_id'];?>" class="pngFix"><i class="link2 pngFix"></i><span><?php echo $lang['nc_microshop_goods'];?></span></a></li>
    <!--
        <li <?php echo $output['home_sign'] == 'album'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=album&member_id=<?php echo $output['member_info']['member_id'];?>"><i class="link3"></i><span><?php echo $lang['nc_microshop_album'];?></span></a></li>
        -->
    <li <?php echo $output['home_sign'] == 'personal'?'class="current pngFix"':'class="link pngFix"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=personal&member_id=<?php echo $output['member_info']['member_id'];?>" class="pngFix"><i class="link4 pngFix"></i><span><?php echo $lang['nc_microshop_personal'];?></span></a></li>
    <li <?php echo $output['home_sign'] == 'like'?'class="current pngFix"':'class="link pngFix"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&op=like_list&member_id=<?php echo $output['member_info']['member_id'];?>" class="pngFix"><i class="link5 pngFix"></i><span><?php echo $lang['nc_microshop_like'];?></span></a></li>
  </ul>
</div>
<?php 
require("widget_{$output['home_sign']}_list.php");
?>
