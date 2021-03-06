<?php

namespace app\admin\controller\contract;

use app\common\controller\Backend;
use think\Db;

/**
 * 合同审核（综合部）
 *
 * @icon fa fa-circle-o
 */
class Synthetical extends Backend
{
    
    /**
     * Synthetical模型对象
     * @var \app\admin\model\contract\Synthetical
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\ContractSynthetical;
        $this->view->assign("agreedataList", $this->model->getAgreedataList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['contractinfo','admin'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = Db::table([     
                                '__CONTRACT_SYNTHETICAL__' => 'contract_synthetical'
                            ])  
                    ->field('
                        contract_synthetical.id as id,
                        CONCAT(project_info.number,\'-材\',contract_info.number) as contractInfoNumber,
                        contract_info.name as contractInfoName,
                        contract_synthetical.agreedata as agreedata,
                        contract_synthetical.opinion,
                        contract_synthetical.number,
                        contract_synthetical.contacts,
                        contract_synthetical.phone,
                        contract_synthetical.createtime
                    ')
                    ->join('__CONTRACT_INFO__ contract_info','contract_info.id = contract_synthetical.contract_info_id')
                    ->join('__PROJECT_INFO__ project_info','contract_info.project_info_id = project_info.id')       
                    ->where($where)
                    ->order($sort, $order)     
                    ->select();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
}
