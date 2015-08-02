<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div id="ncmInformFlow" class="ncm-flow-container">
    <div class="title">
      <h3>咨询平台客服</h3>
    </div>
    <div class="ncm-flow-step">
      <dl class="step-first current">
        <dt>填写咨询内容</dt>
        <dd class="bg"></dd>
      </dl>
      <dl class="">
        <dt>平台客服回复</dt>
        <dd class="bg"> </dd>
      </dl>
      <dl class="">
        <dt>咨询完成</dt>
        <dd class="bg"> </dd>
      </dl>
    </div>
    <div class="ncm-default-form">
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
            <span class="error"></span></div>
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
          <textarea id="consult_content" name="consult_content" class="textarea w400" ></textarea>
          <br>
          <span class="error"></span>
        </dd>
      </dl>
      <div class="bottom">
        <label class="submit-border">
          <input type="submit" class="submit" value="确认提交" />
        </label>
        <a href="javascript:history.go(-1);" class="ncm-btn ml10">取消并返回</a> </div>
    </form>
    </div>
  </div>
  <div class="ncm-flow-item">
    <div class="title">温馨提示</div>
    <div class="content">
      <div class="alert">
        <ul>
          <li> 1.如果您对商品规格、介绍等有疑问，可以在商品详情页“购买咨询”处发起咨询，会得到及时专业的回复；</li>
          <li> 2.如需处理交易中产生的纠纷，请选择投诉；</li>
          <li> 3.咨询时选择咨询类型，填写咨询内容（必填，不超过200字）。请尽量详细填写您要咨询的内容，以方便我们用最短的时间解决您的疑问。</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
    $('#type_id').change(function(){
        $_index = $(this).children('option:selected').index();
        $_introduce = $(this).parent().next();
        $_introduce.children().hide();
        $_introduce.children(':eq('+$_index+')').show();
    });
    $('#mallconsult_form').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.nextAll('span.error'));
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
