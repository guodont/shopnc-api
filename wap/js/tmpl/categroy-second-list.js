$(function(){
	$.ajax({
		url:ApiUrl+"/index.php?act=goods_class&gc_id="+GetQueryString("gc_id"),
		type:'get',
		dataType:'json',
		success:function(result){
			var html = template.render('category2', result.datas);
			$("#content").append(html);
			var category_item = new Array();
			$(".category-seciond-item").click(function (){
				var gc_id = $(this).attr('gc_id');
				var self = this;
				if(contains(category_item,gc_id)){
					$(this).toggleClass("open-sitem");
					return false;
				}
						
				$.ajax({
					url:ApiUrl+"/index.php?act=goods_class&gc_id="+gc_id,
					type:'get',
					dataType:'json',
					success:function(result){
						category_item.push(gc_id);	
						if(result){
							result.datas.gc_id = gc_id;
							var html = template.render('category3', result.datas);
							$(self).append(html);
							$(self).addClass('open-sitem');
						
							$('.product_list').click(function(){	
								location.href = WapSiteUrl+"/tmpl/product_list.html?gc_id="+$(this).attr('gc_id');			
							});							
						}else{
							location.href = WapSiteUrl+"/tmpl/product_list.html?gc_id="+gc_id;
						}		
					}
				});
			});

		}
	});
});