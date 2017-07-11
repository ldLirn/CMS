<?php
namespace Admin\Controller;
use Api\Wchat\Wechat;
use Think\Controller;

include APP_PATH."Api/Wchat/wechat.class.php";
class WechatController extends Controller {
    protected $config;   //微信config表
    protected $options;
    protected $weObj;
    protected function _initialize()
    {
        $this->config = M('wchat_config');
        $this->options = self::getConfig();  //获取微信配置
        if(count($this->options)==0)
        {
            $this->error('请先去微信设置填写相关信息');
        }
        $this->weObj = new Wechat($this->options); //实例化微信类
    }

    /**
     * 微信自动回复
     */
    public function index()
    {
        if(F('wechat_auto_reply')==null)
        {
            $data = M('wechat_auto_reply')->find(1);
            F('wechat_auto_reply',$data);
        }
        $data = F('wechat_auto_reply');

        //$this->weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败
        $type = $this->weObj->getRev()->getRevType();
        $content = $this->weObj->getRevContent();
        switch ($type) {
            case Wechat::MSGTYPE_TEXT: //文字类型回复
                $keywords_table = M('wechat_keywords_reply');
                $has = $keywords_table->query("SELECT * FROM __TABLE__ WHERE find_in_set('$content', extend) or command='$content'");
                if($has)     //如果关键字在数据库中
                {
                    if($has[0]['type']==1)
                    {
                        $this->weObj->text($has[0]['content'])->reply();
                    }
                    else
                    {
                        $newsData[] = array(
                            'Title' => $has[0]['title'],
                            'Description'=>$has[0]['description'],
                            'PicUrl'=>'http://'.$_SERVER['HTTP_HOST'].'/Uploads/'.$has[0]['picurl'],
                            'Url'=>$has[0]['url'],
                        );
                        $this->weObj->news($newsData)->reply();
                    }
                    M('wechat_keywords_reply')->where("id=$has[0][id]")->setInc('demand');  //请求量自增1
                }
                else    //没有则自动回复
                {
                    $this->weObj->text($data['auto_reply_text'])->reply();
                }
                exit;
                break;
            case Wechat::MSGTYPE_EVENT:
                $this->weObj->text($data['follow'])->reply();
                break;
            case Wechat::MSGTYPE_IMAGE:
                $this->weObj->text($data['auto_reply_img'])->reply();
                break;
            case Wechat::MSGTYPE_VOICE:
                $this->weObj->text($data['auto_reply_voice'])->reply();
                break;
            default:
                $this->weObj->text("小的不太明白您说的什么")->reply();

        }
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