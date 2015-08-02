<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store_grade'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store_grade&op=store_grade" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store_grade&op=store_grade_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="sg_id" value="<?php echo $output['grade_array']['sg_id'];?>" />
    <ul style="margin: 5px; width: 100%;">
      <?php if(!empty($output['dir_list']) && is_array($output['dir_list'])){ ?>
      <?php foreach($output['dir_list'] as $k => $v){ ?>
      <li style="float: left; text-align: center; margin: 5px;"> <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/templates/<?php echo TPL_SHOP_NAME;?>/store/style/<?php echo $v;?>/screenshot.jpg"><img width="160" height="120" src="<?php echo SHOP_SITE_URL;?>/templates/<?php echo TPL_SHOP_NAME;?>/store/style/<?php echo $v;?>/images/preview.jpg" style="border: 1px solid #ccc;"></a><br>
        <?php if ($v == 'default'){?>
        <input type="checkbox" value="default" name="template[]" disabled="disabled" checked="checked">
    		<input type="hidden" value="default" name="template[]" />
        <?php }else {?>
        <input type="checkbox" <?php if(@in_array($v,$output['grade_array']['sg_template'])){ ?>checked="checked"<?php } ?> value="<?php echo $v; ?>" name="template[]">
        <?php }?>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
    <div class="clear"></div>
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td><input class="btn btn-green big" name="submit" value="<?php echo $lang['nc_submit'];?>" type="submit"></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
