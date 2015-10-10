<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="add-group">
  <dl class="top-box">
    <dt>
      <h3><?php echo $lang['circle_create_a_group'];?><i><?php echo $lang['circle_first_from'];?> <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=search&op=group"><?php echo $lang['nc_find_fascinating'];?></a> <?php echo $lang['circle_find_like_group'];?></i></h3>
      <p><?php echo $lang['nc_welcome_at'].C('circle_name').$lang['nc_welcome_words'];?></p>
    </dt>
    <dd><span><?php echo $lang['circle_allow_create_group_count'].$lang['nc_colon'];?><em><?php echo C('circle_createsum');?></em></span><span><?php echo $lang['circle_yet_create_group_count'].$lang['nc_colon'];?><em><?php echo $output['create_count'];?></em></span></dd>
    <dd><span><?php echo $lang['circle_allow_join_group_count'].$lang['nc_colon'];?><em><?php echo C('circle_joinsum');?></em></span><span><?php echo $lang['circle_yet_join_group_count'].$lang['nc_colon'];?><em><?php echo $output['join_count'];?></em></span></dd>
  </dl>
  <div class="base-form-style">
    <form method="post" id="groupadd_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=index&op=add_group">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt class=""><em></em><?php echo $lang['circle_belong_to_class'].$lang['nc_colon'];?></dt>
        <dd class="group-classes">
          <?php if(!empty($output['class_list'])){?>
          <ul>
            <?php foreach($output['class_list'] as $val){?>
            <li class="fl mr20 mb5">
              <input type="radio" name="class_id" value="<?php echo $val['class_id'];?>" />
              <h5><?php echo $val['class_name'];?></h5></li>
            <?php }?>
          </ul>
          <?php }?>
          <p class="field_notice"></p>
          <div class="hint"><?php echo $lang['circle_belong_to_class_tips'];?></div>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em></em><?php echo $lang['circle_name'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" name="c_name" id="c_name" class="text w400" value="<?php echo $_GET['kw'];?>" />
          </p>
          <p class="field_notice"></p>
          <div class="hint"><?php echo $lang['circle_name_tips'];?></div>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['circle_introduction'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <textarea name="c_desc" id="c_desc" class="textarea w400 h100"></textarea>
            <span class="count" id="desccharcount"></span>
          </p>
          <p class="field_notice"></p>
          <div class="hint"><?php echo $lang['circle_introduction_tips'];?></div>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['circle_tag'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" name="c_tag" class="text w400" />
          </p>
          <p class="field_notice"></p>
          <div class="hint"><?php echo $lang['circle_tag_tips'];?></div>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['circle_apply_reason'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <textarea name="c_pursuereason" id="c_pursuereason" class="textarea w400 h100"></textarea>
            <span class="count" id="pursuereasoncharcount"></span>
          </p>
          <p class="field_notice"></p>
          <div class="hint"><?php echo $lang['circle_apply_reason_tips'];?></div>
        </dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd>
          <input type="checkbox" checked="checked" />
          <?php echo $lang['circle_my_read_carefully_agree'];?><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=document&code=create_circle"><?php echo $lang['circle_notice_for_use']?></a><?php echo $lang['circle_all_terms'];?></dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd><a class="submit-btn" nctype="submit-btn" href="Javascript: void(0)"><?php echo $lang['circle_submit_applications'];?></a></dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script type="text/javascript">
$(function(){
	$('a[nctype="submit-btn"]').click(function(){
		$('#groupadd_form').submit();
	});
    $('#groupadd_form').validate({
        errorPlacement: function(error, element){
            $(element).parents('dd:first').children('.field_notice').html(error);
        },
    	submitHandler:function(form){
    		ajaxpost('groupadd_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=index&op=add_group', '', 'onerror');
    	},
        rules : {
        	c_name : {
                required : true,
                minlength : 4,
            	maxlength : 12,
            	remote : {
            		url : 'index.php?act=index&op=check_circle_name',
                    type: 'get',
                    data:{
                    	name : function(){
                            return $('#c_name').val();
                        }
                    }
            	}
            },
            c_desc : {
            	maxlength : 255
            },
            c_tag : {
                maxlength : 60
            },
            c_pursuereason : {
                maxlength : 255
            }
        },
        messages : {
        	c_name : {
                required : '<?php echo $lang['circle_tclass_name_not_null'];?>',
                minlength : '<?php echo $lang['circle_name_4_to_12_length'];?>',
            	maxlength : '<?php echo $lang['circle_name_4_to_12_length'];?>',
            	remote : '<?php echo $lang['circle_name_already_exists'];?>'
            },
            c_desc  : {
            	maxlength : '<?php echo $lang['circle_255_maxlength'];?>'
            },
            c_tag : {
                maxlength : '<?php echo $lang['circle_tag_maxlength'];?>'
            },
            c_pursuereason : {
                maxlength : '<?php echo $lang['circle_255_maxlength'];?>'
            }
        }
    });
    //字符个数动态计算
    $("#c_desc").charCount({
		allowed: 255,
		warning: 10,
		counterContainerID:'desccharcount',
		firstCounterText:'<?php echo $lang['charCount_firsttext'];?>',
		endCounterText:'<?php echo $lang['charCount_endtext'];?>',
		errorCounterText:'<?php echo $lang['charCount_errortext'];?>'
	});
    //字符个数动态计算
    $("#c_pursuereason").charCount({
		allowed: 255,
		warning: 10,
		counterContainerID:'pursuereasoncharcount',
		firstCounterText:'<?php echo $lang['charCount_firsttext'];?>',
		endCounterText:'<?php echo $lang['charCount_endtext'];?>',
		errorCounterText:'<?php echo $lang['charCount_errortext'];?>'
	});
});
</script> 