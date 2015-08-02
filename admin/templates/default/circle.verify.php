<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_manage&op=circle_list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="javascript:void(0);" class="current"><span><?php echo $lang['circle_wait_verify'];?></span></a></li>
        <li><a href="index.php?act=circle_manage&op=circle_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
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
        <td>
        <ul>
            <li><?php echo $lang['circle_verify_prompts_one'];?></li>
            <li><?php echo $lang['circle_verify_prompts_two'];?></li>
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
          <th><?php echo $lang['circle_setting_name'];?></th>
          <th><?php echo $lang['circle_master_name'];?></th>
          <th><?php echo $lang['nc_add_time'];?></th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
          <th class="align-center"><?php echo $lang['circle_verify_pass'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['circle_list']) && is_array($output['circle_list'])){ ?>
        <?php foreach($output['circle_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="check_circleid[]" value="<?php echo $v['circle_id'];?>" class="checkitem"></td>
          <td class="w50pre name"><span title="<?php echo $lang['nc_editable'];?>" required="1" ajax_branch="name" fieldid="<?php echo $v['circle_id'];?>" fieldname="circle_name" nc_type="inline_edit" class="editable "><?php echo $v['circle_name'];?></span></td>
          <td><?php echo $v['circle_mastername'];?></td>
          <td><?php echo date('Y-m-d', $v['circle_addtime']);?></td>
          <td class="align-center yes-onoff"><?php if($v['is_recommend'] == 0){ ?>
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['circle_id'];?>" ajax_branch="recommend" fieldname="is_recommend" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" fieldvalue="1" fieldid="<?php echo $v['circle_id'];?>" ajax_branch="recommend" fieldname="is_recommend" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center yes-onoff">
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['circle_id'];?>" ajax_branch="status" fieldname="circle_status" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
          </td>
          <td class="w72"><a href="index.php?act=circle_manage&op=circle_edit&c_id=<?php echo $v['circle_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=circle_manage&op=circle_del&c_id=<?php echo $v['circle_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['circle_list']) && is_array($output['circle_list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="$('#submit_type').val('pass');$('form:first').submit();"><span><?php echo $lang['nc_pass'];?></span></a>
            <a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#submit_type').val('batchdel');$('form:first').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>  
