<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['circle_memberlevel'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_memberlevel"><span><?php echo $lang['circle_defaultlevel'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['circle_memberlevelref'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=ref_add"><span><?php echo $lang['circle_memberleveladd'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=update_cache"><span><?php echo $lang['nc_circle_cache'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="clmdForm" id="clmdForm">
    <input type="hidden" name="form_submit" value="ok" />          
    <table class="table tb-type2 nomargin">
        <thead>
          <tr class="thead">
            <th class="w24"></th>
            <th><?php echo $lang['circle_memberlevelgroup'];?></th>
            <th><?php echo $lang['circle_addtime'];?></th>
            <th class="align-center"><?php echo $lang['nc_status'];?></th>
            <th><?php echo $lang['nc_handle'];?></th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($output['mlref_list'])){?>
          <?php foreach($output['mlref_list'] as $val){?>
          <tr>
            <td><input class="checkitem" type="checkbox" value="<?php echo $val['mlref_id'];?>" name="del_id[]"></td>
            <td><?php echo $val['mlref_name'];?></td>
            <td><?php echo date('Y-m-d H:i:s', $val['mlref_addtime']);?></td>
            <td class="align-center yes-onoff">
              <a href="JavaScript:void(0);" class="<?php echo $val['mlref_status']? 'enabled' : 'disabled' ;?>" ajax_branch="status" nc_type="inline_edit" fieldname="mlref_status" fieldid="<?php echo $val['mlref_id']?>" fieldvalue="<?php echo $val['mlref_status']? '1' : '0' ;?>" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif" /></a>
            </td>
            <td><a href="index.php?act=circle_memberlevel&op=ref_edit&mlref_id=<?php echo $val['mlref_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=circle_memberlevel&op=ref_del&mlref_id=<?php echo $val['mlref_id'];?>'}"><?php echo $lang['nc_del'];?></a></td>
          </tr>
          <?php } ?>
          <?php }else { ?>
          <tr class="no_data">
            <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
          </tr>
          <?php }?>
        </tbody>
        <tfoot>
	    <tr class="tfoot">
	      <td>
            <input id="checkallBottom" class="checkall" type="checkbox">
          </td>
	      <td colspan="20"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#clmdForm').submit();}"><span><?php echo $lang['nc_del'];?></span></a></td>
	    </tr>
	  </tfoot>
 	</table>
 </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 