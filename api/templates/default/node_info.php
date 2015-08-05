<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo NODE_SITE_URL;?>/socket.io/socket.io.js" charset="utf-8"></script>
<script type="text/javascript">
var connect_url = "<?php echo NODE_SITE_URL;?>";
var connect = 0;//连接状态
var user = {};

user['u_id'] = "<?php echo $output['member_info']['member_id'];?>";
user['u_name'] = "<?php echo $output['member_info']['member_name'];?>";
user['s_id'] = "<?php echo $output['member_info']['store_id'];?>";
user['s_name'] = "<?php echo $output['member_info']['store_name'];?>";
user['avatar'] = "<?php echo getMemberAvatar($output['member_info']['avatar']);?>";

setTimeout(function(){
	if ( typeof io === "function" ) {
	  socket = io(connect_url, { 'path': '/socket.io', 'reconnection': false });
	  socket.on('connect', function () {
	    connect = 1;
	    socket.emit('update_user', user);
	    socket.on('get_state', function (data) {
	      window.Android.get_state(JSON.stringify(data));
	    });
	    socket.on('get_msg', function (data) {
	      window.Android.get_msg(JSON.stringify(data));
	    });
        socket.on('del_msg', function (data) {
          window.Android.del_msg(JSON.stringify(data));
        });
        socket.on('disconnect', function () {
          connect = 0;
          window.Android.connect('0');
        });
	  });
  }
},1000);
function node_send_state(data){
    if(connect === 1) {
        socket.emit('get_state', data);
    }
}
function node_send_msg(data){
    if(connect === 1) {
        socket.emit('send_msg', data);
    }
}
function node_del_msg(data){
    if(connect === 1) {
        socket.emit('del_msg', data);
    }
}

</script>
