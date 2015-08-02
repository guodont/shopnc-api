<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_pointprod'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_pointprod_list_title'];?></span></a></li>
        <li><a href="index.php?act=pointprod&op=prod_add" ><span><?php echo $lang['admin_pointprod_add_title'];?></span></a></li>
        <li><a href="index.php?act=pointorder&op=pointorder_list" ><span><?php echo $lang['admin_pointorder_list_title'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="pointprod">
    <input type="hidden" name="op" value="pointprod">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="pg_name"><?php echo $lang['admin_pointprod_goods_name']; ?></label></th>
          <td><input type="text" name="pg_name" id="pg_name" class="txt" value='<?php echo $_GET['pg_name'];?>'></td>
          <td><select name="pg_state">
              <option value="" <?php if (!$_GET['pg_state']){echo 'selected=selected';}?>><?php echo $lang['admin_pointprod_state']; ?></option>
              <option value="show" <?php if ($_GET['pg_state'] == 'show'){echo 'selected=selected';}?>><?php echo $lang['admin_pointprod_show_up']; ?></option>
              <option value="nshow" <?php if ($_GET['pg_state'] == 'nshow'){echo 'selected=selected';}?>><?php echo $lang['admin_pointprod_show_down']; ?></option>
              <option value="commend" <?php if ($_GET['pg_state'] == 'commend'){echo 'selected=selected';}?>><?php echo $lang['admin_pointprod_commend']; ?></option>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_field_value'] != '' or $output['search_sort'] != ''){?>
            <a href="index.php?act=member&op=member" class="btns "><span><?php echo $lang['nc_cancel_search']?></span></a>
            <?php }?></td>
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
            <li><?php echo $lang['pointprod_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_prod" action="index.php">
    <input type="hidden" name="act" value="pointprod">
    <input type="hidden" id="list_op" name="op" value="prod_dropall">
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th><?php echo $lang['admin_pointprod_goods_name']; ?></th>
          <th class="align-center"><?php echo $lang['admin_pointprod_goods_points'];?></th>
          <th class="align-center"><?php echo $lang['admin_pointprod_goods_price'];?></th>
          <th class="align-center"><?php echo $lang['admin_pointprod_goods_storage']; ?></th>
          <th class="align-center"><?php echo $lang['admin_pointprod_goods_view']; ?></th>
          <th class="align-center"><?php echo $lang['admin_pointprod_salenum']; ?></th>
          <th class="align-center"><?php echo $lang['admin_pointprod_show_up']; ?></th>
          <th class="align-center"><?php echo $lang['admin_pointprod_commend']; ?></th>
          <th class="align-center"><?php echo $lang['nc_handle']; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['prod_list']) && is_array($output['prod_list'])){ ?>
        <?php foreach($output['prod_list'] as $k => $v){?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" name="pg_id[]" value="<?php echo $v['pgoods_id'];?>" class="checkitem"></td>
          <td class="w48 picture"><div class="size-44x44"><span class="thumb size-44x44"><i></i><img height="44" width="44" src="<?php echo $v['pgoods_image_small']; ?>" onload="javascript:DrawImage(this,44,44);"/></span></div></td>
          <td><a href="<?php echo urlShop('pointprod', 'pinfo', array('id' => $v['pgoods_id']));?>" target="_blank" ><?php echo $v['pgoods_name'];?></a></td>
          <td class="align-center"><?php echo $v['pgoods_points'];?></td>
          <td class="align-center"><?php echo $v['pgoods_price'];?></td>
          <td class="align-center"><?php echo $v['pgoods_storage'];?></td>
          <td class="align-center"><?php echo $v['pgoods_view'];?></td>
          <td class="align-center"><?php echo $v['pgoods_salenum'];?></td>
          <td class="align-center power-onoff"><?php if($v['pgoods_show'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='pgoods_show' nc_type="inline_edit" fieldname="pgoods_show" fieldid="<?php echo $v['pgoods_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else { ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='pgoods_show' nc_type="inline_edit" fieldname="pgoods_show" fieldid="<?php echo $v['pgoods_id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center yes-onoff"><?php if($v['pgoods_commend'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='pgoods_commend' nc_type="inline_edit" fieldname="pgoods_commend" fieldid="<?php echo $v['pgoods_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else { ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='pgoods_commend' nc_type="inline_edit" fieldname="pgoods_commend" fieldid="<?php echo $v['pgoods_id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="w72 align-center"><a href="index.php?act=pointprod&op=prod_edit&pg_id=<?php echo $v['pgoods_id']; ?>" class="edit"><?php echo $lang['nc_edit']; ?></a> | <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){window.location='index.php?act=pointprod&op=prod_drop&pg_id=<?php echo $v['pgoods_id']; ?>';}else{return false;}"><?php echo $lang['nc_del']; ?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['prod_list']) && is_array($output['prod_list'])){ ?>
        <tr>
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16" id="dataFuncs"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('prod_dropall');"><span><?php echo $lang['nc_del']?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
function submit_form(op){
	if(op=='prod_dropall'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
	}
	$('#list_op').val(op);
	$('#form_prod').submit();
}
</script>