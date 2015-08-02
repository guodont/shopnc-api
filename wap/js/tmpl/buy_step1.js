$(function() {
	var key = getcookie('key');
	var ifcart = GetQueryString('ifcart');
	if(ifcart==1){
		var cart_id = GetQueryString('cart_id');
		var data = {key:key,ifcart:1,cart_id:cart_id};
	}else{
		var goods_id = GetQueryString("goods_id");
		var number = GetQueryString("buynum");
		var cart_id = goods_id+'|'+number;
		var data = {key:key,cart_id:cart_id};
	}

    var isFCode = false;

    var pf = function(f) {
        return parseFloat(f) || 0;
    };

    var p2f = function(f) {
        return (parseFloat(f) || 0).toFixed(2);
    };

    var isEmpty = function(o) {
        var b = true;
        $.each(o, function(k, v) {
            b = false;
            return false;
        });
        return b;
    }

    var cod = (function() {
        // COD开关
        var codSwitch = $('#buy-type-offline').prop('checked');

        // COD状态
        var codGlobal = false;
        var codStores = {};

        // 0b1 正在使用货到付款
        // 0b2 可以使用预存款和充值卡
        var paymentFlag = 2;

        var stateChanged = function() {
            if (codGlobal) {
                var flag1 = false;
                var flag2 = false;

                $('.store-cod-supported').each(function() {
                    if (codStores[$(this).data('store_id')]) {
                        $(this).hide();
                        flag1 = flag1 || true;
                    } else {
                        $(this).show();
                        flag2 = flag2 || true;
                    }
                });

                paymentFlag = 0;

                if (flag1) {
                    paymentFlag |= 1;
                }
                if (flag2) {
                    paymentFlag |= 2;
                }
            } else {
                $('.store-cod-supported').hide();

                paymentFlag = 2;
            }

            switch (paymentFlag) {
            case 1:
                // 支持货到付款的同时不支持在线支付
                $('#offline').show();
                $('#deposit').hide();
                break;

            case 3:
                // 支持货到付款的同时支持在线支付
                $('#offline').show();
                $('#deposit').show();
                break;

            case 0:
                // none
            case 2:
                // 只支持在线支付
            default:
                // default
                $('#buy-type-offline').prop('checked', false);
                $('#buy-type-online').prop('checked', true);

                // 关闭COD开关
                codSwitch = false;

                $('#offline').hide();
                $('#deposit').show();
                break;
            }

            // 在线支付默认优先开关控制
            if (!codSwitch) {
                $('#deposit').show();
            }

            refleshTotals();
        };

        var refleshTotals = function() {
            if (codSwitch && codGlobal) {
                var codTotal = 0;
                var onlineTotal = 0;

                $('.store_total').each(function() {
                    var sid = this.id.substring(2);
                    var st = parseFloat(this.innerHTML) || 0;
                    if (codStores[sid]) {
                        codTotal += st;
                    } else {
                        onlineTotal += st;
                    }
                });

                //console.log(codTotal);
                //console.log(onlineTotal);
                $('#online-total-wrapper').show();
                $('#online-total').html(p2f(onlineTotal));
            } else {
                $('#online-total-wrapper').hide();
            }
        }

        var switchTriggered = function(b) {
            codSwitch = b;

            stateChanged();
        };

        var stateUpdateded = function(allow_offpay, allow_offpay_batch) {
            codGlobal = allow_offpay == '1';
            codStores = allow_offpay_batch || {};

            stateChanged();
        };

        return {
            switchTriggered: switchTriggered,
            stateUpdateded: stateUpdateded,
            refleshTotals: refleshTotals,
            z: 0
        };
    })();

	$.ajax({//提交订单信息
		type:'post',
		url:ApiUrl+'/index.php?act=member_buy&op=buy_step1',
		dataType:'json',
		data:data,
		success:function(result){
			var data = result.datas;
			if(typeof(data.error )!='undefined'){
				location.href = WapSiteUrl;
			}

			var htmldata = '';
			var total_price = 0;
			var i = 0;
			var j = 0;
			$.each(data.store_cart_list,function(k,v){//循环店铺
				if(i==0){
					htmldata+=	'<li>';
				}else{
					htmldata+=	'<li class="bd-t-cc">';
				}
				i++;
				htmldata+='<p class="buys-yt-tlt">店铺名称：'+v.store_name+'<span data-store_id="'+k+'" class="store-cod-supported" style="display:none;">（该店铺不支持选定收货地址的货到付款）</span></p>';
						$.each(v.goods_list,function(k1,v1){//循环商品列表
							if(j==0){
								htmldata+=	'<div class="buys1-pdlist">';
							}else{
								htmldata+=	'<div class="buys1-pdlist bd-t-de">';
							}
							j++;

                            if (v1.is_fcode == '1') {
                                isFCode = true;
                                $('#container-fcode').show();
                            }

							htmldata+='<div class="clearfix">'
												+'<a class="img-wp" href="'+WapSiteUrl+'/tmpl/product_detail.html?goods_id='+v1.goods_id+'">'
													+'<img src="'+v1.goods_image_url+'"/>'
												+'</a>'
												+'<div class="buys1-pdlcnt">'
													+'<p><a class="buys1-pdlc-name" href="'+WapSiteUrl+'/tmpl/product_detail.html?goods_id='+v1.goods_id+'">'+v1.goods_name+'</a></p>'
													+'<p>单价(元)：￥'+v1.goods_price+'</p>'
													+'<p>数量：'+v1.goods_num+'</p>'
												+'</div>'
											+'</div>'
										+'</div>';
						});
						htmldata+= '<div class="shop-total"><p>运费：￥<span id="store'+k+'"></span></p>';
						if(v.store_mansong_rule_list != null){
							htmldata+= '<p>满即送-'+v.store_mansong_rule_list.desc+':-'+v.store_mansong_rule_list.discount+'</p>';
						}

                        if (v.store_voucher_list && !isEmpty(v.store_voucher_list)) {
                            htmldata+='<p><select name="voucher" store_id="'+k+'">';
                            htmldata+='<option value="0">请选择...</option>';
                            $.each(v.store_voucher_list,function(k2,v2){
                                htmldata+='<option value="'+v2.voucher_t_id+'|'+k+'|'+v2.voucher_price+'">'+v2.voucher_title+'</option>'
                            });
                            htmldata+='</select>:￥-<span id="sv'+k+'">0.00</span></p>';
                        }

						if(v.store_mansong_rule_list != null){
							var sp_total = pf(v.store_goods_total)-pf(v.store_mansong_rule_list.discount);
							htmldata+='<p class="clr-c07">本店合计：￥<span id="st'+k+'" store_price="'+sp_total+'" class="store_total">'+p2f(sp_total)+'</span></p>';
						}else{
							var sp_total = pf(v.store_goods_total);
							htmldata+='<p class="clr-c07">本店合计：￥<span id="st'+k+'" store_price="'+sp_total+'" class="store_total">'+p2f(sp_total)+'</span></p>';
						}
						htmldata+='</div>';
						htmldata+='</li>';
						total_price += sp_total;
			});

			$("#deposit").before(htmldata);//订单列表
			if(data.address_info == ''){//收获地址是否存在
                //如果是发票 就是buys1-invoice-cnt
                var thisPrarent = $(".buys1-address-cnt");
                hideDetail(thisPrarent);
				//填写收获地址
			}else{
				$('#true_name').html(data.address_info.true_name);
				$('#address').html(data.address_info.area_info+' '+data.address_info.address);
				$('#mob_phone').html(data.address_info.mob_phone);
			}

			$('#total_price').html(p2f(total_price));
			$('input[name=total_price]').val(total_price);

			if (data.available_rc_balance != null && data.available_rc_balance > 0) { // 充值卡余额
				$('.pre-deposit-wp').show();
				$('#wrapper-usercbpay').show();
				$('#available_rc_balance').html(data.available_rc_balance);
				$('input[name=available_rc_balance]').val(data.available_rc_balance);
			}

			if(data.available_predeposit != null && data.available_predeposit > 0){//预存款
				$('.pre-deposit-wp').show();
				$('#wrapper-usepdpy').show();
				$('#available_predeposit').html(data.available_predeposit);
				$('input[name=available_predeposit]').val(data.available_predeposit);
			}

            // 点击使用新地址才显示新地址编辑框
            $('#new-address-button').click(function() {
                $('#new-address-wrapper').show();
            });

            // 选择COD则不显示预存款和充值卡
            $('#online').click(function() {
                cod.switchTriggered(0);
            });
            $('#offline').click(function() {
                cod.switchTriggered(1);
            });

/*
			if(data.ifshow_offpay){//支付方式
				$('#offline').show();
			}else{
				$('#offline').hide();
			}
*/

			$('#inv_content').html(data.inv_info.content);
			//$('#inv_content').html(data.inv_info.inv_title+"&nbsp;"+data.inv_info.inv_content);//发票信息
			$('input[name=address_id]').val(data.address_info.address_id);
			$('input[name=area_id]').val(data.address_info.area_id);
			$('input[name=city_id]').val(data.address_info.city_id);
			$('input[name=freight_hash]').val(data.freight_hash);
			$('input[name=vat_hash]').val(data.vat_hash);
			$('input[name=offpay_hash]').val(data.offpay_hash);
			$('input[name=offpay_hash_batch]').val(data.offpay_hash_batch);
			$('input[name=invoice_id]').val(data.inv_info.inv_id);

			var area_id = data.address_info.area_id;
			var city_id = data.address_info.city_id;
			var freight_hash = data.freight_hash;

			$.ajax({//保存地址
				type:'post',
				url:ApiUrl+'/index.php?act=member_buy&op=change_address',
				data:{key:key,area_id:area_id,city_id:city_id,freight_hash:freight_hash},
				dataType:'json',
				success:function(result){
					if(result.datas.state == 'success'){
						var sp_s_total = 0;
						$.each(result.datas.content,function(k,v){
                            v = pf(v);
							$('#store'+k).html(p2f(v));
	        				var sp_toal = pf($('#st'+k).attr('store_price'));//店铺商品价格
	        				sp_s_total += pf(v);
	        				$('#st'+k).html(p2f(sp_toal+v));
						});

						var total_price = pf($('input[name=total_price]').val()) + sp_s_total;
						$('#total_price').html(p2f(total_price));
						//$('input[name=total_price]').val(total_price);

                        cod.stateUpdateded(result.datas.allow_offpay, result.datas.allow_offpay_batch);

						$('input[name=allow_offpay]').val(result.datas.allow_offpay);
						$('input[name=offpay_hash]').val(result.datas.offpay_hash);
						$('input[name=offpay_hash_batch]').val(result.datas.offpay_hash_batch);
					}
				}
			});

			$('select[name=voucher]').change(function(){//选择代金券
				var store_id = $(this).attr('store_id');
				var varr = $(this).val();
				if(varr == 0){
					var store_price = 0;
				}else{
					var store_price = pf(varr.split('|')[2]);
				}
				var store_total_price = pf($('#st'+store_id).attr('store_price'));
				var store_tran = pf($('#store'+store_id).html());
				store_total = pf(store_total_price) - store_price + store_tran;
				$("#sv"+store_id).html(p2f(store_price));
				$("#st"+store_id).html(p2f(store_total));

				var total_price = 0;
				$('.store_total').each(function(){
					total_price += pf($(this).html());
				});
				$('#total_price').html(p2f(total_price));

                cod.refleshTotals();
			});
		}
	});

	$.ajax({//获取区域列表
		type:'post',
		url:ApiUrl+'/index.php?act=member_address&op=area_list',
		data:{key:key},
		dataType:'json',
		success:function(result){
			checklogin(result.login);
			var data = result.datas;
			var prov_html = '';
			for(var i=0;i<data.area_list.length;i++){
				prov_html+='<option value="'+data.area_list[i].area_id+'">'+data.area_list[i].area_name+'</option>';
			}
			$("select[name=prov]").append(prov_html);
		}
	});

	$.ajax({//获取发票内容
		type:'post',
		url:ApiUrl+'/index.php?act=member_invoice&op=invoice_content_list',
		data:{key:key},
		dataType:'json',
		success:function(result){
			checklogin(result.login);
			var data = result.datas;
			var html = '';
			$.each(data.invoice_content_list,function(k,v){
				html+='<option value="'+v+'">'+v+'</option>';
			});
			$('#inc_content').append(html);
		}
	});

	$("select[name=prov]").change(function(){//选择省市
		var prov_id = $(this).val();
		$.ajax({
			type:'post',
			url:ApiUrl+'/index.php?act=member_address&op=area_list',
			data:{key:key,area_id:prov_id},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				var data = result.datas;
				var city_html = '<option value="">请选择...</option>';
				for(var i=0;i<data.area_list.length;i++){
					city_html+='<option value="'+data.area_list[i].area_id+'">'+data.area_list[i].area_name+'</option>';
				}
				$("select[name=city]").html(city_html);
				$("select[name=region]").html('<option value="">请选择...</option>');
			}
		});
	});

	$("select[name=city]").change(function(){//选择城市
		var city_id = $(this).val();
		$.ajax({
			type:'post',
			url:ApiUrl+'/index.php?act=member_address&op=area_list',
			data:{key:key,area_id:city_id},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				var data = result.datas;
				var region_html = '<option value="">请选择...</option>';
				for(var i=0;i<data.area_list.length;i++){
					region_html+='<option value="'+data.area_list[i].area_id+'">'+data.area_list[i].area_name+'</option>';
				}
				$("select[name=region]").html(region_html);
			}
		});
	});

	$.ajax({//获取发票列表
		type:'post',
		url:ApiUrl+'/index.php?act=member_invoice&op=invoice_list',
		data:{key:key},
		dataType:'json',
		success:function(result){
			checklogin(result.login);
			var invoice = result.datas.invoice_list;
			if(invoice.length>0){
				var html = '';
				$.each(invoice,function(k,v){
					html+= '<li>'
								+'<label>'
									+'<input type="radio" name="invoice" class="rdo inv-radio" checked="checked" value="'+v.inv_id+'"/>'
									+'<span class="mr5 rdo-span" id="inv_'+v.inv_id+'">'+v.inv_title+'&nbsp;&nbsp;'+v.inv_content+'</span>'
								+'</label>'
								+'<a class="del-invoice" href="javascript:void(0);" inv_id="'+v.inv_id+'">[删除]</a>'
							+'</li>';
				});

				$('#invoice_add').before(html);

				$('.del-invoice').click(function(){
                    var $this = $(this);
					var inv_id = $(this).attr('inv_id');
					$.ajax({
						type:'post',
						url:ApiUrl+'/index.php?act=member_invoice&op=invoice_del',
						data:{key:key,inv_id:inv_id},
						success:function(result){
							if(result){
								$this.parent('li').remove();
							}
							return false;
						}
					});
				});
			}
		}
	});

    $(".head-invoice").click(function (){
        $(this).parent().find(".inv-tlt-sle").prop("checked",true);
    });
    $(".buys1-edit-address").click(function(){//修改收获地址
        var self = this;
        $.ajax({
        	url:ApiUrl+"/index.php?act=member_address&op=address_list",
        	type:'post',
        	data:{key:key},
        	dataType:'json',
        	success:function(result){
        		var data = result.datas;
        		var html = '';
        		for(var i=0;i<data.address_list.length;i++){
        			html+='<li class="current existent-address">'
			                    +'<label>'
			                        +'<input type="radio" name="address" class="rdo address-radio" value="'+data.address_list[i].address_id+'" city_id="'+data.address_list[i].city_id+'" area_id="'+data.address_list[i].area_id+'" />'
			                        +'<span class="mr5 rdo-span"><span class="true_name_'+data.address_list[i].address_id+'">'+data.address_list[i].true_name+'</span> <span class="address_id_'+data.address_list[i].address_id+'">'+data.address_list[i].area_info+' '+data.address_list[i].address+'</span> <span class="mob_phone_'+data.address_list[i].address_id+'">'+data.address_list[i].mob_phone+'</span></span>'
			                    +'</label>'
			                    +'<a class="del-address" href="javascript:void(0);" address_id="'+data.address_list[i].address_id+'">[删除]</a>'
                    		+'</li>';
        		}
        		$('li.existent-address').remove();
        		$('#addresslist').before(html);

                // 点击已有地址 隐藏新地址输入框
                $('li.existent-address input').click(function() {
                    $('#new-address-wrapper').hide();
                });

        		$('.del-address').click(function(){
                    var $this = $(this);
        			var address_id = $(this).attr('address_id');
        			$.ajax({
        				type:'post',
        				url:ApiUrl+'/index.php?act=member_address&op=address_del',
        				data:{key:key,address_id:address_id},
        				dataType:'json',
        				success:function(result){
        					$this.parent('li').remove();
        				}
        			});
        		});

                $('input[name=address]').click(function() {
                    var city_id = $(this).attr('city_id');
                    var area_id = $(this).attr('area_id');

                    $('input[name=city_id]').val(city_id);
                    $('input[name=area_id]').val(area_id);
                });
        	}
        });
        var thisPrarent = $(this).parents(".buys1-address-cnt");
        hideDetail(thisPrarent);
    });
    $(".buys1-edit-invoice").click(function(){
        var self = this;

        var thisPrarent = $(this).parents(".buys1-invoice-cnt");
        hideDetail(thisPrarent);
    });

	$.sValid.init({//地址验证
        rules:{
        	vtrue_name:"required",
        	vmob_phone:"required",
            vprov:"required",
            vcity:"required",
            vregion:"required",
            vaddress:"required",
        },
        messages:{
        	vtrue_name:"姓名必填！",
        	vmob_phone:"手机号必填！",
            vprov:"省份必填！",
            vcity:"城市必填！",
            vregion:"区县必填！",
            vaddress:"街道必填！",
        },
        callback:function (eId,eMsg,eRules){
            if(eId.length >0){
                var errorHtml = "";
                $.map(eMsg,function (idx,item){
                    errorHtml += "<p>"+idx+"</p>";
                });
                $(".error-tips").html(errorHtml).show();
            }else{
                 $(".error-tips").html("").hide();
            }
        }
    });

    $(".save-address").click(function (){//更换收获地址
        var self = this;
        var selfPr
        //获取address_id
        var addressRadio = $('.address-radio');
        var address_id;
        for(var i =0;i<addressRadio.length;i++){
            if(addressRadio[i].checked){
                address_id = addressRadio[i].value;
            }
        }

        if(address_id>0){//变更地址
        	var area_id = $("input[name=area_id]").val();
        	var city_id = $("input[name=city_id]").val();
        	var freight_hash = $("input[name=freight_hash]").val();
        	$.ajax({
        		type:'post',
        		url:ApiUrl+'/index.php?act=member_buy&op=change_address',
        		data:{key:key,area_id:area_id,city_id:city_id,freight_hash:freight_hash},
        		dataType:'json',
        		success:function(result){
        			var data = result.datas;
        			var sp_s_total = 0;
        			$.each(data.content,function(k,v){
                        v = pf(v);
						$('#store'+k).html(p2f(v));
        				var sp_toal = pf($('#st'+k).attr('store_price'));//店铺商品价格
        				sp_s_total += v;
        				$('#st'+k).html(p2f(sp_toal+v));
        			});

					var total_price = pf($('input[name=total_price]').val())+sp_s_total;
					$('#total_price').html(p2f(total_price));

        			$("input[name=address_id]").val(address_id);
        			$('#address').html($('.address_id_'+address_id).html());
        			$('#true_name').html($('.true_name_'+address_id).html());
        			$('#mob_phone').html($('.mob_phone_'+address_id).html());

                    cod.stateUpdateded(result.datas.allow_offpay, result.datas.allow_offpay_batch);

                    $('input[name=allow_offpay]').val(result.datas.allow_offpay);
                    $('input[name=offpay_hash]').val(result.datas.offpay_hash);
                    $('input[name=offpay_hash_batch]').val(result.datas.offpay_hash_batch);

        			return false;
        		}
        	});
        }else{//保存地址
			if($.sValid()){
				var index = $('select[name=prov]')[0].selectedIndex;
				var aa = $('select[name=prov]')[0].options[index].innerHTML;


				var true_name = $('input[name=true_name]').val();
				var mob_phone = $('input[name=mob_phone]').val();
				var tel_phone = $('input[name=tel_phone]').val();
				var city_id = $('select[name=city]').val();
				var area_id = $('select[name=region]').val();
				var address = $('input[name=vaddress]').val();

				var prov_index = $('select[name=prov]')[0].selectedIndex;
				var city_index = $('select[name=city]')[0].selectedIndex;
				var region_index = $('select[name=region]')[0].selectedIndex;
				var area_info = $('select[name=prov]')[0].options[prov_index].innerHTML+' '+$('select[name=city]')[0].options[city_index].innerHTML+' '+$('select[name=region]')[0].options[region_index].innerHTML;

				//ajax 提交收货地址
				$.ajax({
					type:'post',
					url:ApiUrl+'/index.php?act=member_address&op=address_add',
					data:{key:key,true_name:true_name,mob_phone:mob_phone,tel_phone:tel_phone,city_id:city_id,area_id:area_id,address:address,area_info:area_info},
					dataType:'json',
					success:function(result){
						if(result){
							$.ajax({//获取收货地址信息
								type:'post',
								url:ApiUrl+'/index.php?act=member_address&op=address_info',
								data:{key:key,address_id:result.datas.address_id},
								dataType:'json',
								success:function(result1){
									var data1 = result1.datas;
									$('#true_name').html(data1.address_info.true_name);
									$('#address').html(data1.address_info.area_info+' '+data1.address_info.address);
									$('#mob_phone').html(data1.address_info.mob_phone);

									$('input[name=address_id]').val(data1.address_info.address_id);
									$('input[name=area_id]').val(data1.address_info.area_id);
									$('input[name=city_id]').val(data1.address_info.city_id);

									var area_id = data1.address_info.area_id;
									var city_id = data1.address_info.city_id;
									var freight_hash = $('input[name=freight_hash]').val();

									$.ajax({//保存收货地址
										type:'post',
										url:ApiUrl+'/index.php?act=member_buy&op=change_address',
										data:{key:key,area_id:area_id,city_id:city_id,freight_hash:freight_hash},
										dataType:'json',
										success:function(result){
											var data = result.datas;
											var sp_s_total = 0;
											$.each(result.datas.content,function(k,v){
                                                v = pf(v);
												$('#store'+k).html(p2f(v));
						        				var sp_toal = pf($('#st'+k).attr('store_price'));//店铺商品价格
						        				sp_s_total += v;
						        				$('#st'+k).html(p2f(sp_toal+v));
											});

											var total_price = pf($('input[name=total_price]').val()) +sp_s_total;
											$('#total_price').html(p2f(total_price));

                                            cod.stateUpdateded(data.allow_offpay, data.allow_offpay_batch);

                                            $('input[name=allow_offpay]').val(data.allow_offpay);
                                            $('input[name=offpay_hash]').val(data.offpay_hash);
                                            $('input[name=offpay_hash_batch]').val(data.offpay_hash_batch);

											return false;
										}
									});
								}
							});
						}
					}
				});
			}else{
				return false;
			}
        }

        var thisPrarent = $(this).parents(".buys1-address-cnt");
        showDetial(thisPrarent);
    });
    $(".save-invoice").click(function (){//保存发票信息
        var self = this;
        //获取address_id
        var invRadio = $('.inv-radio');
        var inv_id;
        for(var i =0;i<invRadio.length;i++){
            if(invRadio[i].checked){
            	inv_id = invRadio[i].value;
            }
        }

        if(inv_id>0){//选择发票信息
        	var inv_info = $('#inv_'+inv_id).html();
        	$('#inv_content').html(inv_info);//发票信息
        	$("input[name=invoice_id]").val(inv_id);
        }else{//添加发票信息
            var invtRadio = $('input[name=inv_title_select]');
            var inv_title_select;
            for(var i =0;i<invtRadio.length;i++){
                if(invtRadio[i].checked){
                	inv_title_select = invtRadio[i].value;
                }
            }

            var inv_content = $('select[name=inv_content]').val();
            if(inv_title_select == 'company'){
            	var inv_title = $("input[name=inv_title]").val();
            	var data = {key:key,inv_title_select:inv_title_select,inv_title:inv_title,inv_content:inv_content};
            	var html = '公司  ';
            }else{
            	var data = {key:key,inv_title_select:inv_title_select,inv_content:inv_content};
            	var html = '个人  ';
            }
            $.ajax({
            	type:'post',
            	url:ApiUrl+'/index.php?act=member_invoice&op=invoice_add',
            	data:data,
            	dataType:'json',
            	success:function(result){
            		if(result.datas.inv_id>0){
    					var html1 = '<li>'
										+'<label>'
											+'<input type="radio" name="invoice" class="rdo inv-radio" checked="checked" value="'+result.datas.inv_id+'"/>'
											+'<span class="mr5 rdo-span" id="inv_'+result.datas.inv_id+'">'+html+'&nbsp;&nbsp;'+inv_content+'</span>'
										+'</label>'
										+'<a class="del-invoice" href="javascript:void(0);" inv_id="'+result.datas.inv_id+'">[删除]</a>'
									+'</li>';

    					$('#invoice_add').before(html1);
            			$('#inv_content').html(html+inv_content);//发票信息
            			$('input[name=invoice_id]').val(result.datas.inv_id);


        				$('.del-invoice').click(function(){
                            var $this = $(this);
        					var inv_id = $(this).attr('inv_id');
        					$.ajax({
        						type:'post',
        						url:ApiUrl+'/index.php?act=member_invoice&op=invoice_del',
        						data:{key:key,inv_id:inv_id},
        						success:function(result){
        							if(result){
        								$this.parent('li').remove();
        							}
        							return false;
        						}
        					});
        				});
            		}
            	}
            });

        }

        var thisPrarent = $(this).parents(".buys1-invoice-cnt");
        showDetial(thisPrarent);
    });
    $(".no-invoice").click(function (){
        $('#inv_content').html("不需要发票");
        $('input[name=invoice_id]').val('');
        var thisPrarent = $(this).parents(".buys1-invoice-cnt");
        showDetial(thisPrarent);
    });

    $('#pguse').click(function(){//验证密码
    	var loginpassword = $("input[name=loginpassword]").val();
    	if(loginpassword == ''){
    		$('.password_error_tip').show();
    		$('.password_error_tip').html('支付密码不能为空');
    		return false;
    	}
    	$.ajax({
    		type:'post',
    		url:ApiUrl+'/index.php?act=member_buy&op=check_password',
    		data:{key:key,password:loginpassword},
    		dataType:'json',
    		success:function(result){
    			if(result.datas == 1){
    				$('input[name=passwd_verify]').val('1');
    				$('#pd').hide();
    			}else{
    				$('#pd').show();
    				$('.password_error_tip').show();
    				$('.password_error_tip').html(result.datas.error);
    			}
    		}
    	});
    });

    $('#usepdpy,#usercbpay').click(function(){//验证密码切换
    	if($('#usepdpy').attr('checked') || $('#usercbpay').attr('checked')){
    		$('#pd').show();
    	}else{
    		$('#pd').hide();
    	}
    });


    $('#buy_step2').click(function(){//提交订单step2
    	var data = {};

        if (isFCode) {
            data.fcode = $('#fcode').val();
            if (data.fcode.length < 1) {
                $.sDialog({
                    skin:"red",
                    content:'请输入F码！',
                    okBtn:false,
                    cancelBtn:false
                });
                return false;
            }
        }

    	data.key = key;
    	if(ifcart == 1){//购物车订单
    		data.ifcart = ifcart;
    	}
    	data.cart_id = cart_id;

    	var address_id = $('input[name=address_id]').val();
    	data.address_id = address_id;

    	var vat_hash = $('input[name=vat_hash]').val();
    	data.vat_hash = vat_hash;

    	var offpay_hash = $('input[name=offpay_hash]').val();
    	data.offpay_hash = offpay_hash;

    	var offpay_hash_batch = $('input[name=offpay_hash_batch]').val();
    	data.offpay_hash_batch = offpay_hash_batch;

        //获取address_id
        var payRadio = $('input[name=buy-type]');
        var pay_name;
        for(var i =0;i<payRadio.length;i++){
            if(payRadio[i].checked){
            	pay_name = payRadio[i].value;
            }
        }
        data.pay_name = pay_name;

        var invoice_id = $('input[name=invoice_id]').val();
        data.invoice_id = invoice_id;

/*
        var voucher = new Array();
        $("select[name=voucher]").each(function(){
        	var store_id = $(this).attr('store_id');
        	voucher[store_id] = $(this).val();
        });
        data.voucher = voucher;
*/

        var voucher = [];
        $("select[name=voucher]").each(function() {
            var v = $(this).val();
            if (v) {
                voucher.push(v);
            }
            // console.log(v);
        });
        data.voucher = voucher.join(',');
        // console.log(data.voucher);return;

        data.rcb_pay = 0;
        var available_rc_balance = parseInt($('input[name=available_rc_balance]').val());
        if (available_rc_balance > 0 && $('#usercbpay').prop('checked')) { // 使用充值卡
            var passwd_verify = parseInt($('input[name=passwd_verify]').val());
            if (passwd_verify != 1) { // 验证密码失败
                return false;
            }
            data.rcb_pay = 1;
            data.password = $('input[name=loginpassword]').val();
        }

        var available_predeposit = parseInt($('input[name=available_predeposit]').val());
        if(available_predeposit>0){
            if($('#usepdpy').prop('checked')){//使用预存款
            	var passwd_verify = parseInt($('input[name=passwd_verify]').val());
            	if(passwd_verify != 1){//验证密码失败
            		return false;
            	}

            	var pd_pay = 1;
            	data.pd_pay = pd_pay;
            	var passwd = $('input[name=loginpassword]').val();
            	data.password = passwd;
            }else{
            	var pd_pay = 0;
            	data.pd_pay = pd_pay;
            }
        }else{
        	var pd_pay = 0;
        	data.pd_pay = pd_pay;
        }


        $.ajax({
        	type:'post',
        	url:ApiUrl+'/index.php?act=member_buy&op=buy_step2',
        	data:data,
        	dataType:'json',
        	success:function(result){

        		//return false;
        		checklogin(result.login);
        		//if(result.datas.error != ''){
        			//return false;
        		//}

                if (result.datas.error) {
                    $.sDialog({
                        skin:"red",
                        content:result.datas.error,
                        okBtn:false,
                        cancelBtn:false
                    });
                    return false;
                }

        		if(result.datas.pay_sn.pay_sn != ''){
        			location.href = WapSiteUrl+'/tmpl/member/order_list.html';
        		}
        		return false;
        	}
        });
    });

    function showDetial(parent){
        $(parent).find(".buys1-edit-btn").show();
        $(parent).find(".buys1-hide-list").addClass("hide");
        $(parent).find(".buys1-hide-detail").removeClass("hide");
    }
    function hideDetail(parent){
        $(parent).find(".buys1-edit-btn").hide();
        $(parent).find(".buys1-hide-list").removeClass("hide");
        $(parent).find(".buys1-hide-detail").addClass("hide");
    }
});