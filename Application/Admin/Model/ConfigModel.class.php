<?php

/**
 * Created by PhpStorm.
 * User: YG
 * Date: 2017/3/2
 * Time: 16:17
 */
namespace Admin\Model;
use Think\Model;
class ConfigModel extends Model{

    /* 自动验证 */
    protected $_validate = array(
        /* 验证配置名称 */
        array('name', 'require', array('status'=>-9,'info'=>'配置名称不能为空'), self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '', array('status'=>-9,'info'=>'配置名称已经存在'), self::MODEL_INSERT, 'unique', self::MODEL_BOTH),
        /*验证配置说明*/
        array('title', 'require', array('status'=>-9,'info'=>'配置标题不能为空'), self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('name', 'strtoupper', self::MODEL_BOTH, 'function'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * 获取配置列表
     * @return array 配置数组
     */
    public function lists(){
        $data   = $this->field('type,name,value')->select();
        $config = array();
        if($data && is_array($data)){
            foreach ($data as $value) {
                $config[$value['name']] = $value['value'];
            }
        }
        return $config;
    }

    /**
     * @return array|bool
     * 对配置数据进行分组处理
     */
    public function group_config()
    {
        $tmp = array();
        $data = $this->field('id,type,name,value,title,remark,extra,data_type')->select();   //取得所有配置数据
        foreach ($data as $k=>$v)
        {
            switch ($v['data_type'])   //对数据类型进行处理
            {
                case 1:
                    $html = '<input type="text" name="'.$v['name'].'" class="form-control1" value="'.$v['value'].'"/>';
                    $data[$k]['html'] = $html;
                    break;
                case 2:          //单选类型的对选项进行处理
                    $str = '';
                    if($v['extra']!='') {
                        $field_arr = explode(',', $v['extra']);  //单选字段的切割
                        foreach ($field_arr as $a => $s) {
                            $arr = explode('|', $s);
                            $check = '';
                            if ($v['value'] == $arr[0]) {
                                $check = ' checked ';
                            }
                            $str .= '<input type="radio" name="'.$v['name'].'" value="' . $arr[0] . '" ' . $check . '/>' . $arr[1] . '' . '　';
                        }
                    }
                    $data[$k]['html'] = $str;
                    break;
                case 3:         //文本域
                    $data[$k]['html'] = '<textarea name="'.$v['name'].'">'.$v['value'].'</textarea>';
                    break;
                case 4:   //TODO:暂时没用到的类型
                    $data[$k]['html'] = '';
                    break;
                default:
            }
        }
        foreach ($data as $v)
        {
            switch ($v['type'])     //对数据进行分组
            {
                case 1:

                    $tmp[1][] = $v;
                    break;
                case 2:
                    $tmp[2][] = $v;
                    break;
                case 3:
                    $tmp[3][] = $v;
                    break;
                case 4:
                    $tmp[4][] = $v;
                    break;
                default:
            }
        }
        return $tmp;
    }
}