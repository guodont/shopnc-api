<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="index.php?act=store_groupbuy&op=groupbuy_save" method="post" enctype="multipart/form-data">
    <dl>
      <dt><i class="required">*</i><?php echo $lang['group_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w400 text" name="groupbuy_name" type="text" id="groupbuy_name" value="" maxlength="30"  />
        <span></span>
        <p class="hint"><?php echo $lang['group_name_tip'];?></p>
      </dd>
    </dl>
    <dl>
      <dt>抢购副标题<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w400 text" name="remark" type="text" id="remark" value="" maxlength="30"  />
        <span></span>
        <p class="hint">抢购活动副标题最多可输入30个字符</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['start_time'];?><?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="start_time" name="start_time" type="text" class="text w130" /><em class="add-on"><i class="icon-calendar"></i></em><span></span>
          <p class="hint"><?php echo '抢购开始时间不能小于'.date('Y-m-d H:i', $output['groupbuy_start_time']);?></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['end_time'];?><?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="end_time" name="end_time" type="text" class="text w130"/><em class="add-on"><i class="icon-calendar"></i></em><span></span>
          <p class="hint">
<?php if (!$output['isOwnShop']) { ?>
          <?php echo '抢购开始时间不能大于'.date('Y-m-d H:i', $output['current_groupbuy_quota']['end_time']);?>
          </p>
<?php } ?>

      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['groupbuy_goods'].$lang['nc_colon'];?></dt>
      <dd>
      <div nctype="groupbuy_goods_info" class="selected-group-goods " style="display:none;">
      <div class="goods-thumb"><img id="groupbuy_goods_image" src=""/></div>
          <div class="goods-name">
          <a nctype="groupbuy_goods_href" id="groupbuy_goods_name" href="" target="_blank"></a>
          </div>
          <div class="goods-price">商城价：￥<span nctype="groupbuy_goods_price"></span></div>
      </div>
      <a href="javascript:void(0);" id="btn_show_search_goods" class="ncsc-btn ncsc-btn-acidblue">选择商品</a>
      <input id="groupbuy_goods_id" name="groupbuy_goods_id" type="hidden" value=""/>
      <span></span>
      <div id="div_search_goods" class="div-goods-select mt10" style="display: none;">
          <table class="search-form">
              <tr>
                  <th class="w150">
                      <strong>第一步：搜索店内商品</strong>
                  </th>
                  <td class="w160">
                      <input id="search_goods_name" type="text w150" class="text" name="goods_name" value=""/>
                  </td>
                  <td class="w70 tc">
                      <a href="javascript:void(0);" id="btn_search_goods" class="ncsc-btn"/><i class="icon-search"></i><?php echo $lang['nc_search'];?></a></td>
                    <td class="w10"></td>
                    <td>
                        <p class="hint">不输入名称直接搜索将显示店内所有普通商品，特殊商品不能参加。</p>
                    </td>
                </tr>
            </table>
            <div id="div_goods_search_result" class="search-result" style="width:739px;"></div>
            <a id="btn_hide_search_goods" class="close" href="javascript:void(0);">X</a>
        </div>
        <p class="hint"><?php echo $lang['groupbuy_goods_explain'];?></br><span class="red">抢购生效后该商品的所有规格SKU都将执行统一的抢购价格</span></p>
        </dd>
    </dl>
    <dl nctype="groupbuy_goods_info" style="display:none;">
      <dt><?php echo $lang['groupbuy_index_store_price'].$lang['nc_colon'];?></dt>
      <dd> <?php echo $lang['currency'];?><span nctype="groupbuy_goods_price"></span><input id="input_groupbuy_goods_price" type="hidden"></dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['groupbuy_price'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w70 text" id="groupbuy_price" name="groupbuy_price" type="text" value=""/><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
        <p class="hint"><?php echo $lang['groupbuy_price_tip'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购活动图片<?php echo $lang['nc_colon'];?></dt>
      <dd>
      <div class="ncsc-upload-thumb groupbuy-pic">
          <p><i class="icon-picture"></i>
          <img nctype="img_groupbuy_image" style="display:none;" src=""/></p>
      </div>
        <input nctype="groupbuy_image" name="groupbuy_image" type="hidden" value="">
        <div class="ncsc-upload-btn">
            <a href="javascript:void(0);">
                <span>
                    <input type="file" hidefocus="true" size="1" class="input-file" name="groupbuy_image" nctype="btn_upload_image"/>
                </span>
                <p><i class="icon-upload-alt"></i>图片上传</p>
            </a>
        </div>
        <span></span>
        <p class="hint"><?php echo $lang['group_pic_explain'];?></p>
        </dd>
    </dl>
    <dl>
      <dt>抢购推荐位图片<?php echo $lang['nc_colon'];?></dt>
      <dd>
      <div class="ncsc-upload-thumb groupbuy-commend-pic">
          <p><i class="icon-picture"></i>
          <img nctype="img_groupbuy_image" style="display:none;" src=""/></p>
      </div>
        <input nctype="groupbuy_image" name="groupbuy_image1" type="hidden" value="">
        <span></span>
        <div class="ncsc-upload-btn">
            <a href="javascript:void(0);">
                <span>
                    <input type="file" hidefocus="true" size="1" class="input-file" name="groupbuy_image" nctype="btn_upload_image"/>
                </span>
                <p><i class="icon-upload-alt"></i>图片上传</p>
            </a>
        </div>
        <p class="hint"><?php echo $lang['group_pic_explain2'];?></p>
        </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['groupbuy_class'].$lang['nc_colon'];?></dt>
      <dd>
        <select id="class_id" name="class_id" class="w80">
          <option value="0"><?php echo $lang['text_no_limit']; ?></option>
        </select>
        <select id="s_class_id" name="s_class_id" class="w80">
          <option value="0"><?php echo $lang['text_no_limit']; ?></option>
        </select>
        <span></span>
        <p class="hint"><?php echo $lang['groupbuy_class_tip'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['virtual_quantity'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w70 text" id="virtual_quantity" name="virtual_quantity" type="text" value="0"/>
        <span></span>
        <p class="hint"><?php echo $lang['virtual_quantity_explain'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['sale_quantity'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w70 text" id="upper_limit" name="upper_limit" type="text" value="0"/>
        <span></span>
        <p class="hint"><?php echo $lang['sale_quantity_explain'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['group_intro'].$lang['nc_colon'];?></dt>
      <dd>
        <?php showEditor('groupbuy_intro','','740px','360px','','false',false);?>
        <p class="hr8"><a class="des_demo ncsc-btn" href="index.php?act=store_album&op=pic_list&item=groupbuy"><i class="icon-picture"></i><?php echo $lang['store_goods_album_insert_users_photo'];?></a></p>
        <p id="des_demo" style="display:none;"></p>
      </dd>
    </dl>
    <div class="bottom"><label class="submit-border">
      <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"></label>
    </div>
  </form>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#start_time').datetimepicker({
        controlType: 'select'
    });

    $('#end_time').datetimepicker({
        controlType: 'select'
    });

    $('#btn_show_search_goods').on('click', function() {
        $('#div_search_goods').show();
    });

    $('#btn_hide_search_goods').on('click', function() {
        $('#div_search_goods').hide();
    });

    //搜索商品
    $('#btn_search_goods').on('click', function() {
        var url = "<?php echo urlShop('store_groupbuy', 'search_goods');?>";
        url += '&' + $.param({goods_name: $('#search_goods_name').val()});
        $('#div_goods_search_result').load(url);
    });

    $('#div_goods_search_result').on('click', 'a.demo', function() {
        $('#div_goods_search_result').load($(this).attr('href'));
        return false;
    });

    //选择商品
    $('#div_goods_search_result').on('click', '[nctype="btn_add_groupbuy_goods"]', function() {
        var goods_commonid = $(this).attr('data-goods-commonid');
        $.get('<?php echo urlShop('store_groupbuy', 'groupbuy_goods_info');?>', {goods_commonid: goods_commonid}, function(data) {
            if(data.result) {
                $('#groupbuy_goods_id').val(data.goods_id);
                $('#groupbuy_goods_image').attr('src', data.goods_image);
                $('#groupbuy_goods_name').text(data.goods_name);
                $('[nctype="groupbuy_goods_price"]').text(data.goods_price);
                $('#input_groupbuy_goods_price').val(data.goods_price);
                $('[nctype="groupbuy_goods_href"]').attr('href', data.goods_href);
                $('[nctype="groupbuy_goods_info"]').show();
                $('#div_search_goods').hide();
            } else {
                showError(data.message);
            }
        }, 'json');
    });

    //图片上传
    $('[nctype="btn_upload_image"]').fileupload({
        dataType: 'json',
            url: "<?php echo urlShop('store_groupbuy', 'image_upload');?>",
            add: function(e, data) {
                $parent = $(this).parents('dd');
                $input = $parent.find('[nctype="groupbuy_image"]');
                $img = $parent.find('[nctype="img_groupbuy_image"]');
                data.formData = {old_groupbuy_image:$input.val()};
                $img.attr('src', "<?php echo SHOP_TEMPLATES_URL.'/images/loading.gif';?>");
                data.submit();
            },
            done: function (e,data) {
                var result = data.result;
                $parent = $(this).parents('dd');
                $input = $parent.find('[nctype="groupbuy_image"]');
                $img = $parent.find('[nctype="img_groupbuy_image"]');
                if(result.result) {
                    $img.prev('i').hide();
                    $img.attr('src', result.file_url);
                    $img.show();
                    $input.val(result.file_name);
                } else {
                    showError(data.message);
                }
            }
    });

    jQuery.validator.methods.greaterThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };

    jQuery.validator.methods.lessThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 > date2;
    };

    jQuery.validator.methods.greaterThanStartDate = function(value, element) {
        var start_date = $("#start_time").val();
        var date1 = new Date(Date.parse(start_date.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };

    jQuery.validator.methods.lessThanGoodsPrice= function(value, element) {
        var goods_price = $("#input_groupbuy_goods_price").val();
        return Number(value) < Number(goods_price);
    };

    jQuery.validator.methods.checkGroupbuyGoods = function(value, element) {
        var start_time = $("#start_time").val();
        var result = true;
        $.ajax({
            type:"GET",
            url:'<?php echo urlShop('store_groupbuy', 'check_groupbuy_goods');?>',
            async:false,
            data:{start_time: start_time, goods_id: value},
            dataType: 'json',
            success: function(data){
                if(!data.result) {
                    result = false;
                }
            }
        });
        return result;
    };

    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        onfocusout: false,
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
        rules : {
            groupbuy_name: {
                required : true
            },
            start_time : {
                required : true,
                greaterThanDate : '<?php echo date('Y-m-d H:i',$output['groupbuy_start_time']);?>'
            },
            end_time : {
                required : true,
<?php if (!$output['isOwnShop']) { ?>
                lessThanDate : '<?php echo date('Y-m-d H:i',$output['current_groupbuy_quota']['end_time']);?>',
<?php } ?>
                greaterThanStartDate : true
            },
            groupbuy_goods_id: {
                required : true,
                checkGroupbuyGoods: true
            },
            groupbuy_price: {
                required : true,
                number : true,
                lessThanGoodsPrice: true,
                min : 0.01,
                max : 1000000
            },
            virtual_quantity: {
                required : true,
                digits : true
            },
            upper_limit: {
                required : true,
                digits : true
            },
            groupbuy_image: {
                required : true
            }
        },
        messages : {
            groupbuy_name: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['group_name_error'];?>'
            },
            start_time : {
                required : '<i class="icon-exclamation-sign"></i>抢购开始时间不能为空',
                greaterThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf('抢购开始时间必须大于{0}',date('Y-m-d H:i',$output['current_groupbuy_quota']['start_time']));?>'
            },
            end_time : {
                required : '<i class="icon-exclamation-sign"></i>抢购结束时间不能为空',
<?php if (!$output['isOwnShop']) { ?>
                lessThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf('抢购结束时间必须小于{0}',date('Y-m-d H:i',$output['current_groupbuy_quota']['end_time']));?>',
<?php } ?>
                greaterThanStartDate : '<i class="icon-exclamation-sign"></i>结束时间必须大于开始时间'
            },
            groupbuy_goods_id: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['group_goods_error'];?>',
                checkGroupbuyGoods: '该商品已经参加了同时段的活动'
            },
            groupbuy_price: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>',
                number : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>',
                lessThanGoodsPrice: '<i class="icon-exclamation-sign"></i>抢购价格必须小于商品价格',
                min : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>',
                max : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>'
            },
            virtual_quantity: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['virtual_quantity_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['virtual_quantity_error'];?>'
            },
            upper_limit: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['sale_quantity_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['sale_quantity_error'];?>'
            },
            groupbuy_image: {
                required : '<i class="icon-exclamation-sign"></i>抢购图片不能为空'
            }
        }
    });

	$('#li_1').click(function(){
		$('#li_1').attr('class','active');
		$('#li_2').attr('class','');
		$('#demo').hide();
	});

	$('#goods_demo').click(function(){
		$('#li_1').attr('class','');
		$('#li_2').attr('class','active');
		$('#demo').show();
	});

	$('.des_demo').click(function(){
		if($('#des_demo').css('display') == 'none'){
            $('#des_demo').show();
        }else{
            $('#des_demo').hide();
        }
	});

    $('.des_demo').ajaxContent({
        event:'click', //mouseover
            loaderType:"img",
            loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif",
            target:'#des_demo'
    });
});

function insert_editor(file_path){
	KE.appendHtml('goods_body', '<img src="'+ file_path + '">');
}

(function(data) {
    var s = '<option value="0"><?php echo $lang['text_no_limit']; ?></option>';
    if (typeof data.children != 'undefined') {
        if (data.children[0]) {
            $.each(data.children[0], function(k, v) {
                s += '<option value="'+v+'">'+data['name'][v]+'</option>';
            });
        }
    }
    $('#class_id').html(s).change(function() {
        var ss = '<option value="0"><?php echo $lang['text_no_limit']; ?></option>';
        var v = this.value;
        if (parseInt(v) && data.children[v]) {
            $.each(data.children[v], function(kk, vv) {
                ss += '<option value="'+vv+'">'+data['name'][vv]+'</option>';
            });
        }
        $('#s_class_id').html(ss);
    });
})($.parseJSON('<?php echo json_encode($output['groupbuy_classes']); ?>'));
</script>
