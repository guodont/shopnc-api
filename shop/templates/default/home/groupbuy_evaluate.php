<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goodsevallist']) && is_array($output['goodsevallist'])){?>
<?php foreach($output['goodsevallist'] as $k=>$v){?>

<div id="t" class="ncg-evaluate-floor">
  <div class="user-avatar"> <a href="index.php?act=member_snshome&mid=<?php echo $v['geval_frommemberid'];?>" target="_blank" data-param="{'id':<?php echo $v['geval_frommemberid'];?>}" nctype="mcard"> <img src="<?php echo getMemberAvatarForID($v['geval_frommemberid']);?>"> </a> </div>
  <dl class="detail">
    <dt> <span class="user-name">
      <?php if($v['geval_isanonymous'] == 1){?>
      <?php echo str_cut($v['geval_frommembername'],2).'***';?>
      <?php }else{?>
      <a href="index.php?act=member_snshome&mid=<?php echo $v['geval_frommemberid'];?>" target="_blank" data-param="{'id':<?php echo $v['geval_frommemberid'];?>}" nctype="mcard"><?php echo $v['geval_frommembername'];?></a>
      <?php }?>
      </span>
      <time pubdate="pubdate">[<?php echo @date('Y-m-d',$v['geval_addtime']);?>]</time>
    </dt>
    <dd>用户评分：<span class="raty" data-score="<?php echo $v['geval_scores'];?>"></span></dd>
    <dd class="content">评价详情：<span><?php echo $v['geval_content'];?></span></dd>
    <?php if (!empty($v['geval_explain'])){?>
    <dd class="explain">解释：<span><?php echo $v['geval_explain'];?></span></dd>
    <?php } ?>
    <?php if(!empty($v['geval_image'])) {?>
    <dd> 晒单图片：
      <ul class="photos-thumb">
        <?php $image_array = explode(',', $v['geval_image']);?>
        <?php foreach ($image_array as $value) { ?>
        <li><a nctype="nyroModal"  href="<?php echo snsThumb($value, 1024);?>"> <img src="<?php echo snsThumb($value);?>"> </a></li>
        <?php } ?>
      </ul>
    </dd>
    <?php } ?>
  </dl>
</div>
<?php }?>
<div class="tc pr5 pb5 pr">
  <div class="pagination"> <?php echo $output['show_page'];?></div>
</div>
<?php }else{?>
<div class="no-buyer"><?php echo $lang['no_record'];?></div>
<?php }?>
<script type="text/javascript">
$(document).ready(function(){
   $('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        score: function() {
          return $(this).attr('data-score');
        }
    });

   $('a[nctype="nyroModal"]').nyroModal();

    $('#groupbuy_evaluate').find('.demo').ajaxContent({
        event:'click', //mouseover
        loaderType:"img",
        loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
        target:'#groupbuy_evaluate'
    });
});
</script> 
