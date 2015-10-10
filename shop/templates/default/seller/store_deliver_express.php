<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<form method="POST" id='express_form' action="index.php?act=store_deliver_set&op=express" onsubmit="ajaxpost('express_form', '', '', 'onerror');return false;">
  <input value="ok" name="form_submit" type="hidden">
  <table class="ncsc-default-table" >
    <thead>
      <tr>
        <th class="w20"></th>
        <th colspan="4" class="tm"><?php echo $lang['store_deliver_express_title'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['express_list']) && is_array($output['express_list'])){?>
      <tr class="bd-line">
        <td></td>
        <?php $i = 1;?>
        <?php foreach($output['express_list'] as $key=>$value){?>
        <td class="tl"><label>
            <input type="checkbox" name="cexpress[]" <?php if (in_array($key,$output['express_select'])) echo 'checked';?> value="<?php echo $key;?>">
            <?php echo $value['e_name'];?></label></td>
        <?php if ($i%4 == 0){?>
      </tr>
      <tr class="bd-line">
        <td></td>
        <?php };$i++;?>
        <?php }?>
      </tr>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="20" class="bottom"><label class="submit-border"><input class="submit" type="submit" value="<?php echo $lang['nc_common_button_save'];?>"></label></td>
      </tr>
    </tfoot>
  </table>
</form>
