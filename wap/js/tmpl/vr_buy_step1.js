$(function() {
    var key = getcookie('key');
    var goods_id = GetQueryString("goods_id");
    var quantity = GetQueryString("quantity");

    var data = {};

    data.key = key;
    data.goods_id = goods_id;
    data.quantity = quantity;

    var p2f = function(f) {
        return (parseFloat(f) || 0).toFixed(2);
    };

    $.ajax({ //提交订单信息
        type:'post',
        url:ApiUrl+'/index.php?act=member_vr_buy&op=buy_step2',
        dataType:'json',
        data:data,
        success:function(result){
            var data = result.datas;
            if (typeof(data.error) != 'undefined') {
                location.href = WapSiteUrl;
                return;
            }

            var g = data.goods_info;
            var s = data.store_info;
            var m = data.member_info;

            var htmldata = '<li>'
                + '<p class="buys-yt-tlt">店铺名称：'+s.store_name+'</p>'
                + '<div class="buys1-pdlist">'
                + '<div class="clearfix">'
                + '<a class="img-wp" href="'+WapSiteUrl+'/tmpl/product_detail.html?goods_id='+g.goods_id+'">'
                + '<img src="'+g.goods_image_url+'"/>'
                + '</a>'
                + '<div class="buys1-pdlcnt">'
                + '<p><a class="buys1-pdlc-name" href="'+WapSiteUrl+'/tmpl/product_detail.html?goods_id='+g.goods_id+'">'+g.goods_name+'</a></p>'
                + '<p>单价(元)：￥'+g.goods_price+'</p>'
                + '<p>数量：'+g.quantity+'</p>'
                + '</div>'
                + '</div>'
                + '</div>';
                + '</li>';

            $("#deposit").before(htmldata);
            $('#total_price').html(p2f(g.goods_total));
            $('input[name=total_price]').val(g.goods_total);

            $('#buyer_phone').val(m.member_mobile || '');

            //console.log(m.available_rc_balance);
            //console.log(m.available_predeposit);

            if (m.available_rc_balance != null && m.available_rc_balance > 0) {
                $('.pre-deposit-wp').show();
                $('#wrapper-usercbpay').show();
                $('#available_rc_balance').html(m.available_rc_balance);
                $('input[name=available_rc_balance]').val(m.available_rc_balance);
            }

            if (m.available_predeposit != null && m.available_predeposit > 0) {
                $('.pre-deposit-wp').show();
                $('#wrapper-usepdpy').show();
                $('#available_predeposit').html(m.available_predeposit);
                $('input[name=available_predeposit]').val(m.available_predeposit);
            }
        }
    });

    // 验证密码
    $('#pguse').click(function(){
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

    // 验证密码切换
    $('#usepdpy,#usercbpay').click(function(){
        if ($('#usepdpy').attr('checked') || $('#usercbpay').attr('checked')) {
            $('#pd').show();
        } else {
            $('#pd').hide();
        }
    });

    //提交订单step2
    $('#buy_step2').click(function() {
        var data = {};

        data.key = key;
        data.goods_id = goods_id;
        data.quantity = quantity;

        var buyer_phone = $('#buyer_phone').val();
        if (! /^\d{7,11}$/.test(buyer_phone)) {
            $.sDialog({
                skin:"red",
                content:'请正确输入接收手机号码！',
                okBtn:false,
                cancelBtn:false
            });
            return false;
        }
        data.buyer_phone = buyer_phone;

        // 使用充值卡
        data.rcb_pay = 0;
        var available_rc_balance = parseInt($('input[name=available_rc_balance]').val());
        if (available_rc_balance > 0 && $('#usercbpay').prop('checked')) {
            var passwd_verify = parseInt($('input[name=passwd_verify]').val());
            if (passwd_verify != 1) { // 验证密码失败
                return false;
            }
            data.rcb_pay = 1;
            data.password = $('input[name=loginpassword]').val();
        }

        var available_predeposit = parseInt($('input[name=available_predeposit]').val());
        if (available_predeposit > 0) {
            if ($('#usepdpy').prop('checked')) { //使用预存款
                var passwd_verify = parseInt($('input[name=passwd_verify]').val());
                if(passwd_verify != 1){ //验证密码失败
                    return false;
                }

                var pd_pay = 1;
                data.pd_pay = pd_pay;
                var passwd = $('input[name=loginpassword]').val();
                data.password = passwd;
            } else {
                var pd_pay = 0;
                data.pd_pay = pd_pay;
            }
        } else {
            var pd_pay = 0;
            data.pd_pay = pd_pay;
        }

        $.ajax({
            type:'post',
            url:ApiUrl+'/index.php?act=member_vr_buy&op=buy_step3',
            data:data,
            dataType:'json',
            success:function(result) {
                checklogin(result.login);

                if (result.datas.error) {
                    $.sDialog({
                        skin:"red",
                        content:result.datas.error,
                        okBtn:false,
                        cancelBtn:false
                    });
                    return false;
                }

                if (result.datas.order_id) {
                    location.href = WapSiteUrl+'/tmpl/member/vr_order_list.html';
                }

                return false;
            }
        });
    });

});
