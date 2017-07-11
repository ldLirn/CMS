<?php
namespace Admin\Controller;
use Think\Controller;
class LogController extends CommonController {
    
    /**
     * 行为日志列表
     */
    public function index()
    {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $list = page('log','','id desc',$p,C('ADMIN_PAGE'));
        foreach ($list['list'] as $k=>$v){
            $list['list'][$k]['username'] = get_user_name('admin',$v['uid']);
        }
        $this->title = '日志列表';
        $this->assign('data',$list);
        $this->display();
    }
    
    /**
     * 清空日志
     */
    public function clear(){
        $res = M('log')->where('1=1')->delete();
        if($res !== false){
            action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
            $this->ajaxReturn(reAjax(200,'日志清空成功'));
        }else {
            $this->ajaxReturn(reAjax(-1,'日志清空失败，请稍后重试'));
        }
    }
    

}