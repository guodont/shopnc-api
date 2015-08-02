<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" charset="utf-8"></script>
<div id="lazymodule">
  <?php if (count($output['tracelist'])>0){ ?>
  <ul class="fd-list">
    <?php foreach ((array)$output['tracelist'] as $k=>$v){?>
    <li nc_type="tracerow_<?php echo $v['trace_id']; ?>">
      <div class="fd-aside"><span class="thumb size60"><i></i> <a href="index.php?act=member_snshome&mid=<?php echo $v['trace_memberid'];?>" target="_blank"> <img src="<?php if ($v['trace_memberavatar']!='') { echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR.DS.$v['trace_memberavatar']; } else {  echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('default_user_portrait'); } ?>" data-param="{'id':<?php echo $v['trace_memberid'];?>}" nctype="mcard" onload="javascript:DrawImage(this,60,60);"> </a> </span> 
        <!--<p class="arrow"></p>--> 
      </div>
      <dl class="fd-wrap">
        <dt>
          <h3><a href="index.php?act=member_snshome&mid=<?php echo $v['trace_memberid'];?>" target="_blank" data-param="{'id':<?php echo $v['trace_memberid'];?>}" nctype="mcard"><?php echo $v['trace_membername'];?></a><?php echo $lang['nc_colon'];?></h3>
          <h5><?php echo parsesmiles($v['trace_title']);?></h5>
          <?php if ($_SESSION['member_id'] == $v['trace_memberid']){?>
          <span class="fd-handle">
          <p class="hover-arrow"><i></i><a href="javascript:void(0);" class="down-sub" nc_type="fd_del" data-param='{"txtid":"<?php echo $v['trace_id'];?>"}'><?php echo $lang['nc_delete'];?></a> </p>
          </span>
          <?php }?>
        </dt>
        <dd>
          <?php if($v['trace_content'] != ''){?>
          <?php if ($v['trace_originalid'] > 0 || $v['trace_from'] == '2'){//转帖内容?>
          <div class="fd-forward">
            <?php if ($v['trace_originalstate'] == 1){ echo $lang['sns_trace_originaldeleted'];}else{?>
            <?php echo parsesmiles($v['trace_content']);?>
            <?php if($v['trace_from'] == 1){?>
            <div class="stat"><span><?php echo $lang['sns_original_forward']; ?><?php echo $v['trace_orgcopycount']>0?"({$v['trace_orgcopycount']})":''; ?></span>&nbsp;&nbsp; <span><a href="index.php?act=member_snshome&op=traceinfo&mid=<?php echo $v['trace_originalmemberid'];?>&id=<?php echo $v['trace_originalid'];?>" target="_blank"><?php echo $lang['sns_original_comment']; ?><?php echo $v['trace_orgcommentcount']>0?"({$v['trace_orgcommentcount']})":''; ?></a></span> </div>
            <?php }?>
            <?php }?>
          </div>
          <?php } else {?>
          <?php echo parsesmiles($v['trace_content']);?>
          <?php }?>
          <?php }?>
        </dd>
        <dd>
          <span class="goods-time fl"><?php echo date('Y-m-d H:i',$v['trace_addtime']);?></span>
          <span class="fl ml10"><?php echo snsShareFrom($v['trace_from']); ?></span>
          <span class="fr"><a href="javascript:void(0);" nc_type="fd_forwardbtn" data-param='{"txtid":"<?php echo $v['trace_id'];?>"}'><?php echo $lang['sns_forward']; ?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" nc_type="fd_commentbtn" data-param='{"txtid":"<?php echo $v['trace_id'];?>","mid":"<?php echo $v['trace_memberid'];?>"}'><?php echo $lang['sns_comment']; ?><?php echo $v['trace_commentcount']>0?"({$v['trace_commentcount']})":'';?></a></span>
        </dd>
        <!-- 评论模块start -->
        <div id="tracereply_<?php echo $v['trace_id'];?>" style="display:none;"></div>
        <!-- 评论模块end --> 
        <!-- 转发模块start -->
        <div id="forward_<?php echo $v['trace_id'];?>" style="display:none;">
          <div class="forward-widget">
            <div class="forward-edit">
              <form id="forwardform_<?php echo $v['trace_id'];?>" method="post" action="index.php?act=member_snsindex&op=addforward&type=<?php echo $output['type'];?>&irefresh=1">
                <input type="hidden" name="originaltype" value="0"/>
                <input type="hidden" name="originalid" value="<?php echo $v['trace_id'];?>"/>
                <div class="forward-add">
                  <textarea resize="none" id="content_forward<?php echo $v['trace_id'];?>" name="forwardcontent"><?php echo $v['trace_title_forward'];?></textarea>
                  <span class="error"></span> 
                  <!-- 验证码 -->
                  <div id="forwardseccode<?php echo $v['trace_id'];?>" class="seccode">
                    <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon']; ?></label>
                    <input name="captcha" class="text" type="text" size="4" maxlength="4"/>
                    <img src="" title="<?php echo $lang['wrong_checkcode_change']; ?>" name="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/> <span><?php echo $lang['wrong_seccode'];?></span>
                    <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
                  </div>
                  <input type="text" style="display:none;" />
                  <!-- 防止点击Enter键提交 -->
                  <div class="act"> <span class="skin-blue"><span class="btn"><a href="javascript:void(0);" nc_type="forwardbtn" data-param='{"txtid":"<?php echo $v['trace_id'];?>"}'><?php echo $lang['sns_forward'];?></a></span></span> <span id="forwardcharcount<?php echo $v['trace_id'];?>" style="float:right;"></span> <a class="face" nc_type="smiliesbtn" data-param='{"txtid":"forward<?php echo $v['trace_id'];?>"}' href="javascript:void(0);" ><?php echo $lang['sns_smiles'];?></a> </div>
                </div>
              </form>
            </div>
            <ul class="forward-list">
            </ul>
          </div>
        </div>
        <!-- 转发模块end -->
        <div class="clear"></div>
      </dl>
    </li>
    <?php }?>
  </ul>
  <?php if ($output['hasmore']){?>
  <div id="lazymore"></div>
  <?php }else {?>
  <div id="pagehtml">
    <div class="pagination"><?php echo $output['show_page'] ;?></div>
  </div>
  <?php }?>
  <?php } else {?>
  <?php if ($output['relation'] == 3){?>
  <div class="sns-norecord"><?php echo $lang['sns_trace_nohave_self'];?></div>
  <?php } else { ?>
  <div class="sns-norecord"><?php echo $lang['sns_trace_nohave_1'];?><br>
    <a href="index.php?act=member_snsfriend&op=follow"><?php echo $lang['sns_trace_nohave_2'];?></a></div>
  <?php }?>
  <?php }?>
</div>