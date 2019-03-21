<?php

namespace app\admin\model;

use think\Model;

class FinanceInfo extends Model
{
    // 表名
    protected $name = 'finance_info';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    

    







    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectInfo()
    {
        return $this->belongsTo('ProjectInfo', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectSection()
    {
        return $this->belongsTo('ProjectSection', 'project_section_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function companyInfo()
    {
        return $this->belongsTo('CompanyInfo', 'company_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function category()
    {
        return $this->belongsTo('Category', 'label_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
