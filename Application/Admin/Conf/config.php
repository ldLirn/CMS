<?php
define('PAGE',10);   //  定义分页显示条数
return array(
    /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Picture/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ),

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'admin_', //session前缀
    'COOKIE_PREFIX'  => 'admin_', // Cookie前缀 避免冲突
    
    /* 后台错误页面模板 */
    'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/Msg/error.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Msg/success.html', // 默认成功跳转对应的模板文件
   // 'TMPL_EXCEPTION_FILE'   =>  MODULE_PATH.'View/Msg/exception.html',// 异常页面的模板文件
	
	/*表单令牌*/
	'TOKEN_ON'      =>    false,  // 是否开启令牌验证 默认关闭
	'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true

	/*模板布局*/
	'LAYOUT_ON'  	    => true,
	'LAYOUT_NAME'       => 'Public/layout',
	'TMPL_LAYOUT_ITEM'  =>  '{__CONTENT__}',

	//语言包配置项
	 'LANG_SWITCH_ON'     =>     'on',    //开启语言包功能
     'LANG_AUTO_DETECT'   =>     false, // 自动侦测语言
     'DEFAULT_LANG'       =>     'zh-cn', // 默认语言
     'LANG_LIST'          =>    'zh-cn', //必须写可允许的语言列表
     'VAR_LANGUAGE'       => 'l', // 默认语言切换变量


	/* 网站配置 类型*/
	'WEB_CONFIG_TYPE' => array(1 => '基本配置', 2 => '内容配置', 3 => '用户配置' , 4=>'系统配置'),
	//1.文本类型，2.单选类型，3.文本域类型，4.数组类型(请勿更改,重要!!!!!!)
	'WEB_CONFIG_DATA_TYPE' => array(1=>'文本类型',2=>'单选类型',3=>'文本域类型',4=>'数组类型'),
	

);