$(function(){
	var key = getcookie('key');
	if(key==''){
		location.href = 'login.html';
	}
	//初始化页面
	function initPage(){
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_favorites&op=favorites_list",	
			data:{key:key},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				var data = result.datas;
				data.WapSiteUrl = WapSiteUrl;
				var html = template.render('sfavorites_list', data);
				$("#favorites_list").html(html);
				//删除收藏
				$('.i-del').click(delFavorites);
			}
		});
	}
	initPage();
	//删除收藏
	function delFavorites(){
		var goods_id = $(this).attr('goods_id');
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_favorites&op=favorites_del",
			data:{fav_id:goods_id,key:key},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				if(result){
					initPage();
				}
			}
		});
		return false;
	}
});