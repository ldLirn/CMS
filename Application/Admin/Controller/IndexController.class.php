<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    /**
     * 后台首页
     */
    public function index()
    {
        // $Ip = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件 取出数据库的ip字段；
        //$area = $Ip->getlocation(get_client_ip(0)); // 获取某个IP地址所在的位置
        $this->title = '后台首页';
        $this->display('Index/index');
     }

    /**
     * 个人设置
     */
    public function config()
    {
        if(IS_AJAX)
        {
            $tmp = I('post.');
            if(trim($tmp['password'])=='')   //如果密码字段为空，则删除字段（不修改密码）
            {
                unset($tmp['password']);
                unset($tmp['re_password']);
            }

            if(D('Member')->create($tmp))   //验证数据
            {
                if(isset($tmp['password']))   //判断是否有密码字段，有则对密码加密（修改密码）
                {
                    $tmp['password'] = D('Member')->think_md5($tmp['password']);
                }

                if(D('Member')->save($tmp))
                {
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
                    $this->ajaxReturn(array('status'=>200,'info'=>'修改成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'修改失败，请稍后重试'));
                }

            }
            else
            {
                $this->ajaxReturn(D('Member')->getError());  //返回验证错误信息
            }
        }
        $this->title = '个人设置';
        $data = D('Member')->field('id,nickname,username,password,email,phone')->find(session('UID'));
        $this->assign('data',$data);
        $this->display();
    }
    
    /**
     * 清楚runtime 缓存
     */
    public function clear()
    {
        $R = $_GET['path'] ? $_GET['path'] : RUNTIME_PATH;
        if ($this->_deleteDir($R)) {
            $this->success('缓存清理完成','',3);
        }
    }

    public function _deleteDir($R)
    {
        $handle = opendir($R);
        while(($item = readdir($handle)) !== false){
            if($item != '.' and $item != '..'){
                if(is_dir($R.'/'.$item)){
                    $this->_deleteDir($R.'/'.$item);
                }else{
                    if(!unlink($R.'/'.$item))
                        die('error!');
                }
            }
        }
        closedir( $handle );
        return rmdir($R);
    }

}