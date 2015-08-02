// by abc.com 调出图片
	var seller_list = new Array();//商家客服
	var msg_limits = new Array();//消息权限
	var store_msg_list = new Array();//商家收到消息
	var store_msg_obj = {};
	$(function(){
		if(user['seller_id'] != '') {
		    web_info['html_title'] = $(document).attr('title');
            web_info['html_store_msg'] = '<div id="store_msg_dialog" class="dialog_wrapper" style="z-index: 3100; float: right; margin: 0; position: fixed; width: 280px; right: 50px; bottom: 0;display: none;">'+
									'<div class="dialog_body" style="position: relative;"><h3 class="dialog_head"><span class="dialog_title">'+
									'<span class="dialog_title_icon">系统消息</span></span>'+
									'<span class="dialog_close_button" onclick="store_msg_close();">X</span></h3>'+
									'<div class="dialog_content" style="margin: 0px; padding: 0px;"><div class="ncsc-form-default"><dl><dd style="width:100%; padding:10px;"><p></p></dd></dl>'+
									'<div class="bottom pt10 pb10"></div></div></div></div></div>';
			web_info['msg_dialog'] = '<div id="new_msg_dialog" class="msg-windows"><div class="user-tab-bar"><ul class="user-list" id="user_list"></ul></div><div class="msg-dialog">'+
									'<div class="dialog-body">'+
									'<div class="msg-top"><dl class="user-info"><dt class="user-name"></dt><dd class="user-avatar avatar-0"><img src="" alt=""></dd><dd class="store-name"></dd></dl>'+
									'<span class="dialog-close" onclick="msg_dialog_close(\'new_msg_dialog\');">&nbsp;</span></div>'+
									'<div id="msg_list" class="msg-contnet"><div id="user_msg_list"></div></div>'+
									'<div class="msg-input-box"><div class="msg-input-title"><a id="chat_show_smilies" href="javascript:void(0)" class="chat_smiles">表情</a>'+
									'<span class="title">输入聊天信息</span><span class="chat-log-btn off" onclick="show_chat_log();">聊天记录<i></i></span></div>'+
									'<form id="msg_form"><textarea name="send_message" id="send_message" class="textarea" onkeyup="send_keyup(event);" onfocus="send_focus();" ></textarea>'+
									'<div class="msg-bottom"><div id="msg_count"></div><a href="JavaScript:void(0);" onclick="send_msg();" class="msg-button"><i></i>发送消息</a><div id="send_alert"></div></div></form></div></div>'+
									'<div id="dialog_chat_log" class="dialog_chat_log"></div><div id="dialog_right_clear" class="dialog_right_clear"></div></div><div id="dialog_clear" class="dialog_clear"></div></div>';
			var chat_user_list = '<div class="chat-box"><div class="chat-list"><div class="chat-list-top"><h1><i></i>联系人</h1><span class="minimize-chat-list" onclick="chat_show_list();"></span></div>'+
									'<div id="chat_user_list" class="chat-list-content"><div><dl id="chat_user_sellers"><dt onclick="chat_show_user_list(\'sellers\');">'+
									'<span class="show"></span>商家客服</dt><dd id="chat_sellers" style="display: none;"></dd></dl>'+
									'<dl id="chat_user_recent"><dt onclick="chat_show_user_list(\'recent\');"><span class="show"></span>最近联系人</dt><dd id="chat_recent" style="display: none;"></dd></dl></div></div>'+
									'</div></div>';
			var ajaxurl = CHAT_SITE_URL+'/index.php?act=web_chat&op=get_seller_list&n=99&f_id='+user['u_id'];
			$.ajax({
				type: "GET",
				url: ajaxurl,
				dataType:"jsonp",
				async: true,
			    success: function(u_list){
			  	for (var u_id in u_list){
			  		var user_info = u_list[u_id];
			  		connect_list[u_id] = 0;
			  		connect_n++;
				  	set_user_info(u_id,"u_name",user_info['u_name']);
				  	set_user_info(u_id,"avatar",user_info['avatar']);
				  	if ( u_id != user['u_id'] && user_info['seller'] == 1 ) {
				  	    seller_list[u_id] = user_info;
				  	    set_user_info(u_id,"seller_id",user_info['seller_id']);
				  	    set_user_info(u_id,"seller_name",user_info['seller_name']);
				  	}
				  	if ( user_info['recent'] == 1 ) recent_list[u_id] = user_info;
				}
				setTimeout("getconnect()",1000);
				$("#web_chat_dialog").prepend(chat_user_list);
				$("#web_chat_dialog").after(web_info['html_store_msg']);

				$('#chat_user_list').perfectScrollbar();
				setInterval( function () {
					$.get(CHAT_SITE_URL+'/index.php?act=web_chat&op=get_session&key=member_id');
				}, time_max*60000);
				$("#im").click(function() {
				    chat_show_list();
				});
			  }
			});
		}
		$('#dialog_clear,#dialog_right_clear').live('click', function() {
		  if (dialog_show == 1) msg_dialog_close('new_msg_dialog');
		});
		if( user['seller_is_admin'] == 0 && smt_limits != '') {
		    var limits = smt_limits.split(",");//消息权限
		    for (var i in limits){
		        var k = limits[i];
		        msg_limits[k] = 1;
		    }
		}
	});
	function update_sellers(){
		var obj_seller = $("#chat_sellers");
		for (var u_id in seller_list){
			if(obj_seller.parent().find("dd[u_id='"+u_id+"']").size()==0) {
				if(user_list[u_id]['online'] > 0 ) {
					obj_seller.before('<dd u_id="'+u_id+'" title="客服账号:'+user_list[u_id]['seller_name']+'" onclick="chat('+u_id+');"><span class="user-avatar"><img alt="'+user_list[u_id]['u_name']
						+'" src="'+user_list[u_id]['avatar']+'"><i class="online"></i></span><h5>'+user_list[u_id]['u_name']+'</h5><a href="javascript:void(0)"></a></dd>');
				} else {
					obj_seller.after('<dd u_id="'+u_id+'" title="客服账号:'+user_list[u_id]['seller_name']+'" onclick="chat('+u_id+');"><span class="user-avatar"><img alt="'+user_list[u_id]['u_name']
						+'" src="'+user_list[u_id]['avatar']+'"><i class="offline"></i></span><h5>'+user_list[u_id]['u_name']+'</h5><a href="javascript:void(0)"></a></dd>');
				}
			}
		}
		obj_seller.remove();
		chat_show_user_list('sellers');
	}
	function store_msg_close(){
	    store_msg_obj.hide("slide" ,{ direction: 'right' }, 300);
	}
	function store_msg(msg){
	    var code = msg['smt_code'];//消息模板编码
	    if( user['seller_is_admin'] == 1 || msg_limits[code] == 1) {
	        var sm_id = msg['sm_id'];
	        var sm_content = msg['sm_content'];
	        var text_append = '<a href="'+SHOP_SITE_URL+'/index.php?act=store_msg&op=index">'+sm_content+'</a>';
	        store_msg_obj.find(".ncsc-form-default dl p").html(text_append);
	        store_msg_obj.show();
	        store_msg_list[sm_id] = msg;
	    }
	}
	function getconnect(){
		$.getScript(connect_url+"/resource/socket.io.js", function(){
			clearInterval(interval);
			if ( typeof io === "object" ) {
			  socket = io.connect(connect_url, { 'resource': 'resource', 'reconnect': false });
			  socket.on('connect', function () {
			    connect = 1;
				send_state();
			    socket.on('get_state', function (u_list) {
			      get_state(u_list);
			      update_sellers();
			    });
			  	$("#web_chat_dialog").show();
			  	store_msg_obj = $("#store_msg_dialog");
			  	if($("#new_msg_dialog").size()==0) $("#web_chat_dialog").after(web_info['msg_dialog']);
			  	obj = $("#new_msg_dialog");
			    socket.emit('update_user', user);
			    socket.on('get_msg', function (msg_list) {
			      get_msg(msg_list);
			    });
                socket.on('del_msg', function (msg) {
                    del_msg(msg);
                });
                socket.on('store_msg', function (msg) {
                    store_msg(msg);
                });
                socket.on('disconnect', function () {
                    connect = 0;
                    $("#web_chat_dialog").hide();
                    interval = setInterval( getconnect, 60000);//断开1分钟后重新连接服务器
                });
			  });
		  }
		});
	}