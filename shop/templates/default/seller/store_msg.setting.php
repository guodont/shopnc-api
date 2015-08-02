<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10"> <strong>说明：</strong>
  <ul class="mt5">
    <li>1、短信、邮件接收方式需要正确设置接收号码才能正常接收。</li>
    <li>2、子账号接收消息权限请到<a style="color: red" href="<?php echo urlShop('store_account_group', 'group_list');?>" target="_blank">账号组</a>中设置。</li>
  </ul>
</div>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w10"></th>
      <th>模板名称</th>
      <th class="w300">接收方式</th>
      <th class="w70">操作</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($output['smt_list'])) { ?>
    <?php foreach($output['smt_list'] as $val) { ?>
    <tr class="bd-line">
      <td></td>
      <td class="tl"><strong><?php echo $val['smt_name'];?></strong></td>
      <td><?php echo $val['is_opened'];?></td>
      <td class="nscs-table-handle"><span><a href="javascript:void(0);" class="btn-acidblue" nc_type="dialog" dialog_title="接收设置" dialog_id="msg_setting" dialog_width="480" uri="<?php echo urlShop('store_msg', 'edit_msg_setting', array('code'=>$val['smt_code']));?>"><i class="icon-cog"></i>
        <p>设置</p>
        </a></span></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php if (!empty($output['brand_list'])) { ?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
