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

   <script type="text/javascript" src="/Public/admin/js/jquery.blockUI.js"></script>
<!-- Navigation -->
<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo U('Index/index');?>">LIRNCms</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">
            <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"><img src="/Public/admin/images/1.png"><span class="badge"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-menu-header text-center">
                    <strong><?php echo (session('username')); ?></strong>
                </li>
                <li class="m_2"><a href="/" target="_blank"><i class="fa fa-file"></i>前台首页</a></li>
                <li class="m_2"><a href="<?php echo U('Index/clear');?>"><i class="fa fa-refresh"></i>清除缓存</a></li>
                <li class="m_2"><a href="<?php echo U('Index/config');?>"><i class="fa fa-wrench"></i>设置</a></li>
                <li class="m_2"><a href="javascript:void(0)" id="block"><i class="fa fa-shield"></i>锁屏</a></li>
                <li class="m_2"><a href="<?php echo U('Login/loginOut');?>"><i class="fa fa-lock"></i>退出</a></li>
            </ul>
        </li>
    </ul>

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?php echo U('Index/index');?>"><i class="fa fa-dashboard fa-fw nav_icon"></i>首页</a>
                </li>
                <?php if(is_array($menuListData)): $i = 0; $__LIST__ = $menuListData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                        <a href="<?php echo ($v["href"]); ?>"><i class="fa <?php echo ($v["navicon"]); ?> nav_icon"></i><?php echo ($v["navname"]); ?><span class="fa arrow"></span></a>
                        <?php if(count($v.child) > 0): ?><ul class="nav nav-second-level">
                                <?php if(is_array($v["child"])): $i = 0; $__LIST__ = $v["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><li>
                                        <a href="<?php echo U($child['href'],array('nav_id'=>$child['id']));?>"><?php echo ($child["navname"]); ?></a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul><?php endif; ?>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
    <!-- /.navbar-static-side -->
</nav>
<script>
    $('ul.navbar-right').click(function () {
        if( $('ul.navbar-right li.dropdown').hasClass('open')){
            $('ul.navbar-right li.dropdown').removeClass('open');
        }else{
            $('ul.navbar-right li.dropdown').addClass('open');
        }
    })
    $(function(){
        $('#block').click(function () {
            $.blockUI({ message: '<h1>锁屏中。。。</h1>' });
        })
    })
    $('#unblock').click(function() {
        alert(12)
        $.unblockUI();
    });
</script>

</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>