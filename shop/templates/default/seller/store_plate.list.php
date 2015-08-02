<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <a href="<?php echo urlShop('store_plate', 'plate_add');?>" class="ncsc-btn ncsc-btn-green" title="添加关联版式">添加关联版式</a>
</div>
<div class="alert mt15 mb5"><strong>操作提示：</strong>
  <ul>
    <li>1、关联版式可以把预设内容插入到商品描述的顶部或者底部，方便商家对商品描述批量添加或修改。</li>
  </ul>
</div>
<form method="get">
<input type="hidden" name="act" value="store_plate">
<table class="search-form">
    <tr>
      <td>&nbsp;</td>
      
      <th>版式位置</th>
      <td class="w80">
        <select name="p_position">
          <option>请选择</option>
          <?php foreach ($output['position'] as $key => $val) {?>
          <option value="<?php echo $key;?>" <?php if (is_numeric($_GET['p_position']) && $key==$_GET['p_position']) {?>selected="selected"<?php }?>><?php echo $val;?></option>
          <?php }?>
        </select>
      </td><th>版式名称</th>
      <td class="w160"><input type="text" class="text w150" name="p_name" value="<?php echo $_GET['p_name']; ?>"/></td>
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
</table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w30"></th>
      <th class="tl">版式名称</th>
      <th class="w200">版式位置</th>
      <th class="w110"><?php echo $lang['nc_handle'];?></th>
    </tr>
    <?php if (!empty($output['plate_list'])) { ?>
    <tr>
      <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
      <td colspan="10"><label for="all" ><?php echo $lang['nc_select_all'];?></label>
        <a href="javascript:void(0);" nc_type="batchbutton" uri="<?php echo urlShop('store_plate', 'drop_plate');?>" name="p_id" confirm="<?php echo $lang['nc_ensure_del'];?>" class="ncsc-btn-mini"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a>
      </td>
    </tr>
    <?php } ?>
  </thead>
  <tbody>
    <?php if (!empty($output['plate_list'])) { ?>
    <?php foreach($output['plate_list'] as $val) { ?>
    <tr class="bd-line">
      <td class="tc"><input type="checkbox" class="checkitem tc" value="<?php echo $val['plate_id']; ?>"/></td>
      <td class="tl"><?php echo $val['plate_name']; ?></td>
      <td><?php echo $output['position'][$val['plate_position']];?></td>
      <td class="nscs-table-handle">
        <span><a href="<?php echo urlShop('store_plate', 'plate_edit', array('p_id' => $val['plate_id']));?>" class="btn-blue"><i class="icon-edit"></i><p><?php echo $lang['nc_edit'];?></p></a></span>
        <span><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', '<?php echo urlShop('store_plate', 'drop_plate', array('p_id' => $val['plate_id']));?>');" class="btn-red"><i class="icon-trash"></i><p><?php echo $lang['nc_del'];?></p></a></span>
      </td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php if (!empty($output['plate_list'])) { ?>
    <tr>
      <th class="tc"><input type="checkbox" id="all" class="checkall"/></th>
      <th colspan="10"><label for="all" ><?php echo $lang['nc_select_all'];?></label>
        <a href="javascript:void(0);" nc_type="batchbutton" uri="<?php echo urlShop('store_plate', 'drop_plate');?>" name="p_id" confirm="<?php echo $lang['nc_ensure_del'];?>" class="ncsc-btn-mini"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a>
       </th>
    </tr>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
