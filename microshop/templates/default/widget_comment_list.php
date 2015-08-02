<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#comment_pagination li").first().remove();
        $("#comment_pagination li").last().remove();
    });
</script>
<?php if(!empty($output['list']) && is_array($output['list'])){ ?>
<?php foreach($output['list'] as $val){ ?>

<dl>
  <dt class="head-portrait"> <span class="thumb"><i></i> <a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $val['comment_member_id'];?>" target="_blank"> <img src="<?php echo getMemberAvatar($val['member_avatar']);?>" alt="<?php echo $val['member_name'];?>"  /> </a> </span> </dt>
  <dd> <a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $val['comment_member_id'];?>" target="_blank"> <?php echo $val['member_name'].$lang['nc_colon'];?> </a> <span><?php echo parsesmiles($val['comment_message']);?></span>
    <p><em><?php echo date('Y-m-d H:i:s',$val['comment_time']);?></em>
      <?php if($val['comment_member_id'] == $_SESSION['member_id']) { ?>
      <a nc_type="comment_drop" comment_id="<?php echo $val['comment_id'];?>" href="javascript:void(0)" class="del pngFix"><?php echo $lang['nc_delete'];?></a>
      <?php } ?>
    </p>
  </dd>
</dl>
<?php } ?>
<div id="comment_pagination" class="pagination"><?php echo $output['show_page'];?></div>
<?php } ?>
