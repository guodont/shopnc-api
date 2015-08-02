<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_index_goods'];?></h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('goods', 'goods');?>" ><span><?php echo $lang['goods_index_all_goods'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['goods_index_lock_goods'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('goods', 'goods', array('type' => 'waitverify'));?>"><span>等待审核</span></a></li>
        <li><a href="<?php echo urlAdmin('goods', 'goods_set');?>"><span><?php echo $lang['nc_goods_set'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="goods" />
    <input type="hidden" name="op" value="goods" />
    <input type="hidden" name="type" value="lockup" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th> <label for="search_goods_name"><?php echo $lang['goods_index_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['search_goods_name'];?>" name="search_goods_name" id="search_goods_name" class="txt"></td>
          <th><label><?php echo $lang['goods_index_class_name'];?></label></th>
          <td id="searchgc_td"></td>
          <input type="hidden" id="choose_gcid" name="choose_gcid" value="0"/>
        </tr>
        <tr>
          <th><label for="search_store_name"><?php echo $lang['goods_index_store_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['search_store_name'];?>" name="search_store_name" id="search_store_name" class="txt"></td>
          <th><label><?php echo $lang['goods_index_brand'];?></label></th>
          <td><div id="ajax_brand" class="ncsc-brand-select w180">
              <div class="selection">
                <input name="b_name" id="b_name" value="<?php echo $_REQUEST['b_name'];?>" type="text" class="txt w180" readonly="readonly" />
                <input type="hidden" name="b_id" id="b_id" value="<?php echo $_REQUEST['b_id'];?>" />
              </div>
              <div class="ncsc-brand-select-container">
                <div class="brand-index" data-url="index.php?act=common&op=ajax_get_brand">
                  <div class="letter" nctype="letter">
                    <ul>
                      <li><a href="javascript:void(0);" data-letter="all">全部品牌</a></li>
                      <li><a href="javascript:void(0);" data-letter="A">A</a></li>
                      <li><a href="javascript:void(0);" data-letter="B">B</a></li>
                      <li><a href="javascript:void(0);" data-letter="C">C</a></li>
                      <li><a href="javascript:void(0);" data-letter="D">D</a></li>
                      <li><a href="javascript:void(0);" data-letter="E">E</a></li>
                      <li><a href="javascript:void(0);" data-letter="F">F</a></li>
                      <li><a href="javascript:void(0);" data-letter="G">G</a></li>
                      <li><a href="javascript:void(0);" data-letter="H">H</a></li>
                      <li><a href="javascript:void(0);" data-letter="I">I</a></li>
                      <li><a href="javascript:void(0);" data-letter="J">J</a></li>
                      <li><a href="javascript:void(0);" data-letter="K">K</a></li>
                      <li><a href="javascript:void(0);" data-letter="L">L</a></li>
                      <li><a href="javascript:void(0);" data-letter="M">M</a></li>
                      <li><a href="javascript:void(0);" data-letter="N">N</a></li>
                      <li><a href="javascript:void(0);" data-letter="O">O</a></li>
                      <li><a href="javascript:void(0);" data-letter="P">P</a></li>
                      <li><a href="javascript:void(0);" data-letter="Q">Q</a></li>
                      <li><a href="javascript:void(0);" data-letter="R">R</a></li>
                      <li><a href="javascript:void(0);" data-letter="S">S</a></li>
                      <li><a href="javascript:void(0);" data-letter="T">T</a></li>
                      <li><a href="javascript:void(0);" data-letter="U">U</a></li>
                      <li><a href="javascript:void(0);" data-letter="V">V</a></li>
                      <li><a href="javascript:void(0);" data-letter="W">W</a></li>
                      <li><a href="javascript:void(0);" data-letter="X">X</a></li>
                      <li><a href="javascript:void(0);" data-letter="Y">Y</a></li>
                      <li><a href="javascript:void(0);" data-letter="Z">Z</a></li>
                      <li><a href="javascript:void(0);" data-letter="0-9">其他</a></li>
                    </ul>
                  </div>
                  <div class="search" nctype="search">
                    <input name="search_brand_keyword" id="search_brand_keyword" type="text" class="text" placeholder="品牌名称关键字查找"/>
                    <a href="javascript:void(0);" class="ncsc-btn-mini" style="vertical-align: top;">Go</a></div>
                </div>
                <div class="brand-list" nctype="brandList">
                  <ul nctype="brand_list">
                    <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])){?>
                    <?php foreach($output['brand_list'] as $val) { ?>
                    <li data-id='<?php echo $val['brand_id'];?>'data-name='<?php echo $val['brand_name'];?>'><em><?php echo $val['brand_initial'];?></em><?php echo $val['brand_name'];?></li>
                    <?php } ?>
                    <?php }?>
                  </ul>
                </div>
                <div class="no-result" nctype="noBrandList" style="display: none;">没有符合"<strong>搜索关键字</strong>"条件的品牌</div>
              </div>
            </div></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_goods" action="<?php echo urlAdmin('goods', 'goods_del');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w60 align-center">平台货号</th>
          <th colspan="2"><?php echo $lang['goods_index_name'];?></th>
          <th><?php echo $lang['goods_index_brand'];?>&<?php echo $lang['goods_index_class_name'];?></th>
          <th class="w72 align-center">价格(元)</th>
          <th class="w72 align-center">库存</th>
          <th class="w72 align-center">商品状态</th>
          <th class="w96 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
        <?php foreach($output['goods_list'] as $k => $v){  ?>
        <tr class="hover edit">
          <td><i class="icon-plus-sign" nctype="ajaxGoodsList" data-comminid="<?php echo $v['goods_commonid'];?>" style="cursor: pointer;"></i></td>
          <td><?php echo $v['goods_commonid'];?></td>
          <td class="w60"><div class="goods-picture"><span class="thumb size-goods"><i></i><img src="<?php echo thumb($v, 60);?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
          <td><dl class="goods-info">
              <dt class="goods-name"><?php echo $v['goods_name'];?></dt>
              <dd class="goods-type">
                <?php if ($v['is_virtual'] ==1) {?>
                <span class="virtual" title="虚拟兑换商品">虚拟</span>
                <?php }?>
                <?php if ($v['is_fcode'] ==1) {?>
                <span class="fcode" title="F码优先购买商品">F码</span>
                <?php }?>
                <?php if ($v['is_presell'] ==1) {?>
                <span class="presell" title="预先发售商品">预售</span>
                <?php }?>
                <?php if ($v['is_appoint'] ==1) {?>
                <span class="appoint" title="预约销售提示商品">预约</span>
                <?php }?>
                <i class="icon-tablet <?php if ($v['mobile_body'] != '') {?>open<?php }?>" title="手机端商品详情"></i> </dd>
              <dd class="goods-store"><?php echo $output['ownShopIds'][$v['store_id']] ? '平台' : '三方'; ?>店铺：<?php echo $v['store_name'];?></dd>
            </dl></td>
          <td><p><?php echo $v['gc_name'];?></p>
            <p class="goods-brand">品牌：<?php echo $v['brand_name'];?></p></td>
          <td class="align-center"><?php echo $v['goods_price']?></td>
          <td class="align-center"><?php echo $output['storage_array'][$v['goods_commonid']]['sum']?></td>
          <td class="align-center"><p><?php echo $output['state'][$v['goods_state']];?></p>
            <?php if ($v['goods_state'] == 0) {?>
            <p><?php echo $v['goods_stateremark'];?></p>
            <?php }?></td>
          <td class="w48 align-center"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['storage_array'][$v['goods_commonid']]['goods_id']));?>" target="_blank"><?php echo $lang['nc_view'];?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" nctype="del_batch" uri="<?php echo urlAdmin('goods', 'goods_del', array('goods_id' => $v['goods_commonid']));?>"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <tr style="display:none;">
          <td colspan="20"><div class="ncsc-goods-sku ps-container"></div></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(function(){
	//商品分类
	init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);
	/* AJAX选择品牌 */
    $("#ajax_brand").brandinit();

    $('#ncsubmit').click(function(){
        $('input[name="op"]').val('goods');$('#formSearch').submit();
    });

    // 删除
    $('a[nctype="del_batch"]').click(function(){
        if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
            ajaxget($(this).attr('uri'));
        }
    });

    // ajax获取商品列表
    $('i[nctype="ajaxGoodsList"]').toggle(
        function(){
            $(this).removeClass('icon-plus-sign').addClass('icon-minus-sign');
            var _parenttr = $(this).parents('tr');
            var _commonid = $(this).attr('data-comminid');
            var _div = _parenttr.next().find('.ncsc-goods-sku');
            if (_div.html() == '') {
                $.getJSON('index.php?act=goods&op=get_goods_list_ajax' , {commonid : _commonid}, function(date){
                    if (date != 'false') {
                        var _ul = $('<ul class="ncsc-goods-sku-list"></ul>');
                        $.each(date, function(i, o){
                            $('<li><div class="goods-thumb" title="商家货号：' + o.goods_serial + '"><a href="' + o.url + '" target="_blank"><image src="' + o.goods_image + '" ></a></div>' + o.goods_spec + '<div class="goods-price">价格：<em title="￥' + o.goods_price + '">￥' + o.goods_price + '</em></div><div class="goods-storage">库存：<em title="' + o.goods_storage + '">' + o.goods_storage + '</em></div><a href="' + o.url + '" target="_blank" class="ncsc-btn-mini">查看商品详情</a></li>').appendTo(_ul);
                        });
                        _ul.appendTo(_div);
                        _parenttr.next().show();
                        // 计算div的宽度
                        _div.css('width', document.body.clientWidth-54);
                        _div.perfectScrollbar();
                    }
                });
            } else {
            	_parenttr.next().show()
            }
        },
        function(){
            $(this).removeClass('icon-minus-sign').addClass('icon-plus-sign');
            $(this).parents('tr').next().hide();
        }
    );
});
</script>
