<?php

namespace app\admin\model;

use think\Model;


class FinanceCompanyticket extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'finance_companyticket';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'updateTime_text'
    ];
    

    



    public function getUpdatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['updateTime']) ? $data['updateTime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setUpdatetimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


    public function projectinfo()
    {
        return $this->belongsTo('app\admin\model\ProjectInfo', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectsection()
    {
        return $this->belongsTo('app\admin\model\ProjectSection', 'project_section_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
