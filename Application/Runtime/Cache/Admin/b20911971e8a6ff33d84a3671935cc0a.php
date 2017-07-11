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
        <h3>分组列表</h3>
        <div>
            <ol class="breadcrumb">
                <li><button type="button" class="btn btn-default" id="group_add">新增分组</button></li>
            </ol>
        </div>
        <div class="bs-example4" data-example-id="contextual-table">
            <table class="table">
                <thead>
                <tr>
                    <th>用户组</th>
                    <th>描述</th>
                    <th>授权</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>

                <?php if(is_array($group_list)): $i = 0; $__LIST__ = $group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="active">
                    <td><?php echo ($v["title"]); ?></td>
                    <td><?php echo ($v["display_name"]); ?></td>
                    <td> <a class="btn btn-xs btn-info" href="<?php echo U('Auth/power/',array('id'=>$v['id'],'nav_id'=>$_GET['nav_id']));?>" role="button">权限设置</a></td>
                    <td>
                        <div class="switch small" data-on="info" data-off="success">
                            <input type="checkbox" <?php if($v["status"] == 1): ?>checked<?php endif; ?>  name="status" data-id="<?php echo ($v["id"]); ?>" value="<?php echo ($v["status"]); ?>"/>
                        </div>
                    </td>
                    <td>

                        <a class="btn btn-xs btn-info dialog" href="javascript:void(0)" data-id="<?php echo ($v["id"]); ?>" role="button" data-toggle="modal" data-target="#myModal">修改</a>
                        <a class="btn btn-xs btn-danger delete" data-id="<?php echo ($v["id"]); ?>" role="button">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>
            <div class="modal" id="mymodal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">修改分组信息</h4>
                        </div>
                        <div class="modal-body">
                            <div class="tab-pane active" id="horizontal-form">
                                <form class="form-horizontal" method="post" action="<?php echo U('Menu/edit');?>" id="defaultForm">
                                    <input type="hidden" name="id" id="id" value="">

                                    <div class="form-group">
                                        <label for="titel" class="col-sm-2 control-label">分组名称</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control1" value="<?php echo ($data["titel"]); ?>" name="titel" id="titel" placeholder="">
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="display_name" class="col-sm-2 control-label">描述</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control1" value="<?php echo ($data["display_name"]); ?>" name="display_name" id="display_name">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="close" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" id="submit">保存</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <div class="modal" id="mymodalAdd">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">添加分组信息</h4>
                        </div>
                        <div class="modal-body">
                            <div class="tab-pane active" id="horizontal-form1">
                                <form class="form-horizontal" method="post">
                                    <input type="hidden" name="id_add"  value="">

                                    <div class="form-group">
                                        <label for="titel" class="col-sm-2 control-label">分组名称</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control1" value="" name="titel_add"  placeholder="">
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="display_name" class="col-sm-2 control-label">描述</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control1" value="" name="display_name_add">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"  data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" id="add_submit">保存</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <script>
                $(function(){
                    $(".dialog").click(function(){
                        var id = $(this).data('id');
                        $("#mymodal").modal("toggle");
                        $.get("<?php echo U('Auth/group_edit');?>",{id:id},function (data) {
                            if(data.info)
                            {
                                layer.msg(data.info);
                                return false;
                            }
                            $('#titel').val(data.title);
                            $('#id').val(data.id);
                            $('#display_name').val(data.display_name);
                        })
                    });
                    $('#submit').click(function () {
                        var id = $('#id').val();
                        var title = $('#titel').val();
                        var display_name = $('#display_name').val();
                        if($.trim(title)!='')
                        {
                            $.post("<?php echo U('Auth/group_edit');?>",{id:id,title:title,display_name:display_name},function (result) {
                                layer.msg(result.info);
                                if(result.status>0)
                                {
                                    setTimeout(function(){
                                        location.href=location.href;
                                    },2000);
                                }
                            })
                        }
                    })
                    $("#group_add").click(function(){
                        $("#mymodalAdd").modal("toggle");

                    });
                    $('#add_submit').click(function () {
                        var title = $('[name=titel_add]').val();
                        var display_name = $('[name=display_name_add]').val();
                        if($.trim(title)!='')
                        {
                            $.post("<?php echo U('Auth/group_add');?>",{title:title,display_name:display_name},function (result) {
                                layer.msg(result.info);
                                if(result.status>0)
                                {
                                    setTimeout(function(){
                                        location.href=location.href;
                                    },2000);
                                }
                            })
                        }
                    })
                });
            </script>
        </div>
</div>
<script>

    $(function () {
        $('[name="status"]').bootstrapSwitch({
            onText:"正常",
            offText:"禁用",
            onColor:"success",
            offColor:"warning",
            size:"small",
            onSwitchChange:function(event,state){
                var id = $(this).data('id');
                if(state==true){
                    $(this).val("1");
                    var status = 0;
                }else{
                    $(this).val("0");
                    var status = 1;
                }
                $.post("<?php echo U('Auth/group_status');?>",{status:status,id:id},function (result) {
                    if(result.status<=0)
                    {
                        layer.msg(result.info);
                    }
                })
            }
        })

        $('.delete').click(function () {
            var id = $(this).data('id');
            layer.confirm('您确定要删除此分组吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("<?php echo U('Auth/group_delete');?>",{id:id},function (result) {
                    layer.msg(result.info);
                    if(result.status>0)
                    {
                        setTimeout(function(){
                            location.href=location.href;
                        },2000);
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