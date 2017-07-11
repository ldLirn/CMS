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
                <form class="form-horizontal" method="post" action="<?php echo U('Article/cate_edit');?>" id="defaultForm">
                    <div class="form-group">
                        <label for="pid" class="col-sm-2 control-label">所属分类</label>
                        <div class="col-sm-8">
                            <select name="pid" id="pid" class="form-control1">
                                <option value="0" <?php if($data['pid'] == 0): ?>selected<?php endif; ?> >顶级分类</option>
                                <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php if($data['pid'] == $v['id']): ?>selected<?php endif; ?> ><?php echo ($v["name"]); ?></option>
                                    <?php if(is_array($v["child"])): $i = 0; $__LIST__ = $v["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><option value="<?php echo ($m["id"]); ?>" <?php if($data['pid'] == $m['id']): ?>selected<?php endif; ?> >└─<?php echo ($m["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">分类名称</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="name" id="name" value="<?php echo ($data["name"]); ?>" placeholder="">
                            <input name="id" type="hidden" value="<?php echo ($data["id"]); ?>">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">分类描述</label>
                        <div class="col-sm-8">
                            <textarea name="description" cols="50" rows="4" class="form-control1" id="description" style="height: 80px;" data-bv-field="value"><?php echo ($data["description"]); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sort" class="col-sm-2 control-label label-input-sm">排序</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1 input-sm" name="sort" id="sort" value="<?php echo ($data["sort"]); ?>">
                        </div>
                    </div>


                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn btn-success">提交</button>
                                <button type="button" class="btn">返回</button>
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
                            }
                        })
                        .on('success.form.bv', function(e) {
                            alert(123)
                            e.preventDefault();
                            var $form = $(e.target);
                            // Use Ajax to submit form data
                            $.post($form.attr('action'), $form.serialize(), function(result) {
                                layer.msg(result.info);
                                if(result.status>0){
                                    setTimeout(function(){
                                        location.href="<?php echo U('Article/cate');?>";
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