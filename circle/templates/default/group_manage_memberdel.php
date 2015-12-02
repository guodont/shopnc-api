<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="eject_con">
<form method="post" id="delmember" name="delmember" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=delmember&c_id=<?php echo $_GET['c_id'];?>&cm_id=<?php echo $_GET['cm_id'];?>">
    <input type="hidden" name="form_submit" value="ok"/>
    <dl><dd><p><?php echo $lang['nc_ensure_del'];?></p></dd></dl>
    <dl>
      <dd>
        <label><input type="checkbox" name="all" value="1"  />同时删除所有帖子</label>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <a id="fwin_dialog_submit" class="submit-btn" onclick="ajaxpost('delmember', '', '', 'onerror');" href="javascript:void(0)">确定</a>
        <a id="fwin_dialog_cancel" class="submit-btn" onclick="DialogManager.close('delmember');" href="javascript:void(0)">取消</a>
      </dd>
    </dl>
</form>
</div>