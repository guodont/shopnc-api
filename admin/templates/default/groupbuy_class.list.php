<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['groupbuy_index_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
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
            <li>抢购分类最多为2级分类，商家发布抢购活动时选择分类，用于抢购聚合页对抢购活动进行筛选</li>
          </ul></td>
      </tr>
    </tbody>
  </table>

  <form id="list_form" method='post'>
    <input id="class_id" name="class_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['goods_class_index_name'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit <?php echo $val['class_parent_id']=='0'?'':'two';?> <?php echo 'parent'.$val['class_parent_id'];?>">
          <td class="w36"><input type="checkbox"  value="<?php echo $val['class_id'];?>" class="checkitem">
            <?php if($val['have_child'] == '1'){ ?>
            <img class="node_parent" state="close" node_id="<?php echo 'parent'.$val['class_id'];?>" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif">
            <?php } ?></td>
          <td class="w48 sort"><span title="<?php echo $lang['nc_editable'];?>" ajax_branch="class_sort" datatype="number" fieldid="<?php echo $val['class_id'];?>" fieldname="sort" nc_type="inline_edit" class="editable "><?php echo $val['sort'];?></span></td>
          <td class="name"><?php if($val['class_parent_id'] != '0'){ ?>
            <img fieldid="<?php echo $val['class_id'];?>" status="close" nc_type="flex" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-item1.gif">
            <?php } ?>
            <span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $val['class_id'];?>" ajax_branch="class_name" fieldname="class_name" nc_type="inline_edit" class="node_name editable "><?php echo $val['class_name'];?></span>
            <?php if($val['class_parent_id'] == '0'){ ?>
            <a href="index.php?act=groupbuy&op=class_add&parent_id=<?php echo $val['class_id'];?>" class="btn-add-nofloat marginleft"><span><?php echo $lang['nc_add_sub_class'];?></span></a>
            <?php } ?></td>
        <td class="w156 align-center">
            <!--
            <a href="index.php?act=groupbuy&op=class_edit&class_id=<?php echo $val['class_id'];?>"><?php echo $lang['nc_edit'];?></a> |
            -->
        <a href="JavaScript:void(0);" onclick="submit_delete('<?php echo $val['class_id'];?>');"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
        <tr><td colspan="20"><a class="btn-add marginleft" href="<?php echo urlAdmin('groupbuy', 'class_add');?>">添加分类</a></td></tr>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".two").hide();
        $(".node_parent").click(function(){
            var node_id = $(this).attr('node_id');
            var state = $(this).attr('state');
            if(state == 'close') {
                $("."+node_id).show();
                $(this).attr('state','open');
                $(this).attr('src',"<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-collapsable.gif");
            }
            else {
                $("."+node_id).hide();
                $(this).attr('state','close');
                $(this).attr('src',"<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif");
            }
        });
    });
function submit_delete_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_delete(items);
    }
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_delete(id){
    if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=groupbuy&op=class_drop');
        $('#class_id').val(id);
        $('#list_form').submit();
    }
}

</script>
