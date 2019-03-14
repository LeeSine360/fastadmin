<?php

namespace app\admin\model\project;

use think\Model;

class Section extends Model
{
    // 表名
    protected $name = 'project_section';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    

    







    public function info()
    {
        return $this->belongsTo('Info', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function manager()
    {
        return $this->belongsTo('Manager', 'project_manager_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
