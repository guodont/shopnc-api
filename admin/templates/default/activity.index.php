<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['activity_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=activity&op=new" ><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="activity">
    <input type="hidden" name="op" value="activity">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="searchtitle"><?php echo $lang['activity_index_title']; ?></label></th>
          <td><input type="text" name="searchtitle" id="searchtitle" class="txt" value='<?php echo $_GET['searchtitle'];?>'></td>
          <td><select name="searchstate">
              <option value="0" <?php if (!$_GET['searchstate']){echo 'selected=selected';}?>><?php echo $lang['activity_openstate']; ?></option>
              <option value="2" <?php if ($_GET['searchstate'] == 2){echo 'selected=selected';}?>><?php echo $lang['activity_openstate_open']; ?></option>
              <option value="1" <?php if ($_GET['searchstate'] == 1){echo 'selected=selected';}?>><?php echo $lang['activity_openstate_close']; ?></option>
            </select>
          </td>
          <th colspan="1"><label for="searchstartdate"><?php echo $lang['activity_index_periodofvalidity']; ?></label></th>
          <td>
          	<input type="text" name="searchstartdate" id="searchstartdate" class="txt date" readonly='' value='<?php echo $_GET['searchstartdate'];?>'>~<input type="text" name="searchenddate" id="searchenddate" class="txt date" readonly='' value='<?php echo $_GET['searchenddate'];?>'></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query']; ?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['activity_index_help1'];?></li>
            <li><?php echo $lang['activity_index_help2'];?></li>
            <li><?php echo $lang['activity_index_help3'];?></li>
            <li><?php echo $lang['activity_index_help4'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="listform" action="index.php" method='post'>
    <input type="hidden" name="act" value="activity" />
    <input type="hidden" id="listop" name="op" value="del" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24">&nbsp;</th>
          <th class="w48 "><?php echo $lang['nc_sort'];?></th>
          <th class="w270"><?php echo $lang['activity_index_title'];?></th>
          <th class="w96"><?php echo $lang['activity_index_banner'];?></th>
          <!-- <th class="align-center"><?php echo $lang['activity_index_type'];?></th>
          <th class="align-center"><?php echo $lang['activity_index_style'];?></th> -->
          <th class="align-center"><?php echo $lang['activity_index_start'];?></th>
          <th class="align-center"><?php echo $lang['activity_index_end'];?></th>
          <th class="align-center"><?php echo $lang['activity_openstate'];?></th>
          <th class="w150 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover edit row">
          <td><input type="checkbox" name='activity_id[]' value="<?php echo $v['activity_id'];?>" class="checkitem"></td>
          <td class="sort"><span class=" editable" title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['activity_id'];?>" ajax_branch='activity_sort' fieldname="activity_sort" nc_type="inline_edit" ><?php echo $v['activity_sort'];?></span></td>
          <td class="name"><span class=" editable" title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['activity_id'];?>" ajax_branch='activity_title' fieldname="activity_title" nc_type="inline_edit" ><?php echo $v['activity_title'];?></span></td>
          <td><div class="link-logo"><span class="thumb size-logo"><i></i><img height="31" width="88" src="<?php if(is_file(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$v['activity_banner'])){echo UPLOAD_SITE_URL."/".ATTACH_ACTIVITY."/".$v['activity_banner'];}else{echo ADMIN_SITE_URL."/templates/".TPL_NAME."/images/sale_banner.jpg";}?>" onload="javascript:DrawImage(this,88,31);" /></span></div></td>
          <!-- <td class="align-center"><?php switch($v['activity_type']){
					case '1':
						echo $lang['activity_index_goods'];
						break;
					case '2':
						echo $lang['activity_index_group'];
						break;
				}?></td>
          <td class="nowarp align-center"><?php
					switch($v['activity_style']){
						case 'default_style':echo $lang['activity_index_default'];break;
					}
				?></td> -->
          <td class="nowrap align-center"><?php echo @date('Y-m-d',$v['activity_start_date']);?></td>
          <td class="align-center"><?php echo @date('Y-m-d',$v['activity_end_date']);?></td>
          <td class="align-center"><?php echo $v['activity_state'] == 1?$lang['activity_openstate_open']:$lang['activity_openstate_close'];?></td>
          <td class="align-center">
          	<a href="index.php?act=activity&op=edit&activity_id=<?php echo $v['activity_id'];?>"><?php echo $lang['nc_edit'];?></a>&nbsp;|&nbsp;
          	<?php if ($v['activity_state'] == 0 || $v['activity_end_date']<time()){?>
          	<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=activity&op=del&activity_id=<?php echo $v['activity_id'];?>';}"><?php echo $lang['nc_del'];?></a>&nbsp;|&nbsp;
          	<?php }?>
          	<a href="index.php?act=activity&op=detail&id=<?php echo $v['activity_id'];?>"><?php echo $lang['activity_index_deal_apply'];?></a>
          </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom" name="chkVal"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/jquery.ui.js";?>"></script> 
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.goods_class.js" charset="utf-8"></script>
<script type="text/javascript">
$("#searchstartdate").datepicker({dateFormat: 'yy-mm-dd'});
$("#searchenddate").datepicker({dateFormat: 'yy-mm-dd'});
function submit_form(op){
	if(op=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
	}
	$('#listop').val(op);
	$('#listform').submit();
}
</script>