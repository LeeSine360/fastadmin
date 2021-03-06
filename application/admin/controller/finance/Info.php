<?php

namespace app\admin\controller\finance;

use app\common\controller\Backend;
use think\Db;

/**
 * 报账单
 *
 * @icon fa fa-circle-o
 */
class Info extends Backend
{
    
    /**
     * Info模型对象
     * @var \app\admin\model\finance\Info
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\FinanceInfo;

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

            $list = $this->model
                    ->with(['projectinfo','projectsection','companyinfo','category','admin'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->visible(['id','price','contacts','phone','remark','createtime']);
                $row->visible(['projectinfo']);
				$row->getRelation('projectinfo')->visible(['name']);
				$row->visible(['projectsection']);
				$row->getRelation('projectsection')->visible(['name']);
				$row->visible(['companyinfo']);
				$row->getRelation('companyinfo')->visible(['name']);
				$row->visible(['category']);
				$row->getRelation('category')->visible(['name']);
				$row->visible(['admin']);
				$row->getRelation('admin')->visible(['username']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        $list = model('Category')->where(['type' => 'cost'])->select();
        foreach ($list as $row) {
            $row->visible(['id','name']);
        }
        $list = collection($list)->toArray();
        $this->view->assign("categoryList", $list);
        return $this->view->fetch();
    }

    public function label(){
        $custom = (array)$this->request->request("custom/a");

        if ($custom && is_array($custom)) {
            $list = Db::table([                             
                                '__CONTRACT_INFO__' => 'contract_info'])  
                    ->field('
                        category.id as id,
                        category.name as name
                    ')
                    ->join('__CATEGORY__ category',"contract_info.category_id = category.id")                
                    ->where('contract_info.project_info_id',$custom['project_info_id'])
                    ->where('contract_info.project_section_ids',$custom['section_info_id'])
                    ->where('contract_info.company_info_id',$custom['company_info_id'])
                    ->select();

            return json(['list' => $list]);
        }
    }
}
