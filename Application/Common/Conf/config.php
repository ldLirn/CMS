<?php
return array(
    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'admin', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'admin_', // 数据库表前缀
    
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__AIMG__'    => __ROOT__ . '/Public/admin/images/',
        '__ACSS__'    => __ROOT__ . '/Public/admin/css/',
        '__AJS__'     => __ROOT__ . '/Public/admin/js/',
        '__APLUGINS__'=> __ROOT__ . '/Public/admin/plugins/',
        '__IMG__'    => __ROOT__ . '/Public/home/images/',
        '__CSS__'    => __ROOT__ . '/Public/home/css/',
        '__JS__'     => __ROOT__ . '/Public/home/js/',
        '__CIMG__'    => __ROOT__ . '/Public/common/images/',
        '__CCSS__'    => __ROOT__ . '/Public/common/css/',
        '__CJS__'     => __ROOT__ . '/Public/common/js/',
    ),


    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 2, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    'SHOW_PAGE_TRACE' =>false, // 显示页面Trace信息

    'AUTOLOAD_NAMESPACE' => array(
        'Api'     => APP_PATH.'Api',
    ),

    //邮件配置
    'THINK_EMAIL' => array(
        'SMTP_HOST'   => 'smtp.163.com', //SMTP服务器
        'SMTP_PORT'   => '25', //SMTP服务器端口
        'SMTP_USER'   => '18628970131@163.com', //SMTP服务器用户名
        'SMTP_PASS'   => 'lirn01535476', //SMTP服务器密码
        'FROM_EMAIL'  => '18628970131@163.com', //发件人EMAIL
        'FROM_NAME'   => 'Lirn后台管理系统', //发件人名称
        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
        'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
    ),


    
);