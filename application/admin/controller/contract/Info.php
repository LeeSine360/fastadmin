<?php

namespace app\admin\controller\contract;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Info extends Backend {

	/**
	 * Info模型对象
	 * @var \app\admin\model\contract\Info
	 */
	protected $model = null;
	protected $projectModel = null;
	protected $projectSectionModel = null;
	protected $companyModel = null;

	public function _initialize() {
		parent::_initialize();
		$this->model = new \app\admin\model\ContractInfo;
		$this->projectModel = model('ProjectInfo');
		$this->projectSectionModel = model('ProjectSection');
		$this->companyModel = model('CompanyInfo');
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
		$this->relationSearch = true;
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isAjax()) {
			//如果发送的来源是Selectpage，则转发到Selectpage
			if ($this->request->request('keyField')) {
				return $this->selectpage();
			}
			list($where, $sort, $order, $offset, $limit) = $this->buildparams('number');
			$total = $this->model
				->with(['projectInfo', 'projectSection', 'companyInfo', 'category'])
				->where($where)
				->order($sort, $order)
				->count();

			$list = $this->model
				->with(['projectInfo', 'projectSection', 'companyInfo', 'category'])
				->where($where)
				->order($sort, $order)
				->limit($offset, $limit)
				->select();

			$list = addtion($list, 'project_section_ids');
			
			foreach ($list as $row) {
				$row->visible(['id', 'name', 'number', 'phone', 'signdate', 'expirydate', 'price', 'operatorname', 'operatorphone', 'createtime', 'project_section_names']);
				$row->visible(['project_info']);
				$row->getRelation('project_info')->visible(['short']);
				//$row->visible(['project_section']);
				//$row->getRelation('project_section')->visible(['name']);
				$row->visible(['company_info']);
				$row->getRelation('company_info')->visible(['name']);
				$row->visible(['category']);
				$row->getRelation('category')->visible(['name']);
			}
			$list = collection($list)->toArray();
			$result = array("total" => $total, "rows" => $list);

			return json($result);
		}
		return $this->view->fetch();
	}

	public function import() {
		$file = $this->request->request('file');
		if (!$file) {
			$this->error(__('Parameter %s can not be empty', 'file'));
		}
		$filePath = ROOT_PATH . DS . 'public' . DS . $file;
		if (!is_file($filePath)) {
			$this->error(__('No results were found'));
		}
		$PHPReader = new \PHPExcel_Reader_Excel2007();
		if (!$PHPReader->canRead($filePath)) {
			$PHPReader = new \PHPExcel_Reader_Excel5();
			if (!$PHPReader->canRead($filePath)) {
				$PHPReader = new \PHPExcel_Reader_CSV();
				if (!$PHPReader->canRead($filePath)) {
					$this->error(__('Unknown data format'));
				}
			}
		}

		//导入文件首行类型,默认是注释,如果需要使用字段名称请使用name
		$importHeadType = isset($this->importHeadType) ? $this->importHeadType : 'comment';

		$table = $this->model->getQuery()->getTable();
		$database = \think\Config::get('database.database');
		$fieldArr = [];
		$list = db()->query("SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?", [$table, $database]);
		foreach ($list as $k => $v) {
			if ($importHeadType == 'comment') {
				$fieldArr[$v['COLUMN_COMMENT']] = $v['COLUMN_NAME'];
			} else {
				$fieldArr[$v['COLUMN_NAME']] = $v['COLUMN_NAME'];
			}
		}

		$PHPExcel = $PHPReader->load($filePath); //加载文件
		$currentSheet = $PHPExcel->getSheet(0); //读取文件中的第一个工作表
		$allColumn = $currentSheet->getHighestDataColumn(); //取得最大的列号
		$allRow = $currentSheet->getHighestRow(); //取得一共有多少行
		$maxColumnNumber = \PHPExcel_Cell::columnIndexFromString($allColumn);
		for ($currentRow = 1; $currentRow <= 1; $currentRow++) {
			for ($currentColumn = 0; $currentColumn < $maxColumnNumber; $currentColumn++) {
				$val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
				$fields[] = $val;
			}
		}
		$insert = [];
		for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
			$values = [];
			for ($currentColumn = 0; $currentColumn < $maxColumnNumber; $currentColumn++) {
				$val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
				$values[] = is_null($val) ? '' : trim($val);
			}
			$row = [];

			$temp = array_combine($fields, $values);
			foreach ($temp as $k => $v) {
				if (isset($fieldArr[$k]) && $k !== '') {
					$row[$fieldArr[$k]] = $v;
				}
			}

			if ($row) {
				$projectName = $this->projectModel->get(['short' => $row['project_info_id']]);
				$sectionName = explode("、", $row['project_section_ids']);
				$companyName = $this->companyModel->get(['name' => $row['company_info_id']]);

				$sectionArr = [];

				foreach ($sectionName as $value) {
					$sectionObj = $this->projectSectionModel->get(['name' => $value]);
					if ($sectionObj) {
						$sectionArr[] = $sectionObj->id;
					} else {
						break;
					}
				}

				if ($projectName) {
					$row['project_info_id'] = $projectName->id;
				}
				if ($sectionArr) {
					$row['project_section_ids'] = implode(",", $sectionArr);
				}
				if ($companyName) {
					$row['company_info_id'] = $companyName->id;
				} else {
					continue;
				}

				$insert[] = $row;

			}
		}

		if (!$insert) {
			$this->error(__('No rows were updated'));
		}

		try {
			$this->model->saveAll($insert);
		} catch (\think\exception\PDOException $exception) {
			$this->error($exception->getMessage());
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}

		$this->success();

	}

	public function category() {
		$categoryModel = model('app\common\model\Category');

		$categorydata = collection($categoryModel->where(['type' => 'classify', 'pid' => 0])->order('weigh desc,id desc')->select())->toArray();

		$this->view->assign("parentList", $categorydata);
		return $this->view->fetch();
	}
}
