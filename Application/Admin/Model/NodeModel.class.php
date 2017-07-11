<?php

/**
 * Created by PhpStorm.
 * User: YG
 * Date: 2017/3/2
 * Time: 16:17
 */
namespace Admin\Model;
use Think\Model;
class NodeModel extends Model{
    protected $tableName = 'auth_rule' ;   //指定表名
    const  TYPE = 1; //类型
    /* 自动验证 */
    protected $_validate = array(
        /* 验证权限名称 */
        array('title', '', array('status'=>-9,'info'=>'权限名称已经存在'), self::MODEL_INSERT, 'unique'),
        /* 验证权限唯一标识 */
        array('name', '', array('status'=>-9,'info'=>'权限唯一标识已经存在'), self::MODEL_INSERT, 'unique'),
        /*验证pid*/
        array('pid','/^[0-9]\d*$/',array('status'=>-12,'info'=>'请选择栏目'),self::MUST_VALIDATE,'regex'),
        /*验证id*/
        array('id','/^[1-9]\d*$/',array('status'=>-12,'info'=>'不存在的id'),self::MODEL_UPDATE,'regex'),
    );

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('type', self::TYPE, self::MODEL_BOTH),
    );


}