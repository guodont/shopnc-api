<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>分类管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=flea_class&op=goods_class" ><span>管理</span></a></li>
        <li><a href="index.php?act=flea_class&op=goods_class_add" ><span>新增</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['goods_class_batch_edit_batch'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="goods_class_form" method="post" action="index.php?act=flea_class&op=brach_edit_save" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['nc_display'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="radio" checked="checked" value="-1" name="gc_show" id="gc_show-1">
                <label for="gc_show-1"><?php echo $lang['goods_class_batch_edit_keep'];?></label>
              </li>
              <li>
                <input type="radio" value="1" name="gc_show" id="gc_show1">
                <label for="gc_show1"><?php echo $lang['nc_yes'];?></label>
              </li>
              <li>
                <input type="radio" value="0" name="gc_show" id="gc_show0">
                <label for="gc_show"><?php echo $lang['nc_no'];?></label>
              </li>
            </ul></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
