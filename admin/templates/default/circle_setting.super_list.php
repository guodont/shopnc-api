<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_setting'];?></h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('circle_setting', 'index');?>"><span><?php echo $lang['nc_circle_setting'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'seo');?>"><span><?php echo $lang['circle_setting_seo'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'sec');?>"><span><?php echo $lang['circle_setting_sec'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'exp');?>"><span><?php echo $lang['circle_setting_exp'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'superadd');?>"><span>设置超管</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>超管列表</span></a></li>
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
            <th>会员名称</th>
            <th>添加时间</th>
            <th><?php echo $lang['nc_handle'];?></th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($output['cm_list'])){?>
          <?php foreach($output['cm_list'] as $val){?>
          <tr>
            <td><input class="checkitem" type="checkbox" value="<?php echo $val['member_id'];?>" name="del_id[]"></td>
            <td><?php echo $val['member_name'];?></td>
            <td><?php echo date('Y-m-d H-i:s', $val['cm_jointime']);?></td>
            <td><a href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='<?php echo urlAdmin('circle_setting', 'del_super', array('member_id' => $val['member_id']));?>'}"><?php echo $lang['nc_del'];?></a></td>
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