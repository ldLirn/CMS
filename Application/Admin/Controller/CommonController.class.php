<?php
namespace Admin\Controller;
use Org\Net\IpLocation;
use Think\Controller;
use Think\Log;

class CommonController extends Controller {
    protected $nav_id;  //当前菜单id
    protected $breadcrumb; //面包屑
    protected function _initialize()
    {
        self::isLogin();
        self::put_config();
        $this->nav_id = I('get.nav_id',0,'intval');
        $this->breadcrumb = $this->breadcrumb($this->nav_id);  //取得当前的面包屑html代码
        $this->assign('breadcrumb',$this->breadcrumb);
        $ruleName = CONTROLLER_NAME . '/' . ACTION_NAME; //规则唯一标识，获取权限验证的唯一标识
        if(!action_AuthCheck($ruleName,session('UID')))       //验证权限
        {
            $this->error('您没有权限进行此操作');
        }
    }

    /**
     * 读取数据库中的配置  到C方法中
     */
    public function put_config()
    {
        /* 读取数据库中的配置 */
        $config	=	S('DB_CONFIG_DATA');
        if(!$config){
            $config	= D('Config')->lists();
            S('DB_CONFIG_DATA',$config);
        }
        C($config); //添加配置
    }
    /**
     * 判断是否登陆
     * 没登陆重定向到登陆页面
     * 登陆则返回当前用户id
     */
    public function isLogin()
    {
        if(!session('?UID')){
            $this->redirect('Login/login');
        }
    }

    /**
     * 面包屑导航
     * $nav_id  当前菜单的id
     */
    public function breadcrumb($nav_id)
    {
        $breadcrumb = '';
        $breadcrumb .= '<ol class="breadcrumb">';
        $breadcrumb .= ' <li><a href="'.U('Index/index').'">首页</a></li>';
        $menu = M('Menu');
        $uplevels = $menu->field("id,navname,pid")->where("id=$nav_id")->find(); //查询当前菜单数组
        if($uplevels['pid'] != 0)     //如果不是顶级菜单，则递归查询
        {
            $breadcrumb .= $this->get_up_levels($uplevels['pid'],$uplevels);
        }
        else                          //顶级菜单，返回数据
        {
            $breadcrumb .= '<li><a href="'.U("$uplevels[href]").'">'.$uplevels['navname'].'</a></li>';  
        }
        $breadcrumb .= '</ol>';
        return $breadcrumb;

    }

    /**
     * @param $id           pid
     * @param $child_data   下级的数据
     * @return string
     */
    protected function get_up_levels($id,$child_data)
    {
        $menu = M('Menu');
        $here = '';
        $uplevels = $menu->field("id,navname,pid")->where("id=$id")->find();
        $here .= '<li><a href="'.U("$uplevels[href]").'">'.$uplevels['navname'].'</a></li>';
        $here .= '<li class="active">'.$child_data['navname'].'</li>';
        if($uplevels['pid'] != 0)
        {
            $here = $this->get_up_levels($uplevels['pid']).$here;
        }
        return $here;
    }


    /**
    * @param $saveWhere ：想要更新主键ID数组
    * @param $saveData  ：想要更新的ID数组所对应的数据
    * @param $tableName : 想要更新的表名
    * */
    public function sortAll($saveWhere,&$saveData,$tableName)
    {
        if($saveWhere==null||$tableName==null)
            return false;
        //获取更新的主键id名称
		$key_arr = array_keys($saveWhere);
        $key = $key_arr[0];
        //获取更新的排序字段名称
		$field_arr = array_keys($saveData);
        $field = $field_arr[0];
        //获取更新列表的长度
        $len = count($saveWhere[$key]);
        $flag=true;
        $model = isset($model)?$model:M($tableName);
        //开启事务处理机制
        $model->startTrans();
        //记录更新失败ID
        $error=array();
        for($i=0;$i<$len;$i++)
        {
        //预处理sql语句
            $isRight=$model->where($key.'='.$saveWhere[$key][$i])->save(array($field=>$saveData[$field][$i]));
            if($isRight==0)
            {
        //将更新失败的记录下来
                $error[]=$i;
                $flag=false;
            }
        //$flag=$flag&&$isRight;
        }
        if($flag )
        {
            //如果都成立就提交
            $model->commit();
            return true;
        }
        elseif(count($error)>0&count($error)<$len)
        {
            //先将原先的预处理进行回滚
            $model->rollback();
            for($i=0;$i<count($error);$i++)
            {
                //删除更新失败的ID和Data
                unset($saveWhere[$key][$error[$i]]);
                unset($saveData[$field][$error[$i]]);
            }
            //重新将数组下标进行排序
            $saveWhere[$key]=array_merge($saveWhere[$key]);
            $saveData[$field]=array_merge($saveData[$field]);
            //进行第二次递归更新
            $this->sortAll($saveWhere,$saveData,$tableName);
            return $saveWhere;
        }
        else
        {
            //如果都更新就回滚
            $model->rollback();
            return false;
        }
    }

    /**
     * 文件上传
     */
    public function upload()
    {
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->allowExts = array(
            'jpg','png'
        );// 设置附件上传类型
        $upload->replace = false; //存在同名文件是否是覆盖
        $upload->autoSub = true; // 是否使用子目录保存上传文件
        $upload->saveName = array('date','Ymd-His');
        $info = $upload->upload();
        if(!$info)    // 上传错误提示错误信息
        {
            $this->error($upload->getError());
        }
        else
        {
            // 保存表单数据 包括附件数据
            $up = M("upload"); // 实例化upload对象
            foreach ($info as $v)
            {
                //上传数据库
                $arr['picurl']	= $v['savepath'].$v['savename'];//保存图片路径
                $arr['create_time'] = NOW_TIME;//创建时间
                if(!$up->create($arr)){ // 创建数据对象
                    $this->error($up->getError());
                    exit();
                }
                if($up->add() === false){ // 写入用户数据到数据库
                    $this->error('数据保存失败');
                    exit();
                }
            }
            $this->success(array('status'=>1,'info'=>'图片上传成功','picurl'=>$arr['picurl']));
        }
    }
}