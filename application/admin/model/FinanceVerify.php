<?php

namespace app\admin\model;

use think\Model;

class FinanceVerify extends Model
{
    // 表名
    protected $name = 'finance_verify';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'project_agreedata_text',
        'finance_agreedata_text'
    ];
    

    
    public function getProjectAgreedataList()
    {
        return ['wait' => __('Project_agreedata wait'),'agree' => __('Project_agreedata agree'),'veto' => __('Project_agreedata veto')];
    }     

    public function getFinanceAgreedataList()
    {
        return ['wait' => __('Finance_agreedata wait'),'agree' => __('Finance_agreedata agree'),'veto' => __('Finance_agreedata veto')];
    }     


    public function getProjectAgreedataTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['project_agreedata']) ? $data['project_agreedata'] : '');
        $list = $this->getProjectAgreedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getFinanceAgreedataTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['finance_agreedata']) ? $data['finance_agreedata'] : '');
        $list = $this->getFinanceAgreedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function info()
    {
        return $this->belongsTo('FinanceInfo', 'finance_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
