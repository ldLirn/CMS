<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 16-4-5
 * Time: 下午5:30
 * To change this template use File | Settings | File Templates.
 */
namespace Admin\Widget;

use Think\Controller;
class AdminWidget extends Controller{
    /**
     * 后台菜单widget
     */
    public function Menu()
    {
        if(!F('MenuListData_'.session('UID')))    //判断缓存数据
        {
            F('MenuListData_'.session('UID'),D('Menu')->MenuList(array('hide'=>0)));
        }
        $MenuListData = F('MenuListData_'.session('UID'));
        $this->assign('menuListData',$MenuListData);
        $this->display('Menu/menu');
    }

    
}