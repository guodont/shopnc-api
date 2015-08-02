<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-flow-layout" id="ncscComplainFlow">
  <div class="ncsc-flow-container">
    <div class="title">
      <h3>交易投诉申诉</h3>
    </div>
    <div class="ncsc-flow-step">
      <dl id="state_new" class="step-first current">
        <dt><?php echo $lang['complain_state_new'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_appeal" class="">
        <dt><?php echo $lang['complain_state_appeal'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_talk" class="">
        <dt><?php echo $lang['complain_state_talk'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_handle" class="">
        <dt><?php echo $lang['complain_state_handle'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_finish" class="">
        <dt><?php echo $lang['complain_state_finish'];?></dt>
      </dl>
    </div>
    <div class="ncsc-form-default">
      <h3><?php echo $lang['complain_message'];?></h3>
      <dl>
        <dt><?php echo $lang['complain_state'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['complain_info']['complain_state_text'];?></dd>
        <dt><?php echo $lang['complain_subject_content'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['complain_info']['complain_subject_content'];?></dd>
        <dt><?php echo $lang['complain_evidence'].$lang['nc_colon'];?></dt>
        <dd>
          <?php
                        if(empty($output['complain_info']['complain_pic1'])&&empty($output['complain_info']['complain_pic2'])&&empty($output['complain_info']['complain_pic3'])) {
                            echo $lang['complain_pic_none'];
                        }
                        else {
                            $pic_link = SHOP_SITE_URL.'/index.php?act=show_pics&type=complain&pics=';
                            if(!empty($output['complain_info']['complain_pic1'])) {
                                $pic_link .= $output['complain_info']['complain_pic1'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic2'])) {
                                $pic_link .= $output['complain_info']['complain_pic2'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic3'])) {
                                $pic_link .= $output['complain_info']['complain_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|');
                    ?>
          <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['complain_pic_view'];?></a>
          <?php } ?>
        </dd>
        <dt><?php echo $lang['complain_datetime'].$lang['nc_colon'];?></dt>
        <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['complain_datetime']);?></dd>
        <dt><?php echo $lang['complain_content'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['complain_info']['complain_content'];?></dd>
      </dl>
      <h3><?php echo $lang['complain_appeal_detail'];?></h3>
      <form action="index.php?act=store_complain&op=appeal_save" method="post" id="add_form" enctype="multipart/form-data">
        <input name="input_complain_id" type="hidden" value="<?php echo $output['complain_info']['complain_id'];?>" />
        <dl>
          <dt><?php echo $lang['complain_appeal_content'].$lang['nc_colon'];?></dt>
          <dd>
            <textarea class="w600" name="input_appeal_message" rows="3"></textarea>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['complain_appeal_evidence_upload'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input name="input_appeal_pic1" type="file" />
            </p>
            <p>
              <input name="input_appeal_pic2" type="file" />
            </p>
            <p>
              <input name="input_appeal_pic3" type="file" />
            </p>
          </dd>
        </dl>
        <div class="bottom">
          <label class="submit-border">
            <input id="submit_button" type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>">
          </label>
          <label class=""><a href="javascript:history.go(-1);" class="ncsc-btn ml10"><i class="icon-reply"></i>返回列表</a></label>
        </div>
      </form>
    </div>
  </div>
  <?php include template('seller/complain_order.info');?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var state = <?php echo empty($output['complain_info']['complain_state'])?0:$output['complain_info']['complain_state'];?>;
    if(state <= 10) {
        $("#state_new").addClass('current');
    }
    if(state == 20 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
    }
    if(state == 30 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
    }
    if(state == 40 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
        $("#state_handle").addClass('current');
    }
    if(state == 99 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
        $("#state_handle").addClass('current');
        $("#state_finish").addClass('current');
    }
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
		submitHandler:function(form){
			ajaxpost('add_form', '', '', 'onerror');
		},
            rules : {
                input_appeal_message : {
                    required : true,
                    maxlength: 100
                },
                input_appeal_pic1 : {
                    accept : 'jpg|jpeg|gif|png'
                },
                input_appeal_pic2 : {
                    accept : 'jpg|jpeg|gif|png'
                },
                input_appeal_pic3 : {
                    accept : 'jpg|jpeg|gif|png'
                }
            },
                messages : {
                    input_appeal_message : {
                        required : '<?php echo $lang['appeal_message_error'];?>',
                        maxlength : '<?php echo $lang['appeal_message_error'];?>'
                    },
                    input_appeal_pic1: {
                        accept : '<?php echo $lang['complain_pic_error'];?>'
                    },
                    input_appeal_pic2: {
                        accept : '<?php echo $lang['complain_pic_error'];?>'
                    },
                    input_appeal_pic3: {
                        accept : '<?php echo $lang['complain_pic_error'];?>'
                    }
                }
    });

});
</script>