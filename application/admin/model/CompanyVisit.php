<?php

namespace app\admin\model;

use think\Model;


class CompanyVisit extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'company_visit';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'state_text',
        'completedata_text'
    ];
    

    
    public function getStateList()
    {
        return ['call' => __('State call'), 'wait' => __('State wait'), 'error' => __('State error')];
    }

    public function getCompletedataList()
    {
        return ['no' => __('No'), 'yes' => __('Yes')];
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getStateList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getCompletedataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['completedata']) ? $data['completedata'] : '');
        $list = $this->getCompletedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setStateAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }


    public function projectinfo()
    {
        return $this->belongsTo('app\admin\model\ProjectInfo', 'project_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projectsection()
    {
        return $this->belongsTo('app\admin\model\ProjectSection', 'project_section_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function companyinfo()
    {
        return $this->belongsTo('app\admin\model\CompanyInfo', 'company_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('app\admin\model\Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
