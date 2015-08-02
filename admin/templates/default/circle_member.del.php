<?php defined('InShopNC') or exit('Access Invalid!');?>
<form method="post" id="delmember" name="delmember" action="index.php?act=circle_member&op=member_del&param=<?php echo $_GET['param'];?>">
    <input type="hidden" name="form_submit" value="ok"/>
    <dl><dd style="padding:10px 30px;"><p><?php echo $lang['circle_member_del_confirm'];?></p></dd></dl>
    <dl>
      <dd style="padding:10px 30px;">
        <label><input type="checkbox" name="all" value="1"  />同时删除所有帖子</label>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd style="padding:10px 30px;">
        <a id="fwin_dialog_submit" class="btn" onclick="document.delmember.submit();" href="javascript:void(0)"><span>确定</span></a>
        <a id="fwin_dialog_cancel" class="btn" onclick="DialogManager.close('delmember');" href="javascript:void(0)"><span>取消</span></a>
      </dd>
    </dl>
</form>
