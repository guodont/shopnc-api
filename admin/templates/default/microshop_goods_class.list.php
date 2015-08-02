<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".class_parent").click(function(){
            if($(this).attr("status") == "open") {
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
        $('span[nc_type="class_sort"]').inline_edit({act: 'microshop',op: 'goodsclass_sort_update'});
        $('span[nc_type="class_name"]').inline_edit({act: 'microshop',op: 'goodsclass_name_update'});

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
        $('#list_form').attr('action','index.php?act=microshop&op=goodsclass_drop');
        $('#class_id').val(id);
        $('#list_form').submit();
    }
}

</script>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_microshop_goods_class'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['microshop_goods_class_tip1'];?></li>
            <li><?php echo $lang['microshop_goods_class_tip2'];?></li>
            <li><?php echo $lang['microshop_goods_class_tip3'];?></li>
            <li><?php echo $lang['microshop_goods_class_tip4'];?></li>
            <li><?php echo $lang['microshop_goods_class_tip5'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="class_id" name="class_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th class="w48"></th>
          <th class="w48"><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['microshop_class_name'];?></th>
          <th class="w60"><?php echo $lang['microshop_commend'];?></th>
          <th class="w200 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <?php if(empty($val['class_parent_id'])) { ?>
        <tr class="hover edit">
          <td><input type="checkbox" value="<?php echo $val['class_id'];?>" class="checkitem">
            <img class="class_parent" class_id="<?php echo 'class_id'.$val['class_id'];?>" status="open" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif"></td>
          <td class="w48 sort"><span nc_type="class_sort" column_id="<?php echo $val['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $val['class_sort'];?></span></td>
          <td class="name"><span nc_type="class_name" column_id="<?php echo $val['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $val['class_name'];?></span> <a class="btn-add-nofloat marginleft" href="index.php?act=microshop&op=goodsclass_add&class_parent_id=<?php echo $val['class_id'];?>"><span><?php echo $lang['nc_add_sub_class'];?></span></a></td>
          <td class="yes-onoff"><a href="JavaScript:void(0);" class=" <?php echo $val['class_commend']? 'enabled':'disabled'?>" ajax_branch='class_commend'  nc_type="inline_edit" fieldname="class_commend" fieldid="<?php echo $val['class_id']?>" fieldvalue="<?php echo $val['class_commend']?'1':'0'?>" title="<?php echo $lang['editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a></td>
          <td class="align-center"><a href="index.php?act=microshop&op=goodsclass_edit&class_id=<?php echo $val['class_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:submit_delete(<?php echo $val['class_id'];?>)"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php foreach($output['list'] as $val1){ ?>
        <?php if($val1['class_parent_id'] == $val['class_id']) { ?>
        <tr class="hover edit <?php echo 'class_id'.$val['class_id'];?>" style="display:none;">
          <td class="w48"><input type="checkbox" value="<?php echo $val1['class_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span nc_type="class_sort" column_id="<?php echo $val1['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $val1['class_sort'];?></span></td>
          <td class="name"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-item1.gif"> <span nc_type="class_name" column_id="<?php echo $val1['class_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $val1['class_name'];?></span></td>
          <td></td>
          <td class="w200 align-center">
              <?php if(empty($val1['class_default'])) { ?>
              <a href="index.php?act=microshop&op=goodsclass_default&class_id=<?php echo $val1['class_id'];?>"><?php echo $lang['microshop_goods_class_default'];?></a> | 
              <?php } ?>
              <a href="index.php?act=microshop&op=goodsclass_binding&class_id=<?php echo $val1['class_id'];?>"><?php echo $lang['microshop_goods_class_binding'];?></a> | 
              <a href="index.php?act=microshop&op=goodsclass_edit&class_id=<?php echo $val1['class_id'];?>"><?php echo $lang['nc_edit'];?></a> | 
              <a href="javascript:submit_delete(<?php echo $val1['class_id'];?>)"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp; <a href="javascript:void(0)" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['show_page'];?></div>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
