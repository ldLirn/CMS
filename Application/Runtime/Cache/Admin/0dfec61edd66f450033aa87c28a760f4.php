<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo C('WEB_TITLE');?>--<?php echo ($page_title); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="/Public/admin/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="/Public/admin/css/style.css" rel='stylesheet' type='text/css' />
<link href="/Public/admin/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="/Public/admin/css/bootstrapValidator.css"/>
<!-- jQuery -->
<script src="/Public/admin/js/jquery.min.js"></script> 
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="/Public/admin/js/bootstrapValidator.min.js"></script>
<script src="/Public/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/common/js/layer/layer.js"></script>

</head>
<body id="login">
  <div class="login-logo">
    <a href="index.html"><img src="/Public/admin/images/logo.png" alt=""/></a>
  </div>
  <h2 class="form-heading">登陆</h2>
  <div class="app-cam">
	  <form action="<?php echo U('Login/login');?>" method="post" id="loginForm">
		<input type="text" class="text" placeholder="用户名或邮箱" name="username">
		<input type="password" value="" placeholder="密码" name="password">
		<input type="text" name="verifyCode"  placeholder="验证码" class="layui-input" style="width: 176px;float: left">
		<div class="verify" style="border-radius:2px;cursor:pointer;"><img src="<?php echo U('Login/verify');?>" id="verify"></div>
	
		<div class="submit"><input type="submit"  value="登陆"></div>
		<div class="login-social-link">
     
        </div>
		<ul class="new">
			<li class="new_left"><p><a href="<?php echo U('Login/forget');?>">忘记密码 ?</a></p></li>
			<div class="clearfix"></div>
		</ul>
	</form>
  </div>
   <div class="copy_layout">
    <p>Copyright © 2017.Lirn All rights reserved.<a target="_blank" href="http://www.taokebt.cn">券如意</a></p>
</div>
 <script>
		$('#verify').click(function(){
			$('#verify').attr('src',"<?php echo U('Login/verify');?>?"+Math.random());
		});
 </script>
  <script>
	  $(document).ready(function() {
		  $('#loginForm').bootstrapValidator({
			  message: 'This value is not valid',
			  feedbackIcons: {
				  valid: 'glyphicon glyphicon-ok',
				  invalid: 'glyphicon glyphicon-remove',
				  validating: 'glyphicon glyphicon-refresh'
			  },
		  })
				  .on('success.form.bv', function(e) {
					  // Prevent form submission
					  e.preventDefault();

					  // Get the form instance
					  var $form = $(e.target);

					  // Get the BootstrapValidator instance
					  var bv = $form.data('bootstrapValidator');
					  if($.trim($('input[name=username]').val())=='' || $.trim($('input[name=password]').val())=='' || $.trim($('input[name=verifyCode]').val())=='')
					  {
						  layer.msg('请填写完整的登陆信息');
						  $('#loginForm').bootstrapValidator('disableSubmitButtons', false);
						  return false;
					  }
					  // Use Ajax to submit form data
					  $.post($form.attr('action'), $form.serialize(), function(result) {
						  layer.msg(result.info);
						  $('#loginForm').bootstrapValidator('disableSubmitButtons', false);
						  $('#verify').attr('src',"<?php echo U('Login/verify');?>?"+Math.random());
						  if(result.status>0){
							  setTimeout(function(){
								  location.href="<?php echo U('Index/index');?>";
							  },1000);
						  }
					  }, 'json');
				  });
	  });

  </script>
</body>
</html>