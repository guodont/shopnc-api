<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncp-voucher-exchange">
  <?php if ($output['result'] === true){?>
  <form method="post" action="index.php?act=pointvoucher&op=voucherexchange_save" id="exform" onsubmit="ajaxpost('exform', '', '', 'onerror');">
    <input type="hidden" name="form_submit" value="ok"/>
    <input type="hidden" name="vid" value="<?php echo $output['template_info']['voucher_t_id']; ?>"/>
    <div class="pic"><span><img src="<?php echo $output['template_info']['voucher_t_customimg'];?>" onerror="this.src='<?php echo UPLOAD_SITE_URL.DS.defaultGoodsImage(240);?>'"/></span></div>
    <dl>
      <dt>您正在使用<span class="ml5 mr5"><?php echo $output['template_info']['voucher_t_points'];?></span><?php echo$lang['points_unit'];?>&nbsp;兑换&nbsp;1&nbsp;张<br/>
        <?php echo $output['template_info']['store_name'];?><?php echo $output['template_info']['voucher_t_price'].$lang['currency_zh'];?>店铺代金券（<em>满<?php echo $output['template_info']['voucher_t_limit'];?>减<?php echo $output['template_info']['voucher_t_price'];?></em>）</dt>
      <dd>店铺代金券有效期至<?php echo @date('Y-m-d',$output['template_info']['voucher_t_end_date']);?></dd>
      <dd>
        <?php if ($output['template_info']['voucher_t_eachlimit'] > 0){?>
                            每个ID限领<?php echo $output['template_info']['voucher_t_eachlimit'];?>张
        <?php } else {?>
                            每个ID领取不限量
        <?php }?>
      </dd>
    </dl>
    <div class="button">
      <input type="submit" class="submit" value="兑换"/>
      <a href="javascript:DialogManager.close('vexchange');" class="ncp-btn">取消</a>
    </div>
  </form>
  <?php }else {?>
  <div class="errormsg" style="height:50px; text-align:center;"><?php echo $output['message'];?></div>
  <div style="text-align:center;"><a href="javascript:DialogManager.close('vexchange');" class="ncp-btn">取消</a></div>
  <?php }?>
</div>
