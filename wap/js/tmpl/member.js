$(function(){
		var key = getcookie('key');
		if(key==''){
			location.href = 'login.html';
		}
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_index",
			data:{key:key},
			dataType:'json',
			//jsonp:'callback',
			success:function(result){
				checklogin(result.login);
				$('#username').html(result.datas.member_info.user_name);
				$('#point').html(result.datas.member_info.point);
				$('#predepoit').html(result.datas.member_info.predepoit);
					//v3-b11 充值卡
				$('#available_rc_balance').html(result.datas.member_info.available_rc_balance);
				$('#avatar').attr("src",result.datas.member_info.avator);
				return false;
			}
		});
});