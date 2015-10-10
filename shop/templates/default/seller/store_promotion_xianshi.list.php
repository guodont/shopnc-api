<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
<?php if ($output['isOwnShop']) { ?>
  <a class="ncsc-btn ncsc-btn-green" href="<?php echo urlShop('store_promotion_xianshi', 'xianshi_add');?>"><i class="icon-plus-sign"></i><?php echo $lang['xianshi_add'];?></a>

<?php } else { ?>

  <?php if(!empty($output['current_xianshi_quota'])) { ?>
  <a class="ncsc-btn ncsc-btn-green" style="right:100px" href="<?php echo urlShop('store_promotion_xianshi', 'xianshi_add');?>"><i class="icon-plus-sign"></i><?php echo $lang['xianshi_add'];?></a> <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_promotion_xianshi', 'xianshi_quota_add');?>" title=""><i class="icon-money"></i>套餐续费</a>
  <?php } else { ?>
  <a class="ncsc-btn ncsc-btn-acidblue" href="<?php echo urlShop('store_promotion_xianshi', 'xianshi_quota_add');?>" title=""><i class="icon-money"></i><?php echo $lang['xianshi_quota_add'];?></a>
  <?php } ?>

<?php } ?>
</div>

<?php if ($output['isOwnShop']) { ?>
<div class="alert alert-block mt10">
  <ul>
    <li>1、点击添加活动按钮可以添加限时折扣活动，点击管理按钮可以对限时折扣活动内的商品进行管理</li>
    <li>2、点击删除按钮可以删除限时折扣活动</li>
 </ul>
</div>
<?php } else { ?>
<div class="alert alert-block mt10">
  <?php if(!empty($output['current_xianshi_quota'])) { ?>
  <strong>套餐过期时间<?php echo $lang['nc_colon'];?></strong><strong style="color:#F00;"><?php echo date('Y-m-d H:i:s', $output['current_xianshi_quota']['end_time']);?></strong>
  <?php } else { ?>
  <strong>当前没有可用套餐，请先购买套餐</strong>
  <?php } ?>
  <ul>
    <li><?php echo $lang['xianshi_explain1'];?></li>
    <li><?php echo $lang['xianshi_explain2'];?></li>
    <li><?php echo $lang['xianshi_explain3'];?></li>
    <li>4、<strong style="color: red">相关费用会在店铺的账期结算中扣除</strong>。</li>
 </ul>
</div>
<?php } ?>

<form method="get">
  <table class="search-form">
    <input type="hidden" name="act" value="store_promotion_xianshi" />
    <input type="hidden" name="op" value="xianshi_list" />
    <tr>
      <td>&nbsp;</td>
      <th>状态</th>
      <td class="w100"><select name="state">
          <?php if(is_array($output['xianshi_state_array'])) { ?>
          <?php foreach($output['xianshi_state_array'] as $key=>$val) { ?>
          <option value="<?php echo $key;?>" <?php if(intval($key) === intval($_GET['state'])) echo 'selected';?>><?php echo $val;?></option>
          <?php } ?>
          <?php } ?>
        </select></td>
      <th class="w110"><?php echo $lang['xianshi_name'];?></th>
      <td class="w160"><input type="text" class="text w150" name="xianshi_name" value="<?php echo $_GET['xianshi_name'];?>"/></td>
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w30"></th>
      <th class="tl"><?php echo $lang['xianshi_name'];?></th>
      <th class="w180"><?php echo $lang['start_time'];?></th>
      <th class="w180"><?php echo $lang['end_time'];?></th>
      <th class="w80">购买下限</th>
      <th class="w80">状态</th>
      <th class="w150"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <?php if(!empty($output['list']) && is_array($output['list'])){?>
  <?php foreach($output['list'] as $key=>$val){?>
  <tbody id="xianshi_list">
    <tr class="bd-line">
      <td></td>
      <td class="tl"><dl class="goods-name">
          <dt><?php echo $val['xianshi_name'];?></dt>
        </dl></td>
      <td class="goods-time"><?php echo date("Y-m-d H:i",$val['start_time']);?></td>
      <td class="goods-time"><?php echo date("Y-m-d H:i",$val['end_time']);?></td>
      <td><?php echo $val['lower_limit'];?></td>
      <td><?php echo $val['xianshi_state_text'];?></td>
      <td class="nscs-table-handle tr">
          <?php if($val['editable']) { ?>
          <span>
              <a href="index.php?act=store_promotion_xianshi&op=xianshi_edit&xianshi_id=<?php echo $val['xianshi_id'];?>" class="btn-blue">
                  <i class="icon-edit"></i>
                  <p><?php echo $lang['nc_edit'];?></p>
              </a>
          </span>
          <?php } ?>
          <span>
              <a href="index.php?act=store_promotion_xianshi&op=xianshi_manage&xianshi_id=<?php echo $val['xianshi_id'];?>" class="btn-green">
                  <i class="icon-cog"></i>
                  <p><?php echo $lang['nc_manage'];?></p>
              </a>
          </span>
          <span>
              <a href="javascript:;" nctype="btn_del_xianshi" data-xianshi-id=<?php echo $val['xianshi_id'];?> class="btn-red">
                  <i class="icon-trash"></i>
                  <p><?php echo $lang['nc_delete'];?></p>
              </a>
          </span>
      </td>
  </tr>
  <?php }?>
  <?php }else{?>
  <tr id="xianshi_list_norecord">
      <td class="norecord" colspan="20"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
  </tr>
  <?php }?>
  </tbody>
  <tfoot>
    <?php if(!empty($output['list']) && is_array($output['list'])){?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
<form id="submit_form" action="" method="post" >
  <input type="hidden" id="xianshi_id" name="xianshi_id" value="">
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_del_xianshi"]').on('click', function() {
            if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
                var action = "<?php echo urlShop('store_promotion_xianshi', 'xianshi_del');?>";
                var xianshi_id = $(this).attr('data-xianshi-id');
                $('#submit_form').attr('action', action);
                $('#xianshi_id').val(xianshi_id);
                ajaxpost('submit_form', '', '', 'onerror');
            }
        });
    });
</script>
