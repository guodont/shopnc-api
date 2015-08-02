<?php defined('InShopNC') or exit('Access Invalid!');?>

  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncsc-form-default">
    <form method="post" action="index.php?act=store_deliver_set&op=print_set" enctype="multipart/form-data" id="my_store_form">
      <input type="hidden" name="form_submit" value="ok" />
      <dl class="setup">
        <dt><?php echo $lang['store_printsetup_desc'].$lang['nc_colon'];?></dt>
        <dd><textarea name="store_printdesc" cols="150" rows="3" class="textarea w400" id="store_printdesc"><?php echo $output['store_info']['store_printdesc'];?></textarea>
          <p class="hint"><?php echo $lang['store_printsetup_tip1'];?></p>
        </dd>
      </dl>
      <dl class="setup">
        <dt><?php echo $lang['store_printsetup_stampimg'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="hidden" name="store_stamp_old" value="<?php echo $output['store_info']['store_stamp'];?>" />
          <div class="ncsc-upload-thumb watermark-pic">
          	<p>
          	<img src="<?php if(!empty($output['store_info']['store_stamp'])){echo UPLOAD_SITE_URL.'/'.ATTACH_STORE.'/'.$output['store_info']['store_stamp'];}?>" nc_type="store_stamp" /></p> </div>
          <p>
            <input name="store_stamp" type="file"  hidefocus="true" nc_type="change_store_stamp"/>
          </p>
          <p class="hint"><?php echo $lang['store_printsetup_tip2'];?>
          </p>
        </dd>
      </dl>
      <div class="bottom">
          <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" /></label>
       </div>
    </form>
  </div>

<script type="text/javascript">
$(function(){
	$('input[nc_type="change_store_stamp"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="store_stamp"]').attr('src', src);
	});
	$('#my_store_form').validate({
    	submitHandler:function(form){
    		ajaxpost('my_store_form', '', '', 'onerror')
    	},
		rules : {
    		store_printdesc: {
    			required: true,
    			rangelength:[0,100]
    	    },
        },
        messages : {
        	store_printdesc: {
        		required: '<i class="icon-exclamation-sign"></i><?php echo $lang['store_printsetup_desc_error'];?>',
		        rangelength:'<?php echo $lang['store_printsetup_desc_error'];?>'
		    }
        }
    });
});
</script>