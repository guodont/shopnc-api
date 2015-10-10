<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_joinin" ><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="index.php?act=store&op=reopen_list" ><span>续签申请</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>经营类目申请</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="store" name="act">
    <input type="hidden" value="store_bind_class_applay_list" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name"><?php echo $lang['store_name'];?>ID</label></th>
          <td><input type="text" value="" name="store_id" id="store_id" class="txt"></td>
          <th>申请状态</th>
          <td>
          <select name="state">
          <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
          <option <?php if ($_GET['state'] == '0') echo 'selected';?> value="0">待审核</option>
          <option <?php if ($_GET['state'] == '1') echo 'selected';?> value="1">已经审核</option>
          </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
        </tr>
        </tbody>
    </table>
</form>
<table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>此处可以对商家新申请的经营类目进行 审核/删除 操作</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="store_form" name="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="align-center" colspan="3">经营类目</th>
          <th><?php echo $lang['store_name'];?></th>
          <th><?php echo $lang['store_user_name'];?></th>
          <th>分佣比例</th>
          <th class="align-center"><?php echo $lang['operation'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['bind_list']) && is_array($output['bind_list'])){ ?>
        <?php foreach($output['bind_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><?php echo $v['class_1_name'];?></td>
          <td><?php echo $v['class_2_name'] ? '>' : null;?> <?php echo $v['class_2_name'];?></td>
          <td><?php echo $v['class_3_name'] ? '>' : null;?> <?php echo $v['class_3_name'];?></td>
          <td><?php echo $output['bind_store_list'][$v['store_id']]['store_name'];?>[ID:<?php echo $v['store_id'];?>]</td>
          <td><?php echo $output['bind_store_list'][$v['store_id']]['seller_name'];?></td>
          <td class="w150"><?php echo $v['commis_rate'];?> %</td>
          <td class="w72 align-center">
          <?php if ($v['state'] == '0') {?>
          <a href="javascript:if(confirm('确认审核吗？'))window.location = 'index.php?act=store&op=store_bind_class_applay_check&bid=<?php echo $v['bid'];?>&store_id=<?php echo $v['store_id'];?>';">审核</a> |
          <?php } ?>
          <a href="javascript:if(confirm('<?php echo $v['state'] == '1' ? '该类目已经审核通过，删除它可能影响到商家的使用，' : null;?>确认删除吗？'))window.location = 'index.php?act=store&op=store_bind_class_applay_del&bid=<?php echo $v['bid'];?>&store_id=<?php echo $v['store_id'];?>';"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td></td>
          <td colspan="15">
              <?php if(!empty($output['bind_list']) && is_array($output['bind_list'])){ ?>
              <div class="pagination"><?php echo $output['page'];?></div>
              <?php } ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
