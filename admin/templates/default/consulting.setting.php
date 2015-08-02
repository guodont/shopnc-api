<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['consulting_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('consulting', 'consulting');?>"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>设置</span></a></li>
        <li><a href="<?php echo urlAdmin('consulting', 'type_list');?>"><span>咨询类型</span></a></li>
        <li><a href="<?php echo urlAdmin('consulting', 'type_add');?>"><span>新增类型</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
          <li>在商品详细页咨询选项卡头部显示的文字提示。</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" name="form_consultingsetting">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td class="required"><label>咨询头部文件提示:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php showEditor('consult_prompt', $output['setting_list']['consult_prompt']);?></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_consultingsetting.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
