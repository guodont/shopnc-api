<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['db_index_db'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=db&op=db" ><span><?php echo $lang['db_index_backup'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['db_index_restore'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['db_import_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="form_db">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
      <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['db_index_db'];?><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['db_index_name'];?></th>
          <th><?php echo $lang['db_restore_backup_time'];?></th>
          <th class="align-center"><?php echo $lang['db_restore_backup_size'];?></th>
          <th class="align-center"><?php echo $lang['db_restore_volumn'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['dir_list']) && is_array($output['dir_list'])){ ?>
        <?php foreach($output['dir_list'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" class="checkitem" name="dir_name[]" value="<?php echo $v['name'];?>"></td>
          <td class="w25pre"><!--<img fieldid="<?php echo $v['name'];?>" status="open" nc_type="flex" src="<?php echo TEMPLATES_PATH;?>/images/tv-expandable.gif">--> 
            <?php echo $v['name'];?></td>
          <td class="w25pre"><?php echo $v['make_time'];?></td>
          <td class="align-center"><?php echo $v['size'];?></td>
          <td class="align-center"><?php echo $v['file_num'];?></td>
          <td class="w72 align-center"><span> <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=db&op=db_del&dir_name=<?php echo $v['name'];?>'};"><?php echo $lang['nc_del'];?></a>&nbsp;|&nbsp; <a href="javascript:if(confirm('<?php echo $lang['db_index_backup_tip'];?>?')){location.href='index.php?act=db&op=db_import&dir_name=<?php echo $v['name'];?>&step=1'};"><?php echo $lang['db_restore_import'];?></a> </span></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom" name="chkVal"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_db').submit()}"><span><?php echo $lang['nc_del'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.db_dir.js"></script> 
