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
    <div class="graphs">
        <div class="col_3">
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-thumbs-up icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>45%</strong></h5>
                        <span>新订单</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-users user1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>1019</strong></h5>
                        <span>新浏览</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-comment user2 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>1012</strong></h5>
                        <span>新用户</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-dollar dollar1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>$450</strong></h5>
                        <span>今日收入</span>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="col_1">
            <div class="col-md-4 span_7">
                <div class="cal1 cal_2">
                    <div class="clndr"></div>
                </div>
            </div>
            <div class="col-md-4 span_4">
                <div class="cloud">
                    <div class="grid-date_n">
                        <div class="date">
                            <p class="date-in">系统信息</p>
                            <span class="date-on"></span>
                            <div class="clearfix"> </div>
                        </div>
                        <h4 >服务器操作系统：<?php echo PHP_OS;?> </h4>
                        <h4 >运行环境：<?php echo ($_SERVER['SERVER_SOFTWARE']); ?></h4>
                        <h4 >服务器域名/IP：<?php echo ($_SERVER['SERVER_NAME']); ?>/<?php echo ($_SERVER['SERVER_ADDR']); ?></h4>
                        <h4 >上传限制：<?PHP echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"; ?> </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 span_4">
                <div class="cloud">
                    <div class="grid-date">
                        <div class="date">
                            <p class="date-in" id="city_name"></p>
                            <span class="date-on" id="img"></span>
                            <div class="clearfix"> </div>
                        </div>
                        <h4 id="weather" style="font-size: 25px;"><i class="fa fa-cloud-upload"> </i></h4>
                    </div>
                </div>
            </div>

            <div class="clearfix"> </div>
        </div>

        <div class="span_11">
            <div class="col-md-6 col_4">

                <!----Calender -------->
                <link rel="stylesheet" href="/Public/admin/css/clndr.css" type="text/css" />
                <script src="/Public/admin/js/underscore-min.js" type="text/javascript"></script>
                <script src= "/Public/admin/js/moment-2.2.1.js" type="text/javascript"></script>
                <script src="/Public/admin/js/clndr.js" type="text/javascript"></script>
                <script src="/Public/admin/js/site.js" type="text/javascript"></script>
                <!----End Calender -------->
            </div>
            <div class="clearfix"> </div>
        </div>

        <div class="copy_layout">
    <p>Copyright © 2017.Lirn All rights reserved.<a target="_blank" href="http://www.taokebt.cn">券如意</a></p>
</div>
    </div>
    <!-- /#page-wrapper -->
</div>
<script type="text/javascript">

    function findWeather() {
        var cityUrl = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js';
        $.getScript(cityUrl, function (script, textStatus, jqXHR) {
            var citytq = remote_ip_info.city; // 获取城市

            citytq = "成都";
            var url = "http://php.weather.sina.com.cn/iframe/index/w_cl.php?code=js&city=" + citytq + "&day=0&dfc=3";
            $.ajax({
                url: url,
                dataType: "script",
                scriptCharset: "gbk",
                success: function (data) {
                    var _w = window.SWther.w[citytq][0];
                    var _f = _w.f1 + "_0.png";
                    if (new Date().getHours() > 17) {
                        _f = _w.f2 + "_1.png";
                    }
                    var img = "<img width='35px' height='35px' src='http://i2.sinaimg.cn/dy/main/weather/weatherplugin/wthIco/20_20/" + _f
                            + "' />";
                    //var tq = "今日天气 :　" + citytq + " " + img + " " + _w.s1 + " " + _w.t1 + "℃～" + _w.t2 + "℃ " + _w.d1 + _w.p1 + "级";
                    $('#city_name').html(citytq);
                    $('#img').html(img);
                    $('#weather').html(_w.s1 + " " + _w.t1 + "℃～" + _w.t2 + "℃ " + _w.d1 + _w.p1 + "级");
                }
            });
        });
    }
    findWeather()
</script>
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>