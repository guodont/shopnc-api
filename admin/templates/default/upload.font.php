<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['upload_set'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['font_help1'];?></li>
            <li><?php echo $lang['font_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2"><label><?php echo $lang['font_info'];?>:</label></td>
        </tr>
    		<?php if(!empty($output['file_list']) && is_array($output['file_list'])){?>
        <?php foreach($output['file_list'] as $key => $value){?>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $key;?><?php echo $lang['nc_colon'];?><?php echo $value;?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
        <?php }?>
      </tbody>
    </table>
</div>
