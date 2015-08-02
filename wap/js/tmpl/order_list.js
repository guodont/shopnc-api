$(function(){
	var key = getcookie('key');
	if(key==''){
		window.location.href = WapSiteUrl+'/tmpl/member/login.html';
	}
	var page = pagesize;
	var curpage = 1;
	var hasMore = true;

    var readytopay = false;

	function initPage(page,curpage){
		$.ajax({
			type:'post',
            url:ApiUrl+"/index.php?act=member_order&op=order_list&page="+page+"&curpage="+curpage+"&getpayment=true",
			data:{key:key},
			dataType:'json',
			success:function(result){
				checklogin(result.login);//检测是否登录了
				var data = result.datas;
				data.hasmore = result.hasmore;//是不是可以用下一页的功能，传到页面里去判断下一页是否可以用
				data.WapSiteUrl = WapSiteUrl;//页面地址
				data.curpage = curpage;//当前页，判断是否上一页的disabled是否显示
				data.ApiUrl = ApiUrl;
				data.key = getcookie('key');
				template.helper('$getLocalTime', function (nS) {
                    var d = new Date(parseInt(nS) * 1000);
                    var s = '';
                    s += d.getFullYear() + '年';
                    s += (d.getMonth() + 1) + '月';
                    s += d.getDate() + '日 ';
                    s += d.getHours() + ':';
                    s += d.getMinutes();
                    return s;
				});
                template.helper('p2f', function(s) {
                    return (parseFloat(s) || 0).toFixed(2);
                });
				var html = template.render('order-list-tmpl', data);
				$("#order-list").html(html);
				//取消订单
				$(".cancel-order").click(cancelOrder);
				//下一页
				$(".next-page").click(nextPage);
				//上一页
				$(".pre-page").click(prePage);
				//确认订单
				$(".sure-order").click(sureOrder);

                $('.viewdelivery-order').click(viewOrderDelivery);

                $('.check-payment').click(function() {
                    if (!readytopay) {
                        $.sDialog({
                            skin:"red",
                            content:'暂无可用的支付方式',
                            okBtn:false,
                            cancelBtn:false
                        });
                        return false;
                    }
                });

                $(window).scrollTop(0);
			}
		});

        $.ajax({
            type:'get',
            url:ApiUrl+"/index.php?act=member_payment&op=payment_list",
            data:{key:key},
            dataType:'json',
            success:function(result){
                $.each((result && result.datas && result.datas.payment_list) || [], function(k, v) {
                    // console.log(v);
                    if (v != '') {
                        readytopay = true;
                        return false;
                    }
                });
            }
        });
	}
	//初始化页面
	initPage(page,curpage);

	//下一页
	function nextPage (){
		var self = $(this);
		var hasMore = self.attr("has_more");
		if(hasMore == "true"){
			curpage = curpage+1;
			initPage(page,curpage);
		}
	}
	//上一页
	function prePage (){
		var self = $(this);
		if(curpage >1){
			self.removeClass("disabled");
			curpage = curpage-1;
			initPage(page,curpage);
		}
	}

    //取消订单
    function cancelOrder(){
        var order_id = $(this).attr("order_id");

        $.sDialog({
            content: '确定取消订单？',
            okFn: function() { cancelOrderId(order_id); }
        });
    }

    function cancelOrderId(order_id) {
        $.ajax({
            type:"post",
            url:ApiUrl+"/index.php?act=member_order&op=order_cancel",
            data:{order_id:order_id,key:key},
            dataType:"json",
            success:function(result){
                if(result.datas && result.datas == 1){
                    initPage(page,curpage);
                }
            }
        });
    }

    //确认订单
    function sureOrder(){
        var order_id = $(this).attr("order_id");

        $.sDialog({
            content: '确定确认订单？',
            okFn: function() { sureOrderId(order_id); }
        });
    }

    function sureOrderId(order_id) {
        $.ajax({
            type:"post",
            url:ApiUrl+"/index.php?act=member_order&op=order_receive",
            data:{order_id:order_id,key:key},
            dataType:"json",
            success:function(result){
                if(result.datas && result.datas == 1){
                    initPage(page,curpage);
                }
            }
        });
    }

    function viewOrderDelivery() {
        var orderId = $(this).attr('order_id');
        location.href = WapSiteUrl + '/tmpl/member/order_delivery.html?order_id=' + orderId;
    }
});
