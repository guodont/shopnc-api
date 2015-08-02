<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="alert alert-block mt10">
    <h4>操作提示：</h4>
    <ul>
      <li>1、<?php echo $lang['store_sns_setting_tips_1'];?></li>
      <li>2、<?php echo $lang['store_sns_setting_tips_2'];?></li>
    </ul>
  </div>
  <form method="post" id="form_snssetting" action="index.php?act=store_sns&op=setting">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="ncsc-default-table">
      <thead>
        <tr>
          <th class="w100"><?php echo $lang['store_sns_auto'];?></th>
          <th class="w400"><?php echo $lang['store_sns_name'];?><?php echo $lang['store_sns_cotent'];?></th>
          <th>系统默认动态</th>
        </tr>
      </thead>
      <tbody>
        <tr class="bd-line">
          <td><input type="checkbox" name="new" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_new'] == 1){?>checked="checked"<?php }?> value="1" /></td>
          <td class="tl">
          <strong><?php echo $lang['store_sns_new_selease'];?></strong>
          <textarea nctype="charcount" class="textarea w400" name="new_title" rows="2" id="new_title"><?php echo $output['sauto_info']['sauto_newtitle'];?></textarea>
            <div id="charcount_new_title" class="tr w400"></div></td>
          <td><p><?php echo $lang['nc_store_auto_share_new1'];?></p>
            <p><?php echo $lang['nc_store_auto_share_new2'];?></p>
            <p><?php echo $lang['nc_store_auto_share_new3'];?></p>
            <p><?php echo $lang['nc_store_auto_share_new4'];?></p>
            <p><?php echo $lang['nc_store_auto_share_new5'];?></p></td>
        </tr>
       
        <tr class="bd-line">
          <td><input type="checkbox" name="xianshi" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_xianshi'] == 1){?>checked="checked"<?php }?> value="1" /></td>
          <td class="tl"><strong><?php echo $lang['store_sns_xianshi'];?></strong><textarea nctype="charcount" class="w400" name="xianshi_title" rows="2" id="xianshi_title"><?php echo $output['sauto_info']['sauto_xianshititle'];?></textarea>
            <div id="charcount_xianshi_title" class="tr w400"></div></td>
          <td><p><?php echo $lang['nc_store_auto_share_xianshi1'];?></p>
            <p><?php echo $lang['nc_store_auto_share_xianshi2'];?></p>
            <p><?php echo $lang['nc_store_auto_share_xianshi3'];?></p>
            <p><?php echo $lang['nc_store_auto_share_xianshi4'];?></p>
            <p><?php echo $lang['nc_store_auto_share_xianshi5'];?></p></td>
        </tr>
        <tr class="bd-line">
          <td><input type="checkbox" name="mansong" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_mansong'] == 1){?>checked="checked"<?php }?> value="1" /></td>
          <td class="tl"><strong><?php echo $lang['store_sns_mansong'];?></strong><textarea nctype="charcount" class="w400" name="mansong_title" rows="2" id="mansong_title"><?php echo $output['sauto_info']['sauto_mansongtitle'];?></textarea>
            <div id="charcount_mansong_title" class="tr w400"></div></td>
          <td><p><?php echo $lang['nc_store_auto_share_mansong1'];?></p>
            <p><?php echo $lang['nc_store_auto_share_mansong2'];?></p>
            <p><?php echo $lang['nc_store_auto_share_mansong3'];?></p>
            <p><?php echo $lang['nc_store_auto_share_mansong4'];?></p>
            <p><?php echo $lang['nc_store_auto_share_mansong5'];?></p></td>
        </tr>
        <tr class="bd-line">
          <td><input type="checkbox" name="bundling" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_bundling'] == 1){?>checked="checked"<?php }?> value="1" /></td>
          <td class="tl"><strong><?php echo $lang['store_sns_bundling'];?></strong><textarea nctype="charcount" class="w400" name="bundling_title" rows="2" id="bundling_title"><?php echo $output['sauto_info']['sauto_bundlingtitle'];?></textarea>
            <div id="charcount_bundling_title" class="tr w400"></div></td>
          <td><p><?php echo $lang['nc_store_auto_share_bundling1'];?></p>
            <p><?php echo $lang['nc_store_auto_share_bundling2'];?></p>
            <p><?php echo $lang['nc_store_auto_share_bundling3'];?></p>
            <p><?php echo $lang['nc_store_auto_share_bundling4'];?></p>
            <p><?php echo $lang['nc_store_auto_share_bundling5'];?></p></td>
        </tr>
        <tr class="bd-line">
          <td><input type="checkbox" name="groupbuy" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_groupbuy'] == 1){?>checked="checked"<?php }?> value="1" /></td>
          <td class="tl"><strong><?php echo $lang['store_sns_gronpbuy'];?></strong><textarea nctype="charcount" class="w400" name="groupbuy_title" rows="2" id="groupbuy_title"><?php echo $output['sauto_info']['sauto_bundlingtitle'];?></textarea>
            <div id="charcount_groupbuy_title" class="tr w400"></div></td>
          <td><p><?php echo $lang['nc_store_auto_share_groupbuy1'];?></p>
            <p><?php echo $lang['nc_store_auto_share_groupbuy2'];?></p>
            <p><?php echo $lang['nc_store_auto_share_groupbuy3'];?></p>
            <p><?php echo $lang['nc_store_auto_share_groupbuy4'];?></p>
            <p><?php echo $lang['nc_store_auto_share_groupbuy5'];?></p></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20" class="bottom"><input type="submit" value="<?php echo $lang['nc_common_button_save'];?>" class="submit mt10 mb5" style="display: inline-block;"></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript">
$(function(){
	$('#form_snssetting').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('form_snssetting', '', '', 'onerror');
		},
		rules : {
			new_title : {
				maxlength : 140
			},
			coupon_title : {
				maxlength : 140
			},
			xianshi_title : {
				maxlength : 140
			},
			mansong_title : {
				maxlength : 140
			},
			bundling_title : {
				maxlength : 140
			},
			groupbuy_title : {
				maxlength : 140
			}
		},
		messages : {
			new_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			coupon_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			voucher_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			mansong_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			bundling_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			groupbuy_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			}
		}
	});

	//评论字符个数动态计算
	$('*[nctype="charcount"]').each(function(){
		$(this).charCount({
			allowed: 140,
			warning: 10,
			counterContainerID:'charcount_'+$(this).attr('id'),
			firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
			endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
			errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
		});
	});
});
</script>