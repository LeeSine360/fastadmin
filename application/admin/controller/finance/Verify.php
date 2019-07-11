<?php

namespace app\admin\controller\finance;

use app\common\controller\Backend;
use think\Db;

/**
 * 审核(财务副总)
 *
 * @icon fa fa-circle-o
 */
class Verify extends Backend
{
    
    /**
     * Verify模型对象
     * @var \app\admin\model\finance\Verify
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\FinanceVerify;
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
                    ->with(['admin','financeinfo'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = Db::table([                             
                                '__FINANCE_VERIFY__' => 'finance_verify'
                            ])  
                    ->field('
                        finance_verify.id as id,
                        finance_info.id as financeId,
                        project_info.name as projectName,
                        project_section.name as sectionName,
                        company_info.name as companyName,
                        category.name as categoryName,
                        finance_info.price as financePrice,
                        finance_info.contacts as financeContacts,
                        finance_info.phone as financePhone,
                        finance_info.remark as financeRemark,
                        finance_verify.agreedata as agreeData,
                        finance_verify.createtime as createTime
                    ')
                    ->join('__FINANCE_INFO__ finance_info','finance_info.id = finance_verify.finance_info_id')
                    ->join('__PROJECT_INFO__ project_info','finance_info.project_info_id = project_info.id')
                    ->join('__PROJECT_SECTION__ project_section','finance_info.project_section_id = project_section.id')
                    ->join('__COMPANY_INFO__ company_info','finance_info.company_info_id = company_info.id')
                    ->join('__CATEGORY__ category','finance_info.category_id = category.id')
                    ->where($where)
                    ->order($sort, $order)   
                    ->select();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

     //审核
    public function examine(){
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
                                '__PROJECT_SECTION__' => 'project_section',
                                '__CONTRACT_VERIFY__' => 'contract_verify'
                            ])  
                    ->field('
                        contract_info.id as id,
                        CONCAT(project_info.number,\'-材\',contract_info.number) as number,
                        project_info.name as projectName,
                        GROUP_CONCAT(project_section.name) as sectionName,
                        company_info.name as companyName,
                        contract_info.name as contractName,
                        contract_info.createtime as contractCreateTime
                    ')
                    ->join('__CONTRACT_INFO__ contract_info','contract_info.id = contract_verify.contract_info_id')
                    ->join('__PROJECT_INFO__ project_info','contract_info.project_info_id = project_info.id')
                    ->join('__COMPANY_INFO__ company_info','contract_info.company_info_id = company_info.id')
                    ->where('FIND_IN_SET(project_section.id,contract_info.project_section_ids)')
                    ->where($where)
                    ->order($sort, $order)
                    ->select();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
}
