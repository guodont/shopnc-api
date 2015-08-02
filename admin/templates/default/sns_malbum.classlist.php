<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_album_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['snsalbum_class_list'];?></span></a></li>
        <li><a href="index.php?act=sns_malbum&op=setting"><span><?php echo $lang['snsalbum_album_setting'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="sns_malbum">
    <input type="hidden" name="op" value="class_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          
          <th><label for="class_name"><?php echo $lang['snsalbum_class_name'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['class_name'];?>" name="class_name" id="class_name" class="txt"></td>
          <th><label for="user_name"><?php echo $lang['snsalbum_member_name'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['user_name'];?>" name="user_name" id="user_name" class="txt"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_goods">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" id="type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w60" colspan="2"><?php echo $lang['snsalbum_class_name'];?></th>
          <th class=""><?php echo $lang['snsalbum_member_name'];?></th>
          <th><?php echo $lang['snsalbum_add_time'];?></th>
          <th class=""><?php echo $lang['snsalbum_pic_count'];?></th>
          <th class="w48 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['ac_list']) && is_array($output['ac_list'])){ ?>
        <?php foreach($output['ac_list'] as $v){?>
        <tr class="hover edit">
          <td></td>
          <td class="w60 picture"><div class="size-44x44"><span class="thumb size-44x44"><i></i><img src="<?php if($v['ac_cover'] != ''){echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$v['member_id'].DS.$v['ac_cover'];}else{echo ADMIN_SITE_URL.'/templates/'.TPL_NAME.'/images/member/default_image.png';}?>" onerror="this.src='<?php echo ADMIN_SITE_URL.'/templates/'.TPL_NAME.'/images/member/default_image.png';?>'" onload="javascript:DrawImage(this,44,44);"/></span></div></td>
          <td><?php echo $v['ac_name'];?></td>
          <td><?php echo $v['member_name'];?></td>
          <td><?php echo date('Y-m-d', $v['upload_time']);?></td>
          <td><?php echo $v['count'];?></td>
          <td class="align-center"><a href="index.php?act=sns_malbum&op=pic_list&id=<?php echo $v['ac_id'];?>"><?php echo $lang['nc_view'];?></a></td>
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
          <td colspan="16">
            <div class="pagination"><?php echo $output['showpage'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>