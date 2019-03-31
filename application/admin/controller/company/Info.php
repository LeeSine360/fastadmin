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
				->with(['admin'])
				->where($where)
				->order($sort, $order)
				->count();

			$list = $this->model
				->with(['admin'])
				->where($where)
				->order($sort, $order)
				->limit($offset, $limit)
				->select();

			foreach ($list as $row) {
				$row->visible(['name', 'code', 'phone', 'account', 'bankname']);
				$row->visible(['admin']);
				$row->getRelation('admin')->visible(['username']);
			}
			$list = collection($list)->toArray();
			$result = array("total" => $total, "rows" => $list);

			return json($result);
		}
		return $this->view->fetch();
	}

	private function getCompanyData($key) {
		//$key = $this->request->get("key", '');
		$url = "https://xin.baidu.com/";
		$txt = file_get_contents($url . "s?q=" . $key);

		$start = stripos($txt, 'zx-list-op-mask');
		$end = stripos($txt, 'zx-side-con') - $start;
		$subString = substr($txt, $start, $end);

		preg_match_all("/zx-list-item-url(.*)company/U", $subString, $pat_array);

		foreach ($pat_array[0] as $key => $value) {
			preg_match("/compinfo\?pid=(.*)\"/U", $value, $url_array);
			preg_match("/title=\"(.*)\"/U", $value, $name_array);

			if ($name_array[1] == $key) {
				$jsonTxt = file_get_contents($url . "detail/basicAjax?pid=" . $url_array[1]);
				return json_decode($jsonTxt, true);
			}
		}
	}
	public function test($key) {
		$key = $this->request->get("key", '');
		$url = "https://xin.baidu.com/";
		$txt = file_get_contents($url . "s?q=" . $key);

		$start = stripos($txt, 'zx-list-op-mask');
		$end = stripos($txt, 'zx-side-con') - $start;
		$subString = substr($txt, $start, $end);

		preg_match_all("/zx-list-item-url(.*)company/U", $subString, $pat_array);

		foreach ($pat_array[0] as $key => $value) {
			preg_match("/compinfo\?pid=(.*)\"/U", $value, $url_array);
			preg_match("/title=\"(.*)\"/U", $value, $name_array);

			if ($name_array[1] == $key) {
				$jsonTxt = file_get_contents($url . "detail/basicAjax?pid=" . $url_array[1]);
				return $jsonTxt;
			}
		}
	}

	/**
	 * 导入
	 */
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
		$noInsertList = [];
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
				//$insert[] = $row['name'];
				$data = $this->getCompanyData($row['name']);
				if ($data['data']['entName'] == $row['name']) {
					$insert[] = array(
						'name' => $data['data']['entName'],
						'code' => $data['data']['regNo'],
						'type' => $data['data']['entType'],
						'status' => $data['data']['openStatus'],
						'regCapital' => $data['data']['regCapital'],
						'scope' => $data['data']['scope'],
						'address' => $data['data']['regAddr'],
						'contacts' => $data['data']['legalPerson'],
					);
				} else {
					$noInsertList[] = $row['name'];
				}
				//sleep(5);
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

		if ($noInsertList) {
			return json($noInsertList);
		}
		$this->success();

	}

}
