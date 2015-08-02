<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_binding_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_binding_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        	<ul>
        		<li><?php echo $lang['shareset_list_tip'];?></li>
        	</ul>
         </td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['shareset_list_appname'];?></th>
        <th><?php echo $lang['shareset_list_appurl'];?></th>
        <th class="align-center"><?php echo $lang['shareset_list_appstate'];?></th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['app_arr']) && is_array($output['app_arr'])){ foreach($output['app_arr'] as $k => $v){ ?>
      <tr class="hover">
        <td><?php echo $v['name'];?></td>
        <td><?php echo $v['url'];?></td>
        <td class="w25pre align-center">
        	<?php if($v['isuse'] == '1'){ ?>
        		<?php echo $lang['nc_yes'];?>
        	<?php }else { ?>
        		<?php echo $lang['nc_no'];?>
        	<?php } ?>
        </td>
        <td class="w156 align-center">
        	<?php if($v['isuse'] == '1'){ ?>
        		<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['shareset_list_closeprompt'];?>')){location.href='index.php?act=sns_sharesetting&op=set&state=0&key=<?php echo $k;?>'}"> <?php echo $lang['nc_close'];?></a>
        	<?php }else { ?>
        		<a href="index.php?act=sns_sharesetting&op=set&state=1&key=<?php echo $k;?>"><?php echo $lang['nc_open'];?></a>
        	<?php } ?>
        	| <a href="index.php?act=sns_sharesetting&op=edit&state=1&key=<?php echo $k; ?>"><?php echo $lang['nc_edit']?></a></td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15"></td>
      </tr>
    </tfoot>
  </table>
</div>