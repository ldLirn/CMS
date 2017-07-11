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
                <form class="form-horizontal" method="post" action="<?php echo U('Config/edit');?>" id="defaultForm">
                    <input type="hidden" name="id" value="<?php echo ($this_data["id"]); ?>">
                    <div class="form-group">
                        <label for="selector1" class="col-sm-2 control-label">所属分组</label>
                        <div class="col-sm-8">
                            <select name="type" id="selector1" class="form-control1">
                            <?php if(is_array($config_type)): $k = 0; $__LIST__ = $config_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><option value="<?php echo ($k); ?>" <?php if($this_data['type'] == $k): ?>selected<?php endif; ?> ><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">配置标识</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="name" value="<?php echo ($this_data["name"]); ?>" id="name" placeholder="用于C函数调用，只能使用英文且不能重复">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">配置标题</label>
                        <div class="col-sm-8">
                            <input  type="text" class="form-control1" value="<?php echo ($this_data["title"]); ?>" name="title" id="title" placeholder="用于后台显示的配置标题">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data_type" class="col-sm-2 control-label">配置数据类型</label>
                        <div class="col-sm-8">
                            <select name="data_type" id="selector2" class="form-control1">
                                <option value="0">请选择数据类型</option>
                                <?php if(is_array($data_type)): $k = 0; $__LIST__ = $data_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><option value="<?php echo ($k); ?>" <?php if($this_data['data_type'] == $k): ?>selected<?php endif; ?> ><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="change_hide" style="display: none">
                        <label for="extra" class="col-sm-2 control-label label-input-sm">配置选项</label>
                        <div class="col-sm-8">
                            <input  type="text" class="form-control1" value="<?php echo ($this_data["extra"]); ?>" name="extra"  placeholder="例如: 0|关闭,1|开启 (逗号请使用英文半角)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="value" class="col-sm-2 control-label label-input-sm">配置值</label>
                        <div class="col-sm-8">
                            <textarea name="value"  cols="50" rows="4"  class="form-control1" style="height: 80px;"><?php echo ($this_data["value"]); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="remark" class="col-sm-2 control-label label-input-sm">配置说明</label>
                        <div class="col-sm-8">
                            <textarea name="remark" id="remark" cols="100" rows="6" class="form-control1" style="height: 80px;"><?php echo ($this_data["remark"]); ?></textarea>
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
    
</div>
    <div class="copy_layout">
    <p>Copyright © 2017.Lirn All rights reserved.<a target="_blank" href="http://www.taokebt.cn">券如意</a></p>
</div>
</div>
<script>
    $('#selector2').change(function () {
        if($(this).val()==2) {
            $('#change_hide').show();
        }else{
            $('#change_hide').hide();
        }
    })
    $(function () {
        var val = $('#selector2 option:selected').val();
        if(val==2){
            $('#change_hide').show();
        }
    })
</script>


<script>
$(document).ready(function() {
    $('#defaultForm').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        message: '配置标识不能为空',
                        validators: {
                            notEmpty: {
                                message: '配置标识不能为空'
                            },
                                regexp: {
                                    regexp: /^[a-zA-Z]+[a-zA-Z_]*$/,
                                    message: '配置标识只能由字母开头，字母和下划线组成'
                                }
                        }
                    },
                    title:{
                        message: '配置名称不能为空',
                        validators: {
                            notEmpty: {
                                message: '配置名称不能为空'
                            }
                        }
                    },
                    type:{
                        message: '请选择分组',
                        validators: {
                            regexp: {
                                regexp: /^[1-9]\d*$/,
                                message: '请选择分组'
                            }
                        }
                    },
                    data_type:{
                        message: '请选择数据类型',
                        validators: {
                            regexp: {
                                regexp: /^[1-9]\d*$/,
                                message: '请选择数据类型'
                            }
                        }
                    },
                    value:{
                        message: '请填写配置值',
                        validators: {
                            notEmpty: {
                                message: '配置值不能为空'
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
                            location.href="<?php echo U('Config/config');?>";
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