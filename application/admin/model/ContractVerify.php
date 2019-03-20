<?php

namespace app\admin\model;

use think\Model;

class ContractVerify extends Model
{
    // 表名
    protected $name = 'contract_verify';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'agreedata_text',
        'sealdata_text',
        'savedata_text'
    ];
    

    
    public function getAgreedataList()
    {
        return ['wait' => __('Agreedata wait'),'agree' => __('Agreedata agree'),'veto' => __('Agreedata veto')];
    }     

    public function getSealdataList()
    {
        return ['wait' => __('Sealdata wait'),'agree' => __('Sealdata agree'),'veto' => __('Sealdata veto')];
    }     

    public function getSavedataList()
    {
        return ['wait' => __('Savedata wait'),'normal' => __('Savedata normal'),' back' => __('Savedata  back'),' borrow' => __('Savedata  borrow'),' delet' => __('Savedata  delet')];
    }     


    public function getAgreedataTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['agreedata']) ? $data['agreedata'] : '');
        $list = $this->getAgreedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getSealdataTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['sealdata']) ? $data['sealdata'] : '');
        $list = $this->getSealdataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getSavedataTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['savedata']) ? $data['savedata'] : '');
        $list = $this->getSavedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function info()
    {
        return $this->belongsTo('ContractInfo', 'contract_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
