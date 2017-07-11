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
<div class="col-md-12 graphs">
    <div class="xs">
        <h3>数据库备份</h3>
        <div>
            <ol class="breadcrumb">
                <li><a class="btn btn-default" href="javascript:void(0)" id="export" role="button">立即备份</a></li>
            </ol>
        </div>
        <div class="bs-example4" data-example-id="contextual-table">
            <table class="table">
                <thead>
                <tr>
                    <th><input type="checkbox" id="check_all"></th>
                    <th>表名</th>
                    <th>数据量</th>
                    <th>数据大小</th>
                    <th>创建时间</th>
                </tr>
                </thead>
                <tbody>
                <form id="export-form" method="post" action="<?php echo U('Database/backups');?>">
                <?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($key % 2 );++$key;?><tr class="active">
                    <td><input type="checkbox" name="tables[]" value="<?php echo ($v["name"]); ?>" class="check_all"></td>
                    <td><?php echo ($v["name"]); ?></td>
                    <td><?php echo ($v["rows"]); ?></td>
                    <td><?php echo (format_bytes($v["data_length"])); ?></td>
                    <td><?php echo ($v["create_time"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </form>
                </tbody>
            </table>
        </div>
</div>
<script>
    $(function () {
        $('#check_all').click(function () {
            if($(this).prop('checked')){
                $('.check_all').prop('checked','checked');
            }else{
                $('.check_all').prop('checked','');
            }
        })
        $('.check_all').click(function () {
            var all = $('.check_all').length;
            var checked_all = $("input.check_all:checked").length;
            if(all==checked_all){
                $('#check_all').prop('checked','checked');
            }else{
                $('#check_all').prop('checked','');
            }
        })
    })

    $(function($){
        var form = $("#export-form");
        var backups = $("#export");
        var tables;
        backups.click(function(){
            $(this).addClass("disabled");
            backups.html("正在发送备份请求...");
            $.post(form.attr("action"), form.serialize(), function(data){
                    if(data.status){
                        tables = data.tables;
                        backups.html(data.info + "开始备份，请不要关闭本页面！");
                        backup(data.tab);
                        window.onbeforeunload = function(){ return "正在备份数据库，请不要关闭！" }
                    } else {
                        layer.msg(data.info);
                        backups.removeClass("disabled");
                        backups.html("立即备份");
                    }
                },
                "json"
            );
            return false;
        });

        function backup(tab, status){
            status && showmsg(tab.id, "开始备份...(0%)");
            $.get(form.attr("action"), tab, function(data){
                if(data.status){
                    showmsg(tab.id, data.info);

                    if(!$.isPlainObject(data.tab)){
                        backups.removeClass("disabled");
                        backups.html("备份完成，点击重新备份");
                        window.onbeforeunload = function(){ return null }
                        return;
                    }
                    backup(data.tab, tab.id != data.tab.id);
                } else {
                    layer.msg(data.info);
                    backups.removeClass("disabled");
                    backups.html("立即备份");
                }
            }, "json");

        }

        function showmsg(id, msg){
            form.find("input[value=" + tables[id] + "]").closest("tr").find(".info").html(msg);
        }
    });
</script>
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>