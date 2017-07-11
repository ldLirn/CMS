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
        <h3>权限节点列表</h3>
        <div>
            <ol class="breadcrumb">
                <li><a role="button" class="btn btn-default" href="<?php echo U('Auth/node_add',array('nav_id'=>$_GET['nav_id']));?>">添加节点</a></li>
            </ol>
        </div>
        <div class="bs-example4" data-example-id="contextual-table">
            <table class="table">
                <thead>
                <tr>
                    <th>权限名称</th>
                    <th>唯一标识</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($rules)): $i = 0; $__LIST__ = $rules;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="active">
                    <td><?php echo ($v["title"]); ?></td>
                    <td><?php echo ($v["name"]); ?></td>
                    <td>
                        <div class="switch small" data-on="info" data-off="success">
                            <input type="checkbox" <?php if($v["status"] == 1): ?>checked<?php endif; ?>  name="status" data-id="<?php echo ($v["id"]); ?>" value="<?php echo ($v["status"]); ?>"/>
                        </div>
                    </td>
                    <td>
                        <a class="btn btn-xs btn-info" href="<?php echo U('Auth/node_edit/',array('id'=>$v['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">修改</a>
                        <button type="button" class="btn btn-xs btn-warning warning_44 delete" data-id="<?php echo ($v["id"]); ?>">删除</button>
                    </td>
                </tr>
                    <?php if(is_array($v["child"])): $i = 0; $__LIST__ = $v["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><tr class="active">
                            <td style="padding-left: 60px;" align="center">  └─<?php echo ($child["title"]); ?></td>
                            <td><?php echo ($child["name"]); ?></td>
                            <td>
                                <div class="switch small" data-on="info" data-off="success">
                                    <input type="checkbox" <?php if($child["status"] == 1): ?>checked<?php endif; ?>  name="status" data-id="<?php echo ($child["id"]); ?>" value="<?php echo ($child["status"]); ?>"/>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info" href="<?php echo U('Auth/node_edit/',array('id'=>$child['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">修改</a>
                                <button type="button" class="btn btn-xs btn-warning warning_44 delete" data-id="<?php echo ($child["id"]); ?>">删除</button>
                            </td>
                        </tr>
                        <?php if(is_array($child["child"])): $i = 0; $__LIST__ = $child["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$node): $mod = ($i % 2 );++$i;?><tr class="active">
                                <td style="padding-left: 60px;" align="right">  └─<?php echo ($node["title"]); ?></td>
                                <td><?php echo ($node["name"]); ?></td>
                                <td>
                                    <div class="switch small" data-on="info" data-off="success">
                                        <input type="checkbox" <?php if($node["status"] == 1): ?>checked<?php endif; ?>  name="status" data-id="<?php echo ($node["id"]); ?>" value="<?php echo ($node["status"]); ?>"/>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="<?php echo U('Auth/node_edit/',array('id'=>$node['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">修改</a>
                                    <button type="button" class="btn btn-xs btn-warning warning_44 delete" data-id="<?php echo ($node["id"]); ?>">删除</button>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>

            </form>
        </div>
</div>
<script>
    $(function () {
        $('[name="status"]').bootstrapSwitch({
            onText:"正常",
            offText:"禁用",
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
                $.post("<?php echo U('Auth/node_status');?>",{status:hide,id:id},function (result) {
                    if(result.status<0)
                    {
                        layer.msg(result.info);
                    }
                })
            }
        });

        $('.delete').click(function () {
            var id = $(this).data('id');
            layer.confirm('您确定要删除此权限节点吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("<?php echo U('Auth/node_delete');?>",{id:id},function (result) {
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
    })
</script>
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>