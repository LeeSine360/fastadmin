<?php

namespace app\admin\model;

use think\Model;


class FinanceCompanypay extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'finance_companypay';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







    public function financeinfo()
    {
        return $this->belongsTo('app\admin\model\FinanceInfo', 'finance_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('app\admin\model\Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
