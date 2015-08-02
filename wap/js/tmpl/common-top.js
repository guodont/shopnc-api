$(function (){
	var headTitle = document.title;
	var tmpl = '<div class="header-wrap">'
	        		+'<a href="javascript:history.back();" class="header-back"><span>返回</span></a>'
						+'<h2>'+headTitle+'</h2>'
						+'<a href="javascript:void(0)" id="btn-opera" class="i-main-opera">'
					 	+'<span></span>'
				 	+'</a>'
    			+'</div>'
		    	+'<div class="main-opera-pannel">'
		    		+'<div class="main-op-table main-op-warp">'
		    			+'<a href="'+WapSiteUrl+'/index.html" class="quarter">'
		    				+'<span class="i-home"></span>'
		    				+'<p>首页</p>'
		    			+'</a>'
		    			+'<a href="'+WapSiteUrl+'/tmpl/product_first_categroy.html" class="quarter">'
		    				+'<span class="i-categroy"></span>'
		    				+'<p>分类</p>'
		    			+'</a>'
		    			+'<a href="'+WapSiteUrl+'/tmpl/cart_list.html" class="quarter">'
		    				+'<span class="i-cart"></span>'
		    				+'<p>购物车</p>'
		    			+'</a>'
		    			+'<a href="'+WapSiteUrl+'/tmpl/member/member.html?act=member" class="quarter">'
		    				+'<span class="i-mine"></span>'
		    				+'<p>我的商城</p>'
		    			+'</a>'
		    		+'</div>'
		    	+'</div>';
    //渲染页面
	var html = template.compile(tmpl);
	$("#header").html(html);
	$("#btn-opera").click(function (){
		$(".main-opera-pannel").toggle();
	});
	//当前页面
	if(headTitle == "商品分类"){
		$(".i-categroy").parent().addClass("current");
	}else if(headTitle == "购物车列表"){
		$(".i-cart").parent().addClass("current");
	}else if(headTitle == "我的商城"){
		$(".i-mine").parent().addClass("current");
	}
});