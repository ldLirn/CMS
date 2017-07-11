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
        <h3>菜单列表</h3>
        <div class="bs-example4" data-example-id="contextual-table">
            <table class="table">
                <thead>
                <tr>
                    <th>菜单名称</th>
                    <th>菜单说明</th>
                    <th>菜单图标</th>
                    <th>链接地址</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <form method="post" action="<?php echo U('Menu/sort');?>" id="defaultForm">
                <?php if(is_array($menuListData)): $i = 0; $__LIST__ = $menuListData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="active">
                    <td><?php echo ($v["navname"]); ?></td>
                    <td><?php echo ($v["tip"]); ?></td>
                    <td><?php echo ($v["navicon"]); ?></td>
                    <td><?php echo ($v["href"]); ?></td>
                    <td>
                        <input type="hidden" name="id[]" value="<?php echo ($v["id"]); ?>">
                        <input type="text" name="sort[]" value="<?php echo ($v["sort"]); ?>" class="form-control1 input-sm" id="smallinput" style="width: 40px;"></td>
                    <td>
                        <div class="switch small" data-on="info" data-off="success">
                            <input type="checkbox" <?php if($v["hide"] == 0): ?>checked<?php endif; ?>  name="hide" data-id="<?php echo ($v["id"]); ?>" value="<?php echo ($v["hide"]); ?>"/>
                        </div>
                    </td>
                    <td>
                        <a class="btn btn-xs btn-info" href="<?php echo U('Menu/edit/',array('id'=>$v['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">修改</a>
                        <!--<button type="button" class="btn btn-xs btn-warning warning_44">删除</button>-->
                    </td>
                </tr>
                    <?php if(is_array($v["child"])): $i = 0; $__LIST__ = $v["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><tr class="active">
                            <td style="padding-left: 60px;">  └─<?php echo ($child["navname"]); ?></td>
                            <td><?php echo ($child["tip"]); ?></td>
                            <td><?php echo ($child["navicon"]); ?></td>
                            <td><?php echo ($child["href"]); ?></td>
                            <td>
                                <input type="hidden" name="id[]" value="<?php echo ($child["id"]); ?>">
                                <input type="text" name="sort[]" value="<?php echo ($child["sort"]); ?>" class="form-control1 input-sm" id="" style="width: 40px;"></td>
                            <td>
                                <div class="switch small" data-on="info" data-off="success">
                                    <input type="checkbox" <?php if($child["hide"] == 0): ?>checked<?php endif; ?>  name="hide" data-id="<?php echo ($child["id"]); ?>" value="<?php echo ($child["hide"]); ?>"/>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info" href="<?php echo U('Menu/edit/',array('id'=>$child['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">修改</a>
                                <!--<button type="button" class="btn btn-xs btn-warning warning_44">删除</button>-->
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
        $('[name="hide"]').bootstrapSwitch({
            onText:"显示",
            offText:"隐藏",
            onColor:"success",
            offColor:"info",
            size:"small",
            onSwitchChange:function(event,state){
                var id = $(this).data('id');
                if(state==true){
                    $(this).val("0");
                    var hide = 1;
                }else{
                    $(this).val("1");
                    var hide = 0;
                }
                $.post("<?php echo U('Menu/status');?>",{hide:hide,id:id},function (result) {
                    if(result.status<=0)
                    {
                        layer.msg(result.info);
                    }
                })
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