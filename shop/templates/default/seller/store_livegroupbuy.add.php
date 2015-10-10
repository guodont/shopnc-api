<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="index.php?act=store_livegroup&op=groupbuy_add" method="post" enctype="multipart/form-data">
    <dl>
      <dt><i class="required">*</i>抢购名称:</dt>
      <dd>
        <input class="w400 text" name="groupbuy_name" type="text" id="groupbuy_name" value="" maxlength="60"  />
        <span></span>
        <p class="hint">抢购标题名称长度最多可输入60个字符</p>
      </dd>
    </dl>
    <dl>
      <dt>抢购副标题<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w400 text" name="remark" type="text" id="remark" value="" maxlength="60"  />
        <span></span>
        <p class="hint">抢购活动副标题最多可输入60个字符</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购开始时间<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input id="start_time" name="start_time" type="text" class="text w130" /><em class="add-on"><i class="icon-calendar"></i></em><span></span>
        <p class="hint"><?php echo '抢购开始时间应大于'.date('Y-m-d H:i', time());?></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购结束时间<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input id="end_time" name="end_time" type="text" class="text w130"/><em class="add-on"><i class="icon-calendar"></i></em><span></span>
        <p class="hint">抢购结束时间应大于抢购开始时间</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>活动有效期<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input id="validity" name="validity" type="text" class="text w130"/><em class="add-on"><i class="icon-calendar"></i></em><span></span>
        <p class="hint">活动有效期为本次线下抢购活动所生成的兑换码有效使用日期，应大于抢购结束时间</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>原价<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w70 text" id="original_price" name="original_price" type="text" value=""/><em class="add-on"><i class="icon-renminbi"></i></em><span></span>
        <p class="hint">原价为所抢线下服务活动的正常销售价格，作为抢购价格参考及折扣率换算，必须是0.01~1000000之间的数字(单位：元)</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购价格<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w70 text" id="groupbuy_price" name="groupbuy_price" type="text" value=""/><em class="add-on"><i class="icon-renminbi"></i></em><span></span>
        <p class="hint">抢购价格线下服务类活动的促销价格，必须是0.01~1000000之间的数字(单位：元)，并小于原价，线下抢购不产生任何物流运输费用</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购数量<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w70 text" id="buyer_count" name="buyer_count" type="text" value=""/>
        <span></span>
        <p class="hint">本次线下抢购最多可销售数量</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>单笔购买上限<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w70 text" id="buyer_limit" name="buyer_limit" type="text" value="1"/>
        <span></span>
        <p class="hint">每个用户ID单笔订单可购买的最多数量，默认为“1”</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购活动图片<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-upload-thumb groupbuy-pic">
          <p><i class="icon-picture"></i> <img nctype="img_groupbuy_image" style="display:none;" src=""/></p>
        </div>
        <input nctype="groupbuy_image" name="groupbuy_image" type="hidden" value="">
        <div class="ncsc-upload-btn"> <a href="javascript:void(0);"> <span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="groupbuy_image" nctype="btn_upload_image"/>
          </span>
          <p><i class="icon-upload-alt"></i>图片上传</p>
          </a> </div>
        <span></span>
        <p class="hint">用于抢购活动页面的图片,请使用宽度440像素、高度293像素、大小1M内的图片，
          支持jpg、jpeg、gif、png格式上传。</p>
      </dd>
    </dl>
    <dl>
      <dt>抢购推荐位图片<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-upload-thumb groupbuy-commend-pic">
          <p><i class="icon-picture"></i> <img nctype="img_groupbuy_image" style="display:none;" src=""/></p>
        </div>
        <input nctype="groupbuy_image" name="groupbuy_image1" type="hidden" value="">
        <div class="ncsc-upload-btn"> <a href="javascript:void(0);"> <span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="groupbuy_image" nctype="btn_upload_image"/>
          </span>
          <p><i class="icon-upload-alt"></i>图片上传</p>
          </a> </div>
        <span></span>
        <p class="hint">用于抢购页侧边推荐位，首页等推荐位的图片,请使用宽度210像素、高度180像素、大小1M内的图片，
          支持jpg、jpeg、gif、png格式上传。</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购分类<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <select id="class" name="class" class="w80">
          <option value="">请选择...</option>
          <?php if(!empty($output['classlist'])){?>
          <?php foreach($output['classlist'] as $class){?>
          <option value="<?php echo $class['live_class_id'];?>"><?php echo $class['live_class_name'];?></option>
          <?php }?>
          <?php }?>
        </select>
        <select id="s_class" name="s_class" class="w80">
          <option value="">请选择...</option>
        </select>
        <span></span>
        <p class="hint">请选择本次抢购所属线下抢购分类，需选中最后一级</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>抢购区域<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <select id="city" name="city" class="w80">
          <option value="">请选择...</option>
          <?php if(!empty($output['arealist'])){?>
          <?php foreach($output['arealist'] as $area){?>
          <option value="<?php echo $area['live_area_id'];?>"><?php echo $area['live_area_name'];?></option>
          <?php }?>
          <?php }?>
        </select>
        <select id="area" name="area" class="w80">
          <option value="">请选择...</option>
        </select>
        <select id="mall" name="mall" class="w80">
          <option value="">请选择...</option>
        </select>
        <span></span>
        <p class="hint">请选择本次抢购所属线下抢购地区，需选中最后一级</p>
      </dd>
    </dl>
    <dl>
      <dt>抢购介绍<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <?php showEditor('groupbuy_intro','','740px','360px','','false',false);?>
        <p class="hr8"><a class="des_demo ncsc-btn" href="index.php?act=store_album&op=pic_list&item=groupbuy"><i class="icon-picture"></i>插入相册图片</a></p>
        <p id="des_demo" style="display:none;"></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>">
      </label>
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
	$("select[name=class]").change(function(){
		var class_id = $(this).val();
		$.ajax({
			type:'GET',
			url:'index.php?act=store_livegroup&op=ajax&type=class&class_id='+class_id,
			success:function(json){
				var html = '<option value="">'+'请选择...'+'</option>'; 
				if(json){
					var data = eval("("+json+")");
					$.each(data,function(i,val){
						html+='<option value="'+val.live_class_id+'">'+val.live_class_name+'</option>';
					});
				}
				$("select[name=s_class]").html(html);
			}
		});
	});

	$("select[name=city]").change(function(){
		var area_id = $(this).val();
		$.ajax({
			type:'GET',
			url:'index.php?act=store_livegroup&op=ajax&type=area&area_id='+area_id,
			success:function(json){
				var html = '<option value="">'+'请选择...'+'</option>'; 
				var mall = '<option value="">'+'请选择...'+'</option>'; 
				if(json){
					var data = eval("("+json+")");
					$.each(data,function(i,val){
						html+='<option value="'+val.live_area_id+'">'+val.live_area_name+'</option>';
					});
				}
				$("select[name=area]").html(html);
				$("select[name=mall]").html(mall);
			}
		});
	});

	
	$("select[name=area]").change(function(){
		var area_id = $(this).val();
		$.ajax({
			type:'GET',
			url:'index.php?act=store_livegroup&op=ajax&type=area&area_id='+area_id,
			success:function(json){
				var html = '<option value="">'+'请选择...'+'</option>'; 
				if(json){
					var data = eval("("+json+")");		
					$.each(data,function(i,val){
						html+='<option value="'+val.live_area_id+'">'+val.live_area_name+'</option>';
					});	
				}
				$("select[name=mall]").html(html);
			}			
		});
	});

	
    $('#start_time').datetimepicker({
        controlType: 'select'
    });

    $('#end_time').datetimepicker({
        controlType: 'select'
    });

	$('#validity').datetimepicker({
		controlType: 'select'
	});

    //图片上传
    $('[nctype="btn_upload_image"]').fileupload({
        dataType: 'json',
            url: "<?php echo urlShop('store_livegroup', 'image_upload');?>",
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
    
    jQuery.validator.methods.greaterThanEndDate = function(value, element) {
        var end_date = $("#end_time").val();
        var date1 = new Date(Date.parse(end_date.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };

    jQuery.validator.methods.lessThanOriginalPrice = function(value, element) {
        var original_price = $("#original_price").val();
        original_price = parseFloat(original_price);
        value = parseFloat(value);
        return value < original_price;
    };

    jQuery.validator.methods.lessThanBuyerCount = function(value, element) {
        var buyer_count = $("#buyer_count").val();
        buyer_count = parseInt(buyer_count);
        value = parseInt(value);
        return value < buyer_count;
    };
    
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        onfocusout: false,
        rules : {
        	groupbuy_name: {
                required : true
            },
            start_time : {
                required : true,
                greaterThanDate:'<?php echo date('Y-m-d H:i',time());?>'
            },
            end_time : {
                required : true,
                greaterThanStartDate:true
            },
            validity : {
            	required : true,
            	greaterThanEndDate:true
            },
            original_price:{
            	required : true,
                number : true,
                min : 0.01,
                max : 1000000
            },
            groupbuy_price: { 
                required : true,
                number : true,
                min : 0.01,
                max : 1000000,
                lessThanOriginalPrice:true
            },
            buyer_count:{
                required : true,
                number : true,
                min : 0,
                max : 1000000
            },
            buyer_limit:{
                required : true,
                number : true,
                min : 1,
                lessThanBuyerCount:true
            },
            groupbuy_image:{
            	required : true,
            },
            s_class:{
            	required : true,
            },
            mall:{
            	required : true,
            }
        },
        messages : {
            groupbuy_name: {
                required : '<i class="icon-exclamation-sign"></i>抢购名称不能为空',
            },
            start_time : {
                required : '<i class="icon-exclamation-sign"></i>抢购开始时间不能为空',
                greaterThanDate:'<?php echo '抢购开始时间应大于'.date('Y-m-d H:i', time());?>'
            },
            end_time : {
                required : '<i class="icon-exclamation-sign"></i>抢购结束时间不能为空',
                greaterThanStartDate : '抢购结束时间应大于抢购开始时间'
            },
            validity : {
            	required : '<i class="icon-exclamation-sign"></i>有效期时间不能为空',
            	greaterThanEndDate : '活动有效期应大于抢购结束时间'
            },
            original_price:{
            	required : '<i class="icon-exclamation-sign"></i>原价不能为空',
                number : '<i class="icon-exclamation-sign"></i>原价必须是数字',
                min : '<i class="icon-exclamation-sign"></i>价格区间0.01~1000000',
                max : '<i class="icon-exclamation-sign"></i>价格区间0.01~1000000'
            },
            groupbuy_price: { 
            	required : '<i class="icon-exclamation-sign"></i>抢购价格不能为空',
                number : '<i class="icon-exclamation-sign"></i>抢购价格必须是数字',
                min : '<i class="icon-exclamation-sign"></i>价格区间0.01~1000000',
                max : '<i class="icon-exclamation-sign"></i>价格区间0.01~1000000',
                lessThanOriginalPrice:'抢购价格应小于原价'
            },
            buyer_count:{
                required : '<i class="icon-exclamation-sign"></i>抢购数量不能为空',
                number : '<i class="icon-exclamation-sign"></i>抢购数量必须是数字',
                min : '<i class="icon-exclamation-sign"></i>抢购数量数值区间0~1000000',
                max : '<i class="icon-exclamation-sign"></i>抢购数量数值区间0~1000000',
            },
            buyer_limit:{
                required : '<i class="icon-exclamation-sign"></i>购买上限不能为空',
                number : '<i class="icon-exclamation-sign"></i>购买上限必须是数字',
                min : '<i class="icon-exclamation-sign"></i>购买上限应大于等于1',
                lessThanBuyerCount : '<i class="icon-exclamation-sign"></i>购买上限应小于抢购数量'
            },
            groupbuy_image:{
            	required : '<i class="icon-exclamation-sign"></i>抢购图片不能为空',
            },
            s_class:{
            	required : '<i class="icon-exclamation-sign"></i>抢购分类不能为空',
            },
            mall:{
            	required : '<i class="icon-exclamation-sign"></i>抢购区域不能为空',
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
</script> 
