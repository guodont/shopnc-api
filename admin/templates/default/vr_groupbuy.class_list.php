<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>虚拟抢购</h3>
      <ul class="tab-base">
        <li><a href="javascript:;" class="current"><span>分类管理</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=class_add"><span>添加分类</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=area_list"><span>区域管理</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=area_add"><span>添加区域</span></a></li>
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
            <li>商家发布虚拟商品的抢购时，需要选择虚拟抢购所属分类</li>
            <li>通过修改排序数字可以控制前台线下商城分类的显示顺序，数字越小越靠前</li>
            <li>可以对分类名称进行修改,可以新增下级分类</li>
            <li>可以对分类进行编辑、删除操作</li>
            <li>点击行首的"+"号，可以展开下级分类</li>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="list_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <input type="hidden" name="class_id" id="class_id">
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th>分类名称</th>
          <th><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($output['list']) && is_array($output['list'])) { ?>
        <?php foreach ($output['list'] as $val) { ?>
        <?php if ($val['parent_class_id']==0) { ?>
        <tr class="hover edit">
          <td class="w48">
            <input type="checkbox" value="<?php echo $val['class_id'];?>" class="checkitem">
            <img class="class_parent" class_id="<?php echo 'class_id'.$val['class_id'];?>" status="open" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif">
          </td>
          <td class="w48 sort">
            <span nc_type="inline_edit" ajax_branch="class" column_id="<?php echo $val['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable tooltip" fieldid="<?php echo $val['class_id'];?>" fieldname="class_sort" ><?php echo $val['class_sort'];?></span>
          </td>
          <td class="name">
            <span nc_type="inline_edit" ajax_branch="class" column_id="<?php echo $val['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable tooltip" fieldname="class_name" fieldid="<?php echo $val['class_id'];?>"><?php echo $val['class_name'];?></span>
            <a class="btn-add-nofloat marginleft" href="index.php?act=vr_groupbuy&op=class_add&parent_class_id=<?php echo $val['class_id'];?>"><span>新增下级</span></a>
          </td>
          <td>
            <a href="index.php?act=vr_groupbuy&op=class_edit&class_id=<?php echo $val['class_id'];?>"><?php echo $lang['nc_edit'];?></a> |
            <a href="javascript:submit_delete(<?php echo $val['class_id'];?>)"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
        <?php foreach($output['list'] as $val1) { ?>
        <?php if ($val1['parent_class_id'] == $val['class_id']) { ?>
        <tr class="hover edit <?php echo 'class_id'.$val['class_id'];?>" style="display:none;">
          <td class="w48"><input type="checkbox" value="<?php echo $val1['class_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span nc_type="inline_edit" ajax_branch="class" column_id="<?php echo $val1['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable tooltip" fieldid="<?php echo $val1['class_id'];?>" fieldname="class_sort" ><?php echo $val1['class_sort'];?></span></td>
          <td class="name">
          <span nc_type="inline_edit" ajax_branch="class" column_id="<?php echo $val1['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable tooltip" fieldname="class_name" fieldid="<?php echo $val1['class_id'];?>"><?php echo $val1['class_name'];?></span></td>
          <td class="w200">
              <a href="index.php?act=vr_groupbuy&op=class_edit&class_id=<?php echo $val1['class_id'];?>"><?php echo $lang['nc_edit'];?></a> |
              <a href="javascript:submit_delete(<?php echo $val1['class_id'];?>)"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if (!empty($output['list']) && is_array($output['list'])) { ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp; <a href="javascript:void(0)" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
    $(".class_parent").click(function() {
        if ($(this).attr("status") == "open") {
            $(this).attr("status","close");
            $(this).attr("src","<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-collapsable.gif");
            $("."+$(this).attr("class_id")).show();
        } else {
            $(this).attr("status","open");
            $(this).attr("src","<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif");
            $("."+$(this).attr("class_id")).hide();
        }
    });

    //行内ajax编辑
    $('span[nc_type="class_sort"]').inline_edit();
    $('span[nc_type="class_name"]').inline_edit();

});
function submit_delete_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function() {
        items += this.value + ',';
    });
    if (items != '') {
        items = items.substr(0, (items.length - 1));
        submit_delete(items);
    } else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_delete(id){
    if (confirm('<?php echo $lang['nc_ensure_del'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=vr_groupbuy&op=class_del');
        $('#class_id').val(id);
        $('#list_form').submit();
    }
}

</script>
