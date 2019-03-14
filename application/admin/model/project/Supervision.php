<?php

namespace app\admin\model\project;

use think\Model;

class Supervision extends Model
{
    // 表名
    protected $name = 'project_supervision';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    

    







}
