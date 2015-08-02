<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
function submit_verify(id){
    if(confirm('<?php echo $lang['admin_voucher_verify_confirm'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=voucher&op=apply_verify');
        $('#object_id').val(id);
        $('#list_form').submit();
    }
}
function submit_cancel(id){
    if(confirm('<?php echo $lang['admin_voucher_cancel_confirm'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=voucher&op=apply_cancel');
        $('#object_id').val(id);
        $('#list_form').submit();
    }
}
</script>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_voucher_price_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </ul>
    </div>
  </div>
  <!-- 帮助 -->
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
      	<td>
      		<ul>
      			<li><?php echo $lang['admin_voucher_apply_list_tip1'];?></li>
      			<li><?php echo $lang['admin_voucher_apply_list_tip2'];?></li>
      		</ul>
      	</td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <input type="hidden" id="object_id" name="object_id"/>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['admin_voucher_storename']; ?></th>
          <th class="align-center"><?php echo $lang['admin_voucher_apply_num']; ?></th>
          <th class="align-center"><?php echo $lang['admin_voucher_apply_date']; ?></th>
          <th class="align-center"><?php echo $lang['nc_status']; ?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
          <td class="align-left">
              <a href="<?php echo urlShop('show_store','index', array('store_id'=>$val['apply_storeid']));?>" >
          		<span><?php echo $val['apply_storename'];?></span></a>
          </td>
          <td class="align-center"><?php echo $val['apply_quantity'];?></td>
          <td class="align-center"><?php echo @date('Y-m-d',$val['apply_datetime']);?></td>
          <td class="align-center"><?php foreach($output['applystate_arr'] as $k=>$v){ if(intval($val['apply_state']) == $v[0]){ echo $v[1]; }}?></td>
          <td class="nowrap align-center">
              <?php if(intval($val['apply_state']) === 1) { ?>
              <!-- 审核按钮 -->
              <a href="javascript:void(0)" onclick="submit_verify('<?php echo $val['apply_id'];?>')"><?php echo $lang['nc_verify'];?></a> |
              <!-- 取消按钮 -->
              <a href="javascript:void(0)" onclick="submit_cancel('<?php echo $val['apply_id'];?>');"><?php echo $lang['nc_cancel'];?></a>
              <?php } ?>
          </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
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
