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
    <div class="grid_3 grid_5">
        <div class="but_list">
            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#1" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">基本设置</a></li>
                    <li role="presentation" class=""><a href="#2" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">内容设置</a></li>
                    <li role="presentation" ><a href="#3" id="user-tab"  data-toggle="tab" aria-controls="user" aria-expanded="false">用户设置</a></li>
                    <li role="presentation" class=""><a href="#4" role="tab" id="web-tab" data-toggle="tab" aria-controls="web" aria-expanded="false">系统设置</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <!--基本设置-->
                    <div role="tabpanel" class="tab-pane fade active in" id="1" aria-labelledby="home-tab">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <form class="form-horizontal bv-form" method="post" id="configForm1" novalidate="novalidate">
                                    <?php if(is_array($data[1])): $i = 0; $__LIST__ = $data[1];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo ($v["title"]); ?></label>
                                        <div class="col-sm-5">
                                            <?php echo ($v["html"]); ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="help-block"><?php echo ($v["remark"]); ?></p>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                </form>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button  class="btn btn-success" id="form1">提交</button>
                                                <button type="" class="btn btn-inverse">返回</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!--基本设置END-->
                    <!--内容设置-->
                    <div role="tabpanel" class="tab-pane fade" id="2" aria-labelledby="profile-tab">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <form class="form-horizontal bv-form" method="post" id="configForm2"  novalidate="novalidate">
                                    <?php if(is_array($data[2])): $i = 0; $__LIST__ = $data[2];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo ($v["title"]); ?></label>
                                            <div class="col-sm-5">
                                                <?php echo ($v["html"]); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="help-block"><?php echo ($v["remark"]); ?></p>
                                            </div>
                                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                </form>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button type="" class="btn btn-success" id="form2">提交</button>
                                                <button type="" class="btn btn-inverse">返回</button>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                     </div>
                    <!--内容设置END-->
                    <!--用户设置-->
                    <div role="tabpanel" class="tab-pane fade" id="3" aria-labelledby="dropdown1-tab">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <form class="form-horizontal bv-form" method="post" id="configForm3" novalidate="novalidate">
                                    <?php if(is_array($data[3])): $i = 0; $__LIST__ = $data[3];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo ($v["title"]); ?></label>
                                            <div class="col-sm-5">
                                                <?php echo ($v["html"]); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="help-block"><?php echo ($v["remark"]); ?></p>
                                            </div>
                                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                </form>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button type="" class="btn btn-success" id="form3">提交</button>
                                                <button type="" class="btn btn-inverse">返回</button>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                     </div>
                    <!--用户设置END-->
                    <!--系统设置-->
                    <div role="tabpanel" class="tab-pane fade" id="4" aria-labelledby="dropdown2-tab">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <form class="form-horizontal bv-form" method="post"  id="configForm4" novalidate="novalidate">
                                    <?php if(is_array($data[4])): $i = 0; $__LIST__ = $data[4];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo ($v["title"]); ?></label>
                                            <div class="col-sm-5">
                                                <?php echo ($v["html"]); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="help-block"><?php echo ($v["remark"]); ?></p>
                                            </div>
                                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                </form>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button type="" class="btn btn-success" id="form4">提交</button>
                                                <button type="" class="btn btn-inverse">返回</button>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <!--系统设置END-->
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#form1').click(function () {
            var form = $("#configForm1");
            $.post("<?php echo U('Config/setConfig');?>", form.serialize(),function (result) {
                layer.msg(result.info);
                if(result.status>0){
                    setTimeout(function(){
                        location.href="<?php echo U('Config/index');?>"+'#1';
                    },1500);
                }
            })
        })

        $('#form2').click(function () {
            var form = $("#configForm2");
            $.post("<?php echo U('Config/setConfig');?>", form.serialize(),function (result) {
                layer.msg(result.info);
                if(result.status>0){
                    setTimeout(function(){
                        location.href="<?php echo U('Config/index');?>"+'#2';
                    },1500);
                }
            })
        })

        $('#form3').click(function () {
            var form = $("#configForm3");
            $.post("<?php echo U('Config/setConfig');?>", form.serialize(),function (result) {
                layer.msg(result.info);
                if(result.status>0){
                    setTimeout(function(){
                        location.href="<?php echo U('Config/index');?>"+'#3';
                    },1500);
                }
            })
        })

        $('#form4').click(function () {
            var form = $("#configForm4");
            $.post("<?php echo U('Config/setConfig');?>", form.serialize(),function (result) {
                layer.msg(result.info);
                if(result.status>0){
                    setTimeout(function(){
                        location.href="<?php echo U('Config/index');?>"+'#4';
                    },1500);
                }
            })
        })
    </script>
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>