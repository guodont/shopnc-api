<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['activity_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=activity&op=activity" ><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=activity&op=new" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['activity_index_deal_apply'];?></span></a></li>
      </ul>
    </div>
  </div>

  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
  	<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="act" value="activity">
    <input type="hidden" name="op" value="detail">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="searchtitle"><?php echo $lang['activity_detail_index_store']; ?></label></th>
          <td><input type="text" name="searchstore" id="searchstore" class="txt" value='<?php echo $_GET['searchstore'];?>'></td>
          <th><label for="searchtitle"><?php echo $lang['activity_detail_index_goods_name']; ?></label></th>
          <td><input type="text" name="searchgoods" id="searchgoods" class="txt" value='<?php echo $_GET['searchgoods'];?>'></td>
          <td><select name="searchstate">
              <option value="0" <?php if (!$_GET['searchstate']){echo 'selected=selected';}?>><?php echo $lang['activity_detail_index_auditstate']; ?></option>
              <option value="1" <?php if ($_GET['searchstate'] == 1){echo 'selected=selected';}?>><?php echo $lang['activity_detail_index_to_audit']; ?></option>
              <option value="2" <?php if ($_GET['searchstate'] == 2){echo 'selected=selected';}?>><?php echo $lang['activity_detail_index_passed']; ?></option>
              <option value="3" <?php if ($_GET['searchstate'] == 3){echo 'selected=selected';}?>><?php echo $lang['activity_detail_index_unpassed']; ?></option>
            </select>
          </td>
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
            <li><?php echo $lang['activity_detail_index_tip1'];?></li>
            <li><?php echo $lang['activity_detail_index_tip2'];?></li>
            <li><?php echo $lang['activity_detail_index_tip3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>

  <form method='post' action="index.php" id="listform">
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['activity_detail_index_goods_name']; ?></th>
          <th><?php echo $lang['activity_detail_index_store'];?></th>
          <th class="align-center"><?php echo $lang['nc_status'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" name='activity_detail_id[]' value="<?php echo $v['activity_detail_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span class=" editable" title="<?php echo $lang['nc_editable'];?>" style="cursor:pointer;"  required="1" fieldid="<?php echo $v['activity_detail_id'];?>" ajax_branch='activity_detail_sort' fieldname="activity_detail_sort" nc_type="inline_edit"><?php echo $v['activity_detail_sort'];?></span></td>
          <td><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=goods&goods_id=<?php echo $v['item_id']?>"><?php echo $v['item_name'];?></a></td>
          <td><a href="<?php echo urlShop('show_store','index', array('store_id'=>$v['store_id']));?>"><?php echo $v['store_name'];?></a></td>
          <td class="align-center">
          	<?php switch($v['activity_detail_state']){
					case '0':echo $lang['activity_detail_index_to_audit'];break;
					case '1':echo $lang['activity_detail_index_passed'];break;
					case '2':echo $lang['activity_detail_index_unpassed'];break;
					//case '3':echo $lang['activity_detail_index_apply_again'];break;
				}?>
		  </td>
          <td class="w150 align-center">
          	<?php if($v['activity_detail_state']!='1'){?>
            	<a href="index.php?act=activity&op=deal&activity_detail_id=<?php echo $v['activity_detail_id'];?>&state=1"><?php echo $lang['activity_detail_index_pass'];?></a>
            <?php }?>
            <?php if($v['activity_detail_state']=='0'){?>
            	&nbsp;|&nbsp;
            <?php }?>
            <?php if($v['activity_detail_state']!='2'){?>
            	<a href="index.php?act=activity&op=deal&activity_detail_id=<?php echo $v['activity_detail_id'];?>&state=2"><?php echo $lang['activity_detail_index_refuse'];?></a>
            <?php }?>
            <?php if ($v['activity_detail_state']=='0' || $v['activity_detail_state']=='2'){?>
            	&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=activity&op=del_detail&activity_detail_id=<?php echo $v['activity_detail_id'];?>';}"><?php echo $lang['nc_del'];?></a></td>
            <?php }?>
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
          <td colspan="16" id="batchAction">
          	<label for="checkall_1"><?php echo $lang['nc_select_all']; ?></label>&nbsp;&nbsp;
            <a href="JavaScript:void(0);" class="btn" onclick="javascript:submit_form('pass');"><span><?php echo $lang['activity_detail_index_pass'];?></span></a>
            <a href="JavaScript:void(0);" class="btn" onclick="javascript:submit_form('refuse');"><span><?php echo $lang['activity_detail_index_refuse'];?></span></a>
            <a href="JavaScript:void(0);" class="btn" onclick="javascript:submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['show_page'];?></div>
          </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.goods_class.js" charset="utf-8"></script>
<script type="text/javascript">
function submit_form(op){
	if(op=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
		$('#listform').attr('action','index.php?act=activity&op=del_detail');
	}else if(op=='pass'){
		if(!confirm('<?php echo $lang['activity_detail_index_pass_all'];?>')){
			return false;
		}
		$('#listform').attr('action','index.php?act=activity&op=deal&state=1');
	}else if(op=='refuse'){
		if(!confirm('<?php echo $lang['activity_detail_index_refuse_all'];?>')){
			return false;
		}
		$('#listform').attr('action','index.php?act=activity&op=deal&state=2');
	}
	$('#listform').submit();
}
</script>
