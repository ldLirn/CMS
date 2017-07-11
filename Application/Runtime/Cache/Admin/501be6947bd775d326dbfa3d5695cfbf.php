<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title><?php echo ($title); ?>--<?php echo C('WEB_TITLE');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Bootstrap Core CSS -->
    <link href="/Public/admin/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/bootstrap-switch.css">
    <link rel="stylesheet" href="/Public/admin/css/bootstrapValidator.css"/>
    <!-- Custom CSS -->
    <link href="/Public/admin/css/style.css" rel='stylesheet' type='text/css' />
    <link href="/Public/common/css/page.css" rel="stylesheet">
    <!-- Graph CSS -->
    <link href="/Public/admin/css/lines.css" rel='stylesheet' type='text/css' />
    <link href="/Public/admin/css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="/Public/admin/js/jquery.min.js"></script>

    <!-- Nav CSS -->
    <link href="/Public/admin/css/custom.css" rel="stylesheet">
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/Public/admin/js/metisMenu.min.js"></script>
    <script src="/Public/admin/js/custom.js"></script>
    <!-- Graph JavaScript -->
    <script src="/Public/admin/js/d3.v3.js"></script>
    <script src="/Public/admin/js/rickshaw.js"></script>
    <script type="text/javascript" src="/Public/common/js/layer/layer.js"></script>
    <script type="text/javascript" src="/Public/admin/js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="/Public/admin/js/bootstrapValidator.min.js"></script>
</head>

<body>

<div id="wrapper">

   <?php echo W('Admin/menu');?>
<div id="page-wrapper">
    <?php echo ($breadcrumb); ?>
<div class="graphs">
    <div class="xs">
        <h3><?php echo ($title); ?></h3>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="post" action="<?php echo U('Wchat/config');?>" id="defaultForm">
                    <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">

                    <div class="form-group">
                        <label for="appid" class="col-sm-2 control-label">AppID(应用ID)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="appid" value="<?php echo ($data["appid"]); ?>" id="appid" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="appsecret" class="col-sm-2 control-label">AppSecret(应用密钥)</label>
                        <div class="col-sm-8">
                            <input  type="text" class="form-control1" name="appsecret" value="<?php echo ($data["appsecret"]); ?>" id="appsecret" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="token" class="col-sm-2 control-label">Token(令牌)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="token" id="token" value="<?php echo ($data["token"]); ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="key" class="col-sm-2 control-label label-input-sm">EncodingAESKey(消息加解密密钥)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1 input-sm" name="key" id="key" value="<?php echo ($data["key"]); ?>" placeholder="">
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn btn-success">提交</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="copy_layout">
    <p>Copyright © 2017.Lirn All rights reserved.<a target="_blank" href="http://www.taokebt.cn">券如意</a></p>
</div>
</div>
</div>

<script>
            $(document).ready(function() {
                $('#defaultForm').bootstrapValidator({
                            message: '无效的输入值',
                            feedbackIcons: {
                                valid: 'glyphicon glyphicon-ok',
                                invalid: 'glyphicon glyphicon-remove',
                                validating: 'glyphicon glyphicon-refresh'
                            },
                            fields: {
                                appid:{
                                    message: 'AppID(应用ID)必须填写',
                                    validators: {
                                        notEmpty: {
                                            message: 'AppID(应用ID)必须填写'
                                        }
                                    }
                                },
                                appsecret:{
                                    message: 'AppSecret(应用密钥)必须填写',
                                    validators: {
                                        notEmpty: {
                                            message: 'AppSecret(应用密钥)必须填写'
                                        }
                                    }
                                },
                                token:{
                                    message: 'Token(令牌)必须填写',
                                    validators: {
                                        notEmpty: {
                                            message: 'Token(令牌)必须填写'
                                        }
                                    }
                                }
                            }
                        })
                        .on('success.form.bv', function(e) {
                            // Prevent form submission
                            e.preventDefault();
                            // Get the form instance
                            var $form = $(e.target);
                            // Get the BootstrapValidator instance
                            var bv = $form.data('bootstrapValidator');
                            // Use Ajax to submit form data
                            $.post($form.attr('action'), $form.serialize(), function(result) {
                                layer.msg(result.info);
                                if(result.status>0){
                                    setTimeout(function(){
                                        location.href=location.href;
                                    },1500);
                                }
                            }, 'json');
                        });
            });

</script>
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>