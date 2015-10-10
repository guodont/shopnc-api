<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=ap_add" ><span><?php echo $lang['ap_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php?act=adv&op=ap_manage" name="formSearch">
    <input type="hidden" name="act" value="adv" />
    <input type="hidden" name="op" value="ap_manage" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_name"><?php echo $lang['ap_name']; ?></label></th>
          <td><input class="txt" type="text" name="search_name" id="search_name" value="<?php echo $_GET['search_name'];?>" /></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_title'] != '' || $output['search_ac_id'] != ''){?>
            <a href="JavaScript:void(0);" onclick=window.location.href='index.php?act=adv&op=ap_manage' class="btns " title="<?php echo $lang['adv_all']; ?>"><span><?php echo $lang['adv_all']; ?></span></a>
            <?php }?></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['adv_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th><input type="checkbox" class="checkall"/></th>
          <th><?php echo $lang['ap_name'];?></th>
          <th class="align-center"><?php echo $lang['adv_class'];?></th>
          <th class="align-center"><?php echo $lang['ap_show_style'];?></th>
          <th class="align-center"><?php echo $lang['ap_width'];?></th>
          <th class="align-center"><?php echo $lang['ap_height'];?></th>
          <th class="align-center"><?php echo $lang['ap_show_num'];?></th>
          <th class="align-center"><?php echo $lang['ap_publish_num'];?></th>
          <th class="align-center"><?php echo $lang['ap_is_use'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['ap_list']) && is_array($output['ap_list'])){ ?>
        <?php foreach($output['ap_list'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" class="checkitem" name="del_id[]" value="<?php echo $v['ap_id']; ?>" /></td>
          <td><span title="<?php echo $v['ap_name'];?>"><?php echo str_cut($v['ap_name'], '40');?></span></td>
          <td class="align-center"><?php
						switch($v['ap_class']){
							case '0':echo $lang['adv_pic'];break;
							case '1':echo $lang['adv_word'];break;
							case '3':echo "Flash";break;
						}
					?></td>
          <td class="align-center"><?php
						switch($v['ap_display']){
							case '0':echo $lang['ap_slide_show'];break;
							case '1':echo $lang['ap_mul_adv'];break;
							case '2':echo $lang['ap_one_adv'];break;
							default:echo $lang['adv_index_unknown'];break;
						}
					?></td>
          <td class="align-center"><?php echo $v['ap_width'];?></td>
          <td class="align-center"><?php
					 if($v['ap_class'] == '1'){
					 	echo "";
					 }else{
					 	echo "".$v['ap_height']."";
					 }
					?></td>
          <td class="align-center"><?php
					 $i    = 0;
					 $time = time();
					 if(!empty($output['adv_list'])){
					 foreach ($output['adv_list'] as $adv_k => $adv_v){
					 	if($adv_v['ap_id'] == $v['ap_id'] && $adv_v['adv_end_date'] > $time && $adv_v['adv_start_date'] < $time && $adv_v['is_allow'] == '1'){
					 		$i++;
					 	}
					 }}
					 echo $i;
					?></td>
          <td class="align-center"><?php
					 $i    = 0;
					 if(!empty($output['adv_list'])){
					 foreach ($output['adv_list'] as $adv_k => $adv_v){
					 	if($adv_v['ap_id'] == $v['ap_id']){
					 		$i++;
					 	}
					 }}
					 echo $i;
					?></td>
          <td class="align-center yes-onoff"><?php if($v['is_use'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch="is_use" nc_type="inline_edit" fieldname="is_use" fieldid="<?php echo $v['ap_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else { ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch="is_use" nc_type="inline_edit" fieldname="is_use" fieldid="<?php echo $v['ap_id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center">
          <a href="index.php?act=adv&op=adv&ap_id=<?php echo $v['ap_id'];?>">管理广告</a> | <a href='index.php?act=adv&op=ap_edit&ap_id=<?php echo $v['ap_id'];?>'><?php echo $lang['nc_edit'];?></a> |<a href="javascript:void(0)" onclick="copyToClipBoard('<?php echo $v['ap_id'];?>');"><?php echo $lang['ap_get_js'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall"/></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['ap_del_sure'];?>')){$('#store_form').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script>
//弹出复制代码框
function copyToClipBoard(id)
{
   ajax_form('copy_adv', '<?php echo $lang['ap_get_js'];?>', 'index.php?act=adv&op=ap_copy&id='+id);
}
</script>
