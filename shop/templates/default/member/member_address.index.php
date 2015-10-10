<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
    <a href="javascript:void(0)" class="ncm-btn ncm-btn-orange" nc_type="dialog" dialog_title="<?php echo $lang['member_address_new_address'];?>" dialog_id="my_address_edit"  uri="index.php?act=member_address&op=address&type=add" dialog_width="550" title="<?php echo $lang['member_address_new_address'];?>"><i class="icon-map-marker"></i><?php echo $lang['member_address_new_address'];?></a>
    <?php if (C('delivery_isuse')) { ?>
    <a href="javascript:void(0)" class="ncm-btn ncm-btn-orange" style="right: 100px;" nc_type="dialog" dialog_title="使用代收货（自提）" dialog_id="daisou"  uri="index.php?act=member_address&op=delivery_add" dialog_width="900" title="使用自提服务站"><i class="icon-flag"></i>使用自提服务站</a>
    <?php } ?>
  </div>
  <div class="alert alert-success">
    <h4>操作提示：</h4>
    <ul>
      <li>最多可保存20个有效地址</li>
    </ul>
  </div>
  <table class="ncm-default-table" >
    <thead>
      <tr>
        <th class="w80"><?php echo $lang['member_address_receiver_name'];?></th>
        <th class="w150"><?php echo $lang['member_address_location'];?></th>
        <th class="tl">街道地址</th>
        <th class="w120"><?php echo $lang['member_address_phone'];?>/<?php echo $lang['member_address_mobile'];?></th>
        <th class="w150"></th>
        <th class="w110"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php if(!empty($output['address_list']) && is_array($output['address_list'])){?>
    <tbody>
      <?php foreach($output['address_list'] as $key=>$address){?>
      <tr class="bd-line">
        <td><?php echo $address['true_name'];?></td>
        <td><?php echo $address['area_info'];?></td>
        <td class="tl"><em class="delivery"><?php echo intval($address['dlyp_id']) ? '[自提服务站] ' : ''; ?></em><?php echo $address['address'];?></td>
        <td><p><i class="icon-phone"></i><?php echo $address['tel_phone'];?></p>
          <p><i class="icon-mobile-phone"></i><?php echo $address['mob_phone']; ?></p></td>
        <td><?php if ($address['is_default'] == '1') {?>
          <i class="icon-ok-sign green" style="font-size: 18px;"></i>默认地址
          <?php } ?></td>
        <td class="ncm-table-handle"><span>
          <?php if (intval($address['dlyp_id'])) { ?>
          <a href="javascript:void(0);" class="btn-blue" dialog_id="daisou" dialog_width="900" dialog_title="<?php echo $lang['member_address_edit_address'];?>" nc_type="dialog" uri="index.php?act=member_address&op=delivery_add&id=<?php echo $address['address_id'];?>"><i class="icon-edit"></i>
          <p><?php echo $lang['nc_edit'];?></p>
          </a>
          <?php } else { ?>
          <a href="javascript:void(0);" class="btn-blue" dialog_id="my_address_edit" dialog_width="550" dialog_title="<?php echo $lang['member_address_edit_address'];?>" nc_type="dialog" uri="index.php?act=member_address&op=address&type=edit&id=<?php echo $address['address_id'];?>"><i class="icon-edit"></i>
          <p><?php echo $lang['nc_edit'];?></p>
          </a>
          <?php } ?>
          </span> <span><a href="javascript:void(0)" class="btn-red" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=member_address&op=address&id=<?php echo $address['address_id'];?>');"><i class="icon-trash"></i>
          <p><?php echo $lang['nc_del'];?></p>
          </a></span></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<?php if (C('delivery_isuse')) { ?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script>
<?php } ?>
