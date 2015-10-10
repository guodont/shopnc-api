<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"/>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_voucher_price_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </ul>
    </div>
  </div>
  <!--  搜索 -->
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="voucher">
    <input type="hidden" name="op" value="templatelist">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name"><?php echo $lang['admin_voucher_storename'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt" style="width:100px;"></td>
          <th><label for="store_name"><?php echo $lang['admin_voucher_template_adddate'];?></label></th>
          <td><input type="text" id="sdate" name="sdate" class="txt date" value="<?php echo $_GET['sdate'];?>" >~<input type="text" id="edate" name="edate" class="txt date" value="<?php echo $_GET['edate'];?>" ></td>
          <th><label><?php echo $lang['nc_state'];?></label></th>
          <td>
          	<select name="state">
          		<option value="0" <?php if(0 === intval($_GET['state'])) echo 'selected';?>><?php echo $lang['nc_status'];?></option>
          		<?php if(is_array($output['templatestate_arr'])) { ?>
          		<?php foreach($output['templatestate_arr'] as $key=>$val) { ?>
          			<option value="<?php echo $val[0];?>" <?php if(intval($val[0]) === intval($_GET['state'])) echo 'selected';?>><?php echo $val[1];?></option>
          		<?php } ?>
          		<?php } ?>
            </select></td>
          <td>
          	<select name="recommend">
          		<option value="" selected>是否推荐</option>
          		<option value="1" <?php if('1' === $_GET['recommend']) echo 'selected';?>>已推荐</option>
          		<option value="0" <?php if('0' === $_GET['recommend']) echo 'selected';?>>未推荐</option>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul><li><?php echo $lang['admin_voucher_template_list_tip'];?></li></ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <input type="hidden" id="object_id" name="object_id"  />
    <table class="table tb-type2">
      <thead>
          <tr class="thead">
          	  <th class="w24">&nbsp;</th>
              <th class="align-left"><span><?php echo $lang['admin_voucher_storename'];?></span></th>
              <th class="align-left"><span><?php echo $lang['admin_voucher_template_title'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_template_price'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_template_orderpricelimit'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_template_enddate'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_template_adddate'];?></span></th>
              <th class="align-center"><span><?php echo $lang['nc_state'];?></span></th>
              <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
              <th class="align-center"><span><?php echo $lang['nc_handle'];?></span></th>
          </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
        	<td>&nbsp;</td>
            <td class="align-left"><a href="<?php echo urlShop('show_store','index', array('store_id'=>$val['voucher_t_store_id']));?>" ><span><?php echo $val['voucher_t_storename'];?></span></a>
<?php if (isset($output['flippedOwnShopIds'][$val['voucher_t_store_id']])) { ?>
            <span class="ownshop">[自营]</span>
<?php } ?>
            </td>
            <td class="align-left"><span><?php echo $val['voucher_t_title'];?></span></td>
            <td class="align-center"><span><?php echo $val['voucher_t_price'];?></span></td>
            <td class="align-center"><span><?php echo $val['voucher_t_limit'];?></span></td>
            <td class="align-center"><span><?php echo @date('Y-m-d',$val['voucher_t_start_date']);?>~<?php echo @date('Y-m-d',$val['voucher_t_end_date']);?></span></td>
            <td class="align-center"><span><?php echo @date('Y-m-d',$val['voucher_t_add_date']);?></span></td>
            <td class="align-center"><span>
            <?php foreach($output['templatestate_arr'] as $k=>$v){
            	if($val['voucher_t_state'] == $v[0]){
            		echo $v[1];
            	}
            } ?>
            </span></td>
            <td class="align-center yes-onoff"><?php if($val['voucher_t_recommend'] == '0'){ ?>
            <a href="JavaScript:void(0);" class="disabled" ajax_branch='voucher_t_recommend' nc_type="inline_edit" fieldname="voucher_t_recommend" fieldid="<?php echo $val['voucher_t_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class="enabled" ajax_branch='voucher_t_recommend' nc_type="inline_edit" fieldname="voucher_t_recommend" fieldid="<?php echo $val['voucher_t_id']?>" fieldvalue="1"  title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
            <td class="nowrap align-center"><a href="index.php?act=voucher&op=templateedit&tid=<?php echo $val['voucher_t_id'];?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td colspan="16">
            <div class="pagination"> <?php echo $output['show_page'];?> </div>
          </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>

<script language="javascript">
$(function(){
	$('#sdate').datepicker({dateFormat: 'yy-mm-dd'});
	$('#edate').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
