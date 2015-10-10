<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $html_title;?></title>
<link href="css/install.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../data/resource/js/jquery.js"></script>
<script type="text/javascript" src="../data/resource/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="../data/resource/js/jquery.icheck.min.js"></script>
<script>
$(document).ready(function(){
	$('input[type="checkbox"]').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  });
});

$(function(){
	jQuery.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
	}, "不得含有特殊字符");
	$("#install_form").validate({
		errorElement: "font",
    rules : {
        db_host : {required : true},
        db_name : {required : true},
        db_user : {required : true},
        db_port : {required : true,digits : true},
       	site_name : {required : true},
       	admin : {required : true,lettersonly : true},
       	password : {required : true, minlength : 6},
       	rpassword : {required : true,equalTo : '#password'},
		agree : {required : true},
		store_name : {required : true},
		member_name : {required : true},
		seller_name : {required : true},
		member_password : {required : true},
		rmember_password : {required : true, equalTo : '#member_password'}
    }
	});

	jQuery.extend(jQuery.validator.messages, {
	  required: "未输入",
	  digits: "格式错误",
	  lettersonly: "不得含有特殊字符",
	  equalTo: "两次密码不一致",
	  minlength: "密码至少6位"
	});

	$('#next').click(function(){
		$('#install_form').submit();
	});

});
</script>
</head>
<body>
<?php echo $html_header;?>
<div class="main">
  <div class="step-box" id="step3">
    <div class="text-nav">
      <h1>Step.3</h1>
      <h2>创建数据库</h2>
      <h5>填写数据库及站点相关信息</h5>
    </div>
    <div class="procedure-nav">
      <div class="schedule-ico"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-point-now"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-point-bg"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-line-now"><em></em></div>
      <div class="schedule-line-bg"></div>
      <div class="schedule-text"><span class="a">检查安装环境</span><span class="b">选择安装方式</span><span class="c">创建数据库</span><span class="d">安装</span></div>
    </div>
  </div>
  <form action="" id="install_form" method="post">
    <input type="hidden" value="submit" name="submitform">
    <input type="hidden" value="<?php echo $install_recover;?>" name="install_recover">
    <div class="form-box control-group">
      <fieldset>
        <legend>数据库信息</legend>
        <div>
          <label>数据库服务器</label>
          <span>
          <input type="text" name="db_host" maxlength="60" value="<?php echo $_POST['db_host'] ? $_POST['db_host'] : 'localhost';?>">
          </span> <em>数据库服务器地址，一般为localhost</em></div>
        <div>
          <label>数据库名</label>
          <span>
          <input type="text" name="db_name" maxlength="50" value="<?php echo $_POST['db_name'] ? $_POST['db_name'] : '33hao';?>">
          </span> <em></em></div>
        <div>
          <label>数据库用户名</label>
          <span>
          <input type="text" name="db_user" maxlength="30" value="<?php echo $_POST['db_user'] ? $_POST['db_user'] : '';?>">
          </span> <em></em></div>
        <div>
          <label>数据库密码</label>
          <span>
          <input type="password" name="db_pwd" maxlength="30" value="<?php echo $_POST['db_pwd'] ? $_POST['db_pwd'] : '';?>">
          </span> <em></em></div>
        <div>
          <label>数据库表前缀</label>
          <span>
          <input type="text" name="db_prefix" maxlength="30" value="<?php echo $_POST['db_prefix'] ? $_POST['db_prefix'] : '33hao_';?>">
          </span> <em>同一数据库运行多个多用户商城程序时，请修改前缀</em></div>
        <div>
          <label>数据库端口</label>
          <span>
          <input type="text" name="db_port" maxlength="30" value="<?php echo $_POST['db_port'] ? $_POST['db_port'] : '3306';?>">
          </span> <em>数据库默认端口一般为3306</em></div>
        <?php if ($demo_data) {?>
        <div>
          <label>&nbsp;</label>
          <input name="demo_data" type="checkbox" id="demo_data" value="1" checked <?php echo ((empty($_POST['db_user']) || $_POST['demo_data']==1) ? 'checked':'');?>>
        <h4>演示数据，建议默认安装</h4></div>
        <?php }?>
        <?php if ($install_error != ''){?>
        <div>
          <label></label>
          <font class="error"><?php echo $install_error;?></font></div>
        <?php }?>
      </fieldset>
      <fieldset>
        <legend>网站信息</legend>
        <div>
          <label>站点名称</label>
          <span>
          <input name="site_name" value="<?php echo $_POST['site_name'];?>" maxlength="100" type="text">
          </span> <em>输入站点名称，安装后可在平台设置中进行修改</em></div>
        <div>
          <label>管理员帐号</label>
          <span>
          <input name="admin" value="<?php echo $_POST['admin'];?>" maxlength="20" type="text">
          </span> <em></em></div>
        <div>
          <label>管理员密码</label>
          <span>
          <input name="password" id="password" maxlength="20" value="<?php echo $_POST['password'];?>" type="password">
          </span> <em>管理员密码不少于6个字符</em></div>
        <div>
          <label>重复密码</label>
          <span>
          <input name="rpassword" value="<?php echo $_POST['rpassword'];?>" maxlength="20" type="password">
          </span> <em>确保两次输入的密码一致</em></div>
      </fieldset>
      <fieldset>
        <legend>官方店铺信息</legend>
        <div>
          <label>店铺名称</label>
          <span>
            <input name="store_name" value="<?php echo $_POST['store_name'];?>" maxlength="50" type="text">
          </span>
          <em>官方店铺的店铺名称</em>
        </div>
        <div>
          <label>会员用户名</label>
          <span>
            <input name="member_name" value="<?php echo $_POST['member_name']?>" maxlength="50" type="text">
          </span>
          <em>在买家入口登录的用户名</em>
        </div>
        <div>
          <label>商家用户名</label>
          <span>
            <input name="seller_name" value="<?php echo $_POST['seller_name']?>" maxlength="50" type="text">
          </span>
          <em>在商家入口登录的用户名</em>
        </div>
        <div>
          <label>登录密码</label>
          <span>
            <input name="member_password" id="member_password" value="<?php echo $_POST['member_password'];?>" maxlength="20" type="password">
          </span>
          <em>在买家和商家入口登录的密码，两个用户名使用同一个密码</em>
        </div>
        <div>
          <label>重复密码</label>
          <span>
            <input name="rmember_password" value="<?php echo $_POST['rmember_password']?>" maxlength="20" type="password">
          </span>
          <em></em>
        </div>
      </fieldset>
    </div>
    <div class="btn-box"><a href="index.php?step=2" class="btn btn-primary">上一步</a><a id="next" href="javascript:void(0);" class="btn btn-primary">下一步</a></div>
  </form>
</div>
<?php echo $html_footer;?>
</body>
</html>
