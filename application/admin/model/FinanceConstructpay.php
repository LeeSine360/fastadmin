<?php

namespace app\admin\model;

use think\Model;

class FinanceConstructpay extends Model
{
    // 表名
    protected $name = 'finance_constructpay';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    

    







    public function projectConstruct()
    {
        return $this->belongsTo('ProjectConstruct', 'project_construct_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectInfo()
    {
        return $this->belongsTo('ProjectInfo', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectSection()
    {
        return $this->belongsTo('ProjectSection', 'project_section_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
