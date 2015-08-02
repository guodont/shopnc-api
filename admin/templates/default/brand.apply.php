<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['brand_index_brand'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=brand&op=brand"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=brand&op=brand_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['brand_index_to_audit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="POST" name="formSearch">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_brand_name"><?php echo $lang['brand_index_name'];?></label></th>
          <td><input class="txt" name="search_brand_name" id="search_brand_name" value="<?php echo $output['search_brand_name']?>" type="text"></td>
          <th><label for="search_brand_class"><?php echo $lang['brand_index_class'];?></label></th>
          <td><input class="txt" name="search_brand_class" id="search_brand_class" value="<?php echo $output['search_brand_class']?>" type="text"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_brand">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" id="type" value="" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="space">
          <th colspan="15"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['brand_index_name'];?></th>
          <th><?php echo $lang['brand_index_class'];?></th>
          <th><?php echo $lang['brand_index_pic_sign'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){ ?>
        <?php foreach($output['brand_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" class="checkitem" name="del_id[]" value="<?php echo $v['brand_id'];?>"></td>
          <td class="name w270"><span><?php echo $v['brand_name']?></span></td>
          <td class="class"><?php echo $v['brand_class']?></td>
          <td><div class="brand-picture"><img src="<?php echo brandImage($v['brand_pic']);?>"/></div></td>
          <td class="w96 align-center"><a href="index.php?act=brand&op=brand_apply_set&state=pass&brand_id=<?php echo $v['brand_id']?>"><?php echo $lang['nc_pass'];?></a> | <a href="index.php?act=brand&op=brand_apply_set&state=refuse&brand_id=<?php echo $v['brand_id']?>"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){ ?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('pass');" name="id"><span><?php echo $lang['nc_pass'];?></span></a><a href="JavaScript:void(0);" class="btn" onclick="submit_form('refuse');" name="id"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script>
function submit_form(type){
	if(confirm('<?php echo $lang['brand_apply_handle_ensure'];?>?')){
		$('#type').val(type);
		$('#form_brand').submit();
	}
}
</script>