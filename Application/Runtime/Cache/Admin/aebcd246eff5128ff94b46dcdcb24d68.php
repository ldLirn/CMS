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
<body id="login" style="min-height: 670px">
  <div class="login-logo">
    <a href="index.html"><img src="/Public/admin/images/logo.png" alt=""/></a>
  </div>
  <h2 class="form-heading">忘记密码</h2>
  <div class="app-cam">
	  <form action="<?php echo U('Login/forget');?>" method="post" id="forgetForm">
		<input type="email" class="text" placeholder="邮箱地址" name="email">
		<input type="text" name="verifyCode"  placeholder="验证码" class="layui-input" style="width: 176px;float: left">
		<div class="verify" style="border-radius:2px;cursor:pointer;"><img src="<?php echo U('Login/verify');?>" id="verify"></div>
	
		<div class="submit"><input type="button" id="act_form"   value="发送邮件"></div>
		<div class="login-social-link">
     
        </div>
		<ul class="new">
			<li class="new_left"><p><a href="<?php echo U('Login/login');?>">去登陆</a></p></li>
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
		  $('#act_form').click(function () {
			  if($.trim($('input[name=email]').val())=='' ||  $.trim($('input[name=verifyCode]').val())=='')
			  {
				  layer.msg('请填写完整的信息');
				  return false;
			  }
			  var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  if(!re.test($.trim($('input[name=email]').val()))){
				  layer.msg('邮箱地址格式错误');
				  return false;
			  }
			  var $form = $('#forgetForm');
			  $.post($form.attr('action'), $form.serialize(), function(result) {
				  layer.msg(result.info);
				  $('#verify').attr('src',"<?php echo U('Login/verify');?>?"+Math.random());
				  if(result.status>0){
					  $('#act_form').attr("disabled",true);
				  }
			  }, 'json');
		  })
	  });

  </script>
</body>
</html>