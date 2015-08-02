<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_message_set'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form name='form1' method='post'>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th class="w24">&nbsp;</th>
          <th><?php echo $lang['mailtemplates_index_desc'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(is_array($output['templates_list']) && !empty($output['templates_list'])){?>
        <?php foreach($output['templates_list'] as $k => $v){?>
        <tr class="hover">
          <td class="w24"></td>
          <td><?php echo $v['name']; ?></td>
          <td class="w60 align-center"><a href="index.php?act=message&op=email_tpl_edit&code=<?php echo $v['code']; ?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
function go(){
	var url="index.php?act=message&op=email_tpl_ajax";
	document.form1.action = url;
	document.form1.submit();
}
</script>