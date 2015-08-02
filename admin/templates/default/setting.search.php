<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_admin_search_set'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_admin_search_set'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="form" method="post" enctype="multipart/form-data" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="hot_search"><?php echo $lang['hot_search'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="hot_search" name="hot_search" value="<?php echo $output['list_setting']['hot_search'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['field_notice'];?></span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
