<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){

    $(".btn_commend_dialog").click(function(){
        $("#commend_dialog_goods_image").attr('src',$(this).attr("goods_image"));
        $("#commend_dialog_goods_image").attr('alt',$(this).attr("goods_name"));
        $("#commend_goods_id").val($(this).attr("goods_id"));
        $("#commend_dialog_goods_name").html($(this).attr("goods_name"));
        $("#commend_dialog_goods_price").html($(this).attr("goods_price"));
        $("#div_commend_goods").microshop_form_show({width:480});
    });

    $("#div_commend_goods").microshop_form({title:'<?php echo $lang['microshop_text_commend'].$lang['microshop_text_goods'];?>'});

    $("#commend_message").microshop_publish({
        button_item:'#btn_publish',
        allow_null:'true'
    },function(){
        $("#div_commend_goods").hide();
        ajaxpost('add_form', '', '', 'onerror'); 
    });

});
</script>

<div class="all-layout-box">
  <?php if($output['goods_type'] == 'buy') { ?>
  <h1><?php echo $lang['microshop_goods_buy'];?></h1>
  <?php } else { ?>
  <h1><?php echo $lang['microshop_goods_favorite'];?></h1>
  <?php } ?>
  <?php if(!empty($output['list']) && is_array($output['list'])) {?>
  <div class="publish-goods-list">
    <ul>
      <?php foreach($output['list'] as $key=>$val) {?>
      <li class="<?php echo in_array($val['goods_id'],$output['commend_goods_array'])?'selected':'select' ?>">
        <div class="picture"><span class="thumb size210"><i></i><a href="<?php echo urlShop('goods', 'index',array('goods_id'=>$val['goods_id']));?>" target="_blank"> <img src="<?php echo thumb($val, 240);?>" onload="javascript:DrawImage(this,210,210);" alt="<?php echo $val['goods_name'];?>" title="<?php echo $val['goods_name'];?>" /> </a></span></div>
        <dl>
          <dd class="fl"><?php echo $lang['currency'].ncPriceFormat($val['goods_price']);?></dd>
        </dl>
        <div class="recommand-btn">
          <?php if(in_array($val['goods_id'],$output['commend_goods_array'])) { ?>
          <a href="javascript:void(0)"><?php echo $lang['microshop_goods_commend_already'];?></a>
          <?php } else { ?>
          <a href="javascript:void(0)" class="btn_commend_dialog" goods_id="<?php echo $val['goods_id'];?>" goods_name="<?php echo $val['goods_name'];?>" goods_price="<?php echo $lang['currency'].$val['goods_price'];?>" goods_image="<?php echo thumb($val, 240);?>"><?php echo $lang['microshop_goods_commend_want'];?></a>
          <?php } ?>
        </div>
      </li>
      <?php } ?>
    </ul>
  </div>
  <div class="pagination"> <?php echo $output['show_page'];?> </div>
</div>

<!-- 弹出层开始 -->
<div id="div_commend_goods" style="display:none;">
<form action="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=publish&op=goods_save" method="post" id="add_form" class="feededitor">
  <input type="hidden" value="" name="commend_goods_id" id="commend_goods_id">
  </input>
  <div class="command-goods">
    <div class="pic">
      <span class="thumb size100">
      <i></i><img alt="" onload="javascript:DrawImage(this,100,100);" src="" id="commend_dialog_goods_image"></span></div>
    <dl class="intro">
      <dt id="commend_dialog_goods_name"></dt>
      <dd id="commend_dialog_goods_price"></dd>
    </dl>
  </div>
  <dl class="share">
    <dt><?php echo $lang['microshop_goods_publish_tile'];?></dt>
    <dd></dd>
    <textarea name="commend_message" id="commend_message" ></textarea>
  </dl>
  <div class="handle">
    <input id="btn_publish" type="button" value="<?php echo $lang['microshop_text_commend'];?>" />
    <!-- 站外分享 -->
    <?php require('widget_share.php');?>
  </div>
</form>
</div>
<!-- 弹出层结束 -->
<?php } else { ?>
<div class="no-content"> <i class="buy pngFix">&nbsp;</i>
  <?php if($output['goods_type'] == 'buy') { ?>
  <p><?php echo $lang['microshop_goods_buy_none'];?></p>
  <?php } else { ?>
  <p><?php echo $lang['microshop_goods_favorite_none'];?></p>
  <?php } ?>
</div>
<?php } ?>
