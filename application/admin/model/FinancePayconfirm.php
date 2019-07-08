<?php

namespace app\admin\model;

use think\Model;


class FinancePayconfirm extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'finance_payconfirm';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'state_text'
    ];
    

    
    public function getStateList()
    {
        return ['wait' => __('State wait'), 'agree' => __('State agree'), 'veto' => __('State veto')];
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function financeinfo()
    {
        return $this->belongsTo('FinanceInfo', 'id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('Admin', 'id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
