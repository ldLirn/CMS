<?php
namespace Home\Controller;
use Think\Controller;
use Api\Wchat\Wechat;
include APP_PATH."Api/Wchat/wechat.class.php";
class LoginController extends Controller {
    protected $config;   //微信config表
    protected $options;
    protected $weObj;
    protected function _initialize()
    {
        $this->config = M('wchat_config');
        $this->options = self::getConfig();  //获取微信配置
        $this->weObj = new Wechat($this->options); //实例化微信类

    }
    //微信认证链接
    public function wxurl(){
        $token = session('token'); //查看是否已经授权
        if (!empty($token)) {
            print_r($token);
            $state = $this->weObj->getOauthAuth($token['access_token'],$token['openid']); //检验token是否可用(成功的信息："errcode":0,"errmsg":"ok")
            print_r($state);
        }
        $url = $this->weObj->getOauthRedirect('http://'.$_SERVER['SERVER_NAME'].'/'.__ROOT__.'/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/wxrurl'); //此处链接授权后，会跳转到下方处理
       // dd('http://'.$_SERVER['SERVER_NAME'].'/'.__ROOT__.'/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/wxrurl');
        redirect($url);
    }

    //微信返回字符串
    public function wxrurl(){
        $token = $this->weObj->getOauthAccessToken(); //确认授权后会，根据返回的code获取token
        session('token',$token); //保存授权信息
        $user_info = $this->weObj->getOauthUserinfo($token['access_token'],$token['openid']); //获取用户信息
        print_r($user_info);
    }

    /**
     * 读取数据库中微信配置(并缓存)
     */
    protected function getConfig()
    {
        $wchat_config	=	S('wchat_config');
        if(!$wchat_config){
            $wchat_config	= $this->config->find(1);
            unset($wchat_config['id']);
            S('wchat_config',$wchat_config);
        }
        return $wchat_config;
    }

}