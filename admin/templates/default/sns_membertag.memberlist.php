<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['sns_member_tag'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=sns_member"><span><?php echo $lang['sns_member_tag_manage'];?></span></a></li>
        <li><a href="index.php?act=sns_member&op=tag_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="javascript:void(0);" class="current"><span><?php echo $lang['sns_member_member_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['sns_member_member_list_tips'];?></li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post'>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['sns_member_member_name'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
          <th class="w120 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <?php if(!empty($output['tagmember_list']) && is_array($output['tagmember_list'])){ ?>
      <?php foreach($output['tagmember_list'] as $v){ ?>
      <tbody>
        <tr class="hover edit">
          <td class="w48"><input type="checkbox" name="id[]" value="<?php echo $v['mtag_id'];?>" class="checkitem"></td>
          <td class="w48 picture"><div class="size-44x44"><span class="thumb size-44x44"><i></i><img src="<?php if ($v['member_avatar'] != ''){ echo UPLOAD_SITE_URL.DS.ATTACH_AVATAR.DS.$v['member_avatar'];}else { echo ADMIN_TEMPLATES_URL.'/images/default_user_portrait.gif';}?>"  onload="javascript:DrawImage(this,44,44);"/></span></div></td>
          <td class="w50pre name">
            <span><strong><?php echo $v['member_name'];?></strong></span>
          </td>
          <td class="align-center power-onoff">
            <a href="JavaScript:void(0);" class=" <?php if($v['recommend'] == 0){ ?>disabled<?php }else{ ?>enabled<?php }?>" fieldvalue="<?php echo $v['recommend'];?>" fieldid="<?php echo $v['mtag_id'].','.$v['member_id'];?>" ajax_branch="mtagmember_recommend" fieldname="recommend" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
          </td>
          <td class="w120 align-center">
          	<a href="index.php?act=sns_member&op=mtag_del&id=<?php echo $v['mtag_id'];?>&mid=<?php echo $v['member_id'];?>"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#submit_type').val('del');$('form:first').submit();}"><span><?php echo $lang['nc_del'];?></span></a> 
            <div class="pagination"> <?php echo $output['showpage'];?> </div></td>
        </tr>
      </tfoot>
      <?php }else { ?>
      <tbody>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 