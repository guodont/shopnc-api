$(function(){
	$("input[name=keyword]").val(escape(GetQueryString('keyword')));
	$("input[name=gc_id]").val(GetQueryString('gc_id'));


    $(".page-warp").click(function (){
        $(this).find(".pagew-size").toggle();
    });

    if($("input[name=gc_id]").val()!=''){
    	$.ajax({
    		url:ApiUrl+"/index.php?act=goods&op=goods_list&key=4&page="+pagesize+"&curpage=1"+'&gc_id='+$("input[name=gc_id]").val(),
    		type:'get',
    		dataType:'json',
    		success:function(result){
    			$("input[name=hasmore]").val(result.hasmore);
    			if(!result.hasmore){
    				$('.next-page').addClass('disabled');
    			}

    			var curpage = $("input[name=curpage]").val();//分页
    			var page_total = result.page_total;
    			var page_html = '';
    			for(var i=1;i<=result.page_total;i++){
    				if(i==curpage){
    					page_html+='<option value="'+i+'" selected>'+i+'</option>';
    				}else{
    					page_html+='<option value="'+i+'">'+i+'</option>';
    				}
    			}

    			$('select[name=page_list]').empty();
    			$('select[name=page_list]').append(page_html);

    			var html = template.render('home_body', result.datas);
    			$("#product_list").append(html);

                $(window).scrollTop(0);
    		}
    	});
    }else{
    	$.ajax({
    		url:ApiUrl+"/index.php?act=goods&op=goods_list&key=4&page="+pagesize+"&curpage=1"+'&keyword='+$("input[name=keyword]").val(),
    		type:'get',
    		dataType:'json',
    		success:function(result){
    			$("input[name=hasmore]").val(result.hasmore);
    			if(!result.hasmore){
    				$('.next-page').addClass('disabled');
    			}

    			var curpage = $("input[name=curpage]").val();//分页
    			var page_total = result.page_total;
    			var page_html = '';
    			for(var i=1;i<=result.page_total;i++){
    				if(i==curpage){
    					page_html+='<option value="'+i+'" selected>'+i+'</option>';
    				}else{
    					page_html+='<option value="'+i+'">'+i+'</option>';
    				}
    			}

    			$('select[name=page_list]').empty();
    			$('select[name=page_list]').append(page_html);

    			var html = template.render('home_body', result.datas);
    			$("#product_list").append(html);

                $(window).scrollTop(0);
    		}
    	});
    }


    $("select[name=page_list]").change(function(){
		var key = parseInt($("input[name=key]").val());
		var order = parseInt($("input[name=order]").val());
		var page = parseInt($("input[name=page]").val());
		var gc_id = parseInt($("input[name=gc_id]").val());
		var keyword = $("input[name=keyword]").val();
		var hasmore = $("input[name=hasmore]").val();

    	var curpage = $('select[name=page_list]').val();

    	if(gc_id>0){
    		var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&gc_id="+gc_id;
    	}else{
    		var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&keyword="+keyword;
    	}

    	$.ajax({
    		url:url,
    		type:'get',
    		dataType:'json',
    		success:function(result){
				var html = template.render('home_body', result.datas);
				$("#product_list").empty();
				$("#product_list").append(html);

                $(window).scrollTop(0);

				if(curpage>1){
					$('.pre-page').removeClass('disabled');
				}else{
					$('.pre-page').addClass('disabled');
				}

				if(curpage<result.page_total){
					$('.next-page').removeClass('disabled');
				}else{
					$('.next-page').addClass('disabled');
				}

				$("input[name=curpage]").val(curpage);
    		}
    	});

    });


	$('.keyorder').click(function(){
		var key = parseInt($("input[name=key]").val());
		var order = parseInt($("input[name=order]").val());
		var page = parseInt($("input[name=page]").val());
		var curpage = eval(parseInt($("input[name=curpage]").val())-1);
		var gc_id = parseInt($("input[name=gc_id]").val());
		var keyword = $("input[name=keyword]").val();
		var hasmore = $("input[name=hasmore]").val();

		var curkey = $(this).attr('key');//1.销量 2.浏览量 3.价格 4.最新排序
		if(curkey == key){
			if(order == 1){
				var curorder = 2;
			}else{
				var curorder = 1;
			}
		}else{
			var curorder = 1;
		}

        if (curkey == 3) {
            if (curorder == 1) {
                $(this).find('span').removeClass('desc').addClass('asc');
            } else {
                $(this).find('span').removeClass('asc').addClass('desc');
            }
        }

		$(this).addClass("current").siblings().removeClass("current");

		if(gc_id>0){
			var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+curkey+"&order="+curorder+"&page="+page+"&curpage=1&gc_id="+gc_id;
		}else{
			var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+curkey+"&order="+curorder+"&page="+page+"&curpage=1&keyword="+keyword;
		}

		$.ajax({
			url:url,
			type:'get',
			dataType:'json',
			success:function(result){
				$("input[name=hasmore]").val(result.hasmore);
				var html = template.render('home_body', result.datas);
				$("#product_list").empty();
				$("#product_list").append(html);
				$("input[name=key]").val(curkey);
				$("input[name=order]").val(curorder);
			}
		});
	});

	$('.pre-page').click(function(){//上一页
		var key = parseInt($("input[name=key]").val());
		var order = parseInt($("input[name=order]").val());
		var page = parseInt($("input[name=page]").val());
		var curpage = eval(parseInt($("input[name=curpage]").val())-1);
		var gc_id = parseInt($("input[name=gc_id]").val());
		var keyword = $("input[name=keyword]").val();

		if(curpage<1){
			return false;
		}

		if(gc_id>=0){
			var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&gc_id="+gc_id;
		}else{
			var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&keyword="+keyword;
		}
		$.ajax({
			url:url,
			type:'get',
			dataType:'json',
			success:function(result){
				$("input[name=hasmore]").val(result.hasmore);
				if(curpage == 1){
					$('.next-page').removeClass('disabled');
					$('.pre-page').addClass('disabled');
				}else{
					$('.next-page').removeClass('disabled');
				}
				var html = template.render('home_body', result.datas);
				$("#product_list").empty();
				$("#product_list").append(html);
				$("input[name=curpage]").val(curpage);

    			var page_total = result.page_total;
    			var page_html = '';
    			for(var i=1;i<=result.page_total;i++){
    				if(i==curpage){
    					page_html+='<option value="'+i+'" selected>'+i+'</option>';
    				}else{
    					page_html+='<option value="'+i+'">'+i+'</option>';
    				}
    			}

    			$('select[name=page_list]').empty();
    			$('select[name=page_list]').append(page_html);

                $(window).scrollTop(0);
			}
		});
	});

	$('.next-page').click(function(){//下一页
		var hasmore = $('input[name=hasmore]').val();
		if(hasmore == 'false'){
			return false;
		}

		var key = parseInt($("input[name=key]").val());
		var order = parseInt($("input[name=order]").val());
		var page = parseInt($("input[name=page]").val());
		var curpage = eval(parseInt($("input[name=curpage]").val())+1);
		var gc_id = parseInt($("input[name=gc_id]").val());
		var keyword = $("input[name=keyword]").val();

		if(gc_id>=0){
			var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&gc_id="+gc_id;
		}else{
			var url = ApiUrl+"/index.php?act=goods&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&keyword="+keyword;
		}
		$.ajax({
			url:url,
			type:'get',
			dataType:'json',
			success:function(result){
				$("input[name=hasmore]").val(result.hasmore);
				if(!result.hasmore){
					$('.pre-page').removeClass('disabled');
					$('.next-page').addClass('disabled');
				}else{
					$('.pre-page').removeClass('disabled');
				}
				var html = template.render('home_body', result.datas);
				$("#product_list").empty();
				$("#product_list").append(html);
				$("input[name=curpage]").val(curpage);

    			var page_total = result.page_total;
    			var page_html = '';
    			for(var i=1;i<=result.page_total;i++){
    				if(i==curpage){
    					page_html+='<option value="'+i+'" selected>'+i+'</option>';
    				}else{
    					page_html+='<option value="'+i+'">'+i+'</option>';
    				}
    			}
    			$('select[name=page_list]').empty();
    			$('select[name=page_list]').append(page_html);

                $(window).scrollTop(0);
			}
		});
	});
});