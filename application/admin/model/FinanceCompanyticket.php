<?php

namespace app\admin\model;

use think\Model;

class FinanceCompanyticket extends Model
{
    // 表名
    protected $name = 'finance_companyticket';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'categorydata_text'
    ];
    

    
    public function getCategorydataList()
    {
        return ['vat' => __('Categorydata vat'),'general' => __('Categorydata general')];
    }     


    public function getCategorydataTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['categorydata']) ? $data['categorydata'] : '');
        $list = $this->getCategorydataList();
        return isset($list[$value]) ? $list[$value] : '';
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
}
