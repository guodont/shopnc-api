<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['cache_cls_operate'];?></h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="cache_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table nobdb">
      <tbody>
        <tr>
          <td colspan="2"><table class="table nomargin">
              <tbody>
                <tr>
                  <td class="required"><input id="cls_full" name="cls_full" value="1" type="checkbox">
                    &nbsp;
                    <label for="cls_full"><?php echo $lang['cache_cls_all'];?></label></td>
                </tr>
                <tr class="noborder">
                  <td class="vatop rowform"><ul class="nofloat w830">
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" value="setting" >
                          &nbsp;<?php echo $lang['cache_cls_seting'];?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" value="goodsclass" >
                          &nbsp;<?php echo $lang['cache_cls_category'];?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" value="adv" >
                          &nbsp;<?php echo $lang['cache_cls_adv'];?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="groupbuy_price" value="groupbuy_price" >
                          &nbsp;抢购价格区间</label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="nav" value="nav" >
                          &nbsp;<?php echo $lang['cache_cls_nav'];?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="index" value="index" >
                          &nbsp;<?php echo $lang['cache_cls_index'];?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="table" value="table" >
                          &nbsp;<?php echo $lang['cache_cls_table'];?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="seo" value="seo" >
                          &nbsp;SEO</label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="express" value="express" >
                          &nbsp;<?php echo $lang['cache_cls_express']?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="store_class" value="store_class" >
                          &nbsp;<?php echo $lang['cache_cls_store_class']?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="store_grade" value="store_grade" >
                          &nbsp;<?php echo $lang['cache_cls_store_grade']?></label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="store_msg_tpl" value="store_msg_tpl" >
                          &nbsp;商家消息模板</label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="member_msg_tpl" value="member_msg_tpl" >
                          &nbsp;用户消息模板</label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="consult_type" value="consult_type" >
                          &nbsp;咨询类型</label>
                      </li>
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" id="circle_level" value="circle_level" >
                          &nbsp;<?php echo $lang['cache_cls_circle_level']?></label>
                      </li>
                    </ul></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表
$(function(){
	$("#submitBtn").click(function(){
		if($('input[name="cache[]"]:checked').size()>0){
			$("#cache_form").submit();
		}
	});

	$('#cls_full').click(function(){
		$('input[name="cache[]"]').attr('checked',$(this).attr('checked') == 'checked');
	});
});
</script>
