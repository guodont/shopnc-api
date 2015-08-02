<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3>物流自提服务站管理</h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('delivery', 'index');?>"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('delivery', 'index', array('sign' => 'verify'));?>"><span>等待审核</span></a></li>
        <li><a href="javascript:void(0);" class="current"><span>设置</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="setting_form" method="post" action="<?php echo urlAdmin('delivery', 'save_setting');?>">
    <input type="hidden" id="form_submit" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="promotion_booth_price">物流自提服务站是否开启<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
        <td class="vatop rowform onoff"><label for="site_status1" class="cb-enable <?php if($output['list_setting']['delivery_isuse'] == '1'){ ?>selected<?php } ?>" ><span>开启</span></label>
            <label for="site_status0" class="cb-disable <?php if($output['list_setting']['delivery_isuse'] == '0'){ ?>selected<?php } ?>" ><span>关闭</span></label>
            <input id="site_status1" name="delivery_isuse" <?php if($output['list_setting']['delivery_isuse'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="site_status0" name="delivery_isuse" <?php if($output['list_setting']['delivery_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="<?php echo $output['dlyp_info']['dlyp_state'];?>" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2">现在去设置物流自提服务站使用的快递公司，<a onclick="window.parent.openItem('index,express,setting');" href="JavaScript:void(0);">快递公司</a></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(function(){
    $("#submitBtn").click(function(){
        $("#setting_form").submit();
    });
});
</script>