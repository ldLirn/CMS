<?php
/**
 * Created by PhpStorm.
 * User: Lirn
 * Date: 2017/3/9
 * Time: 16:15
 */

/**
 * @param $name     唯一标识
 * 用于修改的时候判断 是否 name 有重复的
 */
function hasMoreOne($field,$name,$id,$model)
{
    if(!$name && !$id && !$model && !$field)
    {
        return false;
    }
    $map[$field] = $name;
    $new_model = M($model);
    //dd($new_model->fetchSql(true)->where("id != $id")->where($map)->field('id')->select());
    $name_count = count($new_model->where("id != $id")->where($map)->field('id')->select());
    if($name_count>0)  //大于0说明有重复的
    {
        return array('status'=>-9,'info'=>'重复的标识');
    }
    return true;
}

