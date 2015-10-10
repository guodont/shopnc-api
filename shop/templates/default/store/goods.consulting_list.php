<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_goods.css" rel="stylesheet" type="text/css">
<div class="wrapper">
  <div class="ncs-goods-layout expanded" >
    <div class="ncs-goods-main">
      <div class="ncs-goods-title-bar">
        <h4><?php echo $lang['goods_index_goods_consult'];?></h4>
      </div>
      <div class="ncs-goods-info-content bd" id="ncGoodsRate">
        <div class="top" style="overflow: hidden;">
          <div class="ncs-cosult-tips"> <i></i>
            <p><?php echo html_entity_decode(C('consult_prompt'));?></p>
          </div>
          <div class="ncs-cosult-askbtn"><a href="#askQuestion" class="ncs-btn ncs-btn-red">我要提问</a></div>
        </div>
        <div class="ncs-goods-title-nav">
          <ul id="comment_tab">
            <li class="<?php if (intval($_GET['ctid']) == 0) {?>current<?php }?>"><a href="<?php echo urlShop('goods', 'consulting_list', array('goods_id' => $_GET['goods_id']));?>">全部</a></li>
            <?php if (!empty($output['consult_type'])) {?>
            <?php foreach ($output['consult_type'] as $val) {?>
            <li class="<?php if (intval($_GET['ctid']) == $val['ct_id']) {?>current<?php }?>"><a href="<?php echo urlShop('goods', 'consulting_list', array('goods_id' => $_GET['goods_id'], 'ctid' => $val['ct_id']));?>"><?php echo $val['ct_name'];?></a></li>
            <?php }?>
            <?php }?>
          </ul>
        </div>
        <div class="ncs-commend-main">
          <?php if(!empty($output['consult_list'])) { ?>
          <?php foreach($output['consult_list'] as $k=>$v){ ?>
          <div class="ncs-cosult-list">
            <dl class="asker">
              <dt>咨询网友<?php echo $lang['nc_colon'];?></dt>
              <dd>
                <?php if($v['member_id']== '0') echo $lang['nc_guest']; else if($v['isanonymous'] == 1){?>
                <?php echo str_cut($v['member_name'],2).'***';?>
                <?php }else{?>
                <a href="index.php?act=member_snshome&mid=<?php echo $v['member_id'];?>" target="_blank" data-param="{'id':<?php echo $v['member_id'];?>}" nctype="mcard"><?php echo str_cut($v['member_name'],8);?></a>
                <?php }?>
                &nbsp;<span>咨询类型：<?php echo $output['consult_type'][$v['ct_id']]['ct_name'];?></span>
                <time datetime="<?php echo date("Y-m-d H:i:s",$v['consult_addtime']);?>" pubdate="pubdate" class="ml20"><?php echo date("Y-m-d H:i:s",$v['consult_addtime']);?></time>
              </dd>
            </dl>
            <dl class="ask-con">
              <dt><?php echo $lang['goods_index_consult_content'];?><?php echo $lang['nc_colon'];?></dt>
              <dd>
                <p><?php echo nl2br($v['consult_content']);?></p>
              </dd>
            </dl>
            <?php if($v['consult_reply']!=""){?>
            <dl class="reply">
              <dt><?php echo $lang['goods_index_seller_reply'];?></dt>
              <dd>
                <p><?php echo nl2br($v['consult_reply']);?></p>
                <time datetime="<?php echo date("Y-m-d H:i:s",$v['consult_reply_time']);?>" pubdate="pubdate">[<?php echo date("Y-m-d H:i:s",$v['consult_reply_time']);?>]</time>
              </dd>
            </dl>
            <?php }?>
          </div>
          <?php }?>
          <div class="tr pr5 pb5">
            <div class="pagination"> <?php echo $output['show_page'];?> </div>
          </div>
          <?php } else { ?>
          <div class="ncs-norecord"><?php echo $lang['goods_index_no_reply'];?></div>
          <?php } ?>
        </div>
      </div>
      <?php if($output['consult_able']) { ?>
      <!-- S 咨询表单部分 -->
      <div class="ncs-goods-title-bar" id="askQuestion">
        <h4>发表咨询</h4>
      </div>
      <form method="post" id="message" action="index.php?act=goods&op=save_consult">
        <?php Security::getToken();?>
        <input type="hidden" name="form_submit" value="ok" />
        <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
        <?php if($output['type_name']==''){?>
        <input type="hidden" name="goods_id" value="<?php echo $_GET['goods_id']; ?>"/>
        <?php }?>
        <div class="ncs-consult-form">
          <?php if (!empty($output['consult_type'])) {?>
          <dl>
            <dt>咨询类型：</dt>
            <dd>
              <?php $checked = true;foreach ($output['consult_type'] as $val) {?>
              <label>
                <input type="radio" <?php if ($checked) {?>checked="checked"<?php }?> nctype="ctype<?php echo $val['ct_id'];?>" name="consult_type_id" class="radio" value="<?php echo $val['ct_id'];?>" />
                <?php echo $val['ct_name'];?></label>
              <?php $checked = false;}?>
            </dd>
          </dl>
          <?php $checked = true;foreach ($output['consult_type'] as $val) {?>
          <div class="ncs-consult-type-intro" <?php if (!$checked) {?>style="display:none;"<?php }?> nctype="ctype<?php echo $val['ct_id'];?>"> <?php echo $val['ct_introduce'];?> </div>
          <?php $checked = false;}?>
          <?php }?>
          <div>
            <?php if($_SESSION['member_id']){ ?>
            <label><strong><?php echo $lang['goods_index_member_name'].$lang['nc_colon'];?></strong><?php echo $_SESSION['member_name'];?></label>
            <label for="gbCheckbox">
              <input type="checkbox" class="checkbox" name="hide_name" value="hide" id="gbCheckbox">
              <?php echo $lang['goods_index_anonymous_publish'];?></label>
            <?php }?>
          </div>
          <dl class="ncs-consult">
            <dt>咨询内容：</dt>
            <dd>
              <textarea name="goods_content" id="textfield3" class="textarea w700 h60"></textarea>
              <span id="consultcharcount"></span> </dd>
          </dl>
          <dl>
            <dt>&nbsp;</dt>
            <dd>
              <?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
              <input name="captcha" class="text w60" type="text" id="captcha" size="4" placeholder="<?php echo $lang['goods_index_checkcode'];?>" autocomplete="off" maxlength="4"/>
              <div class="code">
                <div class="arrow"></div>
                <div class="code-img"><a href="javascript:void(0)" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();"><img src="index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" name="codeimage" border="0" id="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random()"/></a></div>
                <a href="JavaScript:void(0);" id="hide" class="close" title="关闭"><i></i></a> <a href="JavaScript:void(0);" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();" class="change" title="<?php echo $lang['goods_index_change_checkcode'];?>"><i></i></a> </div>
              <?php } ?>
              <a href="JavaScript:void(0);" nctype="consult_submit" title="<?php echo $lang['goods_index_publish_consult'];?>" class="ncs-btn ncs-btn-red"><?php echo $lang['goods_index_publish_consult'];?></a></dd>
            <dd nctype="error_msg"></dd>
          </dl>
        </div>
      </form>
      <!-- E 咨询表单部分 -->
      <?php } ?>
    </div>
    <div class="ncs-sidebar">
      <div class="ncs-sidebar-container">
        <div class="title">
          <h4>商品信息</h4>
        </div>
        <div class="content">
          <dl class="ncs-comment-goods">
            <dt class="goods-name"> <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['goods']['goods_id']));?>"> <?php echo $output['goods']['goods_name']; ?> </a> </dt>
            <dd class="goods-pic"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['goods']['goods_id']));?>"> <img src="<?php echo cthumb($output['goods']['goods_image'], 240); ?>" alt="<?php echo $output['goods']['goods_name']; ?>"> </a> </dd>
            <dd class="goods-price"><?php echo $lang['goods_index_goods_price'].$lang['nc_colon'];?><em class="saleP"><?php echo $lang['currency'].$output['goods']['goods_price'];?></em></dd>
            <dd class="goods-raty"><?php echo $lang['goods_index_evaluation'].$lang['nc_colon'];?> <span class="raty" data-score="<?php echo $output['goods']['evaluation_good_star'];?>"></span> </dd>
          </dl>
        </div>
        <!--S 店铺信息-->
        <?php include template('store/info');?>
        <!--E 店铺信息 --> 
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script>
$(function(){
    $('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        score: function() {
          return $(this).attr('data-score');
        }
    });
    <?php if($output['consult_able']) { ?>
    $('a[nctype="consult_submit"]').click(function(){
    	$('#message').submit();
    });

    $('#message').validate({
    	errorPlacement: function(error, element){
    		$('dd[nctype="error_msg"]').append(error);
        },
    	submitHandler:function(form){
    		ajaxpost('message', '', '', 'onerror');
    	},
        onkeyup: false,
        rules : {
        	goods_content : {
                required : true,
                maxlength : 120
            }
            <?php if(C('captcha_status_goodsqa') == '1') { ?>
            	,captcha: {
            		required : true,
            		remote   : {
                        url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                        type:'get',
                        data:{
                        	captcha : function(){
                                return $('#captcha').val();
                            }
                        },
                        complete: function(data) {
                            if(data.responseText == 'false') {
                            	document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();
                            }
                        }
                    }
            	}
            <?php }?>
        },
        messages : {
        	goods_content : {
                required : '<?php echo $lang['goods_index_cosult_not_null'];?>',
                maxlength: '<?php echo $lang['goods_index_max_120'];?>'
            }
            <?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
            	,captcha: {
            		required : '<?php echo $lang['goods_index_captcha_no_noll'];?>',
            		remote   : '<?php echo $lang['goods_index_captcha_error'];?>'
                }
            <?php }?>
        }
    });
    
    // textarea 字符个数动态计算
    $("#textfield3").charCount({
    	allowed: 120,
    	warning: 10,
    	counterContainerID:'consultcharcount',
    	firstCounterText:'<?php echo $lang['goods_index_textarea_note_one'];?>',
    	endCounterText:'<?php echo $lang['goods_index_textarea_note_two'];?>',
    	errorCounterText:'<?php echo $lang['goods_index_textarea_note_three'];?>'
    });
    <?php }?>

    $('input[type="radio"]').click(function(){
        $('div[nctype^="ctype"]').hide();
        $('div[nctype="' + $(this).attr('nctype') + '"]').show();
    });
	//Hide Show verification code
    $("#hide").click(function(){
        $(".code").fadeOut("slow");
    });
    $("#captcha").focus(function(){
        $(".code").fadeIn("fast");
    });  
});
</script>