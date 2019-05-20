<?php

namespace app\admin\model;

use think\Model;


class ProjectSection extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'project_section';
    
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
        return $this->belongsTo('app\admin\model\ProjectInfo', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectmanager()
    {
        return $this->belongsTo('app\admin\model\ProjectManager', 'project_manager_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('app\admin\model\Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
