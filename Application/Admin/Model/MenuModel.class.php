<?php
/**
 * Created by PhpStorm.
 * User: YG
 * Date: 2017/3/2
 * Time: 17:29
 * 后台菜单
 */

namespace Admin\Model;

use Think\Model;
class MenuModel extends Model
{
    /* 用户模型自动验证 */
    protected $_validate = array(
        /* 验证菜单名 */
        array('navname', 'require', array('status'=>-1,'info'=>'菜单名必须填写'), self::EXISTS_VALIDATE), //菜单名必须填写
        array('navname', '', array('status'=>-2,'info'=>'菜单名已经存在'), self::MODEL_INSERT, 'unique'), //菜单名被占用

        /* 验证排序 */
        array('sort', 'require', array('status'=>-3,'info'=>'排序只能正整数'), self::EXISTS_VALIDATE, 'number'),  //排序只能正整数

    );
    /**
     * @return mixed
     * 菜单数据
     */
    public function MenuList($map=array())
    {
        $uid = session('UID');
       // dd($menu);
        if(session('UID')==1){  //administration  获取所有菜单数据
            $menu_data = $this->where($map)->order('sort asc')->select();
        }else{  //读取用户组的权限
            $group_id = M('auth_group_access')->where("uid=$uid")->find();
           // $result = M()->table(array('auth_group'=>'g','auth_rule'=>'r'))->field('g.rules')->select();
            $rules = M('auth_group')->field('rules')->find($group_id['group_id']);  //得到节点id
            $where['id'] = array('in',$rules['rules']);
            $menu_url = array_merge(M('auth_rule')->where($where)->getField('id,name')); //得到节点url
            for ($i=0;$i<count($menu_url);$i++){
                $menu_data[] = $this->where($map)->where("href='$menu_url[$i]'")->find();
            }
            $menu_data = array_filter($menu_data);  //去除数组中的空元素
            foreach ($menu_data as $v){
                if($v['pid']!=0){
                    $menu_data[] = $this->where($map)->where("id=$v[pid]")->find();  //把顶级菜单查询出来放入数组
                }
            }
        }
       return tree($menu_data);
    }


}