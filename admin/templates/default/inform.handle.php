<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['inform_manage_title'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {   ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  }  ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['inform_text_handle'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="handle_form" method="post"  action="index.php?act=inform&op=inform_handle" name="form1">
    <input id="inform_id" name="inform_id" type="hidden" value="<?php echo $output['inform_id'];?>"/>
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label> <?php echo $lang['inform_goods_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" id="goods_name"><?php echo $output['inform_goods_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['inform_handle_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul>
              <li><label>
                <input type="radio" value="1" name="inform_handle_type">
                <?php echo $lang['inform_handle_type_unuse_message'];?> </label></li>
              <li><label>
                <input type="radio" value="2" name="inform_handle_type">
                <?php echo $lang['inform_handle_type_venom_message'];?> </label></li>
              <li><label>
                <input type="radio" value="3" name="inform_handle_type">
                <?php echo $lang['inform_handle_type_valid_message'];?> </label></li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['inform_handle_message'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea class="tarea" name="inform_handle_message" rows="6" id="inform_handle_message"></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="btn_handle_submit"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //默认选中第一个radio
    $(":radio").first().attr("checked",true);
    $("#btn_handle_submit").click(function(){
        if($("#inform_handle_message").val()=='') {
            alert("<?php echo $lang['inform_handle_message_null'];?>");
        }
        else {
            if(confirm("<?php echo $lang['inform_handle_confirm'];?>")) {
                $("#handle_form").submit();
            }
        }
    });
});
</script>
