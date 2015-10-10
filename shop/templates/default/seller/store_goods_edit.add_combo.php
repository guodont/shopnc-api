<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-info alert-block">
  <div class="faq-img"></div>
  <h4>说明：</h4>
  <ul>
    <li>1.请不要重复选择同一个商品。</li>
    <li>2.特殊商品（如：虚拟商品、F码商品、预售商品）不能参加推荐组合。</li>
  </ul>
</div>
<form method="post" id="goods_combo" action="<?php echo urlShop('store_goods_online', 'save_combo');?>">
  <input type="hidden" name="form_submit" value="ok">
  <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url'];?>" />
  <input type="hidden" name="commonid" value="<?php echo intval($_GET['commonid']);?>" />
  <?php if (!empty($output['goods_array'])) {?>
  <?php foreach ($output['goods_array'] as $value) {?>
  <div class="ncsc-form-goods-combo" data-gid="<?php echo $value['goods_id'];?>">
    <div class="default-goods">
      <div class="goods-pic"><span><img src="<?php echo thumb($value, 240);?>"/></span><em>SKU：<?php echo $value['goods_id'];?></em></div>
      <div class="goods-name"><?php echo $value['goods_name'];?></div>
      <a class="ncsc-btn" nctype="select_goods" href="javascript:void(0);"><i class="icon-thumbs-up"></i>选择商品推荐组合</a></div>
    <div class="combo-goods" nctype="choose_goods_list">
      <ul>
        <?php if (!empty($output['combo_array'][$value['goods_id']])) {?>
        <?php foreach ($output['combo_array'][$value['goods_id']] as $combo) {?>
        <li>
          <input type="hidden" value="<?php echo $combo['goods_id'];?>" name="combo[<?php echo $value['goods_id'];?>][]">
          <div class="pic-thumb"> <a target="_blank" href="<?php echo urlShop('goods', 'index', array('goods_id' => $combo['goods_id']));?>"> <img src="<?php echo cthumb($combo['goods_image'], '240', $_SESSION['store_id']);?>"> </a> </div>
          <dl>
            <dt><a target="_blank" href="<?php echo urlShop('goods', 'index', array('goods_id' => $combo['goods_id']));?>"><?php echo $combo['goods_name'];?></a></dt>
            <dd>￥<?php echo $combo['goods_price'];?></dd>
          </dl>
          <a class="ncsc-btn-mini ncsc-btn-red" nctype="del_choosed" href="javascript:void(0);"><i class="icon-ban-circle"></i>取消推荐</a></li>
        <?php }?>
        <?php }?>
      </ul>
    </div>
    <div class="div-goods-select" style="display: none;">
      <table class="search-form">
        <thead>
          <tr>
            <td></td>
            <th>商品名称</th>
            <td class="w160"><input class="text" type="text" name="search_combo"></td>
            <td class="tc w70"><a class="ncsc-btn" href="javascript:void(0);" nctype="search_combo"><i class="icon-search"></i>搜索</a></td>
            <td class="w10"></td>
          </tr>
        </thead>
      </table>
      <div class="search-result" nctype="combo_goods_list"></div>
      <a class="close" href="javascript:void(0);" nctype="btn_hide_goods_select">X</a> </div>
  </div>
  <?php }?>
  <?php }?>
  <div class="bottom tc hr32">
    <label class="submit-border">
      <input type="submit" class="submit" value="提交" />
    </label>
  </div>
</form>
<script type="text/javascript">
$(function(){
	//凸显鼠标触及区域、其余区域半透明显示
	$("#goods_combo > div").jfade({
        start_opacity:"1",
        high_opacity:"1",
        low_opacity:".25",
        timing:"200"
    });
    // 选择赠品按钮
    $('a[nctype="select_goods"]').click(function(){
        $(this).parents('.ncsc-form-goods-combo:first').find('.div-goods-select').show()
        .find('input[name="search_combo"]').val('').end()
        .find('a[nctype="search_combo"]').click();
    });

    // 关闭按钮
    $('a[nctype="btn_hide_goods_select"]').click(function(){
        $(this).parent().hide();
    });

    // 所搜商品
    $('a[nctype="search_combo"]').click(function(){
        _url = "<?php echo urlShop('store_goods_online', 'search_goods');?>";
        _name = $(this).parents('tr').find('input[name="search_combo"]').val();
        $(this).parents('table:first').next().load(_url, {name: _name});
    });

    // 分页
    $('div[nctype="combo_goods_list"]').on('click', 'a[class="demo"]', function(){
        $(this).parents('div[nctype="combo_goods_list"]').load($(this).attr('href'));
        return false;
    });

    // 删除
    $('div[nctype="choose_goods_list"]').on('click', 'a[nctype="del_choosed"]', function(){
        $(this).parents('li:first').remove();
    });

    // 选择商品
    $('div[nctype="combo_goods_list"]').on('click', 'a[nctype="a_choose_goods"]', function(){
        _owner_gid = $(this).parents('.ncsc-form-goods-combo:first').attr('data-gid');
        eval('var data_str = ' + $(this).attr('data-param'));
        _li = $('<li></li>')
            .append('<input type="hidden" value="' + data_str.gid + '" name="combo[' + _owner_gid + '][]">')
            .append('<div class="pic-thumb"> <a target="_blank" href="' + data_str.gurl + '"> <img src="' + data_str.gimage240 + '"> </a> </div>')
            .append('<dl><dt><a target="_blank" href="' + data_str.gurl + '">' + data_str.gname + '</a></dt><dd>￥' + data_str.gprice + '</dd></dl>')
            .append('<a class="ncsc-btn-mini ncsc-btn-red" nctype="del_choosed" href="javascript:void(0);"><i class="icon-ban-circle"></i>取消推荐</a>');
        $(this).parents('.ncsc-form-goods-combo:first').find('[nctype="choose_goods_list"] > ul').append(_li);
    });

    $('#goods_combo').submit(function(){
        ajaxpost('goods_combo', '', '', 'onerror');
    });
});
</script> 
