<?php

namespace app\admin\model;

use think\Model;

class Company extends Model
{
    // 表名
    protected $name = 'company';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'datumdata_text'
    ];
    

    
    public function getDatumdataList()
    {
        return ['license' => __('Datumdata license'),'id' => __('Datumdata id'),'bank' => __('Datumdata bank'),'other' => __('Datumdata other')];
    }     


    public function getDatumdataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['datumdata']) ? $data['datumdata'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getDatumdataList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

    protected function setDatumdataAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }


}
