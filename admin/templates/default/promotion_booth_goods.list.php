<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_promotion_booth'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>商品列表</span></a></li>
        <li><a href="<?php echo urlAdmin('promotion_booth', 'booth_quota_list');?>"><span>套餐列表</span></a></li>
        <li><a href="<?php echo urlAdmin('promotion_booth', 'booth_setting');?>"><span><?php echo $lang['nc_config'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="promotion_booth">
    <input type="hidden" name="op" value="goods_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label>商品分类</label></th>
          <td id="searchgc_td"></td><input type="hidden" id="choose_gcid" name="choose_gcid" value="0"/>
            <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
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
            <li>被推荐商品将在该商品所在的分类及其上级分类的商品列表左侧随机出现</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_goods" action="<?php echo urlAdmin('promotion_booth', 'del_goods');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th colspan="2">商品名称</th>
          <th class="align-center w72">分类</th>
          <th class="align-center w72">价格</th>
          <th class="w48 align-center"><?php echo $lang['nc_handle'];?> </th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($output['goods_list']) && is_array($output['goods_list'])) { ?>
        <?php foreach ($output['goods_list'] as $k => $v) {?>
        <tr class="hover edit">
          <td><input type="checkbox" name="goods_id[]" value="<?php echo $v['goods_id'];?>" class="checkitem"></td>
          <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><img src="<?php echo thumb($v, 60);?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
          <td class="goods-name w270"><p><span><?php echo $v['goods_name'];?></span></p>
            <p class="store">店铺名称：<?php echo $v['store_name'];?>
<?php if (isset($output['flippedOwnShopIds'][$v['store_id']])) { ?>
            <span class="ownshop">[自营]</span>
<?php } ?>
            </p></td>
          <td class="align-center"><?php echo $output['gc_list'][$v['gc_id']]['gc_name'];?></td>
          <td class="align-center"><?php echo $lang['currency'].$v['goods_price']?></td>
          <td class="align-center">
            <p><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><?php echo $lang['nc_view'];?></a></p>
            <p><a href="javascript:void(0);" onclick="ajaxget('<?php echo urlAdmin('promotion_booth', 'del_goods', array('goods_id' => $v['goods_id']));?>');">删除</a></p>
          </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            <a href="JavaScript:void(0);" class="btn" nctype="del_batch"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(function(){
	init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);
    // 批量删除
    $('a[nctype="del_batch"]').click(function(){
        ajaxpost('form_goods', '', '', 'onerror');
    });
});

// 获得选中哎
function getId() {
    var str = '';
    $('#form_goods').find('input[name="id[]"]:checked').each(function(){
        id = parseInt($(this).val());
        if (!isNaN(id)) {
            str += id + ',';
        }
    });
    if (str == '') {
        return false;
    }
    str = str.substr(0, (str.length - 1));
    return str;
}
</script>
