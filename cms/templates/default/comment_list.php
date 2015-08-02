<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['comment_list']) && is_array($output['comment_list'])){ ?>
<div class="article-comment-list-title">
  <h3><?php echo $lang['cms_comment_new'];?></h3>
</div>
<?php foreach($output['comment_list'] as $value){ ?>
<dl>
  <dt><span class="thumb"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_snshome&mid=<?php echo $value['comment_member_id'];?>" target="_blank"> <img src="<?php echo getMemberAvatar($value['member_avatar']);?>" alt="<?php echo $value['member_name'];?>"/></a></span></dt>
  <dd>
    <p class="comment-user"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_snshome&mid=<?php echo $value['comment_member_id'];?>" target="_blank"> <?php echo $value['member_name'];?></a><em>发表于<?php echo date('Y-m-d H:i:s',$value['comment_time']);?></em>
    </p>
    <p class="comment-quote-list">
    <?php if(!empty($value['comment_quote'])) { ?>
    <?php $comment_quote_array = explode(',', $value['comment_quote']);?>
    <?php for($i = 0,$j = count($comment_quote_array); $i < $j; $i++) { ?>
    <?php echo '<div class="comment-quote-item">';?>
    <?php } ?>
    <?php $i = 1;?>
    <?php foreach($comment_quote_array as $comment_quote_id) {?>
    <?php if(isset($output['comment_quote_list'][$comment_quote_id])) { ?>
    <p>
    <span class="comment-quote-member"><?php echo $output['comment_quote_list'][$comment_quote_id]['member_name'];?><i><?php echo $i;?></i></span>
    <span class="comment-quote-message"><?php echo $output['comment_quote_list'][$comment_quote_id]['comment_message'];?></span>
    <span class="quote"><a nctype="comment_quote" comment_id="<?php echo $output['comment_quote_list'][$comment_quote_id]['comment_id'];?>" href="javascript:void(0)" >回复</a></span>
    </p>
    <?php } else { ?>
    <p>
    <span class="comment-quote-member"></span>
    <span class="comment-quote-message">已删除</span>
    </p>
    <?php } ?>
    </div>
    <?php $i++;?>
    <?php } ?>
    <?php } ?>
    </p>
    <p class="comment-content"><?php echo $value['comment_message'];?></p>
    <p class="commnet-date"> 
    <a nctype="comment_up" comment_id="<?php echo $value['comment_id'];?>" href="javascript:void(0)" class="up">顶<span>[<em><?php echo $value['comment_up'];?></em>]</span></a>
    <a nctype="comment_quote" comment_id="<?php echo $value['comment_id'];?>" href="javascript:void(0)" class="quote">回复</a>
    <?php if($value['comment_member_id'] == $_SESSION['member_id']) { ?>
    <a nctype="comment_drop" comment_id="<?php echo $value['comment_id'];?>" href="javascript:void(0)" class="del"><?php echo $lang['nc_delete'];?></a>
    <?php } ?>
    </p>
    </dd>
</dl>
<?php } ?>
<div id="comment_pagination" class="pagination"><?php echo $output['show_page'];?></div>
<?php } ?>
