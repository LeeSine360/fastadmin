<?php

namespace app\admin\controller\contract;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Info extends Backend
{
    
    /**
     * Info模型对象
     * @var \app\admin\model\contract\Info
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\ContractInfo;

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
                    ->with(['projectinfo','projectsection','companyinfo','category','admin'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = Db::table([                             
                                '__PROJECT_SECTION__' => 'project_section',
                                '__CONTRACT_INFO__' => 'contract_info'
                            ])  
                    ->field('
                        contract_info.id as id,
                        CONCAT(project_info.number,\'-材\',contract_info.number) as number,
                        project_info.name as projectName,
                        GROUP_CONCAT(project_section.name) as sectionName,
                        company_info.name as companyName,
                        contract_info.name as contractName,
                        category.name as categoryName,
                        contract_info.price as contractPrice,
                        contract_info.total as contractTotal,
                        contract_info.save as contractSave,
                        contract_info.phone as contractPhone,
                        contract_info.operatorname as contractOperatorName,
                        contract_info.operatorphone as contractOperatorPhone,
                        contract_info.createtime as contractCreateTime,
                        contract_project.savedata as projectSavedata,
                        contract_synthetical.agreedata as syntheticalAgreedata,
                        contract_verify.agreedata as verifyAgreedata
                    ')
                    ->join('__PROJECT_INFO__ project_info','contract_info.project_info_id = project_info.id')
                    ->join('__COMPANY_INFO__ company_info','contract_info.company_info_id = company_info.id')
                    ->join('__CATEGORY__ category','contract_info.category_id = category.id')
                    ->join('__CONTRACT_PROJECT__ contract_project','contract_info.id = contract_project.contract_info_id','LEFT')
                    ->join('__CONTRACT_VERIFY__ contract_verify','contract_info.id = contract_verify.contract_info_id','LEFT')
                    ->join('__CONTRACT_SYNTHETICAL__ contract_synthetical','contract_info.id = contract_synthetical.contract_info_id','LEFT')
                    ->where('FIND_IN_SET(project_section.id,project_section_ids)')
                    ->where($where)
                    ->order($sort, $order)     
                    ->select();
            
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
}
