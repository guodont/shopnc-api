<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_thememanage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_theme&op=theme_list"><span><?php echo $lang['circle_theme_list'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['circle_theme_info'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="pointprod_form" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="3"><?php echo $lang['circle_theme'];?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="noborder">
          <td colspan="3"><?php echo $output['theme_info']['theme_name'];?></td>
        </tr>
      <tbody>
      <?php if($output['theme_info']['theme_special'] == 1){?>
      <thead>
        <tr class="space">
          <th colspan="3"><?php echo $lang['circle_poll_info'];?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="noborder">
          <td colspan="3"><?php echo $lang['circle_poll_form'].$lang['nc_colon'];if($output['poll_info']['poll_multiple'] == 0){echo $lang['circle_poll_radio'];}else{echo $lang['circle_poll_checkbox'];}?></td>
        </tr>
        <tr class="noborder">
          <td colspan="3"><?php echo $lang['circle_poll_starttime'].$lang['nc_colon'].date('Y-m-d H:i:s', $output['poll_info']['poll_startime']);?></td>
        </tr>
        <tr class="noborder">
          <td colspan="3"><?php echo $lang['circle_poll_days'].$lang['nc_colon'];if($output['poll_info']['poll_days'] == 0){echo $lang['nc_nothing'];}else{ echo $output['poll_info']['poll_days'];}?></td>
        </tr>
        <tr class="noborder">
          <td colspan="3"><?php echo $lang['circle_poll_sum'].$lang['nc_colon'].$output['poll_info']['poll_voters'];?></td>
        </tr>
      </tbody>
      <thead>
        <tr class="space">
          <th colspan="3"><?php echo $lang['circle_poll_option'];?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="noborder">
          <td class="w132"><?php echo $lang['circle_poll_option'];?></td><td class="w48"><?php echo $lang['circle_poll_option_count'];?></td><td class="w830"><?php echo $lang['circle_poll_option_participant'];?></td>
        </tr>
        <?php if(!empty($output['option_list'])){?>
        <?php foreach ($output['option_list'] as $val){?>
        <tr class="noborder">
          <td><?php echo $val['pollop_option'];?></td><td><?php echo $val['pollop_votes'];?></td><td><?php echo $val['pollop_votername'];?></td>
        </tr>
        <?php }?>
        <?php }?>
      </tbody>
      <?php }?>
      <thead>
        <tr class="space">
          <th colspan="3"><?php echo $lang['circle_theme_content'];?></th>
        </tr>
      </thead>
      </tbody>
        <tr class="noborder">
          <td colspan="3"><?php echo ubb($output['theme_info']['theme_content']);?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="space">
          <th colspan="3"><?php echo $lang['nc_handle'];?></th>
        </tr>
        <tr class="tfoot">
          <td colspan="3">
            <a href="index.php?act=circle_theme&op=theme_reply&t_id=<?php echo $output['theme_info']['theme_id'];?>" class="btn"><span><?php echo $lang['circle_theme_check_reply'];?></span></a>
            <a href="JavaScript:void(0);" onclick="if(confirm('<?php echo $lang['circle_theme_del_confirm'];?>')){location.href='index.php?act=circle_theme&op=theme_del&c_id=<?php echo $output['theme_info']['circle_id'];?>&t_id=<?php echo $output['theme_info']['theme_id'];?>';}else{return false;}" class="btn" id="delTheme"><span><?php echo $lang['circle_theme_del'];?></span></a>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>