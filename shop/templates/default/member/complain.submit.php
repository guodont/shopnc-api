<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout" id="ncmComplainFlow">
  <div class="ncm-flow-container">
    <div class="title">
      <h3>交易投诉申请</h3>
    </div>
    <div class="ncm-flow-step">
      <dl id="state_new" class="step-first current">
        <dt><?php echo $lang['complain_state_new'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_appeal" class="">
        <dt><?php echo $lang['complain_state_appeal'];?></dt>
        <dd class="bg"> </dd>
      </dl>
      <dl id="state_talk" class="">
        <dt><?php echo $lang['complain_state_talk'];?></dt>
        <dd class="bg"> </dd>
      </dl>
      <dl id="state_handle" class="">
        <dt><?php echo $lang['complain_state_handle'];?></dt>
        <dd class="bg"> </dd>
      </dl>
      <dl id="state_finish" class="">
        <dt><?php echo $lang['complain_state_finish'];?></dt>
        <dd class="bg"> </dd>
      </dl>
    </div>
    <div class="ncm-default-form">
      <form action="index.php?act=member_complain&op=complain_save" method="post" id="add_form" enctype="multipart/form-data">
        <input name="input_order_id" type="hidden" value="<?php echo $output['order']['order_id'];?>" />
        <input name="input_goods_id" type="hidden" value="<?php echo $output['goods_id'];?>" />
        <dl>
          <dt><?php echo $lang['complain_subject_select'].$lang['nc_colon'];?></dt>
          <dd>
            <?php if (is_array($output['subject_list']) && !empty($output['subject_list'])) { ?>
            <?php foreach($output['subject_list'] as $subject) {?>
              <input name="input_complain_subject" type="radio" value="<?php echo $subject['complain_subject_id'].','.$subject['complain_subject_content']?>" />
              <span class="mr30"><strong><?php echo $subject['complain_subject_content']?></strong></span><p class="hint"><?php echo $subject['complain_subject_desc'];?> </p>
            <?php } ?>
            <?php } ?>
          </dd>
        </dl>
        <dl>
        </dl>
        <dl>
          <dt><?php echo $lang['complain_content'].$lang['nc_colon'];?></dt>
          <dd>
            <textarea name="input_complain_content" rows="3" class="textarea w400" id="input_complain_content"></textarea>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['complain_evidence_upload'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input name="input_complain_pic1" type="file" />
            </p>
            <p>
              <input name="input_complain_pic2" type="file" />
            </p>
            <p>
              <input name="input_complain_pic3" type="file" />
            </p>
            <span class="error">(<?php echo $lang['complain_pic_error'];?>) </dd>
        </dl>
        <div class="bottom">
          <label class="submit-border"><input id="submit_button" type="button" class="submit" value="<?php echo $lang['complain_text_submit'];?>" ></label>
                <a href="javascript:history.go(-1);" class="ncm-btn ml10">取消并返回</a>
        </div>
      </form>
    </div>
  </div>
  <?php include template('member/complain_order.info');?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //默认选中第一个radio
    $(":radio").first().attr("checked",true);
    //提交表单
    $("#submit_button").click(function(){
    	if($("#add_form").valid()){
    		ajaxpost('add_form', '', '', 'onerror');
        }
    });
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
            rules : {
                input_complain_content : {
                    required   : true
                },
                input_complain_pic1 : {
                    accept : 'jpg|jpeg|gif|png'
                },
                input_complain_pic2 : {
                    accept : 'jpg|jpeg|gif|png'
                },
                input_complain_pic3 : {
                    accept : 'jpg|jpeg|gif|png'
                }
            },
                messages : {
                    input_complain_content  : {
                        required   : '请填写投诉内容'
                    },
                    input_complain_pic1: {
                        accept : '<?php echo $lang['complain_pic_error'];?>'
                    },
                    input_complain_pic2: {
                        accept : '<?php echo $lang['complain_pic_error'];?>'
                    },
                    input_complain_pic3: {
                        accept : '<?php echo $lang['complain_pic_error'];?>'
                    }
                }
    });
});
</script>