<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>手机支付</h3>
      <ul class="tab-base"><li><a class="current"><span>列表</span></a></li></ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>此处列出了手机支持的支付方式，点击编辑可以设置支付参数及开关状态</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th>支付方式</th>
        <th class="align-center">启用</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['mb_payment_list']) && is_array($output['mb_payment_list'])){ ?>
        <?php foreach($output['mb_payment_list'] as $k => $v) { ?>
      <tr class="hover">
        <td><?php echo $v['payment_name'];?></td>
        <td class="w25pre align-center"><?php echo $v['payment_state_text'];?></td>
        <td class="w156 align-center"><a href="<?php echo urlAdmin('mb_payment', 'payment_edit', array('payment_id' => $v['payment_id']));?>"><?php echo $lang['nc_edit']?></a></td>
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
