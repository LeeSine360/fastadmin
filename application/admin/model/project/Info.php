<?php

namespace app\admin\model\project;

use think\Model;

class Info extends Model
{
    // 表名
    protected $name = 'project_info';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'starttime_text'
    ];
    

    



    public function getStarttimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['starttime']) ? $data['starttime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setStarttimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


    public function build()
    {
        return $this->belongsTo('Build', 'project_build_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function supervision()
    {
        return $this->belongsTo('Supervision', 'project_supervision_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}