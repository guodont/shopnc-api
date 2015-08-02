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

<h3><?php echo $lang['complain_appeal_detail'];?></h3>
<div class="ncsc-form-default">
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
    </div>
  </form>
</div>
