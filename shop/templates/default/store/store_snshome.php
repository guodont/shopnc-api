<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns_store.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies_data.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.caretInsert.js" charset="utf-8"></script>
<script>
var MAX_RECORDNUM = <?php echo $output['max_recordnum'];?>;
</script>

<div class="cms-sns">
  <div class="cms-sns-left">
    <div class="cms-sns-tabmene">
      <ul>
        <li><a href="<?php echo urlShop('store_snshome', 'index', array('sid' => $output['store_info']['store_id']));?>" <?php if($_GET['type'] == ''){?>class="selected"<?php }?>><?php echo $lang['store_sns_all_trends'];?><i></i></a></li>
        <li><a href="<?php echo urlShop('store_snshome', 'index', array('sid' => $output['store_info']['store_id'], 'type' => 'promotion'));?>" <?php if($_GET['type'] == 'promotion'){?>class="selected"<?php }?>><?php echo $lang['store_sns_sales_promotion'];?><i></i></a></li>
        <li><a href="<?php echo urlShop('store_snshome', 'index', array('sid' => $output['store_info']['store_id'], 'type' => 'new'));?>" <?php if($_GET['type'] == 'new'){?>class="selected"<?php }?>><?php echo $lang['store_sns_new_goods'];?><i></i></a></li>
        <li><a href="<?php echo urlShop('store_snshome', 'index', array('sid' => $output['store_info']['store_id'], 'type' => 'hotsell'));?>" <?php if($_GET['type'] == 'hotsell'){?>class="selected"<?php }?>><?php echo $lang['store_sns_hot_sale'];?><i></i></a></li>
        <li><a href="<?php echo urlShop('store_snshome', 'index', array('sid' => $output['store_info']['store_id'], 'type' => 'recommend'));?>" <?php if($_GET['type'] == 'recommend'){?>class="selected"<?php }?>><?php echo $lang['store_sns_recommended'];?><i></i></a></li>
      </ul>
    </div>
    <div class="cms-sns-content">
      <?php if(!empty($output['strace_array'])){?>
      <ul class="cms-sns-content-list">
        <?php foreach($output['strace_array'] as $val){?>
        <li nc_type="tracerow_<?php echo $val['strace_id']; ?>">
          <dl>
            <dt>
              <h5><?php echo parsesmiles($val['strace_title']);?></h5>
              <?php if ($_SESSION['store_id'] == $val['strace_storeid']){?>
              <span class="fd-handle"> <a href="javascript:void(0);" nc_type="sd_del" data-param='{"txtid":"<?php echo $val['strace_id'];?>"}'><i class="icon-trash"></i><?php echo $lang['nc_delete'];?></a> </span>
              <?php }?>
            </dt>
            <dd> <?php echo parsesmiles($val['strace_content']);?> </dd>
            <dd> <span class="goods-time fl"><?php echo date('Y-m-d H:i',$val['strace_time']);?></span> <span class="fr"> <a href="javascript:void(0);" nc_type="sd_forwardbtn" data-param='{"txtid":"<?php echo $val['strace_id'];?>"}'><?php echo $lang['sns_forward']; ?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" nc_type="sd_commentbtn" data-param='{"txtid":"<?php echo $val['strace_id'];?>"}'><?php echo $lang['sns_comment']; ?><?php echo $val['strace_comment']>0?"(".$val['strace_comment'].")":'';?></a> </span> </dd>
            <dd> 
              <!-- 评论模块start -->
              <div id="tracereply_<?php echo $val['strace_id'];?>" style="display:none;"></div>
              <!-- 评论模块end --> 
              <!-- 转发模块start -->
              <div id="forward_<?php echo $val['strace_id'];?>" style="display:none;">
                <div class="forward-widget">
                  <div class="forward-edit">
                    <form id="forwardform_<?php echo $val['strace_id'];?>" method="post" action="index.php?act=store_snshome&op=addforward">
                      <input type="hidden" name="stid" value="<?php echo $val['strace_id'];?>"/>
                      <div class="forward-add">
                        <textarea resize="none" id="content_forward<?php echo $val['strace_id'];?>" name="forwardcontent"><?php echo $v['trace_title_forward'];?></textarea>
                        <span class="error"></span> 
                        <!-- 验证码 -->
                        <div id="forwardseccode<?php echo $val['strace_id'];?>" class="seccode" style="display: none;">
                          <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon']; ?></label>
                          <input name="captcha" class="text" type="text" size="4" maxlength="4"/>
                          <img src="" title="<?php echo $lang['wrong_checkcode_change']; ?>" name="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/> <span><?php echo $lang['wrong_seccode'];?></span>
                          <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
                        </div>
                        <input type="text" style="display:none;" />
                        <!-- 防止点击Enter键提交 -->
                        <div class="act"> <span class="skin-blue"><span class="btn"><a href="javascript:void(0);" nc_type="s_forwardbtn" data-param='{"txtid":"<?php echo $val['strace_id'];?>"}'><?php echo $lang['sns_forward'];?></a></span></span> <span id="forwardcharcount<?php echo $val['strace_id'];?>" style="float:right;"></span> <a class="face" nc_type="smiliesbtn" data-param='{"txtid":"forward<?php echo $val['strace_id'];?>"}' href="javascript:void(0);" ><?php echo $lang['sns_smiles'];?></a> </div>
                      </div>
                    </form>
                  </div>
                  <ul class="forward-list">
                  </ul>
                </div>
              </div>
              <!-- 转发模块end -->
              <div class="clear"></div>
            </dd>
          </dl>
        </li>
        <?php }?>
      </ul>
      <div id="pagehtml" class="tc mt10 mb10">
        <div class="pagination"><?php echo $output['show_page'] ;?></div>
      </div>
      <?php }else{?>
      <div class="null"><?php echo $lang['store_sns_content_null'];?></div>
      <?php }?>
    </div>
    <!-- 表情弹出层 -->
    <div id="smilies_div" class="smilies-module"></div>
  </div>
  <div class="cms-sns-right">
    <div class="cms-sns-right-container">
      <div class="cms-store-pic"><a><img src="<?php echo getStoreLogo($output['store_info']['store_avatar']);?>" alt="<?php echo $output['store_info']['store_name'];?>" title="<?php echo $output['store_info']['store_name'];?>" /></a></div>
      <dl class="cms-store-info">
        <dt><?php echo $output['store_info']['store_name']; ?></dt>
        <dd>已收藏：<em nctype="store_collect"><?php echo $output['store_info']['store_collect']?></em></dd>
      </dl>
      <div class="cms-store-favorites"><a href="javascript:collect_store('<?php echo $output['store_info']['store_id'];?>','count','store_collect')" ><i class="icon-plus"></i>收藏店铺</a></div>
    </div>
    <div class="cms-sns-right-container">
      <?php if (!empty($output['favorites_list'])) {?>
      <div class="title">最新收藏用户</div>
      <div class="cms-favorites-user">
        <ul>
          <?php foreach ($output['favorites_list'] as $val) {?>
          <li><a target="_blank" href="<?php echo urlShop('member_snshome', 'index', array('mid'=>$val['member_id']));?>"><img alt="<?php echo $val['member_name'];?>" title="<?php echo $val['member_name'];?>" src="<?php echo getMemberAvatarForID($val['member_id']);?>" /></a></li>
          <?php }?>
        </ul>
      </div>
    </div>
    <?php }?>
  </div>
</div>
