<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['navigation_index_nav'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=navigation&op=navigation_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="navigation" name="act">
    <input type="hidden" value="navigation" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_nav_title"><?php echo $lang['navigation_index_title'];?></label></th>
          <td><input type="text" value="<?php echo $output['search_nav_title'];?>" name="search_nav_title" id="search_nav_title" class="txt"></td>
          <th><label><?php echo $lang['navigation_index_location'];?></label></th>
          <td><select name="search_nav_location">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <option value="0" <?php if($output['search_nav_location'] == '0'){ ?>selected="selected"<?php } ?>><?php echo $lang['navigation_index_top'];?></option>
              <option value="1" <?php if($output['search_nav_location'] == '1'){ ?>selected="selected"<?php } ?>><?php echo $lang['navigation_index_center'];?></option>
              <option value="2" <?php if($output['search_nav_location'] == '2'){ ?>selected="selected"<?php } ?>><?php echo $lang['navigation_index_bottom'];?></option>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_nav_title'] != '' or $output['search_nav_location'] != ''){?>
            <a class="btns" href="index.php?act=navigation&op=navigation"><span><?php echo $lang['nc_cancel_search'];?></span></a>
            <?php }?></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_nav">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15"><?php echo $lang['navigation_index_nav'];?><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['navigation_index_title'];?></th>
          <th><?php echo $lang['navigation_index_url'];?></th>
          <th class="align-center"><?php echo $lang['navigation_index_location'];?></th>
          <th class="align-center"><?php echo $lang['navigation_index_open_new'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['navigation_list']) && is_array($output['navigation_list'])){ ?>
        <?php foreach($output['navigation_list'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['nav_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span title="<?php echo $lang['nc_editable'];?>" style="cursor:pointer;"  ajax_branch='nav_sort' datatype="number" fieldid="<?php echo $v['nav_id'];?>" fieldname="nav_sort" nc_type="inline_edit" class="editable"><?php echo $v['nav_sort'];?></span></td>
          <td><?php echo $v['nav_title'];?></td>
          <td><?php echo $v['nav_url'];?></td>
          <td class="w150 align-center"><?php echo $v['nav_location'];?></td>
          <td class="w150 align-center"><?php echo $v['nav_new_open'];?></td>
          <td class="w72 align-center"><a href="index.php?act=navigation&op=navigation_edit&nav_id=<?php echo $v['nav_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=navigation&op=navigation_del&nav_id=<?php echo $v['nav_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['navigation_list']) && is_array($output['navigation_list'])){ ?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_nav').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>