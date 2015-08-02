<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>

<?php if ($output['isOwnShop']) { ?>
  <a class="ncsc-btn ncsc-btn-green" href="<?php echo urlShop('store_promotion_mansong', 'mansong_add');?>"><i class="icon-plus-sign"></i><?php echo $lang['mansong_add'];?></a>

<?php } else { ?>

  <?php if(!empty($output['current_mansong_quota'])) { ?>
  <a class="ncsc-btn ncsc-btn-green" style="right:100px" href="<?php echo urlShop('store_promotion_mansong', 'mansong_add');?>"><i class="icon-plus-sign"></i><?php echo $lang['mansong_add'];?></a> <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_promotion_mansong', 'mansong_quota_add');?>" title=""><i class="icon-money"></i>套餐续费</a>
  <?php } else { ?>
  <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_promotion_mansong', 'mansong_quota_add');?>" title=""><i class="icon-money"></i>购买套餐</a>
  <?php } ?>
<?php } ?>

</div>
<?php if ($output['isOwnShop']) { ?>
<div class="alert alert-block mt10">
  <ul>
    <li>1、<?php echo $lang['mansong_explain1'];?></li>
  </ul>
</div>
<?php } else { ?>
<div class="alert alert-block mt10">
  <?php if(!empty($output['current_mansong_quota'])) { ?>
  <strong>套餐过期时间<?php echo $lang['nc_colon'];?></strong><strong style="color: #F00;"><?php echo date('Y-m-d H:i:s', $output['current_mansong_quota']['end_time']);?></strong>
  </li>
  <?php } else { ?>
  <strong>当前没有可用套餐，请先购买套餐</strong>
  <?php } ?>
  <ul>
    <li>1、<?php echo $lang['mansong_explain1'];?></li>
    <li>2、<strong style="color: red">相关费用会在店铺的账期结算中扣除</strong>。</li>
  </ul>
</div>
<?php } ?>

<form method="get">
  <table class="search-form">
    <input type="hidden" name="act" value="store_promotion_mansong" />
    <input type="hidden" name="op" value="mansong_list" />
    <tr>
      <td>&nbsp;</td>
      <th><?php echo $lang['mansong_status'];?></th>
      <td class="w100"><select name="state">
          <?php if(is_array($output['mansong_state_array'])) { ?>
          <?php foreach($output['mansong_state_array'] as $key=>$val) { ?>
          <option value="<?php echo $key;?>" <?php if(intval($key) === intval($_GET['state'])) echo 'selected';?>><?php echo $val;?></option>
          <?php } ?>
          <?php } ?>
        </select></td>
      <th class="w110"><?php echo $lang['mansong_name'];?></th>
      <td class="w160"><input type="text" class="text w150" name="mansong_name" value="<?php echo $_GET['mansong_name'];?>"/></td>
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <?php if(!empty($output['list']) && is_array($output['list'])){?>
  <thead>
    <tr>
      <th class="w30"></th>
      <th class="tl"><?php echo $lang['mansong_name'];?></th>
      <th class="w180"><?php echo $lang['start_time'];?></th>
      <th class="w180"><?php echo $lang['end_time'];?></th>
      <th class="w90"><?php echo $lang['nc_state'];?></th>
      <th class="w100"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($output['list'] as $key=>$val){?>
    <tr class="bd-line">
      <td></td>
      <td class="tl"><dl class="goods-name">
          <dt><?php echo $val['mansong_name'];?></dt>
        </dl></td>
      <td class="goods-time"><?php echo date("Y-m-d H:i",$val['start_time']);?></td>
      <td class="goods-time"><?php echo date("Y-m-d H:i",$val['end_time']);?></td>
      <td><?php echo $val['mansong_state_text'];?></td>
      <td class="nscs-table-handle"><span><a href="index.php?act=store_promotion_mansong&op=mansong_detail&mansong_id=<?php echo $val['mansong_id'];?>" class="btn-blue"><i class="icon-th-list"></i>
        <p><?php echo $lang['nc_detail'];?></p>
        </a></span> <span><a nctype="btn_mansong_del" data-mansong-id="<?php echo $val['mansong_id'];?>" href="javascript:return void(0)" class="btn-red"><i class="icon-trash"></i>
        <p><?php echo $lang['nc_del'];?></p>
        </a></span></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>
  </tbody>
  <?php if(!empty($output['list']) && is_array($output['list'])){?>
  <tfoot>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
  <?php } ?>
</table>
<form id="submit_form" action="" method="post" >
  <input type="hidden" id="mansong_id" name="mansong_id" value="">
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_mansong_del"]').on('click', function() {
            if(confirm('<?php echo $lang['nc_ensure_cancel'];?>')) {
                var action = "<?php echo urlShop('store_promotion_mansong', 'mansong_del');?>";
                var mansong_id = $(this).attr('data-mansong-id');
                $('#submit_form').attr('action', action);
                $('#mansong_id').val(mansong_id);
                ajaxpost('submit_form', '', '', 'onerror');
            }
        });
    });
</script>
