<?php

namespace app\admin\controller\finance;

use app\common\controller\Backend;
use think\Db;

/**
 * 供应商付款
 *
 * @icon fa fa-circle-o
 */
class Payconfirm extends Backend
{
    
    /**
     * Companypay模型对象
     * @var \app\admin\model\finance\Companypay
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\FinancePayconfirm;

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
                    ->with(['financeinfo','admin'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = Db::table([                             
                                '__FINANCE_PAYCONFIRM__' => 'finance_payconfirm'
                            ])  
                    ->field('
                        finance_payconfirm.id as id,
                        finance_info.id as financeId,
                        project_info.name as projectName,
                        project_section.name as sectionName,
                        company_info.name as companyName,
                        category.name as categoryName,
                        finance_info.price as financePrice,
                        finance_payconfirm.payprice as payprice,
                        finance_info.contacts as financeContacts,
                        finance_info.phone as financePhone,
                        finance_info.remark as financeRemark,
                        finance_project.agreedata as projectAgreeData,
                        finance_verify.agreedata as verifyAgreeData,
                        CONCAT(finance_project.opinion,finance_verify.opinion) as opinion,
                        finance_payconfirm.createtime as createTime
                    ')
                    ->join('__FINANCE_INFO__ finance_info','finance_info.id = finance_payconfirm.finance_info_id')
                    ->join('__FINANCE_PROJECT__ finance_project','finance_info.id = finance_project.finance_info_id')
                    ->join('__FINANCE_VERIFY__ finance_verify','finance_info.id = finance_verify.finance_info_id')
                    ->join('__PROJECT_INFO__ project_info','finance_info.project_info_id = project_info.id')
                    ->join('__PROJECT_SECTION__ project_section','finance_info.project_section_id = project_section.id')
                    ->join('__COMPANY_INFO__ company_info','finance_info.company_info_id = company_info.id')
                    ->join('__CATEGORY__ category','finance_info.category_id = category.id')
                    ->where(['finance_project.agreedata' => 'agree','finance_verify.agreedata' => 'agree'])
                    ->where('finance_payconfirm.state','wait')
                    ->order($sort, $order)
                    ->select();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    //确认付款
    public function confirm($ids = null){
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }

        $list = Db::table([                             
            '__FINANCE_PAYCONFIRM__' => 'finance_payconfirm'
        ])
        ->join('__FINANCE_INFO__ finance_info','finance_info.id = finance_payconfirm.finance_info_id')
        ->join('__FINANCE_PROJECT__ finance_project','finance_info.id = finance_project.finance_info_id')
        ->join('__FINANCE_VERIFY__ finance_verify','finance_info.id = finance_verify.finance_info_id')
        ->where(['finance_project.agreedata' => 'agree','finance_verify.agreedata' => 'agree'])
        ->where('finance_payconfirm.id',$ids)
        ->select();

        if(!empty($list)){
            $row->state = 'yes';
            $result =   $row->save();
            if ($result !== false) {
                $this->success();
            }
        }else {
            $this->error(__('审核流程未完成！'));
        }  
    }
}
