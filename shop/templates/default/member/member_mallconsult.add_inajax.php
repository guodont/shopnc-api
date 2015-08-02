<div class="eject_con">
  <div id="warning"></div>
    <form id="mallconsult_form" method="post" action="<?php echo urlShop('member_mallconsult', 'save_mallconsult');?>">
    <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt>咨询类型<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <div><select name="type_id" id="type_id">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php if (!empty($output['type_list'])) {?>
            <?php foreach ($output['type_list'] as $val) {?>
            <option value="<?php echo $val['mct_id'];?>"><?php echo $val['mct_name'];?></option>
            <?php }?>
            <?php }?>
            </select>
            <p class="hint">选择您要对平台客服咨询的类型。</p></div>
          <div>
            <div></div>
            <?php if (!empty($output['type_list'])) {?>
            <?php foreach ($output['type_list'] as $val) {?>
            <div style="display:none;"><?php echo html_entity_decode($val['mct_introduce']);?></div>
            <?php }?>
            <?php }?>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>咨询内容<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <textarea id="consult_content" name="consult_content" class="textarea w400 h100" ></textarea>
          <p class="hint">输入您要咨询的问题内容，注意商品类咨询应注明“商品名称”或“链接地址”，<br />订单类咨询应注明“订单编号”，方便平台工作人员及时处理并回复。<br/>
          咨询内容请不要超过200字。</p>
        </dd>
      </dl>
      <div class="bottom">
        <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"/></label>
      </div>
    </form>
</div>
<script>
$(function(){
    $('#mallconsult_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
        submitHandler:function(form){
            ajaxpost('mallconsult_form', '', '', 'onerror');
        },
        rules : {
            type_id : {
                required : true,
                min : 1
            },
            consult_content : {
                required : true
            }
        },
        messages : {
            type_id  : {
                required  : '<i class="icon-exclamation-sign"></i>请选择咨询类型',
                min : '<i class="icon-exclamation-sign"></i>请选择咨询类型'
            },
            consult_content : {
                required : '<i class="icon-exclamation-sign"></i>请填写咨询内容'
            }
        }
    });
});

</script> 
