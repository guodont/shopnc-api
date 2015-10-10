<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['sns_member_tag'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['sns_member_tag_manage'];?></span></a></li>
        <li><a href="index.php?act=sns_member&op=tag_add"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['sns_member_index_tips_1'];?></li>
            <li><?php echo $lang['sns_member_index_tips_2'];?></li>
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
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['sns_member_tag_name'];?></th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
          <th class="w132 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <?php if(!empty($output['tag_list']) && is_array($output['tag_list'])){ ?>
      <?php foreach($output['tag_list'] as $v){ ?>
      <tbody>
        <tr class="hover edit">
          <td class="w48"><input type="checkbox" name="id[]" value="<?php echo $v['mtag_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span title="<?php echo $lang['nc_editable'];?>" ajax_branch="membertag_sort" datatype="number" fieldid="<?php echo $v['mtag_id'];?>" fieldname="mtag_sort" nc_type="inline_edit" class="editable "><?php echo $v['mtag_sort'];?></span></td>
          <td class="w50pre name"><span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['mtag_id'];?>" ajax_branch="membertag_name" fieldname="mtag_name" nc_type="inline_edit" class="editable "><?php echo $v['mtag_name'];?></span></td>
          <td class="align-center yes-onoff"><?php if($v['mtag_recommend'] == 0){ ?>
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['mtag_id'];?>" ajax_branch="membertag_recommend" fieldname="mtag_recommend" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" fieldvalue="1" fieldid="<?php echo $v['mtag_id'];?>" ajax_branch="membertag_recommend" fieldname="mtag_recommend" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="w132 align-center"><a href="index.php?act=sns_member&op=tag_edit&id=<?php echo $v['mtag_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="index.php?act=sns_member&op=tag_del&id=<?php echo $v['mtag_id'];?>"><?php echo $lang['nc_del'];?></a> | <a href="index.php?act=sns_member&op=tag_member&id=<?php echo $v['mtag_id'];?>"><?php echo $lang['sns_member_view_member'];?></a></td>
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.goods_class.js" charset="utf-8"></script> 
