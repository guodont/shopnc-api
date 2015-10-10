<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-info alert-block">
  <div class="faq-img"></div>
  <h4>说明：</h4>
  <ul>
    <li>1.请不要重复选择同一个商品。</li>
    <li>2.特殊商品（如：虚拟商品、F码商品、预售商品）不能作为赠品。</li>
    <li>3.赠品为正常销售中的商品，赠品送出后会记录销量。</li>
    <li>4.如赠品库存不足或已经下架，不会被作为赠品加入到订单流程。</li>
  </ul>
</div>
<form method="post" id="goods_gift" action="<?php echo urlShop('store_goods_online', 'save_gift');?>">
  <input type="hidden" name="form_submit" value="ok">
  <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url'];?>" />
  <input type="hidden" name="commonid" value="<?php echo intval($_GET['commonid']);?>" />
  <?php if (!empty($output['goods_array'])) {?>
  <?php foreach ($output['goods_array'] as $value) {?>
  <div class="ncsc-form-goods-gift" data-gid="<?php echo $value['goods_id'];?>">
    <div class="goods-pic"> <span><img src="<?php echo thumb($value, 240);?>"/></span></div>
    <div class="goods-summary">
      <h2><?php echo $value['goods_name'];?><em>SKU：<?php echo $value['goods_id'];?></em></h2>
      <dl>
        <dt>商品价格：</dt>
        <dd>￥<?php echo $value['goods_price'];?></dd>
      </dl>
      <dl>
        <dt>库&nbsp;&nbsp;存&nbsp;&nbsp;量：</dt>
        <dd><?php echo $value['goods_storage'];?></dd>
      </dl>      
      <dl>
        <dt>赠品捆绑：</dt>
        <dd>
          <ul class="goods-gift-list" nctype="choose_goods_list">
            <?php if (!empty($output['gift_array'][$value['goods_id']])) {?>
            <?php foreach ($output['gift_array'][$value['goods_id']] as $gift) {?>
            <li>
              <div class="pic-thumb"><span><img src="<?php echo cthumb($gift['gift_goodsimage'], '60', $_SESSION['store_id']);?>"></span></div>
              <dl class="goods_name">
                <dt><?php echo $gift['gift_goodsname'];?></dt>
                <dd>赠品数量：
                  <input class="text" type="text" value="<?php echo $gift['gift_amount'];?>" name="gift[<?php echo $value['goods_id'];?>][<?php echo $gift['gift_goodsid'];?>]">
                </dd>
              </dl>
              <a class="gift-del" nctype="del_choosed" href="javascript:void(0);" title="删除赠品">X</a></li>
            <?php }?>
            <?php }?>
          </ul>
          <a class="ncsc-btn-mini" nctype="select_goods" href="javascript:void(0);"><i class="icon-gift"></i>选择赠品</a></dd>
      </dl>
    </div>
    <div class="div-goods-select" style="display: none;">
      <table class="search-form">
        <thead>
          <tr>
            <td></td>
            <th>商品名称</th>
            <td class="w160"><input class="text" type="text" name="search_gift"></td>
            <td class="tc w70"><a class="ncsc-btn" href="javascript:void(0);" nctype="search_gift"><i class="icon-search"></i>搜索</a></td>
            <td class="w10"></td>
          </tr>
        </thead>
      </table>
      <div class="search-result" nctype="gift_goods_list"></div>
      <a class="close" href="javascript:void(0);" nctype="btn_hide_goods_select">X</a> </div>
  </div>
  <?php }?>
  </div>
  <?php }?>
  <div class="bottom tc">
    <label class="submit-border">
      <input type="submit" class="submit" value="确认提交" />
    </label>
  </div>
</form>
<script type="text/javascript">
$(function(){
	//凸显鼠标触及区域、其余区域半透明显示
	$("#goods_gift > div").jfade({
        start_opacity:"1",
        high_opacity:"1",
        low_opacity:".25",
        timing:"200"
    });
    // 选择赠品按钮
    $('a[nctype="select_goods"]').click(function(){
        $(this).parents('.goods-summary:first').nextAll('.div-goods-select').show()
            .find('input[name="search_gift"]').val('').end()
            .find('a[nctype="search_gift"]').click();
    });

    // 关闭按钮
    $('a[nctype="btn_hide_goods_select"]').click(function(){
        $(this).parent().hide();
    });

    // 所搜商品
    $('a[nctype="search_gift"]').click(function(){
        _url = "<?php echo urlShop('store_goods_online', 'search_goods');?>";
        _name = $(this).parents('tr').find('input[name="search_gift"]').val();
        $(this).parents('table:first').next().load(_url, {name: _name});
    });

    // 分页
    $('div[nctype="gift_goods_list"]').on('click', 'a[class="demo"]', function(){
        $(this).parents('div[nctype="gift_goods_list"]').load($(this).attr('href'));
        return false;
    });

    // 删除
    $('ul[nctype="choose_goods_list"]').on('click', 'a[nctype="del_choosed"]', function(){
        $(this).parents('li:first').remove();
    });

    // 选择商品
    $('div[nctype="gift_goods_list"]').on('click', 'a[nctype="a_choose_goods"]', function(){
        _owner_gid = $(this).parents('.ncsc-form-goods-gift:first').attr('data-gid');
        eval('var data_str = ' + $(this).attr('data-param'));
        _li = $('<li></li>')
            .append('<div class="pic-thumb"><span><img src="' + data_str.gimage + '"></span></div>')
            .append('<dl class="goods_name"><dt>' + data_str.gname + '</dt><dd>赠品数量：<input class="text" type="text" value="1" name="gift[' + _owner_gid + '][' + data_str.gid + ']"></dd></dl>')
            .append('<a class="gift-del" nctype="del_choosed" href="javascript:void(0);" title="删除赠品">X</a>');
        $(this).parents('.div-goods-select:first').prev().find('ul[nctype="choose_goods_list"]').append(_li);
    });

    $('#goods_gift').submit(function(){
        ajaxpost('goods_gift', '', '', 'onerror');
    });
});
</script> 
