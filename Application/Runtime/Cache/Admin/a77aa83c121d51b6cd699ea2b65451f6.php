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
        <h3>修改菜单</h3>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="post" action="<?php echo U('Menu/edit');?>" id="defaultForm">
                    <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
                    <div class="form-group">
                        <label for="selector1" class="col-sm-2 control-label">所属类别</label>
                        <div class="col-sm-8"><select name="pid" id="selector1" class="form-control1">
                            <option value="0">顶级菜单</option>
                            <?php if(is_array($menuListData)): $i = 0; $__LIST__ = $menuListData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php if($data['pid'] == $v['id']): ?>selected='selected'<?php endif; ?> ><?php echo ($v["navname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                        </select></div>
                    </div>

                    <div class="form-group">
                        <label for="navname" class="col-sm-2 control-label">菜单名称</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["navname"]); ?>" name="navname" id="navname" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="icon" class="col-sm-2 control-label">菜单icon样式</label>
                        <div class="col-sm-8">
                            <input  type="text" class="form-control1" value="<?php echo ($data["navicon"]); ?>" name="navicon" id="icon" placeholder="fa-jui">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="href" class="col-sm-2 control-label">菜单链接地址</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["href"]); ?>" name="href" id="href" placeholder="User/add">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="12" class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-8">
                            <div class="switch small" data-on="info" data-off="success">
                                <input type="checkbox"  name="asd" value="<?php echo ($data["hide"]); ?>" <?php if($data['hide'] == 0): ?>checked<?php endif; ?> />
                                <input type="hidden" name="hide" id="hide" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tip" class="col-sm-2 control-label label-input-sm">提示说明</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1 input-sm" name="tip" value="<?php echo ($data["tip"]); ?>" id="tip" placeholder="tip">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sort" class="col-sm-2 control-label label-input-sm">排序</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1 input-sm" name="sort" id="sort" value="<?php echo ($data["sort"]); ?>" placeholder="sort">
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
            onText:"显示",
            offText:"隐藏",
            onColor:"success",
            offColor:"info",
            size:"small",
            onSwitchChange:function(event,state){
                if(state==true){
                    $(this).val(0);
                    $('#hide').val(0);
                }else{
                    $(this).val(1);
                    $('#hide').val(1);
                }
            }
        })
    })
            $(document).ready(function() {
                $('#defaultForm').bootstrapValidator({
                            message: 'This value is not valid',
                            feedbackIcons: {
                                valid: 'glyphicon glyphicon-ok',
                                invalid: 'glyphicon glyphicon-remove',
                                validating: 'glyphicon glyphicon-refresh'
                            },
                            fields: {
                                navname: {
                                    message: '菜单名称不能为空',
                                    validators: {
                                        notEmpty: {
                                            message: '菜单名称不能为空'
                                        }
//                                        stringLength: {
//                                            min: 6,
//                                            max: 30,
//                                            message: 'The username must be more than 6 and less than 30 characters long'
//                                        },
//                                        regexp: {
//                                            regexp: /^[a-zA-Z0-9_\.]+$/,
//                                            message: 'The username can only consist of alphabetical, number, dot and underscore'
//                                        }
                                    }
                                },
                                sort:{
                                    message: '排序只能是数字类型',
                                    validators: {
                                        notEmpty: {
                                            message: '排序不能为空'
                                        },
                                        stringLength: {
                                            min: 1,
                                            max: 10000,
                                            message: '排序只能是1到10000之间'
                                        },
                                        regexp: {
                                            regexp: /^\+?[1-9][0-9]*$/,
                                            message: '数字只能是正整数'
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
                                        location.href="<?php echo U('Menu/lists');?>";
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