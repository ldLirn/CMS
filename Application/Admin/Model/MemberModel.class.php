<?php

/**
 * Created by PhpStorm.
 * User: YG
 * Date: 2017/3/2
 * Time: 16:17
 */
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model{
    protected $tableName = 'admin' ;   //指定表名
    const  KEY = 'srHfW%0${.,x=r(<}pVz!bRJ9Om?]-5)oAwdB[X&#'; //加密KEY
    /* 用户模型自动验证 */
    protected $_validate = array(

        /* 验证用户名 */
        array('username', '5,20', array('status'=>-1,'info'=>'用户名只能是5到20位之间'), self::MUST_VALIDATE, 'length'), //用户名长度不合法
        array('username', '/^[a-zA-Z0-9_\.]+$/', array('status'=>-2,'info'=>'用户名只能由字母、数字、点和下划线组成'), self::MUST_VALIDATE, 'regex'), //用户名只能由字母、数字、点和下划线组成
        array('username', '', array('status'=>-3,'info'=>'用户名已经存在'), self::MUST_VALIDATE, 'unique'), //用户名被占用

        /* 验证密码 */
        array('password', '5,20', array('status'=>-4,'info'=>'密码只能是5到20位之间'), self::EXISTS_VALIDATE, 'length'), //密码长度不合法
        array('password', '/^[a-zA-Z0-9_\.]+$/', array('status'=>-5,'info'=>'密码只能由字母、数字、点和下划线组成'), self::EXISTS_VALIDATE, 'regex'), //密码只能由字母、数字、点和下划线组成
        array('re_password','password',array('status'=>-6,'info'=>'两次输入的密码不一致'),self::EXISTS_VALIDATE,'confirm'), // 验证确认密码是否和密码一致

        /* 验证邮箱 */
        array('email', 'email', array('status'=>-7,'info'=>'邮箱格式不正确'), self::MUST_VALIDATE), //邮箱格式不正确
        array('email', '1,32', array('status'=>-8,'info'=>'邮箱长度不合法'), self::MUST_VALIDATE, 'length'), //邮箱长度不合法
        array('email', '', array('status'=>-9,'info'=>'邮箱已经存在'), self::MUST_VALIDATE, 'unique'), //邮箱被占用

        /* 验证手机号码 */
        array('mobile', '/^(\+?86-?)?(18|15|13)[0-9]{9}$/', array('status'=>-10,'info'=>'手机格式不正确'), self::VALUE_VALIDATE), //手机格式不正确
        array('mobile', '', array('status'=>-11,'info'=>'手机号码已经存在'), self::VALUE_VALIDATE, 'unique'), //手机号被占用

        /*验证分组*/
        //array('group_id','/^[1-9]\d*$/',array('status'=>-12,'info'=>'请选择分组'),self::MUST_VALIDATE,'regex'), //验证是否选择分组
    );

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('lasttime', NOW_TIME, self::MODEL_BOTH),
        array('lastip', 'get_client_ip', self::MODEL_BOTH, 'function', 0),
    );


    /**
     * @param $userPwd
     * @return string
     * 密码md5
     */
    public function think_md5($userPwd)
    {
        return md5($userPwd.self::KEY);
    }


    /**
     * 用户登录认证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
    public function login($username, $password,$map = array())
    {
        if(filter_var($username, FILTER_VALIDATE_EMAIL))   //判断是否邮箱
        {
            $map['email'] = $username;
        }elseif (isTelPhone($username))                   //判断是否手机号
        {
            $map['phone'] = $username;
        }else                                              //用户名
        {
            $map['username'] = $username;
        }

        /* 获取用户数据 */
        $user = $this->where($map)->find();
        if(is_array($user))
        {
            if($user['id']!=1)  //不是administration  则需要判断用户状态，用户组状态
            {
                if($user['status']==1)
                {
                    return -3; //用户被禁止访问
                }
                /*判断用户所在分组是否禁用*/
                $status = M('auth_group_access')->alias('a')->join('__AUTH_GROUP__ as g on g.id=a.group_id')->
                where('a.uid='.$user['id'])->getfield('g.status');
                if($status==0)
                {
                    return -4;    //用户所在组被禁用
                }
            }
            /* 验证用户密码 */
            if(md5($password.self::KEY) === $user['password'])
            {
                $this->updateLogin($user['id'],$user['loginnum']); //更新用户登录信息
                session('username',$user['username']);
                session('UID',$user['id']);
                session('verity',null);             //删除存储的验证码
                return 1; //登录成功
            } else
            {
                return -2; //密码错误
            }
        } else
        {
            return -1; //用户不存在
        }
    }

    /**
     * 更新用户登录信息
     * @param  integer $uid 用户ID
     */
    protected function updateLogin($uid,$loginNum)
    {
        $data = array(
            'id'              => $uid,
            'lasttime' => NOW_TIME,
            'lastip'   => get_client_ip(),
            'loginnum'       => $loginNum+1,
        );
        $this->save($data);
    }

    /**
     * 取得管理员列表
     */
    public function lists()
    {
        $p = empty($_GET['p']) ? 1 : $_GET['p'];
        $data['list'] = $list = $this->alias('c')->
        field('c.id,nickname,username,email,loginnum,lasttime,lastip,phone,c.status,b.title')->
        join('__AUTH_GROUP_ACCESS__ as a on a.uid=c.id')->
        join('__AUTH_GROUP__ as b on b.id=a.group_id')->
        page($p.','.PAGE)->select();
        $count        = $this->count();// 查询满足要求的总记录数
        $Page         = new \Think\Page($count,PAGE);// 实例化分页类 传入总记录数和每页显示的记录数
        $data['show']       = $Page->show();
        return $data;
    }

    /**
     * 得到具体的某条信息
     * @param $uid
     */
    public function getInfo($uid)
    {
        if(!is_numeric($uid))
        {
            return false;
        }
        $data = $list = $this->alias('c')->
        field('c.*,a.group_id')->
        join('__AUTH_GROUP_ACCESS__ as a on a.uid=c.id')->find($uid);
        return $data;
    }
}