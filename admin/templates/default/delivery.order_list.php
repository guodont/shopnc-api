<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>物流自提服务站管理</h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('delivery', 'index');?>"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('delivery', 'index', array('sign' => 'verify'));?>"><span>等待审核</span></a></li>
        <li><a href="<?php echo urlAdmin('delivery', 'setting');?>"><span>设置</span></a></li>
        <li><a href="javascript:void(0);" class="current"><span>订单列表</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="delivery" name="act">
    <input type="hidden" value="order_list" name="op">
    <input type="hidden" value="<?php echo $_GET['d_id'];?>" name="d_id">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_title">运单号&订单号</label></th>
          <td><input type="text" value="<?php echo $output['search_name'];?>" name="search_name" id="search_name" class="txt"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_name'] != ''){?>
            <a href="index.php?act=delivery&op=order_list&d_id=<?php echo $_GET['d_id'];?>" class="btns " title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
            <?php }?></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method="post" id="form_article">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>订单号</th>
          <th>运单号</th>
          <th>收货人</th>
          <th>手机号</th>
          <th>座机号</th>
          <th class="align-center">状态</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['dorder_list'])){ ?>
        <?php foreach($output['dorder_list'] as $k => $v){ ?>
        <tr class="hover">
          <td><?php echo $v['order_sn'];?></td>
          <td><?php echo $v['shipping_code'];?></td>
          <td><?php echo $v['reciver_name'];?></td>
          <td><?php echo $v['reciver_mobphone'];?></td>
          <td><?php echo $v['reciver_telphone'];?></td>
          <td class="align-center"><?php echo $output['dorder_state'][$v['dlyo_state']];?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['dorder_list'])){ ?>
        <tr class="tfoot">
          <td colspan="16">
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
