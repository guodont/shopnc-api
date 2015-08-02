<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_promotion_booth'];?></h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('promotion_booth', 'goods_list');?>"><span>商品列表</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>套餐列表</span></a></li>
        <li><a href="<?php echo urlAdmin('promotion_booth', 'booth_setting');?>"><span><?php echo $lang['nc_config'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="promotion_booth">
    <input type="hidden" name="op" value="booth_quota_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name">店铺名称</label></th>
          <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt" style="width:100px;"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>卖家购买推荐展位活动的列表。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <input type="hidden" id="object_id" name="object_id"  />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>店铺名称</th>
          <th class="align-center">开始时间</th>
          <th class="align-center">结束时间</th>
          <th class="align-center"><?php echo $lang['nc_status'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['booth_list']) && is_array($output['booth_list'])){ ?>
        <?php foreach($output['booth_list'] as $k => $val){ ?>
        <tr class="hover">
            <td class="align-left"><a href="<?php echo urlShop('show_store','index', array('store_id'=>$val['store_id']));?>" ><span><?php echo $val['store_name'];?></span></a></td>
          <td class="align-center"><?php echo date('Y-m-d',$val['booth_quota_starttime']);?></td>
          <td class="align-center"><?php echo date('Y-m-d',$val['booth_quota_endtime']);?></td>
          <td class="align-center">
            <?php echo $output['state_array'][$val['booth_state']];?>
          </td>
          <td class="align-center"><a href="<?php echo urlAdmin('promotion_booth', 'goods_list', array('store_id' => $val['store_id']));?>">查看商品</a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['booth_list']) && is_array($output['booth_list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td colspan="16"><label>
            <div class="pagination"><?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
</script>
