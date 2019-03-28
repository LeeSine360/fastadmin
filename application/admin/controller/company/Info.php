<?php

namespace app\admin\controller\company;

use app\common\controller\Backend;

/**
 * 供应商信息
 *
 * @icon fa fa-circle-o
 */
class Info extends Backend {

	/**
	 * Info模型对象
	 * @var \app\admin\model\company\Info
	 */
	protected $model = null;

	public function _initialize() {
		parent::_initialize();
		$this->model = new \app\admin\model\CompanyInfo;

	}

	/**
	 * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
	 * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
	 * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
	 */

	/**
	 * 查看
	 */
	public function index() {
		//当前是否为关联查询
		$this->relationSearch = false;
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isAjax()) {
			//如果发送的来源是Selectpage，则转发到Selectpage
			if ($this->request->request('keyField')) {
				return $this->selectpage();
			}
			list($where, $sort, $order, $offset, $limit) = $this->buildparams();
			$total = $this->model

				->where($where)
				->order($sort, $order)
				->count();

			$list = $this->model

				->where($where)
				->order($sort, $order)
				->limit($offset, $limit)
				->select();

			foreach ($list as $row) {
				$row->visible(['id', 'name', 'code', 'city', 'contacts', 'phone', 'account', 'bankname', 'uploadimages', 'createtime']);

			}
			$list = collection($list)->toArray();
			$result = array("total" => $total, "rows" => $list);

			return json($result);
		}
		return $this->view->fetch();
	}

	public function test() {
		$string = "湖南浩宇建设有限公司";
		$txt = file_get_contents("https://www.qichacha.com/search?key=" . $string);
		$start = stripos($txt, 'search-result');
		$end = stripos($txt, 'excelTipsModalBody');
		$result = substr($txt, $start, $end);

		preg_match_all("/href=\"\/firm_(.*)<\/a>/U", $result, $pat_array);

		foreach ($pat_array[0] as $key => $value) {
			$companyNameStart = strpos($value, '>') + 1;
			$companyName = substr($value, $companyNameStart);

			$vowels = array("<em>", "</em>", "</a>");
			$onlyconsonants = str_replace($vowels, "", $companyName);

			if ($onlyconsonants == $string) {
				echo $value;
				//preg_match('/"(.*)"/U', $value, $context);
				//echo $context[0];
			}
		}
		//return $result;
	}
}
