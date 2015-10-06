//v3-b11
$(function(){
	var ac_id = GetQueryString('ac_id')
	
	if (ac_id=='') {
    	window.location.href = WapSiteUrl + '/index.html';
    	return;
	}
	else {
		$.ajax({
			url:ApiUrl+"/index.php?act=article_class&op=index",
			type:'get',
			data:{ac_id:ac_id},
			jsonp:'callback',
			dataType:'jsonp',
			success:function(result){
				var data = result.datas;
				data.WapSiteUrl = WapSiteUrl;
				var html = template.render('article-class', data);				
				$("#article-content").html(html);
			}
		});
	}	
});