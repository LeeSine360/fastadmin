<?php

namespace app\admin\model;

use think\Model;


class CompanyBill extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'company_bill';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];

    
    public function projectinfo()
    {
        return $this->belongsTo('ProjectInfo', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectsection()
    {
        return $this->belongsTo('ProjectSection', 'project_section_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function companyinfo()
    {
        return $this->belongsTo('CompanyInfo', 'company_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
