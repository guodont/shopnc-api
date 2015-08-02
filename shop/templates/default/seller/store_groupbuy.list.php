<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
<?php if ($output['isOwnShop']) { ?>
  <a href="<?php echo urlShop('store_groupbuy', 'groupbuy_add_vr'); ?>" style="right:100px" class="ncsc-btn ncsc-btn-green" title="新增虚拟商品抢购"><i class="icon-plus-sign"></i>新增虚拟抢购</a>
  <a href="<?php echo urlShop('store_groupbuy', 'groupbuy_add');?>" class="ncsc-btn ncsc-btn-green" title="<?php echo $lang['groupbuy_index_new_group'];?>"><i class="icon-plus-sign"></i><?php echo $lang['groupbuy_index_new_group'];?></a>
<?php } else { ?>

  <?php if(!empty($output['current_groupbuy_quota'])) { ?>
  <a href="<?php echo urlShop('store_groupbuy', 'groupbuy_add_vr'); ?>" style="right:200px" class="ncsc-btn ncsc-btn-green" title="新增虚拟商品抢购"><i class="icon-plus-sign"></i>新增虚拟抢购</a>
  <a href="<?php echo urlShop('store_groupbuy', 'groupbuy_add');?>" style="right:100px" class="ncsc-btn ncsc-btn-green" title="<?php echo $lang['groupbuy_index_new_group'];?>"><i class="icon-plus-sign"></i><?php echo $lang['groupbuy_index_new_group'];?></a>
  <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_groupbuy', 'groupbuy_quota_add');?>" title="套餐续费"><i class="icon-money"></i>套餐续费</a>
  <?php } else { ?>
  <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_groupbuy', 'groupbuy_quota_add');?>" title="购买套餐"><i class="icon-money"></i>购买套餐</a>
  <?php } ?>
<?php } ?>

</div>
<?php if ($output['isOwnShop']) { ?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、点击新增抢购按钮可以添加抢购活动</li>
    <li>2、如发布虚拟商品的抢购活动，请点击新增虚拟抢购按钮</li>
  </ul>
</div>
<?php } else { ?>
<div class="alert alert-block mt10">
  <?php if(!empty($output['current_groupbuy_quota'])) { ?>
  <strong>套餐过期时间<?php echo $lang['nc_colon'];?></strong><strong style="color: #F00;"><?php echo date('Y-m-d H:i:s', $output['current_groupbuy_quota']['end_time']);?></strong>
  <?php } else { ?>
  <strong>当前没有可用套餐，请先购买套餐</strong>
  <?php } ?>
  <ul class="mt5">
    <li>1、点击购买套餐和套餐续费按钮可以购买或续费套餐</li>
    <li>2、点击新增抢购按钮可以添加抢购活动</li>
    <li>3、如发布虚拟商品的抢购活动，请点击新增虚拟抢购按钮</li>
    <li>4、<strong style="color: red">相关费用会在店铺的账期结算中扣除</strong></li>
  </ul>
</div>
<?php } ?>

<table class="search-form">
  <form method="get">
    <input type="hidden" name="act" value="store_groupbuy" />
    <tr>
      <td>&nbsp;</td>
      <th>抢购类型</th>
      <td class="w100">
        <select name="groupbuy_vr" class="w90">
          <option value="">全部</option>
          <option value="0"<?php if ($output['groupbuy_vr'] === '0') echo ' selected'; ?>>线上抢</option>
          <option value="1"<?php if ($output['groupbuy_vr'] === '1') echo ' selected'; ?>>虚拟抢</option>
        </select>
      </td>
      <th><?php echo $lang['groupbuy_index_activity_state'];?></th>
      <td class="w100"><select name="groupbuy_state" class="w90">
          <?php if(is_array($output['groupbuy_state_array'])) { ?>
          <?php foreach($output['groupbuy_state_array'] as $key=>$val) { ?>
          <option value="<?php echo $key;?>" <?php if($key == $_GET['groupbuy_state']) { echo 'selected';}?>><?php echo $val;?></option>
          <?php } ?>
          <?php } ?>
        </select></td>
      <th><?php echo $lang['group_name'];?></th>
      <td class="w160"><input class="text" type="text" name="groupbuy_name" value="<?php echo $_GET['groupbuy_name'];?>"/></td>
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </form>
</table>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w10"></th>
      <th class="w50"></th>
      <th class="tl"><?php echo $lang['group_name'];?></th>
      <th class="w130">开始时间</th>
      <th class="w130">结束时间</th>
      <th class="w90">浏览数</th>
      <th class="w90">已购买</th>
      <th class="w110"><?php echo $lang['groupbuy_index_activity_state'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['group']) && is_array($output['group'])){?>
    <?php foreach($output['group'] as $key=>$group){?>
    <tr class="bd-line">
      <td></td>
      <td><div class="pic-thumb"><a href="<?php echo $group['groupbuy_url'];?>" target="_blank"><img src="<?php echo gthumb($group['groupbuy_image'], 'small');?>"/></a></div></td>
      <td class="tl">
        <dl class="goods-name">
          <dt>
<?php if ($group['is_vr']) { ?>
            <span title="虚拟兑换商品" class="type-virtual">虚拟抢</span>
<?php } ?>
            <a target="_blank" href="<?php echo $group['groupbuy_url'];?>"><?php echo $group['groupbuy_name'];?></a>
          </dt>
        </dl>
      </td>
      <td><?php echo $group['start_time_text'];?></td>
      <td><?php echo $group['end_time_text'];?></td>
      <td><?php echo $group['views'];?></td>
      <td><?php echo $group['buy_quantity'];?></td>
      <td><?php echo $group['groupbuy_state_text'];?></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
</table>
