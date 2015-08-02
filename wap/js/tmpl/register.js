$(function(){
	
	
	$.sValid.init({//注册验证
        rules:{
        	username:"required",
            userpwd:"required",            
            password_confirm:"required",
            email:{
            	required:true,
            	email:true
            }
        },
        messages:{
            username:"用户名必须填写！",
            userpwd:"密码必填!", 
            password_confirm:"确认密码必填!",
            email:{
            	required:"邮件必填!",
            	email:"邮件格式不正确"           	
            }
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
	
	$('#loginbtn').click(function(){	
		var username = $("input[name=username]").val();
		var pwd = $("input[name=pwd]").val();
		var password_confirm = $("input[name=password_confirm]").val();
		var email = $("input[name=email]").val();
		var client = $("input[name=client]").val();
		
		if($.sValid()){
			$.ajax({
				type:'post',
				url:ApiUrl+"/index.php?act=login&op=register",	
				data:{username:username,password:pwd,password_confirm:password_confirm,email:email,client:client},
				dataType:'json',
				success:function(result){
					if(!result.datas.error){
						if(typeof(result.datas.key)=='undefined'){
							return false;
						}else{
							addcookie('username',result.datas.username);
							addcookie('key',result.datas.key);
							location.href = WapSiteUrl+'/tmpl/member/member.html';
						}
						$(".error-tips").hide();
					}else{
						$(".error-tips").html(result.datas.error).show();
					}
				}
			});			
		}
	});
});