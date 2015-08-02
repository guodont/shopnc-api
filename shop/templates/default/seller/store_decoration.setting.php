<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="form_setting" method="post" action="<?php echo urlShop('store_decoration', 'decoration_setting_save');?>">
    <dl>
      <dt>启用店铺装修<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <label for="store_decoration_switch_on" class="mr30">
          <input id="store_decoration_switch_on" type="radio" class="radio vm mr5" name="store_decoration_switch" value="1" <?php echo $output['store_decoration_switch'] > 0?'checked':'';?>>
          是</label>
        <label for="store_decoration_switch_off">
          <input id="store_decoration_switch_off" type="radio" class="radio vm mr5" name="store_decoration_switch" value="0" <?php echo $output['store_decoration_switch'] == 0?'checked':'';?>>
          否</label>
        <p class="hint">选择是否使用店铺装修模板；<br/>
          如选择“是”，店铺首页背景、头部、导航以及上方区域都将根据店铺装修模板所设置的内容进行显示；<br/>
          如选择“否”根据 <a href="index.php?act=store_setting&op=theme">“店铺主题”</a> 所选中的系统预设值风格进行显示。</p>
      </dd>
    </dl>
    <dl>
      <dt>仅显示装修内容<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <label for="store_decoration_only_on" class="mr30">
          <input id="store_decoration_only_on" type="radio" class="radio vm mr5" name="store_decoration_only" value="1" <?php echo $output['store_decoration_only'] > 0?'checked':'';?>>
          是</label>
        <label for="store_decoration_only_off">
          <input id="store_decoration_only_off" type="radio" class="radio vm mr5" name="store_decoration_only" value="0" <?php echo $output['store_decoration_only'] == 0?'checked':'';?>>
          否</label>
        <p class="hint">该项设置如选择“是”，则店铺首页仅显示店铺装修所设定的内容；<br/>
          如选择“否”则按标准默认风格模板延续显示页面下放内容，即左侧店铺导航、销售排行，右侧轮换广告、最新商品、推荐商品等相关店铺信息。</p>
      </dd>
    </dl>
    <dl>
      <dt>店铺装修<?php echo $lang['nc_colon'];?></dt>
      <dd> <a href="<?php echo urlShop('store_decoration', 'decoration_edit', array('decoration_id' => $output['decoration_id']));?>" class="ncsc-btn ncsc-btn-acidblue mr5" target="_blank"><i class="icon-puzzle-piece"></i>装修页面</a> <a id="btn_build" href="<?php echo urlShop('store_decoration', 'decoration_build', array('decoration_id' => $output['decoration_id']));?>" class="ncsc-btn ncsc-btn-orange" target="_blank"><i class="icon-magic"></i>生成页面</a>
        <p class="hint">点击“装修页面”按钮，在新窗口对店铺首页进行装修设计；<br/>
          预览效果满意后，点击“生成页面”按钮则可将预览效果保存为您的“店铺装修”风格模板。</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input id="btn_submit" type="button" class="submit" value="提交" />
      </label>
    </div>
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_submit').on('click', function() {
            ajaxpost('form_setting', '', '', 'onerror');
        });

        $('#btn_build').on('click', function() {
            $.getJSON($(this).attr('href'), function(data) {
                if(typeof data.error == 'undefined') {
                    showSucc(data.message);
                } else {
                    showError(data.error);
                }
            });
            return false;
        });
    });
</script> 
