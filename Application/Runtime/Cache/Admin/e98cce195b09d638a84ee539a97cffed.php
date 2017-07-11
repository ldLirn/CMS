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
        <h3>修改管理员</h3>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="post" action="<?php echo U('Auth/manager_edit',array('id'=>$data['id']));?>" id="defaultForm">
                    <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
                    <div class="form-group">
                        <label for="selector1" class="col-sm-2 control-label">所属分组</label>
                        <div class="col-sm-8">
                            <select name="group_id" id="selector1" class="form-control1">
                                <?php if(is_array($group_list)): $i = 0; $__LIST__ = $group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php if($data['group_id'] == $v['id']): ?>selected<?php endif; ?> ><?php echo ($v["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nickname" class="col-sm-2 control-label">管理员昵称</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="nickname" value="<?php echo ($data["nickname"]); ?>" id="nickname" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">管理员用户名</label>
                        <div class="col-sm-8">
                            <input  type="text" class="form-control1" name="username" value="<?php echo ($data["username"]); ?>" id="username" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">管理员邮箱</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control1" name="email" id="email" value="<?php echo ($data["email"]); ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label label-input-sm">管理员电话</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1 input-sm" name="phone" id="phone" value="<?php echo ($data["phone"]); ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label label-input-sm">管理员密码</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control1 input-sm" name="password" id="password" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block">不修改密码留空</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="re_password" class="col-sm-2 control-label label-input-sm">重复密码</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control1 input-sm" name="re_password" id="re_password" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block">不修改密码留空</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-8">
                            <div class="switch small" data-on="info" data-off="success">
                                <input type="checkbox" <?php if($data["status"] == 0): ?>checked<?php endif; ?>  name="asd" value="<?php echo ($data["status"]); ?>"/>
                                <input type="hidden" name="status" id="status" value="<?php echo ($data["status"]); ?>">
                            </div>
                        </div>
                    </div>


                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn btn-success">提交</button>
                                <button type="reset" class="btn btn-inverse">重置</button>
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

    $(function () {
        $('[name="asd"]').bootstrapSwitch({
            onText:"正常",
            offText:"禁用",
            onColor:"success",
            offColor:"info",
            size:"small",
            onSwitchChange:function(event,state){
                if(state==true){
                    $(this).val("0");
                    $('#status').val(0);
                }else{
                    $(this).val("1");
                    $('#status').val(1);
                }
            }
        })
    })
            $(document).ready(function() {
                $('#defaultForm').bootstrapValidator({
                            message: '无效的输入值',
                            feedbackIcons: {
                                valid: 'glyphicon glyphicon-ok',
                                invalid: 'glyphicon glyphicon-remove',
                                validating: 'glyphicon glyphicon-refresh'
                            },
                            fields: {
                                group_id: {
                                    message: '请选择分组',
                                    validators: {
                                        notEmpty: {
                                            message: '请选择分组'
                                        },
                                        regexp: {
                                            regexp: /^[1-9]\d*$/,
                                            message: '请选择正确的分组'
                                        }
                                    }
                                },
                                username:{
                                    message: '用户名必须填写',
                                    validators: {
                                        notEmpty: {
                                            message: '用户名必须填写'
                                        },
                                        stringLength: {
                                            min: 5,
                                            max: 20,
                                            message: '用户名只能是5到20位之间'
                                        },
                                        regexp: {
                                            regexp: /^[a-zA-Z0-9_\.]+$/,
                                            message: '用户名只能由字母、数字、点和下划线组成'
                                        }
                                    }
                                },
                                email:{
                                    message: '邮箱必须填写',
                                    validators: {
                                        notEmpty: {
                                            message: '邮箱必须填写'
                                        },
                                        regexp: {
                                            regexp: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                                            message: '邮箱地址不合法'
                                        }
                                    }
                                },
                                phone:{
                                    message: '请输入管理员电话',
                                    validators: {
                                        regexp: {
                                            regexp: /^(\+?86-?)?(18|15|13)[0-9]{9}$/,
                                            message: '手机号码格式不正确'
                                        }
                                    }
                                },
                                password:{
                                    message: '请输入管理员密码',
                                    validators: {
                                        stringLength: {
                                            min: 5,
                                            max: 20,
                                            message: '密码只能是5到20位之间'
                                        },
                                        regexp: {
                                            regexp: /^[a-zA-Z0-9_\.]+$/,
                                            message: '密码只能由字母、数字、点和下划线组成'
                                        }
                                    }
                                },
                                re_password:{
                                    message: '请再次输入管理员密码',
                                    validators: {
                                        stringLength: {
                                            min: 5,
                                            max: 20,
                                            message: '密码只能是5到20位之间'
                                        },
                                        regexp: {
                                            regexp: /^[a-zA-Z0-9_\.]+$/,
                                            message: '密码只能由字母、数字、点和下划线组成'
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
                                        location.href="<?php echo U('Auth/manager');?>";
                                    },2000);
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