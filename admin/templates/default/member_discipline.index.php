<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>学科门类</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
        <li><a href="index.php?act=member_discipline&op=member_discipline_add" ><span>新增</span></a></li>
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
            <li>点击学科名前“+”符号，显示当前学科门类的下级学科</li>
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
          <th>学科名称</th>
          <th class="align-center"><?php echo $lang['nc_display'];?></th>
          <th><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['discipline_list']) && is_array($output['discipline_list'])){ ?>
        <?php foreach($output['discipline_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w36"><input type="checkbox" name="check_discipline_id[]" value="<?php echo $v['discipline_id'];?>" class="checkitem">
            <?php if($v['have_child'] == '1'){ ?>
            <img fieldid="<?php echo $v['discipline_id'];?>" status="open" nc_type="flex" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif">
            <?php }else{ ?>
            <img fieldid="<?php echo $v['discipline_id'];?>" status="close" nc_type="flex" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-item.gif">
            <?php } ?></td>
          <td class="w48 sort"><span title="<?php echo $lang['nc_editable'];?>" ajax_branch="discipline_sort" datatype="number" fieldid="<?php echo $v['discipline_id'];?>" fieldname="discipline_sort" nc_type="inline_edit" class="editable tooltip"><?php echo $v['discipline_sort'];?></span></td>
          <td class="w50pre name">
          <span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['discipline_id'];?>" ajax_branch="discipline_name" fieldname="discipline_name" nc_type="inline_edit" class="editable tooltip"><?php echo $v['discipline_name'];?></span>
          <a class="btn-add-nofloat marginleft" href="index.php?act=member_discipline&op=member_discipline_add&discipline_parent_id=<?php echo $v['discipline_id'];?>"><span><?php echo $lang['nc_add_sub_class'];?></span></a>
          </td>
          <td class="align-center power-onoff"><?php if($v['discipline_show'] == 0){ ?>
            <a href="JavaScript:void(0);" class="tooltip disabled" fieldvalue="0" fieldid="<?php echo $v['discipline_id'];?>" ajax_branch="discipline_show" fieldname="discipline_show" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class="tooltip enabled" fieldvalue="1" fieldid="<?php echo $v['discipline_id'];?>" ajax_branch="discipline_show" fieldname="discipline_show" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="w84"><a href="index.php?act=member_discipline&op=member_discipline_edit&discipline_id=<?php echo $v['discipline_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:if(confirm('<?php echo $lang['discipline_index_ensure_del'];?>'))window.location = 'index.php?act=member_discipline&op=member_discipline_del&discipline_id=<?php echo $v['discipline_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['discipline_list']) && is_array($output['discipline_list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['discipline_index_ensure_del'];?>')){$('#submit_type').val('del');$('form:first').submit();}"><span><?php echo $lang['nc_del'];?></span></a></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/jquery.member_discipline.js" charset="utf-8"></script> 
