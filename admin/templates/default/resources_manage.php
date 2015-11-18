<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
    $("#submit").click(function(){
        $("#add_form").submit();
    });
});
</script>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>资源库设置</h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=resources_manage&op=resources_manage_save">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="resources_isuse"><?php echo $lang['resources_isuse'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="cms_isuse_1" class="cb-enable <?php if($output['setting']['resources_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="cms_isuse_0" class="cb-disable <?php if($output['setting']['resources_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="cms_isuse_1" name="resources_isuse" value="1" <?php echo $output['setting']['resources_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="cms_isuse_0" name="resources_isuse" value="0" <?php echo $output['setting']['resources_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['resources_isuse_explain'];?></td>
        </tr>
        <!-- 允许自行发布资源 -->
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['resources_submit_allow'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="cms_attitude_flag_1" class="cb-enable <?php if($output['setting']['resources_submit_flag'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="cms_attitude_flag_0" class="cb-disable <?php if($output['setting']['resources_submit_flag'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="cms_attitude_flag_1" name="resources_submit_flag" value="1" <?php echo $output['setting']['resources_submit_flag']==1?'checked=checked':''; ?>>
            <input type="radio" id="cms_attitude_flag_0" name="resources_submit_flag" value="0" <?php echo $output['setting']['resources_submit_flag']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['resources_submit_allow_explain'];?></td>
        </tr>        
        <!-- 个人发布资源需要审核 -->
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['resource_submit_verify'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="resource_submit_verify_flag_1" class="cb-enable <?php if($output['setting']['resources_submit_verify_flag'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="resource_submit_verify_flag_0" class="cb-disable <?php if($output['setting']['resources_submit_verify_flag'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="resource_submit_verify_flag_1" name="resources_submit_verify_flag" value="1" <?php echo $output['setting']['resources_submit_verify_flag']==1?'checked=checked':''; ?>>
            <input type="radio" id="resource_submit_verify_flag_0" name="resources_submit_verify_flag" value="0" <?php echo $output['setting']['resources_submit_verify_flag']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['resources_submit_verify_explain'];?></td>
        </tr>
        <!-- 允许评论 -->
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['resources_comment_allow'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="cms_comment_flag_1" class="cb-enable <?php if($output['setting']['resources_comment_flag'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="cms_comment_flag_0" class="cb-disable <?php if($output['setting']['resources_comment_flag'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="cms_comment_flag_1" name="resources_comment_flag" value="1" <?php echo $output['setting']['resources_comment_flag']==1?'checked=checked':''; ?>>
            <input type="radio" id="cms_comment_flag_0" name="resources_comment_flag" value="0" <?php echo $output['setting']['resources_comment_flag']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['resources_comment_allow_explain'];?></td>
        </tr>
        
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a id="submit" href="javascript:void(0)" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
