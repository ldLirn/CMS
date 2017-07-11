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
<link rel="stylesheet" href="/Public/common/css/ssi-uploader.css">
<script src="/Public/common/js/ssi-uploader.js"></script>
<div id="page-wrapper">
    <?php echo ($breadcrumb); ?>
<div class="graphs">
    <div class="xs">
        <h3><?php echo ($title); ?></h3>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="post" action="<?php echo U('Wchat/keywords_edit');?>" id="defaultForm">
                    <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">功能描述</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["name"]); ?>" name="name" id="name" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="command" class="col-sm-2 control-label">主关键字</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["command"]); ?>" name="command" id="command">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="extend" class="col-sm-2 control-label">扩展关键字</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["extend"]); ?>" name="extend" id="extend" placeholder="多个用英文半角,分割">
                        </div>
                        <div class="col-sm-2">
                            <p class="help-block">多个用英文半角,分割</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label">回复类型</label>
                        <div class="col-sm-8">
                            <div class="checkbox-inline"><label><input type="radio" value="1" name="type" <?php if($data['type'] == 1): ?>checked<?php endif; ?> >自定义文字</label></div>
                            <div class="checkbox-inline"><label><input type="radio" value="2" name="type" <?php if($data['type'] == 2): ?>checked<?php endif; ?>>自定义图文</label></div>
                      </div>
                    </div>


                    <div class="form-group type1" >
                        <label for="sort" class="col-sm-2 control-label label-input-sm">回复内容</label>
                        <div class="col-sm-8">
                            <textarea name="content" cols="50" rows="4" class="form-control1" style="height: 80px;" data-bv-field="value"><?php echo ($data["content"]); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group type2" style="display: none">
                        <label for="title" class="col-sm-2 control-label">标题</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["title"]); ?>" name="title" id="title" placeholder="">
                        </div>
                    </div>
                    <div class="form-group type2" style="display: none">
                        <label for="description" class="col-sm-2 control-label">描述</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["description"]); ?>" name="description" id="description" placeholder="">
                        </div>
                    </div>
                    <div class="form-group type2" style="display: none">
                        <label for="picurl" class="col-sm-2 control-label">图片</label>
                        <div class="col-sm-8">
                            <input type="file" multiple id="picurl" value="<?php echo ($data["picurl"]); ?>"/>
                            <input type="hidden" name="picurl" id="imgurl" value="<?php echo ($data["picurl"]); ?>"/>
                            <img src="/Uploads/<?php echo ($data["picurl"]); ?>" id="oldImg"/>
                        </div>
                    </div>
                    <div class="form-group type2" style="display: none">
                        <label for="url" class="col-sm-2 control-label">链接地址</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" value="<?php echo ($data["url"]); ?>" name="url" id="url" placeholder="">
                        </div>
                    </div>


                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" id="validateBtn" class="btn btn-success">提交</button>
                                <button type="reset" class="btn btn-inverse">返回</button>
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
                            message: 'This value is not valid',
                            feedbackIcons: {
                                valid: 'glyphicon glyphicon-ok',
                                invalid: 'glyphicon glyphicon-remove',
                                validating: 'glyphicon glyphicon-refresh'
                            },
                            fields: {
                                name: {
                                    message: '菜单名称不能为空',
                                    validators: {
                                        notEmpty: {
                                            message: '菜单名称不能为空'
                                        }
                                    }
                                },
                                sort:{
                                    message: '排序只能是数字类型',
                                    validators: {
                                        notEmpty: {
                                            message: '排序不能为空'
                                        },
                                        stringLength: {
                                            min: 1,
                                            max: 10000,
                                            message: '排序只能是1到10000之间'
                                        },
                                        regexp: {
                                            regexp: /^\+?[1-9][0-9]*$/,
                                            message: '数字只能是正整数'
                                        }
                                    }
                                }
                            }
                        })

                $('#validateBtn').click(function() {
                    var $form = $('#defaultForm');
                    $('#defaultForm').bootstrapValidator('validate');
                    var bootstrapValidator = $("#defaultForm").data('bootstrapValidator');
                    bootstrapValidator.validate();
                    if(bootstrapValidator.isValid())
                        $.post($form.attr('action'), $form.serialize(), function(result) {
                            $('#defaultForm').bootstrapValidator('disableSubmitButtons', false);
                            layer.msg(result.info);
                            if(result.status>0){
                                setTimeout(function(){
                                    location.href="<?php echo U('Wchat/keywords_reply');?>";
                                },1500);
                            }
                        }, 'json');
                    else
                        return;
                });
                var ImgList;
                $('#picurl').ssi_uploader({
                    url: "<?php echo U('Common/upload');?>",
                    locale:'zh',
                    allowed: ['jpg','png'],
                    //最大文件数
                    maxNumberOfFiles: 2, //微信图文
                    onUpload: function () {
                        layer.msg('图片上传成功');
                        $('#oldImg').remove();
                        $('#imgurl').val(ImgList);
                        $('#defaultForm').bootstrapValidator('disableSubmitButtons', false);
                    },
                    onEachUpload: function (fileInfo) {
                        ImgList = fileInfo.returnMsg.info.picurl;
                    },
                });

                $('input[type=radio]').click(function () {
                    var value = $(this).val();
                    if(value==2)
                    {
                        $('.type2').show();
                        $('.type1').hide();
                    }else{
                        $('.type2').hide();
                        $('.type1').show();
                    }
                })
                var type =  $('input[type=radio]:checked').val();
                if(type==2)
                {
                    $('.type2').show();
                    $('.type1').hide();
                }else{
                    $('.type2').hide();
                    $('.type1').show();
                }
            });

</script>
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/admin/js/bootstrap.min.js"></script>
</body>
</html>