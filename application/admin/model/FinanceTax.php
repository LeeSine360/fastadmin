<?php

namespace app\admin\model;

use think\Model;


class FinanceTax extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'finance_tax';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'starttime_text',
        'creattime_text'
    ];
    

    



    public function getStarttimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['starttime']) ? $data['starttime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreattimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['creattime']) ? $data['creattime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setStarttimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setCreattimeAttr($value)
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
