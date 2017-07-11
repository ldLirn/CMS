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
        <div>
            <ol class="breadcrumb">
                <li><a class="btn btn-default" href="<?php echo U('Wchat/menu_add',array('nav_id'=>$_GET['nav_id']));?>"  role="button">添加菜单</a></li>
            </ol>
        </div>
        <div class="bs-example4" data-example-id="contextual-table">
            <table class="table">
                <thead>
                <tr>
                    <th>菜单名称</th>
                    <th>菜单类型</th>
                    <th>链接值</th>
                    <th>排序</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <form method="post" action="<?php echo U('Wchat/menu_sort');?>" id="defaultForm">
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="active">
                    <td><?php echo ($v["name"]); ?></td>
                    <td><?php echo ($v["type"]); ?></td>
                    <td><?php echo ($v["value"]); ?></td>
                    <td>
                        <input type="hidden" name="id[]" value="<?php echo ($v["id"]); ?>">
                        <input type="text" name="sort[]" value="<?php echo ($v["sort"]); ?>" class="form-control1 input-sm" id="smallinput" style="width: 40px;height: 30px;"></td>
                    <td>
                        <a class="btn btn-xs btn-info" href="<?php echo U('Wchat/menu_edit/',array('id'=>$v['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">修改</a>
                        <button type="button" class="btn btn-xs btn-warning warning_44 delete" data-id="<?php echo ($v["id"]); ?>" data-pid="0">删除</button>
                    </td>
                </tr>
                    <?php if(is_array($v["child"])): $i = 0; $__LIST__ = $v["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><tr class="active">
                            <td style="padding-left: 60px;">└─<?php echo ($child["name"]); ?></td>
                            <td><?php echo ($child["type"]); ?></td>
                            <td><?php echo ($child["value"]); ?></td>
                            <td>
                                <input type="hidden" name="id[]" value="<?php echo ($child["id"]); ?>">
                                <input type="text" name="sort[]" value="<?php echo ($child["sort"]); ?>" class="form-control1 input-sm" id="" style="width: 40px;height:30px;">
                            </td>

                            <td>
                                <a class="btn btn-xs btn-info" href="<?php echo U('Wchat/menu_edit/',array('id'=>$child['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">修改</a>
                                <button type="button" class="btn btn-xs btn-warning warning_44 delete" data-id="<?php echo ($child["id"]); ?>" data-pid="<?php echo ($child["pid"]); ?>">删除</button>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>

            <button type="submit" class="btn btn-xs btn-warning" id="update_sort">更新排序</button>
            </form>
        </div>
</div>
<script>
    $(function () {
        $('.delete').click(function () {
            var id = $(this).data('id');
            var pid=$(this).data('pid');
            layer.confirm('您确定要删除此菜单吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("<?php echo U('Wchat/menu_delete');?>",{id:id,pid:pid},function (result) {
                    layer.msg(result.info);
                    if(result.status>0)
                    {
                        setTimeout(function(){
                            window.location = window.location
                        },1500);
                    }
                })
            }, function(){

            });
        })
    });
    $(document).ready(function() {
        $('#defaultForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {

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
                        if(result.status>0)
                        {
                            setTimeout(function(){
                                window.location = window.location
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