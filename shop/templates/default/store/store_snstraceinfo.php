<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
<div class="mt20">
<ul class="fd-list">
  <?php if (!empty($output['strace_info'])){?>
  <li nc_type="stracerow_<?php echo $output['strace_info']['strace_id']; ?>">
  	<div class="fd-aside">
		<span class="thumb size60"><i></i>
			<a href="index.php?act=store_snshome&sid=<?php echo $output['strace_info']['strace_storeid'];?>" target="_blank">
				<img src="<?php echo getStoreLogo($output['strace_info']['strace_storelogo']);  ?>" onload="javascript:DrawImage(this,60,60);">
			</a>
		</span>
      </div>
    <dl class="fd-wrap">
      <dt>
        <h3><a href="index.php?act=store_snshome&sid=<?php echo $output['strace_info']['strace_storeid'];?>" target="_blank"><?php echo $output['strace_info']['strace_storename'];?></a><?php echo $lang['nc_colon'];?></h3>
        <h5><?php echo $output['strace_info']['strace_title'];?></h5>
  		<?php if ($_SESSION['store_id'] == $output['strace_info']['strace_storeid']){?>
        <span class="fd-handle">
        <p class="hover-arrow"><i></i><a href="javascript:void(0);" nc_type="sd_del" data-param='{"txtid":"<?php echo $output['strace_info']['strace_id'];?>","type":"href"}'><?php echo $lang['nc_delete'];?></a></p>
        </span>
        <?php }?>
        </dt>
      <dd>
        <?php echo parsesmiles($output['strace_info']['strace_content']);?>
      </dd>
	  <dd>
		<span class="goods-time fl"><?php echo date('Y-m-d H:i',$output['strace_info']['strace_time']);?></span>
		<span class="fr">
			<a href="javascript:void(0);" nc_type="sd_forwardbtn" data-param='{"txtid":"<?php echo $output['strace_info']['strace_id'];?>"}'><?php echo $lang['sns_forward']; ?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" nc_type="sd_commentbtn" data-param='{"txtid":"<?php echo $output['strace_info']['strace_id'];?>"}'><?php echo $lang['sns_comment']; ?><?php echo $output['strace_info']['strace_comment']>0?"(".$output['strace_info']['strace_comment'].")":'';?></a>
		</span>
	  </dd>
	  <dd>
		<!-- 评论模块start -->
		<div id="tracereply_<?php echo $output['strace_info']['strace_id'];?>" style="display:none;"></div>
		<!-- 评论模块end --> 
		<!-- 转发模块start -->
		<div id="forward_<?php echo $output['strace_info']['strace_id'];?>" style="display:none;">
			<div class="forward-widget">
				<div class="forward-edit">
					<form id="forwardform_<?php echo $output['strace_info']['strace_id'];?>" method="post" action="index.php?act=store_snshome&op=addforward">
						<input type="hidden" name="stid" value="<?php echo $output['strace_info']['strace_id'];?>"/>
						<div class="forward-add">
							<textarea resize="none" id="content_forward<?php echo $output['strace_info']['strace_id'];?>" name="forwardcontent"></textarea>
							<span class="error"></span> 
							<!-- 验证码 -->
							<div id="forwardseccode<?php echo $output['strace_info']['strace_id'];?>" class="seccode" style="display: none;">
								<label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon']; ?></label>
								<input name="captcha" class="text" type="text" size="4" maxlength="4"/>
								<img src="" title="<?php echo $lang['wrong_checkcode_change']; ?>" name="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/> <span><?php echo $lang['wrong_seccode'];?></span>
								<input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
							</div>
							<input type="text" style="display:none;" />
							<!-- 防止点击Enter键提交 -->
							<div class="act"> <span class="skin-blue"><span class="btn"><a href="javascript:void(0);" nc_type="s_forwardbtn" data-param='{"txtid":"<?php echo $output['strace_info']['strace_id'];?>"}'><?php echo $lang['sns_forward'];?></a></span></span> <span id="forwardcharcount<?php echo $output['strace_info']['strace_id'];?>" style="float:right;"></span> <a class="face" nc_type="smiliesbtn" data-param='{"txtid":"forward<?php echo $output['strace_info']['strace_id'];?>"}' href="javascript:void(0);" ><?php echo $lang['sns_smiles'];?></a> </div>
						</div>
					</form>
				</div>
				<ul class="forward-list"></ul>
			</div>
		</div>
		<!-- 转发模块end -->
		<div class="clear"></div>
	  </dd>
    </dl>
    <!-- 转发模块end -->
    <div id="smilies_div" class="smilies-module"></div>
  </li>
  <?php } else {?>
  <li>
    <div class="sns-norecord"><?php echo $lang['sns_trace_deleted'];?></div>
  </li>
  <?php } ?>
</ul>
</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script type="text/javascript">
$(function(){
    $("#tracereply_<?php echo $output['strace_info']['strace_id'];?>").load('index.php?act=store_snshome&op=commentlist&id=<?php echo $output['strace_info']['strace_id'];?>').show();
    $('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:'img',
		loadingMsg:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
		target:'#tracereply_<?php echo $output['strace_info']['strace_id'];?>'
	});
});
</script>