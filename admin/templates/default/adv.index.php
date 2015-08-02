<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['adv_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=adv_add&ap_id=<?php echo $_GET['ap_id'];?>"><span><?php echo $lang['adv_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" id="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['adv_name'];?></th>
          <th><?php echo $lang['adv_ap_id'];?></th>
          <th class="align-center"><?php echo $lang['adv_class'];?></th>
          <th class="align-center"><?php echo $lang['adv_start_time'];?></th>
          <th class="align-center"><?php echo $lang['adv_end_time'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['adv_info']) && is_array($output['adv_info'])){ ?>
        <?php foreach($output['adv_info'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" class="checkitem" name="del_id[]" value="<?php echo $v['adv_id']; ?>" /></td>
          <td><span title="<?php echo $v['adv_title']; ?>"><?php echo str_cut($v['adv_title'], '36'); ?></span></td>
          <?php
				 foreach ($output['ap_info'] as $ap_k => $ap_v){
				 	if($v['ap_id'] == $ap_v['ap_id']){
				 		?>
          <td><span title="<?php echo $ap_v['ap_name']; ?>"><?php echo str_cut($ap_v['ap_name'], '22'); ?></span></td>
          <td class="align-center"><?php
				 		 switch ($ap_v['ap_class']){
				 		 	case '0':
				 		 		echo $lang['adv_pic'];
				 		 		break;
				 		 	case '1':
				 		 		echo $lang['adv_word'];
				 		 		break;
				 		 	case '3':
				 		 		echo "Flash";
				 		 		break;
				 		 }
				 		?></td>
          <?php }}?>
          <td class="align-center nowrap"><?php echo date('Y-m-d',$v['adv_start_date']); ?></td>
          <td class="align-center nowrap"><?php echo date('Y-m-d',$v['adv_end_date']); ?></td>
          <td class="w72 align-center"><a href="index.php?act=adv&op=adv_edit&adv_id=<?php echo $v['adv_id'];?>"><?php echo $lang['adv_edit'];?></a>&nbsp;|&nbsp;<a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=adv&op=adv_del&adv_id=<?php echo $v['adv_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $output['ap_name'].' '.$lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall"/></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['adv_del_sure'];?>')){$('#store_form').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>