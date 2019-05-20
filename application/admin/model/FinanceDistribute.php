<?php

namespace app\admin\model;

use think\Model;


class FinanceDistribute extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'finance_distribute';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







    public function projectinfo()
    {
        return $this->belongsTo('app\admin\model\ProjectInfo', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
