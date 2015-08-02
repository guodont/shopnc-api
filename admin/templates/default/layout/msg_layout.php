<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/skin_0.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_shopnc_message'];?></h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2 msg">
    <tbody class="noborder">
      <tr>
        <td rowspan="5" class="msgbg"></td>
        <td class="tip"><?php require_once($tpl_file); ?></td>
      </tr>
      <?php if ($output['is_show'] == 1){ ?>
      <tr>
        <td class="tip2"><?php echo $lang['nc_auto_redirect'];?></td>
      </tr>
      <tr>
        <td><?php if (is_array($output['url'])){ foreach($output['url'] as $k => $v){ ?>
          <a href="<?php echo $v['url'];?>" class="btns"><span><?php echo $v['msg'];?></span></a>
          <?php } ?>
          <script type="text/javascript"> window.setTimeout("javascript:location.href='<?php echo $output['url'][0]['url'];?>'", <?php echo $time;?>); </script>
          <?php }else { if ($output['url'] != ''){ ?>
          <a href="<?php echo $output['url'];?>" class="btns"><span><?php echo $lang['nc_back_to_pre_page'];?></span></a> 
          <script type="text/javascript"> window.setTimeout("javascript:location.href='<?php echo $output['url'];?>'", <?php echo $time;?>); </script>
          <?php }else { ?>
          <a href="javascript:history.back()" class="btns"><span><?php echo $lang['nc_back_to_pre_page'];?></span></a> 
          <script type="text/javascript"> window.setTimeout("javascript:history.back()", <?php echo $time;?>); </script>
          <?php } } ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>