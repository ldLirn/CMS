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
        <h3>添加权限节点</h3>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="post" action="<?php echo U('Auth/node_add');?>" id="defaultForm">
                    <div class="form-group">
                        <label for="selector1" class="col-sm-2 control-label">所属栏目</label>
                        <div class="col-sm-8">
                            <select name="pid" id="selector1" class="form-control1">
                                <option value="">请选择所属栏目</option>
                                <option value="0">顶级栏目</option>
                                <?php if(is_array($rules)): $i = 0; $__LIST__ = $rules;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rule): $mod = ($i % 2 );++$i;?><option value="<?php echo ($rule["id"]); ?>"><?php echo ($rule["title"]); ?></option>
                                    <?php if(is_array($rule["child"])): $i = 0; $__LIST__ = $rule["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><option value="<?php echo ($child["id"]); ?>">└─<?php echo ($child["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">节点名称</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="title" id="title" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">节点唯一标识</label>
                        <div class="col-sm-8">
                            <input  type="text" class="form-control1" name="name" id="name" placeholder="例如:Auth/node">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block">U方法地址</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-8">
                            <div class="switch small" data-on="info" data-off="success">
                                <input type="checkbox" checked  name="asd" value="1"/>
                                <input type="hidden" name="status" id="status" value="1">
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
                                pid: {
                                    message: '请选择栏目',
                                    validators: {
                                        notEmpty: {
                                            message: '请选择栏目'
                                        },
                                        regexp: {
                                            regexp: /^[0-9]\d*$/,
                                            message: '请选择正确的分组'
                                        }
                                    }
                                },
                                title:{
                                    message: '标识名称必须填写',
                                    validators: {
                                        notEmpty: {
                                            message: '标识名称必须填写'
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
                                        location.href="<?php echo U('Auth/node');?>";
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