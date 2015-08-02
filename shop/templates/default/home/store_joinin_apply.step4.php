<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="explain"><i></i><?php echo $output['joinin_message'];?></div>
<?php if (is_array($output['joinin_detail']) && !empty($output['joinin_detail'])) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="all">
  <tbody>
    <tr>
      <th>付款清单列表</th>
      <td></td>
    </tr>
    <tr>
      <td colspan="2"><table  border="0" cellpadding="0" cellspacing="0" class="type">
          <tbody>
            <tr>
              <td class="w80">收费标准：</td>
              <td class="w250 tl"><?php echo $output['joinin_detail']['sg_info']['sg_price'];?>元/年 ( <?php echo $output['joinin_detail']['sg_name'];?> )</td>
              <td class="w80">开店时长：</td>
              <td class="tl"><?php echo $output['joinin_detail']['joinin_year'];?> 年</td>
            </tr>
            <tr>
              <td class="w80">店铺分类：</td>
              <td class="tl"><?php echo $output['joinin_detail']['sc_name'];?></td>
              <td class="w80">开店保证金：</td>
              <td class="tl"><?php echo $output['joinin_detail']['sc_bail'];?> 元</td>
            </tr>
            <tr>
              <td>应付金额：</td>
              <td class="tl" colspan="3"><?php echo $output['joinin_detail']['paying_amount'];?> 元</td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <th>经营类目列表</th>
      <td></td>
    </tr>
    <tr>
      <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" id="table_category" class="type">
          <thead>
            <tr>
              <th class="w120 tc">一级类目</th>
              <th class="w120 tc">二级类目 </th>
              <th class="tc">三级类目</th>
              <th class="tc">分佣比例</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($output['joinin_detail']['store_class_names'] as $k => $name) {?>
            <?php $name = explode(',', $name);?>
            <tr>
              <td><?php echo $name[0];?></td>
              <td><?php echo $name[1];?></td>
              <td><?php echo $name[2];?></td>
              <td><?php echo $output['joinin_detail']['store_class_commis_rates'][$k]; ?> %</td>
            </tr>
            <?php } ?>
          </tbody>
        </table></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php } ?>
<div class="bottom">
  <?php if($output['btn_next']) { ?>
  <a id="" href="<?php echo $output['btn_next'];?>" class="btn">下一步</a>
  <?php } ?>
</div>
