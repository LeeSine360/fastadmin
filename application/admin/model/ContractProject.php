<?php

namespace app\admin\model;

use think\Model;

class ContractProject extends Model
{
    // 表名
    protected $name = 'contract_project';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'savedata_text'
    ];
    

    
    public function getSavedataList()
    {
        return ['wait' => __('Savedata wait'),'normal' => __('Savedata normal'),' back' => __('Savedata  back'),' delet' => __('Savedata  delet')];
    }     


    public function getSavedataTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['savedata']) ? $data['savedata'] : '');
        $list = $this->getSavedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function info()
    {
        return $this->belongsTo('ContractInfo', 'contract_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
