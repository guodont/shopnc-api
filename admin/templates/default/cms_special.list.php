<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
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
        $('#list_form').attr('action','index.php?act=cms_special&op=cms_special_drop');
        $('#special_id').val(id);
        $('#list_form').submit();
    }
}
</script>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_cms_special_manage'];?></h3>
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
        <th colspan="12" class="nobg"> <div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['cms_special_list_tip1'];?></li>
            <li>专题类型分为资讯和商城，资讯专题将出现在资讯频道内，商城专题出现在商城使用商城统一风格</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="special_id" name="special_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th></th>
          <th class="align-left"><?php echo $lang['cms_text_title'];?></th>
          <th class="align-left">类型</th>
          <th class="align-left"><?php echo $lang['cms_text_state'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
          <td class="w48"><input type="checkbox" value="<?php echo $val['special_id'];?>" class="checkitem"></td>
          <td class="name"><?php echo $val['special_title'];?></td>
          <td class="name"><?php echo $val['special_type_text'];?></td>
          <td class="name"><?php echo $output['special_state_list'][$val['special_state']];?></td>
          <td class="w84 align-center">
              <?php if($val['special_state'] == '2') { ?> 
              <a href="<?php echo $val['special_link'];?>" target="_blank"><?php echo $lang['cms_text_see'];?></a>
              <?php } else { ?>
              <a href="index.php?act=cms_special&op=cms_special_detail&special_id=<?php echo $val['special_id'];?>" target="_blank"><?php echo $lang['cms_text_view'];?></a>
              <?php } ?>
              <a href="index.php?act=cms_special&op=cms_special_edit&special_id=<?php echo $val['special_id'];?>"><?php echo $lang['nc_edit'];?></a>
              <a href="javascript:submit_delete(<?php echo $val['special_id'];?>)"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
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
