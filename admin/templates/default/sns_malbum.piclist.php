<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_album_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=sns_malbum&op=class_list"><span><?php echo $lang['snsalbum_class_list'];?></span></a></li>
        <li><a href="index.php?act=sns_malbum&op=setting"><span><?php echo $lang['snsalbum_album_setting'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['snsalbum_pic_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="sns_malbum">
    <input type="hidden" name="op" value="pic_list">
    <input type="hidden" name="id" value="<?php echo $output['id'];?>" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="pic_name"><?php echo $lang['snsalbum_pic_name'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['pic_name'];?>" name="pic_name" id="pic_name" class="txt"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_pic">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <?php if(!empty($output['pic_list'])){ ?>
      	<tr><td colspan="20"><ul class="thumblists">
          <?php foreach($output['pic_list'] as $val){?>
          <li class="picture">
            <div class="size-64x64">
              <span class="thumb">
                <i></i><img width="64" height="64" class="show_image" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$val['member_id'].DS.str_ireplace('.', '_240.', $val['ap_cover']);?>" />
                <span class="type-file-preview" style="display: none;">
                  <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$val['member_id'].DS.str_ireplace('.', '_240.', $val['ap_cover']);?>">
                </span>
              </span>
            </div>
            <p>
              <span><input class="checkitem" type="checkbox" name="id[]" value="<?php echo $val['ap_id'];?>" /></span><span><a href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=sns_malbum&op=del_pic&id=<?php echo $val['ap_id'];?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></span>
            </p>
          </li>
          <?php } ?>
      	</ul></td></tr>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td class="w48"><input id="checkallBottom" class="checkall" type="checkbox" /></td>
          <td colspan="16">
            <label for="checkallBottom"><?php echo $lang['nc_select_all'];?></label>
            <a class="btn" href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_pic').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['showpage'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>