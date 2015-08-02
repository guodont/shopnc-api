<?php defined('InShopNC') or exit('Access Invalid!');?>
  <div class="visitors pngFix">
    <h4><span class="active" nc_type="visitmodule" data-param='{"name":"visit_me"}'><?php echo $lang['sns_visit_me']; if ($output['relation'] == 3){echo $lang['sns_me']; }else {echo 'TA';}?></span><?php if($output['relation'] == 3){?><span class="line">|</span><span class="normal" nc_type="visitmodule" data-param='{"name":"visit_other"}'><?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {echo 'TA';} echo $lang['sns_visit_other'];?></span><?php }?></h4>
    <ul id="visit_me" nc_type="visitlist">
      <?php if (!empty($output['visitme_list'])){?>
      <?php foreach ($output['visitme_list'] as $k=>$v){?>
      <li>
        <div class="visitor-pic"><span class="thumb size60"><i></i><a href="index.php?act=member_snshome&mid=<?php echo $v['v_mid'];?>" target="_blank"> <img src="<?php echo getMemberAvatarForID($v['v_mid']); ?>" data-param="{'id':<?php echo $v['v_mid'];?>}" nctype="mcard" onload="javascript:DrawImage(this,60,60);"> </a></span></div>
        <p class="visitor-name"><a href="index.php?act=member_snshome&mid=<?php echo $v['v_mid'];?>" target="_blank" data-param="{'id':<?php echo $v['v_mid'];?>}" nctype="mcard"><?php echo $v['v_mname'];?></a></p>
        <p class="visitor-time"><?php echo $v['adddate_text'];?></p>
      </li>
      <?php }?>
      <?php }else {?>
      <?php echo $lang['sns_visitme_tip_1'];?><a href="index.php?act=member_snsfriend&op=find"><?php echo $lang['sns_visitme_tip_2'];?></a><?php echo $lang['sns_visitme_tip_3'];?>
      <?php }?>
    </ul>
    <?php if($output['relation'] == 3){?>
    <ul id="visit_other" nc_type="visitlist" style="display: none;">
      <?php if (!empty($output['visitother_list'])){?>
      <?php foreach ($output['visitother_list'] as $k=>$v){?>
      <li>
        <div class="visitor-pic"><span class="thumb size60"><i></i><a href="index.php?act=member_snshome&mid=<?php echo $v['v_ownermid'];?>" target="_blank"> <img src="<?php echo getMemberAvatarForID($v['v_ownermid']);?>" data-param="{'id':<?php echo $v['v_ownermid'];?>}" nctype="mcard" onload="javascript:DrawImage(this,60,60);"> </a></span></div>
        <p class="visitor-name"><a href="index.php?act=member_snshome&mid=<?php echo $v['v_ownermid'];?>" target="_blank" data-param="{'id':<?php echo $v['v_ownermid'];?>}" nctype="mcard"><?php echo $v['v_ownermname'];?></a></p>
        <p class="visitor-time"><?php echo $v['adddate_text'];?> <?php echo $v['addtime_text'];?></p>
      </li>
      <?php }?>
      <?php }else {?>
      <?php echo $lang['sns_visitother_tip_1'];?><a href="index.php?act=member_snsfriend&op=follow"><?php echo $lang['sns_visitother_tip_2'];?></a><?php echo $lang['sns_visitother_tip_3'];?>
      <?php }?>
    </ul>
    <?php }?>
  </div>
<script>
$(function(){
	$("[nc_type='visitmodule']").bind('click',function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    $("[nc_type='visitmodule']").removeClass('active');
	    $("[nc_type='visitmodule']").addClass('normal');
	    $(this).removeClass('normal');
	    $(this).addClass('active');
	    $("[nc_type='visitlist']").hide();
	    $("#"+data_str.name).show();
	});
});
</script>