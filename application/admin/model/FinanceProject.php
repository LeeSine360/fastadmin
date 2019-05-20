<?php

namespace app\admin\model;

use think\Model;


class FinanceProject extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'finance_project';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'agreedata_text'
    ];
    

    
    public function getAgreedataList()
    {
        return ['wait' => __('Agreedata wait'), 'agree' => __('Agreedata agree'), 'veto' => __('Agreedata veto')];
    }


    public function getAgreedataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['agreedata']) ? $data['agreedata'] : '');
        $list = $this->getAgreedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function admin()
    {
        return $this->belongsTo('app\admin\model\Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function financeinfo()
    {
        return $this->belongsTo('app\admin\model\FinanceInfo', 'finance_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
