<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<style type="text/css">
h3.dialog_head {
	margin: 0 !important;
}
.dialog_content {
	width: 610px;
	padding: 0 15px 15px 15px !important;
	overflow: hidden;
}
</style>
<script type="text/javascript">
var SHOP_SITE_URL = "<?php echo SHOP_SITE_URL; ?>";
var UPLOAD_SITE_URL = "<?php echo UPLOAD_SITE_URL; ?>";
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_config_index'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=web_config&op=web_config"><span><?php echo '板块区';?></span></a></li>
        <li><a href="index.php?act=web_api&op=focus_edit"><span><?php echo '焦点区';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '促销区';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo '最多可以加五组，每组五个商品。';?></li>
            <li><?php echo '所有相关设置完成，使用底部的“更新板块内容”前台展示页面才会变化。';?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="sale_list_form" method="post" name="form1">
    <input type="hidden" name="web_id" value="<?php echo $output['code_sale_list']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_sale_list']['code_id'];?>">
    <div class="sale-layout">
      <?php if (is_array($output['code_sale_list']['code_info']) && !empty($output['code_sale_list']['code_info'])) { ?>
      <?php foreach ($output['code_sale_list']['code_info'] as $key => $val) { ?>
      <dl sale_id="<?php echo $key;?>">
      <a href="JavaScript:del_sale_list(<?php echo $key;?>);" class="del">X</a>
        <dt>
          <h4><?php echo $val['recommend']['name'];?></h4>
          <input name="sale_list[<?php echo $key;?>][recommend][name]" value="<?php echo $val['recommend']['name'];?>" type="hidden">
           <a href="JavaScript:show_sale_dialog(<?php echo $key;?>);"><i class="icon-edit"></i><?php echo $lang['nc_edit'];?></a> </dt>
        <dd>
          <ul>
            <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])){ ?>
            <?php foreach($val['goods_list'] as $k => $v){ ?>
            <li>
              <div class="goods-thumb"><img title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>"/></div>
              <input name="sale_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_id]" value="<?php echo $v['goods_id'];?>" type="hidden">
              <input name="sale_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][market_price]" value="<?php echo $v['market_price'];?>" type="hidden">
              <input name="sale_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_name]" value="<?php echo $v['goods_name'];?>" type="hidden">
              <input name="sale_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_price]" value="<?php echo $v['goods_price'];?>" type="hidden">
              <input name="sale_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_pic]" value="<?php echo $v['goods_pic'];?>" type="hidden">
            </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </dd>
      </dl>
      <?php } ?>
      <?php } ?>
      <div class="add-sale" id="add_list"><a class="btn-add-nofloat" href="JavaScript:add_sale_list();"><?php echo $lang['web_config_add_recommend'];?></a><?php echo $lang['web_config_sale_max'];?></div>
    </div>
    <a href="index.php?act=web_api&op=html_update&web_id=<?php echo $output['code_sale_list']['web_id'];?>" class="btn"><span><?php echo $lang['web_config_web_html'];?></span></a>
  </form>
</div>

<!-- 促销区商品推荐模块 -->
<div id="sale_list_dialog" style="display:none;">
  <?php if (is_array($output['code_sale_list']['code_info']) && !empty($output['code_sale_list']['code_info'])) { ?>
  <?php foreach ($output['code_sale_list']['code_info'] as $key => $val) { ?>
  <dl select_sale_id="<?php echo $key;?>">
    <dt>
      <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_title'];?></h4>
      <div class="dialog-handle-box"><span class="left">
        <input name="sale_list[<?php echo $key;?>][recommend][name]" value="<?php echo $val['recommend']['name'];?>" type="text" class="w200">
        </span><span class="right"><?php echo $lang['web_config_recommend_tips'];?></span>
        <div class="clear"></div>
      </div>
    </dt>
    <dd>
      <div class="s-tips"><i></i><?php echo $lang['web_config_goods_list_tips'];?></div>
      <ul class="dialog-goodslist-s1 goods-list">
        <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])){ ?>
        <?php foreach($val['goods_list'] as $k => $v){ ?>
        <li>
          <div ondblclick="del_sale_goods(<?php echo $v['goods_id'];?>);" class="goods-pic"> <span class="ac-ico" onclick="del_sale_goods(<?php echo $v['goods_id'];?>);"></span>
            <span class="thumb size-72x72"><i></i><img select_goods_id="<?php echo $v['goods_id'];?>"
                title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>"
                onload="javascript:DrawImage(this,72,72);" goods_price="<?php echo $v['goods_price'];?>" market_price="<?php echo $v['goods_marketprice'];?>" /></span></div>
          <div class="goods-name"><a href="<?php echo SHOP_SITE_URL."/index.php?act=goods&goods_id=".$v['goods_id'];?>" target="_blank"><?php echo $v['goods_name'];?></a></div>
        </li>
        <?php } ?>
        <?php } ?>
      </ul>
    </dd>
  </dl>
  <?php } ?>
  <?php } ?>
  <div id="select_sale_list" style="display:none;"></div>
  <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_add_goods'];?></h4>
  <div class="dialog-show-box">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label><?php echo $lang['web_config_goods_order_gcategory'];?></label></th>
          <td colspan="3" class="dialog-select-bar" id="gcategory"><input type="hidden" id="cate_id" name="cate_id" value="0" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select>
              <option value="0">-<?php echo $lang['nc_please_choose'];?>-</option>
              <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
              <?php foreach($output['goods_class'] as $k => $v){ ?>
              <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <th><label><?php echo $lang['web_config_goods_order_type'];?></label></th>
          <td><select name="goods_order" id="goods_order">
              <option value="goods_salenum" selected><?php echo $lang['web_config_goods_order_sale'];?></option>
              <option value="goods_click" ><?php echo $lang['web_config_goods_order_click'];?></option>
              <option value="evaluation_count" ><?php echo $lang['web_config_goods_order_comment'];?></option>
              <option value="goods_collect" ><?php echo $lang['web_config_goods_order_collect'];?></option>
            </select></td>
          <th><label for="order_goods_name"><?php echo $lang['web_config_goods_order_name'];?></label></th>
          <td><input type="text" value="" name="order_goods_name" id="order_goods_name" class="txt">
            <a href="JavaScript:void(0);" onclick="get_goods_list();" class="btn-search " title="<?php echo $lang['nc_query'];?>"></a></td>
        </tr>
      </tbody>
    </table>
    <div id="show_sale_goods_list"></div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
  <a href="JavaScript:void(0);" onclick="update_sale();" class="btn"><span><?php echo $lang['web_config_save'];?></span></a> </div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/web_config/web_index.js"></script>
