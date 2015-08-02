<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/template.min.js" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){

        // 当前编辑对象，默认为空
        $edit_item = {};

        //现实商品搜索
        $('#btn_show_goods_select').on('click', function() {
            $('#div_goods_select').show();
        });

        //隐藏商品搜索
        $('#btn_hide_goods_select').on('click', function() {
            $('#div_goods_select').hide();
        });

        //搜索商品
        $('#btn_search_goods').on('click', function() {
            var url = "<?php echo urlShop('store_promotion_xianshi', 'goods_select');?>";
            url += '&' + $.param({goods_name: $('#search_goods_name').val()});
            $('#div_goods_search_result').load(url);
        });
        $('#div_goods_search_result').on('click', 'a.demo', function() {
            $('#div_goods_search_result').load($(this).attr('href'));
            return false;
        });

        //添加限时折扣商品弹出窗口 
        $('#div_goods_search_result').on('click', '[nctype="btn_add_xianshi_goods"]', function() {
            $('#dialog_goods_id').val($(this).attr('data-goods-id'));
            $('#dialog_goods_name').text($(this).attr('data-goods-name'));
            $('#dialog_goods_price').text($(this).attr('data-goods-price'));
            $('#dialog_input_goods_price').val($(this).attr('data-goods-price'));
            $('#dialog_goods_img').attr('src', $(this).attr('data-goods-img'));
            $('#dialog_add_xianshi_goods').nc_show_dialog({width: 450, title: '添加商品'});
            $('#dialog_xianshi_price').val('');
            $('#dialog_add_xianshi_goods_error').hide();
        });

        //添加限时折扣商品
        $('#div_goods_search_result').on('click', '#btn_submit', function() {
            var goods_id = $('#dialog_goods_id').val();
            var xianshi_id = <?php echo $_GET['xianshi_id'];?>;
            var goods_price = Number($('#dialog_input_goods_price').val());
            var xianshi_price = Number($('#dialog_xianshi_price').val());
            if(!isNaN(xianshi_price) && xianshi_price > 0 && xianshi_price < goods_price) {
                $.post('<?php echo urlShop('store_promotion_xianshi', 'xianshi_goods_add');?>', 
                    {goods_id: goods_id, xianshi_id: xianshi_id, xianshi_price: xianshi_price},
                    function(data) {
                        if(data.result) {
                            $('#dialog_add_xianshi_goods').hide();
                            $('#xianshi_goods_list').prepend(template.render('xianshi_goods_list_template', data.xianshi_goods)).hide().fadeIn('slow');
                            $('#xianshi_goods_list_norecord').hide();
                            showSucc(data.message);
                        } else {
                            showError(data.message);
                        }
                    }, 
                'json');
            } else {
                $('#dialog_add_xianshi_goods_error').show();
            }
        });

        //编辑限时活动商品
        $('#xianshi_goods_list').on('click', '[nctype="btn_edit_xianshi_goods"]', function() {
            $edit_item = $(this).parents('tr.bd-line');
            var xianshi_goods_id = $(this).attr('data-xianshi-goods-id');
            var xianshi_price = $edit_item.find('[nctype="xianshi_price"]').text();
            var goods_price = $(this).attr('data-goods-price');
            $('#dialog_xianshi_goods_id').val(xianshi_goods_id);
            $('#dialog_edit_goods_price').text(goods_price);
            $('#dialog_edit_xianshi_price').val(xianshi_price);
            $('#dialog_edit_xianshi_goods').nc_show_dialog({width: 450, title: '修改价格'});
        });

        $('#btn_edit_xianshi_goods_submit').on('click', function() {
            var xianshi_goods_id = $('#dialog_xianshi_goods_id').val();
            var xianshi_price = Number($('#dialog_edit_xianshi_price').val());
            var goods_price = Number($('#dialog_edit_goods_price').text());
            if(!isNaN(xianshi_price) && xianshi_price > 0 && xianshi_price < goods_price) {
                $.post('<?php echo urlShop('store_promotion_xianshi', 'xianshi_goods_price_edit');?>',
                    {xianshi_goods_id: xianshi_goods_id, xianshi_price: xianshi_price},
                    function(data) {
                        if(data.result) {
                            $edit_item.find('[nctype="xianshi_price"]').text(data.xianshi_price);
                            $edit_item.find('[nctype="xianshi_discount"]').text(data.xianshi_discount);
                            $('#dialog_edit_xianshi_goods').hide();
                        } else {
                            showError(data.message);
                        }
                    }, 'json'
                ); 
            } else {
                $('#dialog_edit_xianshi_goods_error').show();
            }
        });

        //删除限时活动商品
        $('#xianshi_goods_list').on('click', '[nctype="btn_del_xianshi_goods"]', function() {
            var $this = $(this);
            if(confirm('确认删除？')) {
                var xianshi_goods_id = $(this).attr('data-xianshi-goods-id');
                $.post('<?php echo urlShop('store_promotion_xianshi', 'xianshi_goods_delete');?>',
                    {xianshi_goods_id: xianshi_goods_id},
                    function(data) {
                        if(data.result) {
                            $this.parents('tr').hide('slow', function() {
                                var xianshi_goods_count = $('#xianshi_goods_list').find('.bd-line:visible').length;
                                if(xianshi_goods_count <= 0) {
                                    $('#xianshi_goods_list_norecord').show();
                                }
                            });
                        } else {
                            showError(data.message);
                        }
                    }, 'json'
                );
            }
        });

        //渲染限时折扣商品列表
        xianshi_goods_array = $.parseJSON('<?php echo json_encode($output['xianshi_goods_list']);?>');
        if(xianshi_goods_array.length > 0) {
            var xianshi_goods_list = '';
            $.each(xianshi_goods_array, function(index, xianshi_goods) {
                xianshi_goods_list += template.render('xianshi_goods_list_template', xianshi_goods);
            });
            $('#xianshi_goods_list').prepend(xianshi_goods_list);
        } else {
            $('#xianshi_goods_list_norecord').show();
        }
    });
</script>
<div class="tabmenu">
    <?php include template('layout/submenu');?>
    <?php if($output['xianshi_info']['editable']) { ?>
    <a id="btn_show_goods_select" class="ncsc-btn ncsc-btn-green" href="javascript:;"><i></i><?php echo $lang['goods_add'];?></a> </div>
    <?php } ?>
<table class="ncsc-default-table">
  <tbody>
    <tr>
      <td class="w90 tr"><strong><?php echo $lang['xianshi_name'].$lang['nc_colon'];?></strong></td>
      <td class="w120 tl"><?php echo $output['xianshi_info']['xianshi_name'];?></td>
      <td class="w90 tr"><strong><?php echo $lang['start_time'].$lang['nc_colon'];?></strong></td>
      <td class="w120 tl"><?php echo date('Y-m-d H:i',$output['xianshi_info']['start_time']);?></td>
      <td class="w90 tr"><strong><?php echo $lang['end_time'].$lang['nc_colon'];?></strong></td>
      <td class="w120 tl"><?php echo date('Y-m-d H:i',$output['xianshi_info']['end_time']);?></td>
      <td class="w90 tr"><strong><?php echo '购买下限'.$lang['nc_colon'];?></strong></td>
      <td class="w120 tl"><?php echo $output['xianshi_info']['lower_limit'];?></td>
      <td class="w90 tr"><strong><?php echo '状态'.$lang['nc_colon'];?></strong></td>
      <td class="w120 tl"><?php echo $output['xianshi_info']['xianshi_state_text'];?></td>
    </tr>
</table>
<div class="alert">
  <strong><?php echo $lang['nc_explain'];?><?php echo $lang['nc_colon'];?></strong>
  <ul>
    <li><?php echo $lang['xianshi_manage_goods_explain1'];?></li>
    <li><?php echo $lang['xianshi_manage_goods_explain2'];?></li>
  </ul>
</div>
<!-- 商品搜索 -->
<div id="div_goods_select" class="div-goods-select" style="display: none;">
    <table class="search-form">
      <tr><th class="w150"><strong>第一步：搜索店内商品</strong></th><td class="w160"><input id="search_goods_name" type="text w150" class="text" name="goods_name" value=""/></td>
        <td class="w70 tc"><a href="javascript:void(0);" id="btn_search_goods" class="ncsc-btn"/><i class="icon-search"></i><?php echo $lang['nc_search'];?></a></td><td class="w10"></td><td><p class="hint">不输入名称直接搜索将显示店内所有普通商品，特殊商品不能参加。</p></td>
      </tr>
    </table>
  <div id="div_goods_search_result" class="search-result"></div>
  <a id="btn_hide_goods_select" class="close" href="javascript:void(0);">X</a> </div>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w10"></th>
      <th class="w50"></th>
      <th class="tl"><?php echo $lang['goods_name'];?></th>
      <th class="w90"><?php echo $lang['goods_store_price'];?></th>
      <th class="w120">折扣价格</th>
      <th class="w120">折扣率</th>
      <th class="w120"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody id="xianshi_goods_list">
    <tr id="xianshi_goods_list_norecord" style="display:none">
      <td class="norecord" colspan="20"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
  </tbody>
</table>
<div class="bottom">
  <label class="submit-border"><input type="submit" class="submit" id="submit_back" value="<?php echo $lang['nc_back'].$lang['xianshi_index'];?>" onclick="window.location='index.php?act=store_promotion_xianshi&op=xianshi_list'"></label>
</div>
<div id="dialog_edit_xianshi_goods" class="eject_con" style="display:none;">
    <input id="dialog_xianshi_goods_id" type="hidden">
    <dl><dt>商品价格：</dt><dd><span id="dialog_edit_goods_price"></dd>
    </dl>
    <dl><dt>折扣价格：</dt><dd><input id="dialog_edit_xianshi_price" type="text" class="text w70"><em class="add-on"><i class="icon-renminbi"></i></em>
    <p id="dialog_edit_xianshi_goods_error" style="display:none;"><label for="dialog_edit_xianshi_goods_error" class="error"><i class='icon-exclamation-sign'></i>折扣价格不能为空，且必须小于商品价格</label></p>
    </dl>    
    <div class="eject_con">
        <div class="bottom pt10 pb10"><a id="btn_edit_xianshi_goods_submit" class="submit" href="javascript:void(0);">提交</a></div>
    </div>
</div>
<script id="xianshi_goods_list_template" type="text/html">
<tr class="bd-line">
    <td></td>
    <td><div class="pic-thumb"><a href="<%=goods_url%>" target="_blank"><img src="<%=image_url%>" alt=""></a></div></td>
    <td class="tl"><dl class="goods-name"><dt><a href="<%=goods_url%>" target="_blank"><%=goods_name%></a></dt></dl></td>
    <td><?php echo $lang['currency']; ?><%=goods_price%></td>
    <td><?php echo $lang['currency']; ?><span nctype="xianshi_price"><%=xianshi_price%></span></td>
    <td><span nctype="xianshi_discount"><%=xianshi_discount%></span></td>
    <td class="nscs-table-handle">
    <?php if($output['xianshi_info']['editable']) { ?>
    <span><a nctype="btn_edit_xianshi_goods" class="btn-blue" data-xianshi-goods-id="<%=xianshi_goods_id%>" data-goods-price="<%=goods_price%>" href="javascript:void(0);"><i class="icon-edit"></i><p><?php echo $lang['nc_edit'];?></p></a></span>
        <span><a nctype="btn_del_xianshi_goods" class="btn-red" data-xianshi-goods-id="<%=xianshi_goods_id%>" href="javascript:void(0);"><i class="icon-trash"></i><p><?php echo $lang['nc_del'];?></p></a></span>
    <?php } ?>
    </td>
</tr>
</script> 
