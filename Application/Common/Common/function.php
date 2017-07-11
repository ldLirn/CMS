<?php

/**
 * @param $code 用户输入的验证码字符串
 * @param string $id 验证码id
 * @return bool
 * 检测输入的验证码是否正确
 */
function check_verify($code, $id = '1')
{
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

/**
 * 判断是否登陆
 * 没登陆重定向到登陆页面
 * 登陆则返回当前用户id
 */
function is_login()
{
	if(!session('?UID')){
		redirect('/Admin/Login/login');
	}
}

/**
 * 生成验证码
 */
function CreateVerify($fontSize='18',$length='4',$w='120',$h='40',$expire='600',$bg=array(),$useNoise=false,$code='1')
{
	$Verify =     new \Think\Verify();
	$Verify->fontSize = $fontSize;      //验证码字体大小（像素） 默认为25
	$Verify->length   = $length;		 //验证码位数
	$Verify->imageW   = $w;	//验证码宽度 设置为0为自动计算
	$Verify->imageH   = $h;		//验证码高度 设置为0为自动计算
	$Verify->expire   = $expire;     //验证码的有效期（秒）
	$Verify->bg       = $bg;   //验证码背景颜色 rgb数组设置，例如 array(243, 251, 254)
	$Verify->useNoise = $useNoise;			//是否添加杂点 默认为true
//	$Verify->useImgBg = false;  //是否使用背景图片 默认为false
//	$Verify->useCurve = true;   //是否使用混淆曲线 默认为true
//	$Verify->fontttf  =  '' ;        //指定验证码字体 默认为随机获取
//	$Verify->useZh    = false;   //是否使用中文验证码
//	$Verify->seKey    = '' ;      //验证码的加密密钥
//	$Verify->codeSet  = '' ;      //验证码字符集合 3.2.1 新增
//	$Verify->zhSet    = '' ;	  //验证码字符集合(中文)
	$Verify->entry($code);
}

/**
 * @param $username
 * @return bool
 * 检测用户名
 */
function CheckUserNameExist($username){
	$map['username']=$username;
	$data = M('user')->where($map)->find();
	if($data){
		return true;
	}else{
		return false;
	}
}

/**
 * @param $email
 * @return bool
 * 检测邮箱
 */
function CheckEmailExist($email){
	$map['email']=$email;
	$data = M('user')->where($map)->find();
	if($data){
		return true;
	}else{
		return false;
	}
}

/**
 * @param $username
 * @return bool
 * 用户名规则
 * 以字母数字下划线开头，5-15位
 */
function CheckUserName($username){
	if(preg_match("/^[A-Z][a-z\d\_]{5,15}$/i",$username)){
		return false;
	}else{
		return true;
	}
}

/**
 * 得到用户名
 * @param $model
 * @param $uid
 * @return mixed|string
 */
function get_user_name($model,$uid){
	if($name = M($model)->field('username')->find($uid)){
		return $name['username'];
	}else{
		return '未知用户';
	}
}

/**
 * 验证是否是手机号码
 * @param string $phone 待验证的号码
 * @return boolean 如果验证失败返回false,验证成功返回true
 */
function isTelPhone($phone) {
	if (strlen ( $phone ) != 11 || ! preg_match ( '/^1[3|4|5|7|8][0-9]\d{4,8}$/', $phone )) {
		return false;
	} else {
		return true;
	}
}

/**
 * @param $data
 * @param $type   0 echo, 1 print_r  , 2 var_dump
 * 打印（调试用）
 */
function dd($data,$type=1){
	switch ($type)
	{
		case 0:
			echo $data;
			die;
			break;
		case 1:
			print_r($data);
			die;
			break;
		case 2:
			var_dump($data);
			die;
			break;
		default:
			return false;
	}
}

/**
 * @param $uid   用户id
 * @return bool
 * 检查用户状态
 */
function checkStatus($uid)
{
	$map['id']=$uid;
	$data = M('user')->where($map)->field('status');
	if($data){
		return true;
	}else{
		return false;
	}
}

/**
 * @param $data      
 * @param int $pid
 * @param int $level
 * @return array
 * 无极分类，返回树状结构
 */
function tree($data,$pid=0,$level=0)
{
	$tmp = array();
	foreach ($data as $k=>$v)
	{
		if($v['pid'] == $pid)
		{
			$v['href'] = $v['href'] ? $v['href'] : '#';
			$v['level'] = $level;
			$tmp[$k] = $v;
			$tmp[$k]['child'] = tree($data,$v['id'],$level+1);
		}
	}
	return $tmp;
}


/**
 * @param $ruleName
 * @param $userId
 * @param string $relation
 * @return bool
 * Auth权限验证 - 控制器
 * $Auth = new \Think\Auth();
	$ruleName = MODULE_NAME . '/' . ACTION_NAME; //规则唯一标识,取当前的控制器:Admin/index
	if(action_AuthCheck($ruleName,1)){
	$dietxt = '认证：通过';
	}else{
	$dietxt = '认证：失败';
	}
 */
function action_AuthCheck($ruleName,$userId,$relation='or'){
//$relation = or|and; //默认为'or' 表示满足任一条规则即通过验证; 'and'则表示需满足所有规则才能通过验证
	$Auth = new \Think\Auth();

	if(empty($userId)){ //用户ID判断，没有就取当前登录的用户ID
		$userId = $_SESSION['UID'];
	}
	if($userId==1){   //系统管理员不需要权限验证
		return true;
	}
	$type=1; //分类-具体是什么没搞懂，默认为:1
	$mode='url'; //执行check的模式,默认为:url

	return $Auth->check($ruleName,$userId,$type,$mode,$relation);
}

/**
 * @param $ruleName
 * @param $userId
 * @param string $relation
 * @param $t
 * @param string $f
 * @return string
 * Auth权限验证 - 模板
 * 模板中调用：{:tpl_AuthCheck('Admin/add',$_SESSION['userid'],'or','<a href=”__URL__/add”>添加</a>','')}
 */
function tpl_AuthCheck($ruleName,$userId,$relation='or',$t,$f='false'){
//$relation = or|and; //默认为'or' 表示满足任一条规则即通过验证; 'and'则表示需满足所有规则才能通过验证
	$Auth = new \Think\Auth();

	if(empty($userId)){ //用户ID判断，没有就取当前登录的用户ID
		$userId = $_SESSION['userid'];
	}
	$type=1; //分类-具体是什么没搞懂，默认为:1
	$mode='url'; //执行check的模式,默认为:url

	return $Auth->check($ruleName,$userId,$type,$mode,$relation) ? $t : $f;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array();
	if(is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data[$pk]] =& $list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$parentId =  $data[$pid];
			if ($root == $parentId) {
				$tree[] =& $list[$key];
			}else{
				if (isset($refer[$parentId])) {
					$parent =& $refer[$parentId];
					$parent[$child][] =& $list[$key];
				}
			}
		}
	}
	return $tree;
}


/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
	return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 通用分页
 * @param $model     数据库名称
 * @param $map		  查询条件
 * @param $order     排序
 * @param $p		  当前页码
 * @param $page		  每页显示条数
 * @return mixed
 */
function page($model,$map,$order,$p,$page){
	$User = M($model); // 实例化User对象
    // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
	$data['list'] = $User->where($map)->order($order)->page($p.','.$page)->select();
	$count      = $User->where($map)->count();// 查询满足要求的总记录数
	$Page       = new \Think\Page($count,$page);// 实例化分页类 传入总记录数和每页显示的记录数
	//$Page->setConfig(array('header'=>'条记录','theme'=>'<ul><li><span> %totalRow% %header% %nowPage%/%totalPage% 页</span></li> %first%  %upPage% %prePage%  %linkPage% %downPage%  %nextPage% %end%</ul>'));
	$Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录</li>');
	$Page->setConfig('prev','上一页');
	$Page->setConfig('next','下一页');
	$Page->setConfig('last','末页');
	$Page->setConfig('first','首页');
	$Page->setConfig('theme','<ul class="pagination"><li>%FIRST%</li> <li>%UP_PAGE%</li> <li>%LINK_PAGE%</li> <li>%DOWN_PAGE%</li> <li>%END%</li> %HEADER%</ul>');
	$data['show']       = $Page->show();// 分页显示输出
	return $data;
}


/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
	if(function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		$slice = iconv_substr($str,$start,$length,$charset);
		if(false === $slice) {
			$slice = '';
		}
	}else{
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice.'...' : $slice;
}


/**
 * 替换隐藏手机号
 * @param $phone
 * @return mixed
 */
function hide_tel($phone){
	return  preg_replace('/(1[0-9]{2})[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
}


/**
 * 面包屑导航
 * $nav_id  当前菜单的id
 */
function breadcrumb($nav_id)
{
	$breadcrumb = '';
	$breadcrumb .= '<ol class="breadcrumb">';
	$breadcrumb .= ' <li><a href="'.U('Index/index').'">首页</a></li>';
	$menu = M('Menu');
	$uplevels = $menu->field("id,navname,pid")->where("id=$nav_id")->find(); //查询当前菜单数组
	if($uplevels['pid'] != 0)     //如果不是顶级菜单，则递归查询
	{
		$breadcrumb .= get_up_levels($uplevels['pid'],$uplevels);
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
function get_up_levels($id,$child_data)
{
	$menu = M('Menu');
	$here = '';
	$uplevels = $menu->field("id,navname,pid")->where("id=$id")->find();
	$here .= '<li><a href="'.U("$uplevels[href]").'">'.$uplevels['navname'].'</a></li>';
	$here .= '<li class="active">'.$child_data['navname'].'</li>';
	if($uplevels['pid'] != 0)
	{
		$here = get_up_levels($uplevels['pid']).$here;
	}
	return $here;
}

/**
 * 读取数据库中的配置  到C方法中
 */
function put_config()
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
 * 记录行为日志
 * @param string $node 行为标识
 * @return boolean
 */
function action_log($node = null,$extend=''){
	$uid = session('UID') ? session('UID') : '';
	if(empty($node)  || empty($uid)){
		return '参数不能为空';
	}
	//参数检查
	if($node=='login'){
		$data['node']           =   'Login/login';
		$data['node_name']      =   '登陆';
	}else{
		//查询行为
		$action_info = M('auth_rule')->getByName($node);
		//判断是否为空
		if($action_info){
			if($action_info['status'] != 1){
				return '该行为被禁用或删除';
			}
			//插入行为日志
			$extend = empty($extend) ? '' : '['.$extend.']';
			$data['node']           =   $action_info['name'];
			$data['node_name']      =   $action_info['title'].$extend;
		}else{
			//未定义日志规则，记录操作url
			$data['node']        =   '操作url：'.$_SERVER['REQUEST_URI'];
			$data['node_name']   =   '未定义节点';
		}
	}
	$data['uid']            =   $uid;
	$data['ip']             =   get_client_ip(0);
	$data['time']           =   NOW_TIME;

	if(M('log')->add($data)){
		return 1;
	}else{
		return '日志添加失败';
	}
}

/**
 * ajxa 返回格式
 * @param int $status
 * @param string $info
 * @return array
 */
function reAjax($status=0,$info='')
{
	return array('status'=>$status,'info'=>$info);
}

/**
 * 检查邮箱是否存在
 * @param $model
 * @param $email
 * @return bool
 */
function CkEmailHas($model,$email)
{

	if(M($model)->where("email='$email'")->find()){
		return true;
	}else{
		return false;
	}
}

/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
	$config = C('THINK_EMAIL');
	include_once APP_PATH.'Api/mail/phpmailer.class.php';
	$mail             = new PHPMailer(); //PHPMailer对象
	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP();  // 设定使用SMTP服务
	$mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
	// 1 = errors and messages
	// 2 = messages only
	$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
	//$mail->SMTPSecure = 'ssl';                 // 使用安全协议
	$mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
	$mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
	$mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
	$mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
	$mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
	$replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
	$replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
	$mail->AddReplyTo($replyEmail, $replyName);
	$mail->Subject    = $subject;
	$mail->MsgHTML($body);
	$mail->AddAddress($to, $name);
	if(is_array($attachment)){ // 添加附件
		foreach ($attachment as $file){
			is_file($file) && $mail->AddAttachment($file);
		}
	}
	return $mail->Send() ? true : $mail->ErrorInfo;
}
?>