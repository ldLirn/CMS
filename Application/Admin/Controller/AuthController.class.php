<?php
/**
 * Created by PhpStorm.
 * User: Lirn
 * Date: 2017/3/6
 * Time: 13:38
 * 分组，管理员管理
 */

namespace Admin\Controller;

use Think\Controller;
class AuthController extends CommonController
{
    protected $group;  //分组表
    protected $admin;   //管理员表
    protected $node;    //权限节点
    public function _initialize()
    {
        parent::_initialize();
        $this->group = M('auth_group');
        $this->admin = D('Member');
        $this->node = D('Node');
    }


    /**
     * 分组管理列表
     */
    public function group()
    {
        $group_list = $this->group->select();
        $this->title = '分组管理';
        $this->assign('group_list',$group_list);
        $this->display();
    }

    /**
     * 分组状态
     */
    public function group_status()
    {
        if(IS_AJAX)
        {
            $status = I('post.status',0,'intval');
            $id = I('post.id','','intval');
            if(is_numeric($id))
            {
                $update = $status == 0 ? 1 : 0 ;
                if($this->group->where("id=$id")->save(['status'=>$update])===false)
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'系统错误，请稍后重试'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>200,'info'=>'状态更新成功'));
                }
            }
            else
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'不存在的id'));
            }
        }
        $this->ajaxReturn(array('status'=>-3,'info'=>'非法操作'));
    }

    /**
     * 分组修改
     */
    public function group_edit()
    {
        if(IS_POST)
        {
            $data['id'] = I('post.id',0,'intval');
            $data['title'] = I('post.title','','htmlspecialchars');
            $data['display_name'] = I('post.display_name','','htmlspecialchars');
            if($data['id']==0)
            {
                $this->ajaxReturn(array('status'=>-6,'info'=>'不存在的id'));
            }
            if(trim($data['title'])=='')
            {
                $this->ajaxReturn(array('status'=>-5,'info'=>'分组名称不能为空'));
            }

            if($this->group->save($data))
            {
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['title']);
                $this->ajaxReturn(array('status'=>200,'info'=>'分组修改成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-4,'info'=>'分组修改失败'));
            }
        }
        $id = I('get.id','','intval');
        if(!is_numeric($id))
        {
            $this->error(array('status'=>-2,'info'=>'非法操作'));
        }
        $data = $this->group->field('id,title,display_name')->find($id);
        $this->ajaxReturn($data);
    }


    /**
     * 分组添加
     */
    public function group_add()
    {
        if(IS_AJAX)
        {
            $data['title'] = I('post.title','','htmlspecialchars');
            $data['display_name'] = I('post.display_name','','htmlspecialchars');
            if(trim($data['title'])=='')
            {
                $this->ajaxReturn(array('status'=>-5,'info'=>'分组名称不能为空'));
            }
            if($this->group->add($data))
            {
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['title']);
                $this->ajaxReturn(array('status'=>200,'info'=>'分组添加成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-4,'info'=>'分组添加失败'));
            }
        }
        $this->error(array('status'=>-2,'info'=>'非法操作'));
    }

    /**
     * 分组删除
     */
    public function group_delete()
    {
        if(IS_AJAX)
        {
            $id = I('post.id',0,'intval');
            if($id==0)
            {
                $this->ajaxReturn(array('status'=>-6,'info'=>'不存在的id'));
            }
            if(M('auth_group_access')->where("group_id=$id")->find())   //如果存在有当前分组的管理员，则不能删除
            {
                $this->ajaxReturn(array('status'=>-7,'info'=>'此分组下有管理员，请先解除后再删除'));
            }
            if($this->group->where("id=$id")->delete())
            {
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME,"id=$id");
                $this->ajaxReturn(array('status'=>200,'info'=>'分组删除成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-4,'info'=>'分组删除失败'));
            }

        }
        $this->error(array('status'=>-2,'info'=>'非法操作'));
    }

    /**
     * 管理员列表
     */
    public function manager()
    {
        $list = $this->admin->lists();
        $this->title = '管理员管理';
        $this->assign('list',$list);
        $this->display();
    }
    
    /**
     * 改变管理员状态
     */
    public function manager_status()
    {
        if(IS_AJAX)
        {
            $status = I('post.status',0,'intval');
            $id = I('post.id','','intval');
            if(is_numeric($id))
            {
                if($id==1)    //administration   不允许禁用
                {
                    $this->ajaxReturn(array('status'=>-4,'info'=>'不允许禁用此管理'));
                }
                $update = $status == 0 ? 0 : 1 ;
                if($this->admin->where("id=$id")->save(['status'=>$update])===false)
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'系统错误，请稍后重试'));
                }
                else
                {
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
                    $this->ajaxReturn(array('status'=>200,'info'=>'状态更新成功'));
                }
            }
            else
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'不存在的id'));
            }
        }
        $this->ajaxReturn(array('status'=>-3,'info'=>'非法操作'));
    }
    
    /**
     * 添加管理员
     */
    public function manager_add()
    {
        if(IS_AJAX)
        {
            $data = I('post.');
            if($this->admin->create($data))
            {
                $data['password'] = $this->admin->think_md5($data['password']);  //对密码加密
                $this->admin->startTrans();  //开启事务
                if($uid = $this->admin->add($data))
                {
                    /*添加分组关系*/
                    $result = M('auth_group_access')->add(array('uid'=>$uid,'group_id'=>$data['group_id']));
                    if($result)
                    {
                        $this->admin->commit();     //如果都成功，提交
                        action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['username']);
                        $this->ajaxReturn(array('status'=>200,'info'=>'添加管理员成功'));
                    }
                    else
                    {
                        $this->admin->rollback();  //回滚
                        $this->ajaxReturn(array('status'=>-1,'info'=>'添加管理员失败，请稍后重试'));
                    }

                }
                else
                {
                    $this->admin->rollback();  //回滚
                    $this->ajaxReturn(array('status'=>-1,'info'=>'添加管理员失败，请稍后重试'));
                }
            }
            else
            {
                $this->ajaxReturn($this->admin->getError());
            }
        }
        $this->title = '添加管理员';
        $group_list = $this->group->select();   //得到分组信息
        $this->assign('group_list',$group_list);
        $this->display();
    }
    
    /**
     * 修改管理员
     */
    public function manager_edit()
    {
        $id = I('get.id','','intval');
        if(!is_numeric($id))
        {
            $this->error('非法操作');
        }
        if($id==1)  //administration不允许在此修改
        {
            $this->error('不允许修改此管理员');
        }
        $group_list = $this->group->select();  //得到分组信息
        $data = $this->admin->getInfo($id);     //得到具体某一条管理员信息
        /*修改操作*/
        if(IS_AJAX)
        {
            $tmp = I('post.');
            if(trim($tmp['password'])=='')   //如果密码字段为空，则删除字段（不修改密码）
            {
                unset($tmp['password']);
                unset($tmp['re_password']);
            }

            if($this->admin->create($tmp))   //验证数据
            {
                if(isset($tmp['password']))   //判断是否有密码字段，有则对密码加密（修改密码）
                {
                    $tmp['password'] = $this->admin->think_md5($tmp['password']);
                }
                $tmp['foredit'] = $data['foredit'] + 1;    //为了在只修改分组的情况下，修改成功，admin表必须修改一个字段
                $this->admin->startTrans();  //开启事务
                if($this->admin->save($tmp))
                {
                    if($data['group_id']!=$tmp['group_id'])   //如果以前的group_id 不等于 现在的 则修改 分组关系
                    {
                        /*修改分组关系*/
                        $result = M('auth_group_access')->where("uid=$id")->save(array('group_id'=>$tmp['group_id']));
                    }
                    else
                    {
                        $result = true;   //相等 返回true 继续下面的操作
                    }

                    if($result)
                    {
                        $this->admin->commit();     //如果都成功，提交
                        action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$tmp['username']);
                        $this->ajaxReturn(array('status'=>200,'info'=>'修改管理员成功'));
                    }
                    else
                    {
                        $this->admin->rollback();  //回滚
                        $this->ajaxReturn(array('status'=>-1,'info'=>'修改管理员失败，请稍后重试'));
                    }

                }
                else
                {
                    $this->admin->rollback();  //回滚
                    $this->ajaxReturn(array('status'=>-1,'info'=>'修改管理员失败，请稍后重试'));
                }
            }
            else
            {
                $this->ajaxReturn($this->admin->getError());  //返回验证错误信息
            }
        }
        $this->title = '修改管理员';
        $this->assign('group_list',$group_list);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 删除管理员
     */
    public function manager_delete()
    {
        if(IS_AJAX)
        {
            $id = I('post.id');
            if($id==0)
            {
                $this->ajaxReturn(array('status'=>-6,'info'=>'不存在的id'));
            }
            if($id==1)   //administration不允许删除
            {
                $this->ajaxReturn(array('status'=>-6,'info'=>'您没有权限删除此管理员'));  
            }
            $this->admin->startTrans();  //开启事务
            if($this->admin->where("id=$id")->delete())
            {
                /*删除分组关系*/
                if(M('auth_group_access')->where("uid=$id")->delete())
                {
                    $this->admin->commit();     //如果都成功，提交
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,"id=$id");
                    $this->ajaxReturn(array('status'=>200,'info'=>'管理员删除成功'));
                }
                else
                {
                    $this->admin->rollback();  //回滚
                    $this->ajaxReturn(array('status'=>-4,'info'=>'管理员删除失败'));
                }
            }
            else
            {
                $this->admin->rollback();  //回滚
                $this->ajaxReturn(array('status'=>-4,'info'=>'管理员删除失败'));
            }

        }
        $this->error(array('status'=>-2,'info'=>'非法操作'));
    }

    /**
     * 分组权限设置
     */
    public function power()
    {
        if(IS_POST)
        {
            $rules = I('post.');
            $group_id = I('post.group_id',0,'intval');
            if($group_id==0)     //判断是否有group_id
            {
                $this->ajaxReturn(array('status'=>-1,'info'=>'不存在的id'));
            }
            if(!isset($rules['rule']))    //如果没有选择权限，则这个数组不存在
            {
                $this->ajaxReturn(array('status'=>-1,'info'=>'请选择相关的权限'));
            }
            $rules_str = implode(',',$rules['rule']);  //得到权限id字符串
            if($this->group->where("id=$group_id")->save(array('rules'=>$rules_str)))
            {
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME,"id=$group_id");
                $this->ajaxReturn(array('status'=>200,'info'=>'权限设置成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'权限设置失败，请稍后重试'));
            }
        }
        $group_id = I('get.id',0,'intval');
        if($group_id==0)
        {
            $this->error('不存在的id');
        }
        $map         = array('status'=>1);
        $main_rules  = tree(M('auth_rule')->where($map)->select());  //取得所有权限规则,树形结构
        $this_rules  = explode(',',$this->group->where("id=$group_id")->getfield('rules'));  //得到当前分组的权限数组
        $this->title = '访问授权';
        $this->assign('rules',$main_rules);
        $this->assign('group_id',$group_id);
        $this->assign('this_rules',$this_rules);
        $this->display();
    }

    /**
     * 权限节点
     */
    public function node()
    {
        $main_rules  = tree(M('auth_rule')->field('id,name,title,status,pid')->select());  //取得所有权限规则,树形结构
        $this->title = '权限节点';
        $this->assign('rules',$main_rules);
        $this->display();
    }

    /**
     * 节点状态
     */
    public function node_status()
    {
        if(IS_AJAX)
        {
            $status = I('post.status',0,'intval');
            $id = I('post.id','','intval');
            if(is_numeric($id))
            {
                $update = $status == 0 ? 0 : 1 ;
                if($this->node->where("id=$id")->save(['status'=>$update])===false)
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'系统错误，请稍后重试'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>200,'info'=>'状态更新成功'));
                }
            }
            else
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'不存在的id'));
            }
        }
        $this->ajaxReturn(array('status'=>-3,'info'=>'非法操作'));
    }
    
    /**
     * 添加节点
     */
    public function node_add()
    {
        if(IS_AJAX)
        {
            $data['pid'] = I('post.pid','','intval');
            $data['name'] = I('post.name','','htmlspecialchars');
            $data['title'] = I('post.title','','htmlspecialchars');
            $data['status'] = I('post.status',1,'intval');

            if($data['pid']>0 && strpos($data['name'],'/')===false)  //不是顶级栏目时判断节点唯一标识  TODO:暂时这样判断
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'权限唯一标识格式错误'));
            }
            if($this->node->create($data))
            {
                if($this->node->add())
                {
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['title']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'权限节点添加成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-3,'info'=>'权限节点添加失败，请稍后重试'));
                }
            }
            else
            {
                $this->ajaxReturn($this->node->getError());
            }
        }
        $main_rules  = tree(M('auth_rule')->field('id,name,title,status,pid')->select());  //取得所有权限规则,树形结构
        $this->title = '添加权限节点';
        $this->assign('rules',$main_rules);
        $this->display();
    }
    
    /**
     * 修改节点
     */
    public function node_edit()
    {
        if(IS_AJAX)
        {
            $data['id'] = I('post.id','','intval');
            $data['pid'] = I('post.pid','','intval');
            $data['name'] = I('post.name','','htmlspecialchars');
            $data['title'] = I('post.title','','htmlspecialchars');
            $data['status'] = I('post.status',1,'intval');

            if($data['pid']>0 && strpos($data['name'],'/')===false)  //不是顶级栏目时判断节点唯一标识  TODO:暂时这样判断
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'权限唯一标识格式错误'));
            }
            $result = hasMoreOne('name',$data['name'],$data['id'],'auth_rule');
            if($result!==true)  //判断权限名或标识是否唯一
            {
                $this->ajaxReturn($result);
            }
            if($this->node->create($data))
            {
                if($this->node->save())
                {
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['title']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'权限节点修改成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-3,'info'=>'权限节点修改失败，请稍后重试'));
                }
            }

        }
        $id = I('get.id','','intval');
        if(!is_numeric($id))
        {
            $this->error('非法操作');
        }
        $this->title = '修改权限节点';
        $main_rules  = tree(M('auth_rule')->field('id,name,title,status,pid')->select());  //取得所有权限规则,树形结构
        $this_data   = M('auth_rule')->field('id,name,title,status,pid')->find($id);
        $this->assign('rules',$main_rules);
        $this->assign('data',$this_data);
        $this->display();
    }

    /**
     * 删除节点
     */
    public function node_delete()
    {
        if(IS_AJAX)
        {
            $id = I('post.id',0,'intval');
            if($id==0)
            {
                $this->ajaxReturn(array('status'=>-6,'info'=>'不存在的id'));
            }

            if($this->node->where("id=$id")->delete())
            {
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME,"id=$id");
                $this->ajaxReturn(array('status'=>200,'info'=>'权限节点删除成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-4,'info'=>'权限节点删除失败'));
            }
        }
        $this->error(array('status'=>-2,'info'=>'非法操作'));
    }
}