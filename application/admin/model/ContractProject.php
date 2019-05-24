<?php

namespace app\admin\model;

use think\Model;


class ContractProject extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'contract_project';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'savedata_text'
    ];
    

    
    public function getSavedataList()
    {
        return ['wait' => __('Savedata wait'), 'normal' => __('Savedata normal'), ' back' => __('Savedata  back'), ' delet' => __('Savedata  delet'), ' end' => __('Savedata end')];
    }


    public function getSavedataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['savedata']) ? $data['savedata'] : '');
        $list = $this->getSavedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function contractinfo()
    {
        return $this->belongsTo('app\admin\model\ContractInfo', 'contract_info_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('app\admin\model\Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
