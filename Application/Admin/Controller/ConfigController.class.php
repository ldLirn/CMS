<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigController extends CommonController {
    protected $config;   //config表
    protected $config_type;  //网站配置分组
    protected $data_type;    //数据类型数组
    protected function _initialize()
    {
        parent::_initialize();
        $this->config = D('Config');
        $this->config_type = C('WEB_CONFIG_TYPE');  //网站配置类型
        $this->data_type = C('WEB_CONFIG_DATA_TYPE');  //网站配置数据类型
    }
    /**
     * 网站设置（视图）
     */
    public function index()
    {
        $data = $this->config->group_config();
        $this->title = '网站设置';
        $this->assign('data',$data);
        $this->display();
     }

    /**
     * 网站设置（操作 AJAX）
     */
    public function setConfig()
    {
        if(IS_POST)
        {
            $data = I('post.');
            foreach ($data as $name => $value) {
                $map = array('name' => $name);
                $this->config->where($map)->setField('value', $value);
            }
            S('DB_CONFIG_DATA',null);
            action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
            $this->ajaxReturn(array('status'=>200,'info'=>'网站设置保存成功'));
        }
        $this->ajaxReturn(array('status'=>-1,'info'=>'非法操作'));
    }
    /**
     * 网站配置管理
     */
    public function config()
    {
        $p = isset($_GET['p']) ? $_GET['p'] : 1;
        $data = page('config','','',$p,C('ADMIN_PAGE'));
       // $data = $this->config->field('id,name,title,type,data_type')->select();
        $config_type = $this->config_type;
        $data_type   = $this->data_type;
        foreach ($data['list'] as $k=>$v)
        {
            $data['list'][$k]['type_name'] = $config_type[$v['type']];
            $data['list'][$k]['data_type_name'] = $data_type[$v['data_type']];
        }
        $this->title = '网站配置';
        $this->assign('data',$data);
        $this->display();
    }
    
    /**
     * 添加网站配置
     */
    public function add()
    {
        if(IS_AJAX)
        {
            $data = I('post.');
            if($this->config->create($data))
            {
                if($this->config->add())
                {
                    S('DB_CONFIG_DATA',null);
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['title']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'网站配置添加成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'网站配置添加失败，请稍后重试'));
                }
            }
            else
            {
                $this->ajaxReturn($this->config->getError());
            }
        }

        $this->title = '添加网站配置';
        $this->assign('config_type',$this->config_type); //网站配置类型
        $this->assign('data_type',$this->data_type);     //网站配置数据类型
        $this->display();
    }

    /**
     * 修改网站配置
     */
    public function edit()
    {
        if(IS_AJAX)
        {
            $data = I('post.');
            if($this->config->create($data))
            {
                $result = hasMoreOne('name',$data['name'],$data['id'],'config');  //判断是否有除当前外的name相同的
                if($result!==true)
                {
                    $this->ajaxReturn($result);
                }
                if($this->config->save())
                {
                    S('DB_CONFIG_DATA',null);
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['title']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'网站配置修改成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'网站配置修改失败，请稍后重试'));
                }
            }
            else
            {
                $this->ajaxReturn($this->config->getError());
            }
        }
        $id = I('get.id','','intval');
        if(!is_numeric($id))
        {
            $this->ajaxReturn(array('status'=>-1,'info'=>'不存在的id'));
        }
        $this->title = '修改网站配置';
        $this->assign('config_type',$this->config_type); //网站配置类型
        $this->assign('data_type',$this->data_type);     //网站配置数据类型
        $this->assign('this_data',$this->config->find($id));
        $this->display();
    }

    /**
     * 删除网站配置
     */
    public function delete()
    {
        if(IS_AJAX)
        {
            $id = I('post.id',0,'intval');
            if($id==0)
            {
                $this->ajaxReturn(array('status'=>-6,'info'=>'不存在的id'));
            }

            if($this->config->where("id=$id")->delete())
            {
                S('DB_CONFIG_DATA',null);
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME,"id=$id");
                $this->ajaxReturn(array('status'=>200,'info'=>'网站配置删除成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-4,'info'=>'网站配置删除失败'));
            }
        }
        $this->error(array('status'=>-2,'info'=>'非法操作'));
    }
    
    /**
     * 批量删除
     */
    public function delete_more()
    {
        
    }
}