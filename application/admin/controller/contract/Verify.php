<?php

namespace app\admin\controller\contract;

use app\common\controller\Backend;
use think\Db;

/**
 * 合同审核（项目副总）
 *
 * @icon fa fa-circle-o
 */
class Verify extends Backend
{
    
    /**
     * Verify模型对象
     * @var \app\admin\model\contract\Verify
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\ContractVerify;        
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
                    //->where($where)
                    ->order($sort, $order)
                    ->select();

            /*foreach ($list as $row) {
                $row->visible(['id','agreedata','opinion','createtime']);
                $row->visible(['contractinfo']);
				$row->getRelation('contractinfo')->visible(['name']);
				$row->visible(['admin']);
				$row->getRelation('admin')->visible(['username']);
            }
            $list = collection($list)->toArray();*/
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    //审核
    public function examine($ids = null){
        /*$params = $this->request->post("row/a");*/
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            $projectList = Db::table([                             
                            '__CONTRACT_INFO__' => 'contract_info'
                        ])  
                ->field('
                    `project_section`.`price` AS sectonPrice,
                    sum(`finance_payconfirm`.`payprice`) AS payPrice')
                ->join('__PROJECT_SECTION__ project_section','FIND_IN_SET(`project_section`.`id`,`contract_info`.`project_section_ids`)')
                ->join('__FINANCE_INFO__ finance_info','`finance_info`.`project_section_id`=`project_section`.`id`')
                ->join('__FINANCE_PAYCONFIRM__ finance_payconfirm','`finance_payconfirm`.`finance_info_id`=`finance_info`.`id`')
                ->where('contract_info.id',$ids)
                ->where('finance_payconfirm.state','yes')
                ->select();

            $payList = Db::table([                             
                            '__CONTRACT_INFO__' => 'contract_info'
                        ])  
                ->field('
                    `category.name` AS name,
                    `` AS value')
                ->join('__PROJECT_SECTION__ project_section','FIND_IN_SET(`project_section`.`id`,`contract_info`.`project_section_ids`)')
                ->join('__FINANCE_INFO__ finance_info','`finance_info`.`project_section_id`=`project_section`.`id`')
                ->join('__FINANCE_PAYCONFIRM__ finance_payconfirm','`finance_payconfirm`.`finance_info_id`=`finance_info`.`id`')
                ->where('contract_info.id',$ids)
                ->where('finance_payconfirm.state','yes')
                ->select();

            /*$this->view->assign([
                'totaluser'        => 35200,
                'totalviews'       => 219390,
                'totalorder'       => 32143,
                'totalorderamount' => 174800,
                'todayuserlogin'   => 321,
                'todayusersignup'  => 430,
                'todayorder'       => 2324,
                'unsettleorder'    => 132,
                'sevendnu'         => '80%',
                'sevendau'         => '32%'
            ]);*/
            return $this->view->fetch();
        }
        $list = Db::table([                             
                            '__CONTRACT_INFO__' => 'contract_info'
                        ])  
                ->field('
                    contract_info.id as id,
                    project_info.name as projectName,
                    GROUP_CONCAT(project_section.name) as sectionName,
                    project_manager.name as managerName,
                    company_info.name as companyName,
                    company_info.phone as companyPhone,
                    contract_info.name as contractName,
                    contract_info.price as contractPrice,
                    category.name as categoryName,
                    category.id as categoryId,
                    contract_info.settlement as contractSettlement,
                    contract_info.createtime as contractCreateTime
                ')
                ->join('__PROJECT_INFO__ project_info','project_info.id = contract_info.project_info_id')
                ->join('__PROJECT_SECTION__ project_section','FIND_IN_SET(project_section.id,contract_info.project_section_ids)')
                ->join('__CATEGORY__ category','category.id = contract_info.category_id')
                ->join('__COMPANY_INFO__ company_info','company_info.id = contract_info.company_info_id')
                ->join('__PROJECT_MANAGER__ project_manager','project_manager.id = project_section.project_manager_id')
                ->where('contract_info.id',$ids)
                ->select();

        $this->view->assign("agreedataList", $this->model->getAgreedataList());
        $this->view->assign("list", $list[0]);
        return $this->view->fetch();
    }

    /**
     * 查看付款详情
     */
    public function payinfo()
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
                    //->where($where)
                    ->order($sort, $order)
                    ->select();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    //查看同类型合同明细
    public function contract(){
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
                    //->where($where)
                    ->order($sort, $order)
                    ->select();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
}
