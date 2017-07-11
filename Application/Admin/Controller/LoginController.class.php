<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

    public function _empty()
    {
        $this->redirect('Login/login');
    }
    /**
     * 登陆
     */
    public function Login()
    {
        if(IS_POST)
        {
            $username = I('post.username','','htmlspecialchars');
            $password  = I('post.password','','htmlspecialchars');
            $verify   = I('post.verifyCode','','htmlspecialchars');
           if(check_verify($verify,1))
           {
               $status = D('Member')->login($username,$password);
               switch ($status)
               {
                   case -1:
                       $this->error('用户不存在',U('Login/login'),3);
                       break;
                   case -2;
                       $this->error('密码错误',U('Login/login'),3);
                       break;
                   case -3:
                       $this->error('用户被禁止访问',U('Login/login'),3);
                       break;
                   case -4:
                       $this->error('用户所在组被禁止访问',U('Login/login'),3);
                       break;
                   case 1:
                       action_log('login');
                       $this->success('登录成功',U('Index/index'),2);
                       break;
                   default:
                       $this->error('未知错误',U('Login/login'),3);
               }
           }else
           {
               $this->error('验证码错误',U('Login/login'),3);
               exit;
           }
        }else
        {
            put_config();  //读取配置
            $this->assign('page_title','登陆');
            $this->display();
        }
     }

    /**
     * 退出
     */
    public function loginOut()
    {
        session('username',null);
        session('UID',null);
        $this->redirect('Login/login');
    }

    /**
     * 生成验证码
     */
    public function verify()
    {
        CreateVerify(18,4,120,49,600,array(34,34,36));
    }
    
    /**
     * 忘记密码  ，发送邮件
     */
    public function forget()
    {
        if(IS_AJAX)
        {
            $email  = I('post.email','','');
            if(!preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i',$email)){
                $this->ajaxReturn(reAjax(-1,'邮箱地址格式错误'));
            }
            $verify   = I('post.verifyCode','','htmlspecialchars');
            if(!check_verify($verify,1)){
                $this->ajaxReturn(reAjax(-2,'验证码错误'));
            }
            if(CkEmailHas('admin',$email)){   //发送邮件
                $map['email'] = $email;
                if(M('password_reset')->where($map)->find()){
                    $this->ajaxReturn(reAjax(-6,'邮件已经发送，请去邮箱查看'));
                }
                $data['send_time'] = NOW_TIME;
                $data['code'] = sha1(NOW_TIME.$email.mt_rand(57,159));
                $data['email'] = $email;
                $reset_url = 'http://'.$_SERVER['SERVER_NAME'].'/'.__ROOT__.'/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/reset/code/'.$data['code'];
                $mail_title = '找回登陆密码';
                $mail_content = '<p>请点击以下链接完成密码找回（24小时有效）</p><p>'.$reset_url.'</p>';
                $result = think_send_mail($email,$email,$mail_title,$mail_content);
                if($result){
                    if(M('password_reset')->add($data)){
                        $this->ajaxReturn(reAjax(200,'找回密码邮件发生成功，请打开邮件完成操作'));
                    }else{
                        $this->ajaxReturn(reAjax(-5,'系统发生错误，请重新发送找回密码邮件'));
                    }
                }else{
                    $this->ajaxReturn(reAjax(-7,'邮件发送失败了，请重试'));
                }
            }else{
                $this->ajaxReturn(reAjax(-3,'邮箱地址不存在'));
            }
        }
        put_config();  //读取配置
        $this->page_title = '找回密码';
        $this->display();
    }

    /**
     * 重置密码
     */
    public function reset()
    {
        $code = I('post.code','','htmlspecialchars');
        if($code==''){
            $this->error('非法操作');
        }
        $map['code'] = $code;
        $result = M('password_reset')->where($map)->find();
        if($result){  //判断code是否存在
            $expire_time = strtotime('+1 day',$result['send_time']); //过期时间
            if($expire_time<NOW_TIME){  //过期时间大于当前时间，删除当前数据
                M('password_reset')->where($map)->delete();
                $this->error('邮件已经过期，请重新获取');
            }
            //验证通过 渲染模板
            put_config();  //读取配置
            $this->page_title = '重置密码';
            $this->assign('mail',$result['email']);
            $this->display();
        }else{
            $this->error('非法操作');
        }
    }

    /**
     * 重置密码 操作
     */
    public function reset_act()
    {
        if(IS_AJAX)
        {
            $code = I('post.code','','htmlspecialchars');
            $mail = I('post.email','','htmlspecialchars');
            $map['code'] = $code;
            $map['email'] = $mail;
            $mail = M('password_reset')->where($map)->find();
            if($mail===false)
            {
                $this->ajaxReturn(reAjax(-5,'参数错误'));
            }
            $data['password'] = I('post.password','','htmlspecialchars');
            $re_password = I('post.password','','htmlspecialchars');
            if($data['password']!=$re_password)
            {
                $this->ajaxReturn(reAjax(-2,'两次输入的密码不一致'));
            }
            if(5>=strlen($re_password) || strlen($re_password)>30)
            {
                $this->ajaxReturn(reAjax(-3,'输入的密码必须是6到30位'));
            }
            $tmp['password'] = D('Member')->think_md5($data['password']);
            $where['email'] = $mail['email'];
            if(D('Member')->where($where)->save($tmp))
            {
                M('password_reset')->where($map)->delete();
                $this->ajaxReturn(reAjax(200,'重置密码成功'));
            }
            else
            {
                $this->ajaxReturn(reAjax(-4,'重置密码失败，请重试'));
            }
        }
        $this->ajaxReturn(reAjax(-1,'非法操作'));
    }

    public function test(){
        print_r('<script>alert("213")</script>');
        die;
        $this->assign('','');
        $this->display();
    }
}