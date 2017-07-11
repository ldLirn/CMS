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
        <h3><?php echo ($title); ?></h3>
        <div style="background: #f5f5f5;width: 100%;height: 50px">
            <ol class="breadcrumb" style="float: left;width: 20%">
                <a class="btn btn-default" href="<?php echo U('Wchat/wchat_list');?>" role="button">更新粉丝数据</a>
            </ol>

                <div class="col-lg-4" style="float: right">
                    <div class="input-group" style="background: #fff">
                        <input type="text" class="form-control" placeholder="搜你想要的">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>

        </div>
        <div class="bs-example4" data-example-id="contextual-table">
            <table class="table">
                <thead>
                <tr>
                    <th><input type="checkbox" id="check_all">ID</th>
                    <th>头像</th>
                    <th>昵称</th>
                    <th>所在地</th>
                    <th>性别</th>
                    <th>关注时间</th>
                </tr>
                </thead>
                <tbody>

                <?php if(is_array($data["list"])): $i = 0; $__LIST__ = $data["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="active">
                    <td><input type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>" class="check_all"><?php echo ($v["id"]); ?></td>
                    <td><img src="<?php echo ($v["headimgurl"]); ?>" width="40" height="40"/></td>
                    <td><?php echo ($v["nickname"]); ?></td>
                    <td><?php echo ($v["province"]); echo ($v["city"]); ?></td>
                    <td><?php if($v['sex'] == 1): ?>男<?php else: ?>女<?php endif; ?></td>
                    <td><?php echo (date('Y-m-d',$v["subscribe_time"])); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>
        </div>
        <nav>
           <?php echo ($data["show"]); ?>
        </nav>
</div>
    <div class="copy_layout">
    <p>Copyright © 2017.Lirn All rights reserved.<a target="_blank" href="http://www.taokebt.cn">券如意</a></p>
</div>
<script>

    $(function () {

        $('.delete').click(function () {
            var id = $(this).data('id');
            layer.confirm('您确定要删除此配置吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("<?php echo U('Config/delete');?>",{id:id},function (result) {
                    layer.msg(result.info);
                    if(result.status>0)
                    {
                        setTimeout(function(){
                            location.href=location.href;
                        },1500);
                    }
                })
            }, function(){

            });
        })

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
</script>
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>