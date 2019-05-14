<?php

namespace app\admin\controller\contract;

use app\common\controller\Backend;
use think\Db;

/**
 * 合同审核（项目副总）
 *
 * @icon fa fa-circle-o
 */
class Verify extends Backend {

	/**
	 * Verify模型对象
	 * @var \app\admin\model\contract\Verify
	 */
	protected $model = null;

	public function _initialize() {
		parent::_initialize();
		$this->model = new \app\admin\model\ContractVerify;
		$this->view->assign("agreedataList", $this->model->getAgreedataList());
	}

	/**
	 * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
	 * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
	 * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
	 */

<<<<<<< HEAD
            foreach ($list as $row) {
                $row->visible(['id','contract_info_id','agreedata','opinion','createtime']);
                $row->visible(['info']);
				$row->getRelation('info')->visible(['name','number','project_info_id','project_section_ids','company_info_id','category_id','label_ids','contacts','phone','price','total','save','operatorname','operatorphone','settlement','content','createtime']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
=======
	/**
	 * 查看
	 */
	public function index() {
		//当前是否为关联查询
		$this->relationSearch = true;
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isAjax()) {
			//如果发送的来源是Selectpage，则转发到Selectpage
			if ($this->request->request('keyField')) {
				return $this->selectpage();
			}
			list($where, $sort, $order, $offset, $limit) = $this->buildparams();
			$total = $this->model
				->with(['contractInfo'])
				->where($where)
				->order($sort, $order)
				->count();
>>>>>>> 39676902148da64e4614141bdf0430d75b34fdb0

			$list = Db::table('fa_contract_verify')
				->alias('contract_verify')
				->join('contract_info c', 'contract_verify.contract_info_id = c.id', 'LEFT')
				->join('project_info p', 'c.project_info_id = p.id', 'LEFT')
				->join('company_info com', 'c.company_info_id = com.id', 'LEFT')
				->join('category cat', 'c.label_ids = cat.id', 'LEFT')
				->field('
					contract_verify.id,
					contract_verify.agreedata,
					com.name as companyName,
					c.name as contractName,
					c.number as contractNumber,
					c.total,
					c.price,
					c.project_section_ids,
					c.createtime,
					c.phone as contractPhone,
					p.short as projectName,
					cat.name as categoryName
				')
				->where($where)
				->order($sort, $order)
				->limit($offset, $limit)
				->select();
			$list = addtion($list, 'project_section_ids');
			//return $list;

			//return collection($list)->toArray();

			/*foreach ($list as $row) {
				$row->visible(['id', 'agreedata', 'opinion', 'createtime', 'name', 'number', 'project_info_name', 'project_section_names', 'company_info_id', 'category_id', 'label_ids', 'contacts', 'phone', 'price', 'total', 'save', 'operatorname', 'operatorphone', 'settlement', 'content', 'createtime']);
			}*/
			$list = collection($list)->toArray();
			$result = array("total" => $total, "rows" => $list);

			return json($result);
		}
		return $this->view->fetch();
	}
}
