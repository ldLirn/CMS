<?php
namespace Admin\Controller;
use Api\Wchat\Wechat;
use Think\Controller;

include APP_PATH."Api/Wchat/wechat.class.php";
class WchatController extends CommonController {
    protected $config;   //微信config表
	protected $options;
	protected $weObj;
    protected function _initialize()
    {
        parent::_initialize();
        $this->config = M('wchat_config');
		$this->options = self::getConfig();  //获取微信配置
        if(count($this->options)==0)
        {
            $this->error('请先去微信设置填写相关信息');
        }
		$this->weObj = new Wechat($this->options); //实例化微信类
    }

    public function _empty()
    {
        header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码
        $this->display("Msg:404");
    }

    /**
     * 粉丝列表
     */
    public function fans_list()
    {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $data = page('wechat_group_list','','',$p,C('ADMIN_PAGE'));
        $this->title = '微信粉丝列表';
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 获取微信关注用户列表，并写入更新数据库
     */
    public function wchat_list()
    {
        action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
        if ($_GET['wxupover'] != 'y') {       //判断是否完成拉取
            if (!isset($_GET['next_openid']) || $_GET['next_openid']=='') {  //如果不需要继续获取则清空保存的粉丝列表
                session('fansData', null);
            }

            if(isset($_GET['next_openid']) && $_GET['next_openid'] != '') {
                $user_list = ($this->weObj->getUserList($_GET['next_openid']));  //得到所有关注者的openid
            }else {
                $user_list = ($this->weObj->getUserList());  //得到所有关注者的openid
            }
            $userData_session = session('fansData');
            if($userData_session=='') {
                $userData_session = $user_list['data']['openid'];
            }else {
                $userData_session = array_merge($userData_session,$user_list['data']['openid']);
            }
            session('fansData', $userData_session);
            if ($user_list['count'] < 10000) {   //判断总的关注人数
                $this->success('粉丝列表获取完成，正在写入数据库……', U('Wchat/wchat_list', array('wxupover' => 'y')),3);
            }
            else {
                $this->success('正在获取粉丝列表……', U('Wchat/wchat_list', array('next_openid' => $user_list['next_openid'])),2);
            }
        }
        else {
            $fans_session = session('fansData');
            $a = 0;
            $b = 0;
            $n = 0;
            $num = intval($_GET['num']);
            for ($i = $num; $i < ($num + 20); $i++) {
                $check = M('wechat_group_list')->field('openid')->where(array('openid' => $fans_session[$i]))->find();
                if ($check == false) {
                    if ($fans_session[$i] != '') {
                        M('wechat_group_list')->data(array('openid' => $fans_session[$i]))->add();
                        $a++;
                    }
                }
                else {
                    $b++;
                }
                if ((count($fans_session) - 1) <= $i) {
                    $over = true;
                    $upnum = $n + 1;
                }
                else {
                    $over = false;
                    $n++;
                    $upnum = $n;
                }
            }
            $upnum = intval($_GET['num']) + $upnum;
            if ($over) {
                session('fansData', null);
                $this->success('更新完成' . count($fans_session) . '条,现在获取粉丝详细信息',U('Wchat/fans_info'),3);
                //echo 1;
            }
            else {
                $this->success('本次更新' . $a . '条,重复' . ($b = ($b == 1 ? 0 : $b . '条，已更新粉丝' . $upnum . '条')), U('Wchat/wchat_list', array('wxupover' => 'y', 'num' => $num + 20)),3);
            }
        }

    }

    /**
     * 获取粉丝具体信息
     */
    public function fans_info()
    {
            $refreshAll = (isset($_GET['all']) ? 1 : 0);
            if ($refreshAll) {
                $fansCount = M('wechat_group_list')->count();
                $i = intval($_GET['i']);
                $step = 20;
                $fans = M('wechat_group_list')->order('id DESC')->limit($i, $step)->select();
                if ($fans) {
                    foreach ($fans as $v ) {
                        $classData = $this->weObj->getUserInfo($v['openid']);
                        if ($classData['subscribe'] == 1) {      //判断是否关注，1关注
                            $data['nickname'] = str_replace('‘', '', $classData['nickname']);
                            $data['sex'] = $classData['sex'];
                            $data['city'] = $classData['city'];
                            $data['province'] = $classData['province'];
                            $data['headimgurl'] = $classData['headimgurl'];
                            $data['subscribe_time'] = $classData['subscribe_time'];
                            $data['groupid'] = $classData['groupid'];
                            M('wechat_group_list')->where(array('id' => $v['id']))->save($data);
                        }
                        else {
                            M('wechat_group_list')->delete($v['id']);
                        }
                    }
                    $i = $step + $i;
                    $this->success('更新中请勿关闭…进度：' . $i . '/' . $fansCount, U('Wchat/fans_info',array('all'=>'1','i'=>$i)));
                }
                else {
                    $this->success('粉丝列表更新成功',U('Wchat/fans_list'),3);
                }
            }
            else {
                $dataAll = M('wechat_group_list')->where(array('subscribe_time' => ''))->order('id desc')->limit(20)->select();
                if ($dataAll == false) {
                    $this->success('粉丝列表更新成功',U('Wchat/fans_list'),3);
                }else{
                    $i = 0;
                    foreach ($dataAll as $data_all ) {
                        $classData = $this->weObj->getUserInfo($data_all['openid']);;
                        if ($classData['subscribe'] == 1) {
                            $data['openid'] = $classData['openid'];
                            $data['nickname'] = str_replace('‘', '', $classData['nickname']);
                            $data['sex'] = $classData['sex'];
                            $data['city'] = $classData['city'];
                            $data['province'] = $classData['province'];
                            $data['headimgurl'] = $classData['headimgurl'];
                            $data['subscribe_time'] = $classData['subscribe_time'];
                            $data['id'] = $data_all['id'];
                            $data['groupid'] = $classData->groupid;
                            M('wechat_group_list')->save($data);
                            $i++;
                        }
                        else {
                            M('wechat_group_list')->delete($data_all['id']);
                        }
                    }

                    $count = M('wechat_group_list')->field('id')->where(array('subscribe_time' => ''))->count();
                    if($count>0){
                        $this->success('还有' . $count . '个粉丝信息没有更新,<br />请耐心等待', U('Wchat/fans_info'),3);
                    }else{
                        $this->success('粉丝列表更新成功',U('Wchat/fans_list'),3);
                    }
                }
            }
    }


    /**
     * 自定义菜单
     */
    public function menu()
    {
        $data = tree(M('wechat_menu')->order('sort asc')->select());
        $this->title = '自定义菜单';
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 添加菜单
     */
    public function menu_add()
    {
        if(IS_POST)
        {
            $data = I('post.');
            $data['type'] = $data['type'] == 1 ? 'view' : 'click' ;
            $result = self::check_menu($data);
            if($result['status']!=200)
            {
                $this->ajaxReturn($result);
            }
            $top_menu = M('wechat_menu')->field('name')->where('pid=0')->count();
            $child_menu = M('wechat_menu')->field('name')->where('pid='.$data['pid'])->count();
            if($top_menu<=3)  //微信顶级菜单最多三个
            {
                if($data['pid']==0 && $top_menu==3)  //添加的顶级菜单并且已经有3个顶级菜单,不允许再添加
                {
                    $this->ajaxReturn(array('status'=>-5,'info'=>'微信顶级菜单，最多只能三个，请删除后再添加'));
                }
                else
                {
                    if($child_menu>=5)  //微信二级菜单最多五个
                    {
                        $this->ajaxReturn(array('status'=>-3,'info'=>'微信二级菜单，最多只能五个，请删除后再添加'));
                    }

                    if($last_id = M('wechat_menu')->add($data))
                    {
                        if($this->weObj->createMenu(self::getMenuData()))
                        {
                            action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['name']);
                            $this->ajaxReturn(array('status'=>200,'info'=>'菜单新增成功'));
                        }
                        else
                        {
                            M('wechat_menu')->delete($last_id);
                            $this->ajaxReturn(array('status'=>-1,'info'=>'菜单新增失败，请稍后重试'));
                        }
                    }
                    else
                    {
                        $this->ajaxReturn(array('status'=>-4,'info'=>'菜单新增失败，请稍后重试'));
                    }
                }
            }
            else
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'微信顶级菜单，最多只能三个，请删除后再添加'));
            }
        }
        $menuData = M('wechat_menu')->where('pid=0')->select();
        $this->title = '添加微信菜单';
        $this->assign('menuData',$menuData);
        $this->display();
    }

    /**
     * 微信菜单修改
     */
    public function menu_edit()
    {
        if(IS_AJAX)
        {
            $data = I('post.');
            $data['type'] = $data['type'] == 1 ? 'view' : 'click' ;
            $result = self::check_menu($data);
            if($result['status']!=200)
            {
                $this->ajaxReturn($result);
            }
            unset($data['pid']);  //TODO: 暂时不能修改所属关系
            if(M('wechat_menu')->save($data))
            {
                if($this->weObj->createMenu(self::getMenuData()))
                {
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['name']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'菜单修改成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'菜单修改失败，请稍后重试'));
                }
            }
            else
            {
                $this->ajaxReturn(array('status'=>-4,'info'=>'菜单修改失败，请稍后重试'));
            }
        }
        $id = I('get.id','','intval');
        if(!is_numeric($id))
        {
            $this->error('非法操作');
        }
        $data = M('wechat_menu')->find($id);
        $menuData = M('wechat_menu')->where('pid=0')->select();
        $this->title = '修改微信菜单';
        $this->assign('menuData',$menuData);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 微信菜单删除
     */
    public function menu_delete()
    {
        if(IS_AJAX)
        {
            $id = I('post.id',0,'intval');
            $pid = I('post.pid',0,'intval');
            if($id==0)
            {
                $this->ajaxReturn(array('status'=>-6,'info'=>'不存在的id'));
            }
            if($pid==0 && M('wechat_menu')->where("pid=$id")->find())
            {
                $this->ajaxReturn(array('status'=>-5,'info'=>'请先删除下级子菜单'));
            }
            if(M('wechat_menu')->delete($id))
            {
                if($this->weObj->createMenu(self::getMenuData()))
                {
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,"id=$id");
                    $this->ajaxReturn(array('status'=>200,'info'=>'微信菜单删除成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'微信菜单删除成功，请稍后重试'));
                }
            }
            else
            {
                $this->ajaxReturn(array('status'=>-4,'info'=>'微信菜单删除失败'));
            }
        }
        $this->error(array('status'=>-2,'info'=>'非法操作'));
    }

    /**
     * 微信菜单排序
     */
    public function menu_sort()
    {
        if(IS_AJAX)
        {
            $arr_id['id'] = I('post.id');
            $arr_sort['sort'] = I('post.sort');
            $Common = A("Common");
            $result = $Common->sortAll($arr_id,$arr_sort,'wechat_menu');
            if($result)
            {
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
    /**
     * 微信设置
     */
    public function config()
    {
        if(IS_AJAX)
        {
            $data = array(
                'appid'     => I('post.appid','','htmlspecialchars'),
                'appsecret' => I('post.appsecret','','htmlspecialchars'),
                'token'     => I('post.token','','htmlspecialchars'),
                'encodingaeskey'       => I('post.key','','htmlspecialchars'),
                'id'        => I('post.id',1,'intval'),
            );
           if($data['appid']=='' || $data['appsecret']=='' || $data['token']=='')
           {
               $this->ajaxReturn(array('status'=>-1,'info'=>'AppID(应用ID)，AppSecret(应用密钥)，Token(令牌)都不能为空'));
           }
            if($this->config->save($data))
            {
                S('wchat_config',null);
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
                $this->ajaxReturn(array('status'=>200,'info'=>'微信设置成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-2,'info'=>'微信设置失败，请稍后重试'));
            }
        }
        $data = $this->config->find(1);
        $this->title = '微信设置';
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 微信自动回复设置
     * auto_reply
     */
    public function auto_reply()
    {
        if(IS_AJAX)
        {
            $data = array(
                'follow'     => I('post.follow','','htmlspecialchars'),
                'auto_reply_text' => I('post.auto_reply_text','','htmlspecialchars'),
                'auto_reply_img' => I('post.auto_reply_img','','htmlspecialchars'),
                'auto_reply_voice' => I('post.auto_reply_voice','','htmlspecialchars'),
            );
            if(M('wechat_auto_reply')->add($data))
            {
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME);
                $this->ajaxReturn(array('status'=>200,'info'=>'自动回复设置成功'));
            }
            else
            {
                $this->ajaxReturn(array('status'=>-1,'info'=>'自动回复设置失败'));
            }
        }
        if(F('wechat_auto_reply')==null)
        {
            $data = M('wechat_auto_reply')->find(1);
            F('wechat_auto_reply',$data);
        }
        $data = F('wechat_auto_reply');
        $this->title = '微信自动回复设置';
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 关键字回复
     */
    public function keywords_reply()
    {

        if(F('wechat_keywords_reply')==null)
        {
            $data = M('wechat_keywords_reply')->select();
            F('wechat_keywords_reply',$data);
        }
        $keywords_data = F('wechat_keywords_reply');

        $this->title = '关键字回复';
        $this->assign('keywords_data',$keywords_data);
        $this->display();
    }

    /**
     * 添加关键字
     */
    public function keywords_add()
    {
        if(IS_AJAX)
        {
            $data['type'] = I('post.type',1,'intval');
            $data['name'] = I('post.name','','htmlspecialchars');
            $data['command'] = I('post.command','','htmlspecialchars');
            $data['extend'] = I('post.extend','','htmlspecialchars');
            $has = M('wechat_keywords_reply')->query("SELECT 'id' FROM __TABLE__ WHERE find_in_set('$data[extend]', extend) or find_in_set('$data[command]', extend) or command='$data[command]' or command='$data[extend]'");
            if($has)
            {
                $this->ajaxReturn(array('status'=>-9,'info'=>'关键字或扩展字段已经存在'));
            }
            if(strpos($data['extend'],','))  //判断是否多个扩展
            {
                $arr = explode(',',$data['extend']);
                foreach ($arr as $v)
                {
                    if(M('wechat_keywords_reply')->query("SELECT 'id' FROM __TABLE__ WHERE find_in_set('$v', extend) or command='$v') and id<>$data[id]"))
                    {
                        $this->ajaxReturn(array('status'=>-8,'info'=>'扩展字段已经存在'));
                        break;
                    }
                }
            }
            if($data['type']==1)
            {
                $data['content'] = I('post.content','','htmlspecialchars');
            }
            else
            {
                $data['title'] = I('post.title','','htmlspecialchars');
                $data['description'] =  I('post.description','','htmlspecialchars');
                $data['picurl'] = I('post.picurl','','');
                $data['url'] = I('post.url','','');
            }
            if(M('wechat_keywords_reply')->create($data))
            {
                if(M('wechat_keywords_reply')->add())
                {
                    F('wechat_keywords_reply',null);
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['name']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'关键字回复添加成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'关键字回复添加失败'));
                }
            }
            else
            {
                $this->ajaxReturn(M('wechat_keywords_reply')->getError());
            }
        }
        $this->title = '添加关键字';
        $this->display();
    }

    /**
     * 修改关键字
     */
    public function keywords_edit()
    {
        $keywords_table = M('wechat_keywords_reply');
        if(IS_AJAX)
        {
            $data['id'] = I('post.id',0,'intval');
            $data['type'] = I('post.type',1,'intval');
            $data['name'] = I('post.name','','htmlspecialchars');
            $data['command'] = I('post.command','','htmlspecialchars');
            $data['extend'] = I('post.extend','','htmlspecialchars');

            $has = $keywords_table->query("SELECT `id` FROM __TABLE__ WHERE ( find_in_set('$data[extend]', extend) or find_in_set('$data[command]', extend) or command='$data[command]' or command='$data[extend]') and id<>$data[id]");
            if($has)
            {
                $this->ajaxReturn(array('status'=>-9,'info'=>'关键字或扩展字段已经存在'));
            }
            if(strpos($data['extend'],','))  //判断是否多个扩展
            {
                $arr = explode(',',$data['extend']);
                foreach ($arr as $v)
                {
                    if($keywords_table->query("SELECT `id` FROM __TABLE__ WHERE (find_in_set('$v', extend) or command='$v') and id<>$data[id]"))
                    {
                        $this->ajaxReturn(array('status'=>-8,'info'=>'扩展字段已经存在'));
                        break;
                    }
                }
            }
            if($data['type']==1)
            {
                $data['content'] = I('post.content','','htmlspecialchars');
            }
            else
            {
                $data['title'] = I('post.title','','htmlspecialchars');
                $data['description'] =  I('post.description','','htmlspecialchars');
                $data['picurl'] = I('post.picurl','','');
                $data['url'] = I('post.url','','');
            }
            if($keywords_table->create($data))
            {
                if($keywords_table->save())
                {
                    F('wechat_keywords_reply',null);
                    action_log(CONTROLLER_NAME . '/' . ACTION_NAME,$data['name']);
                    $this->ajaxReturn(array('status'=>200,'info'=>'关键字回复修改成功'));
                }
                else
                {
                    $this->ajaxReturn(array('status'=>-1,'info'=>'关键字回复修改失败'));
                }
            }
            else
            {
                $this->ajaxReturn($keywords_table->getError());
            }

        }
        $id = I('get.id',0,'intval');
        if($id==0)
        {
            $this->ajaxReturn(array('status'=>-1,'info'=>'不存在的id'));
        }
        $data = $keywords_table->find($id);
        $this->title = '修改关键字';
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 删除关键字
     */
    public function keywords_delete()
    {
        if(IS_AJAX)
        {
            $id = I('post.id', 0, 'intval');
            if ($id == 0)
            {
                $this->ajaxReturn(array('status' => -6, 'info' => '不存在的id'));
            }
            if (M('wechat_keywords_reply')->delete($id))
            {
                F('wechat_keywords_reply',null);
                action_log(CONTROLLER_NAME . '/' . ACTION_NAME,"id=$id");
                $this->ajaxReturn(array('status' => 200, 'info' => '关键字删除成功'));
            }
            else
            {
                $this->ajaxReturn(array('status' => -4, 'info' => '关键字删除失败，请稍后重试'));
            }
        }
        $this->ajaxReturn(array('status'=>-1,'info'=>'非法操作'));
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

    /**
     *   得到微信菜单格式的数据
     */
    protected function getMenuData()
    {
        $menu = tree(M('wechat_menu')->order('sort asc')->select());
        $tmp = array();
        foreach ($menu as $k=>$v)
        {
            if(count($v['child'])==0)
            {
                $tmp['button'][$k]['name'] = $v['name'];
                $tmp['button'][$k]['type'] = $v['type'];
                if($v['type']=='click')
                {
                    $tmp['button'][$k]['key'] = $v['value'];
                }
                else
                {
                    $tmp['button'][$k]['url'] = $v['value'];
                }
            }
            else
            {
                $tmp['button'][$k]['name'] = $v['name'];
            }

            foreach ($v['child'] as $m)
            {
                if($m['type']=='click')
                {
                    $tmp['button'][$k]['sub_button'][] = array('type'=>$m['type'],'name'=>$m['name'],'key'=>$m['value']);
                }
                else
                {
                    $tmp['button'][$k]['sub_button'][] = array('type'=>$m['type'],'name'=>$m['name'],'url'=>$m['value']);
                }
            }
        }
        $tmp = array_merge($tmp['button'],array());  //重建数组索引关系
        $array['button'] = $tmp;
       // sort($tmp['button']);
        return $array;
    }
    
    
    /**
     * 菜单的验证
     */
    protected function check_menu($data=array())
    {
        if($data['pid']==0 && strlen($data['name'])>16)
        {
            $result = array('status'=>-6,'info'=>'微信顶级菜单,最大16个字节');
        }
        elseif($data['pid']!=0 && strlen($data['name'])>60)
        {
            $result = array('status'=>-7,'info'=>'微信子菜单,最大60个字节');
        }
        else
        {
            if($data['type']=='view' && strlen($data['value'])>1024)
            {
                $result = array('status'=>-8,'info'=>'链接菜单值不超过1024字节');
            }
            elseif($data['type']=='click' && strlen($data['value'])>128)
            {
                $result = array('status'=>-8,'info'=>'消息接口推送，菜单值不超过128字节');
            }
            else
            {
                $result = array('status'=>200,'info'=>'');
            }
        }
        return $result;
        
       
    }
}