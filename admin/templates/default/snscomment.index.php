<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['admin_snstrace_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=snstrace&op=tracelist"><span><?php echo $lang['admin_snstrace_tracelist'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_snstrace_commentlist'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="snstrace">
    <input type="hidden" name="op" value="commentlist">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_uname"><?php echo $lang['admin_snstrace_membername'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['search_uname'];?>" name="search_uname" id="search_uname" class="txt"></td>
          <th><label for="search_content"><?php echo $lang['admin_snstrace_content'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['search_content'];?>" name="search_content" id="search_content" class="txt"></td>
          <th><label><?php echo $lang['admin_snstrace_state'];?></label></th>
          <td>
          	<select name="search_state">
              <option value=''><?php echo $lang['nc_please_choose'];?>...</option>
              <option value="0" <?php echo $_GET['search_state'] == '0'?'selected':''; ?>><?php echo $lang['admin_snstrace_stateshow'];?></option>
              <option value="1" <?php echo $_GET['search_state'] == '1'?'selected':''; ?>><?php echo $lang['admin_snstrace_statehide'];?></option>
            </select>
           </td>
           <th><label for="search_stime"><?php echo $lang['admin_snstrace_addtime'];?></label></th>
           <td>
           	<input type="text" class="txt date" value="<?php echo $_GET['search_stime'];?>" name="search_stime" id="search_stime" class="txt">
          	<label for="search_etime">~</label>
          	<input type="text" class="txt date" value="<?php echo $_GET['search_etime'];?>" name="search_etime" id="search_etime" class="txt">
           <a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
          </td>
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
            <li><?php echo $lang['admin_snstrace_commentlisttip'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_comment">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th><?php echo $lang['admin_snstrace_content'];?></th>
          <th class="w150 align-center"><?php echo $lang['admin_snstrace_membername'];?></th>
          <th class="w150 align-center"><?php echo $lang['admin_snstrace_addtime'];?></th>
          <th class="w150 align-center">IP</th>
          <th class="w150 align-center"><?php echo $lang['admin_snstrace_state'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['commentlist']) && is_array($output['commentlist'])){ ?>
        <?php foreach($output['commentlist'] as $k => $v){?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="c_id[]" value="<?php echo $v['comment_id'];?>" class="checkitem"></td>
          <td><?php echo parsesmiles($v['comment_content']);?></td>
          <td class="w150 align-center"><?php echo $v['comment_membername'];?></td>
          <td class="w150 align-center"><?php echo @date('Y-m-d H:i:s',$v['comment_addtime']);?></td>
          <td class="w150 align-center"><?php echo $v['comment_ip'];?></td>
          <td class="w150 align-center"><?php echo $v['comment_state']==1?$lang['admin_snstrace_statehide']:$lang['admin_snstrace_stateshow'];?></td>
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
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;
            <a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <a href="JavaScript:void(0);" class="btn" onclick="submit_form('hide');"><span><?php echo $lang['admin_snstrace_statehide'];?></span></a>
            <a href="JavaScript:void(0);" class="btn" onclick="submit_form('show');"><span><?php echo $lang['admin_snstrace_stateshow'];?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#search_stime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#search_etime').datepicker({dateFormat: 'yy-mm-dd'});
});
function submit_form(type){
	if(type=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
		$('#form_comment').attr('action','index.php?act=snstrace&op=commentdel');
	}else if(type=='hide'){
		$('#form_comment').attr('action','index.php?act=snstrace&op=commentedit&type=hide');
	}else{
		$('#form_comment').attr('action','index.php?act=snstrace&op=commentedit&type=show');
	}
	$('#form_comment').submit();
}
</script>