<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['express_name'];?></h3>
      <ul class="tab-base"><li><a class="current"><span><?php echo $lang['express_name'];?></span></a></li></ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_brand_name"><?php echo $lang['express_letter'];?></label></th>
          <td>
        <?php foreach (range('A','Z') as $v){?>
        <a href="index.php?act=express&op=index&letter=<?php echo $v;?>"><?php echo $v;?></a>&nbsp;&nbsp;
        <?php }?>
          </td>
        </tr>
      </tbody>
    </table>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['express_index_help1'];?></li>
            <!--<li><?php echo $lang['express_index_help2'];?></li>-->
          </ul></td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w270"><?php echo $lang['express_name'];?></th>
          <th ><?php echo $lang['express_letter'];?></th>
          <th class="w270"><?php echo $lang['express_url'];?></th>
          <th class="align-center"><?php echo $lang['express_order'];?></th>
          <th class="align-center"><?php echo $lang['express_state'];?></th>
          <th class="align-center">支持服务站配送</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover">
          <td></td>
          <td><?php echo $v['e_name']?></td>
          <td><?php echo $v['e_letter']?></td>
          <td><?php echo $v['e_url']?></td>
          <td class="align-center yes-onoff"><?php if($v['e_order'] == '1'){ ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='order' nc_type="inline_edit" fieldname="e_order" fieldid="<?php echo $v['id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='order' nc_type="inline_edit" fieldname="e_order" fieldid="<?php echo $v['id']?>" fieldvalue="0"  title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>     
          <td class="align-center yes-onoff"><?php if($v['e_state'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='state' nc_type="inline_edit" fieldname="e_state" fieldid="<?php echo $v['id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='state' nc_type="inline_edit" fieldname="e_state" fieldid="<?php echo $v['id']?>" fieldvalue="1"  title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center yes-onoff"><?php if($v['e_zt_state'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='e_zt_state' nc_type="inline_edit" fieldname="e_zt_state" fieldid="<?php echo $v['id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='e_zt_state' nc_type="inline_edit" fieldname="e_zt_state" fieldid="<?php echo $v['id']?>" fieldvalue="1"  title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="5"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr class="tfoot">
          <td colspan="20"><div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>      
    </table>
  <div class="clear"></div>
</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>