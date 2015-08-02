<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>店铺帮助</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '帮助内容';?></span></a></li>
        <li><a href="index.php?act=help_store&op=help_type"><span><?php echo '帮助类型';?></span></a></li>
        <li><a href="index.php?act=help_store&op=add_help"><span><?php echo '新增内容';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="help_store" />
    <input type="hidden" name="op" value="help_store" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th>帮助标题</th>
        <td><input type="text" class="text" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>
          <th>帮助类型</th>
          <td><select name="type_id" id="type_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['type_list']) && is_array($output['type_list'])){ ?>
              <?php foreach($output['type_list'] as $key => $val){ ?>
              <option <?php if($val['type_id'] == $_GET['type_id']){?>selected<?php }?> value="<?php echo $val['type_id'];?>"><?php echo $val['type_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>帮助内容排序显示规则为排序小的在前，新增内容的在前</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['nc_sort'];?></th>
          <th>帮助标题</th>
          <th>帮助类型</th>
          <th class="align-center">更新时间</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['help_list']) && is_array($output['help_list'])){ ?>
        <?php foreach($output['help_list'] as $key => $val){ ?>
        <tr class="hover">
          <td class="w48 sort"><?php echo $val['help_sort'];?></td>
          <td><?php echo $val['help_title'];?></td>
          <td><?php echo $output['type_list'][$val['type_id']]['type_name'];?></td>
          <td class="w150 align-center"><?php echo date('Y-m-d H:i:s',$val['update_time']);?></td>
          <td class="w150 align-center"><a href="index.php?act=help_store&op=edit_help&help_id=<?php echo $val['help_id'];?>"><?php echo $lang['nc_edit'];?></a> |
          	<a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')) window.location = 'index.php?act=help_store&op=del_help&help_id=<?php echo $val['help_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['help_list']) && is_array($output['help_list'])){ ?>
        <tr class="tfoot">
          <td colspan="16">
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
</div>
<script type="text/javascript">
$(function(){
    $('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
});
</script>