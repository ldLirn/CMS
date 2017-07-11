<?php
/**
 * 菜单管理
 */
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController {
    protected $model;  //模型
    protected $nav_id;  //当前菜单id
    protected $breadcrumb; //面包屑
    public function _initialize()
    {
        parent::_initialize();
        $this->model = D('Menu');
        $this->nav_id = I('get.nav_id',0,'intval');
        $this->breadcrumb = $this->breadcrumb($this->nav_id);  //取得当前的面包屑html代码
        $this->assign('breadcrumb',$this->breadcrumb);
        $MenuListData = D('Menu')->MenuList();  //得到菜单数组
        $this->assign('menuListData',$MenuListData);
    }

    /**
     * 后台菜单列表
     */
    public function lists()
    {
        $this->display('Menu/list');
    }

    /**
     * 添加后台菜单
     */
    public function create()
    {
        if(IS_AJAX)
        {
            $data = I('POST.');
            if($this->model->create($data))
            {
                if($this->model->add())
                {
                    F('MenuListData',null);  //清楚缓存
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['navname']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'菜单添加成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-4,'info'=>'菜单添加失败'));
                }
            }
            else
            {
                $this->ajaxReturn($this->model->getError());
            }
        }
        
        $this->display();
    }
    
    /**
     * 修改后台菜单
     */
    public function edit()
    {
        if(IS_AJAX)
        {
            $data = I('post.');
            if($this->model->create($data))
            {
                if($this->model->save())
                {
                    F('MenuListData',null);  //清楚缓存
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['navname']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'菜单修改成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-4,'info'=>'菜单修改失败'));
                }
            }
            else
            {
                $this->ajaxReturn($this->model->getError());
            }
        }
        $id = I('get.id','','intval');
        if(!is_numeric($id))
        {
            $this->error(array('status'=>-2,'info'=>'非法操作'));
        }
        $data = $this->model->find($id);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 删除菜单
     */
    public function delete()
    {
        if(IS_AJAX)
        {
            //TODO: 后台菜单暂时不支持删除
        }

        $this->ajaxReturn('非法操作');
    }

    /**
     * 改变状态
     */
    public function status()
    {
        if(IS_AJAX)
        {
            $hide = I('post.hide',0,'intval');
            $id = I('post.id','','intval');
            if(is_numeric($id))
            {
                $update = $hide == 0 ? 1 : 0 ;
                if($this->model->where("id=$id")->save(['hide'=>$update])===false)
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'系统错误，请稍后重试'));
                }
                else
                {
                    F('MenuListData',null);  //清楚缓存
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
     * 更新排序
     */
    public function sort()
    {
        if(IS_AJAX)
        {
            $arr_id['id'] = I('post.id');
            $arr_sort['sort'] = I('post.sort');
            $result = $this->sortAll($arr_id,$arr_sort,'menu');
            if($result)
            {
                F('MenuListData',null);  //清楚缓存
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
                $this->ajaxReturn(array('status'=>200,'info'=>'排序更新成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-1,'info'=>'系统错误，请稍后重试'));
            }
            //$new_arr = array_combine($arr_id,$arr_sort);    //合并id数组和对应的排序数组，组成id对应sort的形式
        }
        $this->ajaxReturn(array('status'=>-3,'info'=>'非法操作'));
    }

}