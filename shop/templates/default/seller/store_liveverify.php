<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-form-default pt10">
  <form id="add_form" action="index.php?act=store_liveorder&op=store_liveverify" method="post"  onsubmit="ajaxpost('add_form','','','onerror')">
    <dl>
      <dt><i class="required">*</i>线下抢购兑换码：</dt>
      <dd>
        <input class="w400 text" name="order_pwd" type="text" id="order_pwd" value="" maxlength="13"  />
        <span></span>
        <p class="hint">请输入买家提供的13位兑换码数字，核对无误后提交，每个兑换码抵消单笔消费。</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="submit" class="submit" value="提交验证">
      </label>
    </div>
  </form>
</div>
