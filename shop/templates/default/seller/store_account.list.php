<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <a href="javascript:void(0)" class="ncsc-btn ncsc-btn-green" onclick="go('index.php?act=store_account&op=account_add');" title="添加账号">添加账号</a> </div>
<table class="ncsc-default-table">
  <thead>
    <tr><th class="w60"></th>
      <th class="tl">账号名</th>
      <th class="w200">账号组</th>
      <th class="w100"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['seller_list']) && is_array($output['seller_list'])){?>
    <?php foreach($output['seller_list'] as $key => $value){?>
    <tr class="bd-line">
    <td></td>
      <td class="tl"><?php echo $value['seller_name'];?></td>
      <td><?php echo $output['seller_group_array'][$value['seller_group_id']]['group_name'];?></td>
      <td class="nscs-table-handle">
          <span><a href="<?php echo urlShop('store_account', 'account_edit', array('seller_id' => $value['seller_id']));?>" class="btn-blue"><i class="icon-edit"></i>
        <p><?php echo $lang['nc_edit'];?></p></a>
          </span><span><a nctype="btn_del_account" data-seller-id="<?php echo $value['seller_id'];?>" href="javascript:;" class="btn-red"><i class="icon-trash"></i>
        <p><?php echo $lang['nc_del'];?></p></a></span>
      </td>
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
<form id="del_form" method="post" action="<?php echo urlShop('store_account', 'account_del');?>">
  <input id="del_seller_id" name="seller_id" type="hidden" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_del_account"]').on('click', function() {
            var seller_id = $(this).attr('data-seller-id');
            if(confirm('确认删除？')) {
                $('#del_seller_id').val(seller_id);
                ajaxpost('del_form', '', '', 'onerror');
            }
        });
    });
</script> 
