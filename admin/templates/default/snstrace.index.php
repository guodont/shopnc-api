<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['admin_snstrace_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_snstrace_tracelist'];?></span></a></li>
        <li><a href="index.php?act=snstrace&op=commentlist"><span><?php echo $lang['admin_snstrace_commentlist'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="snstrace">
    <input type="hidden" name="op" value="tracelist">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_uname"><?php echo $lang['admin_snstrace_membername'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['search_uname'];?>" name="search_uname" id="search_uname" class="txt"></td>
          <th><label for="search_content"><?php echo $lang['admin_snstrace_content'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['search_content'];?>" name="search_content" id="search_content" class="txt"></td>
          <th><label><?php echo $lang['admin_snstrace_state'];?></label></th>
          <td><select name="search_state">
              <option value=''><?php echo $lang['nc_please_choose'];?>...</option>
              <option value="0" <?php echo $_GET['search_state'] == '0'?'selected':''; ?>><?php echo $lang['admin_snstrace_stateshow'];?></option>
              <option value="1" <?php echo $_GET['search_state'] == '1'?'selected':''; ?>><?php echo $lang['admin_snstrace_statehide'];?></option>
            </select></td>
          <th><label for="search_stime"><?php echo $lang['admin_snstrace_addtime'];?></label></th>
          <td><input type="text" class="txt date" value="<?php echo $_GET['search_stime'];?>" name="search_stime" id="search_stime" class="txt">
            <label for="search_etime">~</label>
            <input type="text" class="txt date" value="<?php echo $_GET['search_etime'];?>" name="search_etime" id="search_etime" class="txt">
            <a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
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
            <li><?php echo $lang['admin_snstrace_tracelisttip1'];?></li>
            <li><?php echo $lang['admin_snstrace_tracelisttip2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_trace">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <?php if(!empty($output['tracelist']) && is_array($output['tracelist'])){ ?>
        <?php foreach($output['tracelist'] as $k => $v){?>
        <tr class="hover edit">
          <td style="vertical-align:top;"><input type="checkbox" name="t_id[]" value="<?php echo $v['trace_id'];?>" class="checkitem"></td>
          <td class="fd-list"><!-- 动态列表start -->
            
            <li>
              <div class="fd-aside"> <span class="thumb size60"><a href="<?php echo SHOP_SITE_URL.DS;?>index.php?act=member_snshome&mid=<?php echo $v['trace_memberid'];?>" target="_blank"> <img src="<?php echo getMemberAvatarForID($v['trace_memberid']);?>" onload="javascript:DrawImage(this,60,60);"> </a> </span> </div>
              <dl class="fd-wrap">
                <dt>
                  <h3><a href="<?php echo SHOP_SITE_URL.DS;?>index.php?act=member_snshome&mid=<?php echo $v['trace_memberid'];?>" target="_blank"><?php echo $v['trace_membername'];?></a><?php echo $lang['nc_colon'];?></h3>
                  <h5><?php echo parsesmiles($v['trace_title']);?></h5>
                </dt>
                <dd>
                  <?php if($v['trace_content'] != ''){?>
                  <?php if ($v['trace_originalid'] > 0  && $v['trace_from'] == 1){//转帖内容?>
                  <div class="fd-forward">
                    <?php if ($v['trace_originalstate'] == 1){ echo $lang['admin_snstrace_originaldeleted']; }else{?>
                    <?php echo parsesmiles($v['trace_content']);?>
                    <div class="stat"> <span><?php echo $lang['admin_snstrace_forward'];?><?php echo $v['trace_orgcopycount']>0?"({$v['trace_orgcopycount']})":''; ?></span>&nbsp;&nbsp; <span><a href="index.php?act=snstrace&op=commentlist&tid=<?php echo $v['trace_originalid'];?>"><?php echo $lang['admin_snstrace_comment']; ?><?php echo $v['trace_orgcommentcount']>0?"({$v['trace_orgcommentcount']})":''; ?></a></span> </div>
                  	<?php }?>
                  </div>
                  <?php } else {?>
                  <?php echo parsesmiles($v['trace_content']);?>
                  <?php }?>
                  <?php }?>
                </dd>
                <dd> <span class="fc-time fl"><?php echo date('Y-m-d H:i',$v['trace_addtime']);?></span> <span class="fr"><?php echo $lang['admin_snstrace_forward'];?><?php echo $v['trace_copycount']>0?"({$v['trace_copycount']})":'';?>&nbsp;|&nbsp;<a href="index.php?act=snstrace&op=commentlist&tid=<?php echo $v['trace_id'];?>"><?php echo $lang['admin_snstrace_comment']; ?><?php echo $v['trace_commentcount']>0?"({$v['trace_commentcount']})":'';?></a></span> <span class="fl">&nbsp;&nbsp;<?php echo $lang['admin_snstrace_state'].$lang['nc_colon'];?><?php echo $v['trace_state']==1?"<font style='color:red;'>{$lang['admin_snstrace_statehide']}</font>":"{$lang['admin_snstrace_stateshow']}";?></span> <span class="fl">&nbsp;&nbsp;<?php echo $lang['admin_snstrace_privacytitle'].$lang['nc_colon'];?>
                  <?php switch($v['trace_privacy']){
			          		case '1':
			          			echo $lang['admin_snstrace_privacy_friend'];
			          			break;
			          		case '2':
			          			echo $lang['admin_snstrace_privacy_self'];
			          			break;
			          		default:
			          			echo $lang['admin_snstrace_privacy_all'];
			          			break;
			          	}?>
                  </span> </dd>
                <div class="clear"></div>
              </dl>
            </li>
            
            <!-- 动态列表end --></td>
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
          <td class="w24"><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a> <a href="JavaScript:void(0);" class="btn" onclick="submit_form('hide');"><span><?php echo $lang['admin_snstrace_statehide'];?></span></a> <a href="JavaScript:void(0);" class="btn" onclick="submit_form('show');"><span><?php echo $lang['admin_snstrace_stateshow'];?></span></a>
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
		$('#form_trace').attr('action','index.php?act=snstrace&op=tracedel');
	}else if(type=='hide'){
		$('#form_trace').attr('action','index.php?act=snstrace&op=traceedit&type=hide');
	}else{
		$('#form_trace').attr('action','index.php?act=snstrace&op=traceedit&type=show');
	}
	$('#form_trace').submit();
}
</script>