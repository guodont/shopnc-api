<?php defined('InShopNC') or exit('Access Invalid!'); ?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>自营店铺</h3>
      <ul class="tab-base">
        <li><a href="javascript:;" class="current"><span>管理</span></a></li>
        <li><a href="index.php?act=ownshop&op=add"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
  <input type="hidden" name="act" value="ownshop" />
  <input type="hidden" name="op" value="list" />
  <table class="tb-type1 noborder search">
  <tbody>
    <tr>
      <th><label for="store_name">店铺</label></th>
      <td><input type="text" value="<?php echo $output['store_name']; ?>" name="store_name" id="store_name" class="txt" /></td>
      <td>
        <a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
<?php if ($output['store_name'] != '') { ?>
        <a href="index.php?act=ownshop&op=list" class="btns" title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
<?php } ?>
      </td>
    </tr>
  </tbody>
  </table>
  </form>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts']; ?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
          <ul>
            <li>平台在此处统一管理自营店铺，可以新增、编辑、删除平台自营店铺</li>
            <li>可以设置未绑定全部商品类目的平台自营店铺的经营类目</li>
            <li>已经发布商品的自营店铺不能被删除</li>
            <li>删除平台自营店铺将会同时删除店铺的相关图片以及相关商家中心账户，请谨慎操作！</li>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>店铺名称</th>
          <th>店主账号</th>
          <th>店主卖家账号</th>
          <th class="align-center">状态</th>
          <th class="align-center">绑定所有类目</th>
          <th class="align-center">操作</th>
        </tr>
      </thead>
<?php if (empty($output['store_list'])) { ?>
      <tbody>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
      </tbody>
<?php } else { ?>
      <tbody>
<?php foreach($output['store_list'] as $k => $v) { ?>
        <tr class="">
          <td>
            <a href="<?php echo urlShop('show_store','index', array('store_id'=>$v['store_id'])); ?>" >
              <?php echo $v['store_name']; ?>
            </a>
          </td>
          <td><?php echo $v['member_name']; ?></td>
          <td><?php echo $v['seller_name']; ?></td>
          <td class="align-center w72">
            <?php echo $v['store_state'] ? $lang['open'] : $lang['close']; ?>
          </td>
          <td class="align-center w120"><?php echo $v['bind_all_gc'] ? '是' : '否'; ?></td>
          <td class="align-center w200">
            <a href="index.php?act=ownshop&op=edit&id=<?php echo $v['store_id']; ?>">编辑</a>
<?php if (!$v['bind_all_gc']) { ?>
            |
            <a href="index.php?act=ownshop&op=bind_class&id=<?php echo $v['store_id']; ?>">经营类目</a>
<?php } ?>
<?php if (empty($output['storesWithGoods'][$v['store_id']])) { ?>
            |
            <a href="index.php?act=ownshop&op=del&id=<?php echo $v['store_id']; ?>" onclick="return confirm('此操作不可逆转！确定删除？');">删除</a>
<?php } ?>
          </td>
        </tr>
<?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td></td>
          <td colspan="16">
            <div class="pagination"><?php echo $output['page']; ?></div></td>
        </tr>
      </tfoot>
<?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script>
$(function(){
    $('#ncsubmit').click(function(){
        $('input[name="op"]').val('store');$('#formSearch').submit();
    });
});
</script>
