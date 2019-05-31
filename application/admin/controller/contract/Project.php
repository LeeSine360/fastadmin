<?php

namespace app\admin\controller\contract;

use app\common\controller\Backend;
use think\Db;

/**
 * 合同审核（项目管理部）
 *
 * @icon fa fa-circle-o
 */
class Project extends Backend
{
    
    /**
     * Project模型对象
     * @var \app\admin\model\contract\Project
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\ContractProject;
        $this->view->assign("savedataList", $this->model->getSavedataList());
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
            					'__CONTRACT_PROJECT__' => 'contract_project'
            				])	
            		->field('
            			contract_project.id as id,
            			CONCAT(project_info.number,\'-材\',contract_info.number) as number,
            			project_info.name as projectName,
            			GROUP_CONCAT(project_section.name) as sectionName,
            			company_info.name as companyName,
            			contract_info.name as contractName,
            			contract_project.savedata as savedata,
					    contract_info.save as save,
					    contract_info.operatorname as operatorname,
					    contract_info.operatorphone as operatorphone,
					    contract_info.createtime as createtime
            			')
            		->join('__CONTRACT_INFO__ contract_info','contract_project.contract_info_id = contract_info.id')
            		->join('__PROJECT_INFO__ project_info','project_info.id = contract_info.project_info_id')
            		->join('__COMPANY_INFO__ company_info','company_info.id = contract_info.company_info_id')
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
