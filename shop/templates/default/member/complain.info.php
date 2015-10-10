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
        <h3><?php echo $lang['complain_message'];?></h3>
        <dl>
          <dt><?php echo $lang['complain_accused'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['complain_info']['accused_name'];?></dd>
          <dt><?php echo $lang['complain_subject_content'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['complain_info']['complain_subject_content'];?></dd>
          <dt><?php echo $lang['complain_datetime'].$lang['nc_colon'];?></dt>
          <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['complain_datetime']);?></dd>
          <dt><?php echo $lang['complain_content'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['complain_info']['complain_content'];?></dd>
          <dt><?php echo $lang['complain_evidence'].$lang['nc_colon'];?></dt>
          <dd>
            <?php if (is_array($output['complain_pic']) && !empty($output['complain_pic'])) { ?>
            <ul class="ncm-evidence-pic">
              <?php foreach ($output['complain_pic'] as $key => $val) { ?>
              <?php if(!empty($val)){ ?>
              <li><a href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/complain/'.$val;?>" nctype="nyroModal" rel="gal">
                <img class="show_image" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/complain/'.$val;?>"></a></li>
              <?php } ?>
              <?php } ?>
            </ul>
            <?php } else { ?>
            <?php echo $lang['complain_pic_none'];?>
                <?php if((intval($output['complain_info']['complain_state']) < 99)) { ?>
                    <a class="ncm-btn-mini ncm-btn-orange" href="javascript:void(0);" onclick="$('#post_add_pic_form').toggle();" title="<?php echo $lang['complain_add_pic'];?>"><i class="icon-cloud-upload "></i><?php echo $lang['complain_add_pic'];?></a>
                    <form style="display: none;" id="post_add_pic_form" method="post" action="index.php?act=member_complain&op=complain_add_pic&complain_id=<?php echo $output['complain_info']['complain_id']; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="form_submit" value="ok" />
                    <p>
                      <input name="input_complain_pic1" type="file" />
                    </p>
                    <p>
                      <input name="input_complain_pic2" type="file" />
                    </p>
                    <p>
                      <input name="input_complain_pic3" type="file" />
                    </p>
                    <p>
                      <label class="submit-border"><input id="add_pic_submit_button" type="button" class="submit" value="<?php echo $lang['complain_text_submit'];?>" ></label>
                    </p>
                    </form>
                <?php } ?>
            <?php } ?>
          </dd>
          </dd>
        </dl>
        <?php if ($output['complain_info']['complain_state'] >= 30) { ?>
        <?php if ($output['complain_info']['appeal_datetime'] > 0) { ?>
            <h3><?php echo $lang['complain_appeal_message'];?></h3>
            <dl>
              <dt><?php echo $lang['complain_appeal_datetime'].$lang['nc_colon'];?></dt>
              <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['appeal_datetime']);?></dd>
              <dt><?php echo $lang['complain_appeal_content'].$lang['nc_colon'];?></dt>
              <dd><?php echo $output['complain_info']['appeal_message'];?></dd>
              <dt><?php echo $lang['complain_appeal_evidence'].$lang['nc_colon'];?></dt>
              <dd>
                <?php if (is_array($output['appeal_pic']) && !empty($output['appeal_pic'])) { ?>
                <ul class="ncm-evidence-pic">
                  <?php foreach ($output['appeal_pic'] as $key => $val) { ?>
                  <?php if(!empty($val)){ ?>
                  <li><a href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/complain/'.$val;?>" nctype="nyroModal" rel="gal">
                    <img class="show_image" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/complain/'.$val;?>"></a></li>
                  <?php } ?>
                  <?php } ?>
                </ul>
                <?php } else { ?>
                <?php echo $lang['complain_pic_none'];?>
                <?php } ?>
              </dd>
            </dl>
        <?php } ?>
        <?php include template('member/complain_talk.info');?>
        <?php } ?>
        <?php if ($output['complain_info']['complain_state'] == 99) { ?>
        <h3><?php echo $lang['final_handle_message'];?></h3>
        <dl>
          <dt><?php echo '处理意见'.$lang['nc_colon'];?></dt>
          <dd><?php echo $output['complain_info']['final_handle_message'];?></dd>
          <dt><?php echo $lang['final_handle_datetime'].$lang['nc_colon'];?></dt>
          <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['final_handle_datetime']);?></dd>
        </dl>
        <?php } ?>
        <div class="bottom"><a href="javascript:history.go(-1);" class="ncm-btn"><i class="icon-reply"></i>返回列表</a></div>
    </div>
  </div>
  <?php include template('member/complain_order.info');?>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" ></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
$(document).ready(function(){
   $('a[nctype="nyroModal"]').nyroModal();
    var state = <?php echo empty($output['complain_info']['complain_state'])?0:$output['complain_info']['complain_state'];?>;
    if(state == 20 ){
        $("#state_appeal").addClass('current');
    }
    if(state == 30 ){
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
    }
    if(state == 40 ){
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
        $("#state_handle").addClass('current');
    }
    if(state == 99 ){
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
        $("#state_handle").addClass('current');
        $("#state_finish").addClass('current');
    }
    $("#add_pic_submit_button").click(function(){
    	if($("#post_add_pic_form").valid()){
    		ajaxpost('post_add_pic_form', '', '', 'onerror');
        }
    });
    $('#post_add_pic_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
            rules : {
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