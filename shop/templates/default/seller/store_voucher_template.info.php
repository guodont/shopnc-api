
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
<dl>
  <dt><em class="pngFix"></em><?php echo $lang['voucher_template_title'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_title'];?></dd>
</dl>
<dl>
  <dt><em class="pngFix"></em><?php echo $lang['voucher_template_enddate'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_end_date']?@date('Y-m-d',$output['t_info']['voucher_t_end_date']):'';?></dd>
</dl>
<dl>
  <dt><?php echo $lang['voucher_template_price'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_price'];?>&nbsp;<?php echo $lang['currency_zh'];?></dd>
</dl>
<dl>
  <dt ><em class="pngFix"></em><?php echo $lang['voucher_template_total'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_total']; ?>&nbsp;<?php echo $lang['voucher_template_eachlimit_unit'];?></dd>
</dl>
<dl>
  <dt ><em class="pngFix"></em><?php echo $lang['voucher_template_eachlimit'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_eachlimit'];?>&nbsp;<?php echo $lang['voucher_template_eachlimit_unit'];?></dd>
</dl>
<dl>
  <dt ><em class="pngFix"></em><?php echo $lang['voucher_template_orderpricelimit'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_limit'];?>&nbsp;<?php echo $lang['currency_zh'];?></dd>
</dl>
<dl>
  <dt ><em class="pngFix"></em><?php echo $lang['voucher_template_describe'].$lang['nc_colon']; ?></dt>
  <dd>
    <textarea  name="txt_template_describe" rows="3" class="w300" readonly><?php echo $output['t_info']['voucher_t_desc'];?></textarea>
  </dd>
</dl>
<dl>
  <dt ><em class="pngFix"></em><?php echo $lang['voucher_template_image'].$lang['nc_colon']; ?></dt>
  <dd>
    <div style="clear:both; padding-top:10px;">
      <?php if ($output['t_info']['voucher_t_customimg']){?>
      <img onload="javascript:DrawImage(this,220,95);" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.$output['t_info']['voucher_t_customimg'];?>"/>
      <?php }?>
    </div>
  </dd>
</dl>
<dl>
  <dt><em class="pngFix"></em><?php echo $lang['nc_status'].$lang['nc_colon']; ?></dt>
  <dd>
    <?php foreach ($output['templatestate_arr'] as $k=>$v){?>
    <?php if ($v[0] == $output['t_info']['voucher_t_state']){ echo $v[1];}?>
    <?php }?>
  </dd>
</dl>
<dl>
  <dt><em class="pngFix"></em><?php echo $lang['voucher_template_giveoutnum'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_giveout'];?>&nbsp;<?php echo $lang['voucher_template_eachlimit_unit'];?></dd>
</dl>
<dl>
  <dt><em class="pngFix"></em><?php echo $lang['voucher_template_usednum'].$lang['nc_colon']; ?></dt>
  <dd><?php echo $output['t_info']['voucher_t_used'];?>&nbsp;<?php echo $lang['voucher_template_eachlimit_unit'];?></dd>
</dl>
<div class="bottom"> <a href="javascript:void(0);" class="submit" onclick="window.location='index.php?act=store_voucher&op=templatelist'" > <?php echo $lang['voucher_template_backlist'];?></a> </div>
