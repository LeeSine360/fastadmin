<?php

namespace app\admin\controller\flow;

use app\common\controller\Backend;
use fast\Tree;
use app\admin\model\AuthGroup;
use think\Db;
use think\Config;
use think\console\Input;
use app\admin\model\Command;

/**
 * 流程设计
 *
 * @icon fa fa-database
 */
class Scheme extends Backend
{

    /**
     * Scheme模型对象
     * @var \app\admin\model\flow\Scheme
     */
    protected $model = null;
    protected $bizscheme = null;
    protected $command = null;
    protected $runtime = null;
    protected $task = null;
    protected $prefix = "";
    protected $noNeedRight = ['*'];

    public function _initialize()
    {
        $this->prefix = Config::get('database.prefix');
        parent::_initialize();
        $this->model = new \app\admin\model\flow\Scheme;
        $this->bizscheme = new \app\admin\model\flow\Bizscheme;
        $grouplist = collection(model('AuthGroup')->select())->toArray();
        //获取部门下拉框
        Tree::instance()->init($grouplist);
        $groupdata = [];
        $result = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0));
        foreach ($result as $k => $v) {
            $groupdata[$v['id']] = $v['name'];
        }

        $this->view->assign('groupdata', $groupdata);
    }

    /**
     * 查看
     */
    public function index()
    {
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
                $row->visible(['id', 'flowcode', 'flowname', 'flowversion', 'weight', 'url', 'isenable']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $flowcode = $params['flowcode'];
            $prefix = Config::get('database.prefix');
            $bizScheme = $prefix . 'flow_' . $flowcode;
            $params['bizscheme'] = $bizScheme;
            //$params = $this->request->post("row/a");
            if ($params) {
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                    $this->model->validate($validate);
                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
                        $sql = "DROP TABLE IF EXISTS $bizScheme";
                        Db::execute($sql);
                        $sql = "CREATE TABLE $bizScheme ( id char(36) primary key ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";
                        Db::execute($sql);
                        $this->success();
                    } else {
                        $this->error($this->model->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
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
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    $result = $row->allowField(true)->save(['flowname' => $params['flowname']]);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $count = $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();
            foreach ($list as $k => $v) {
                $this->model->where('id', $v['id'])->delete();

                $flowcode = $v['flowcode'];;
                $table = $v['bizscheme'];
                if ($v['isenable'] == '1') {
                    //生成curd
                    $commandtype = 'FlowCrud';
                    $table = $v['bizscheme'];
                    $argv = array("--table=$table", "--delete=1", "-force=1");
                    $commandName = "\\app\\admin\\command\\" . ucfirst($commandtype);
                    $input = new Input($argv);
                    $output = new \app\admin\model\flow\Output();
                    $command = new $commandName($commandtype);
                    $data = [
                        'type'        => $commandtype,
                        'params'      => json_encode($argv),
                        'command'     => "php think {$commandtype} " . implode(' ', $argv),
                        'executetime' => time(),
                    ];

                    $command->run($input, $output);
                    $result = implode("\n", $output->getMessage());
                }

                if ($table) {
                    $sql = "DROP TABLE IF EXISTS $table";
                    Db::execute($sql);
                }
            }
        }
        $this->success();
    }

    public function flow($ids = null)
    {
        parent::edit($ids);
        return $this->view->fetch();
    }

    /**
     * 浏览
     */
    public function browser()
    {
        $flowcode = $this->request->request('flowcode');
        $ids = $this->request->request('ids');
        $id = Model($flowcode)->where('instanceid', $ids)->value('id');
        $this->redirect('/admin/flow/' . $flowcode . '/edit', ['ids' => $id]);
    }

    public function model()
    {
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
            $total = $this->bizscheme
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->bizscheme
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible(['id', 'flowcode', 'flowname', 'flowversion', 'weight', 'url']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function flowchart($ids = null)
    {
        $this->task = new \app\admin\model\flow\Task;
        $this->scheme = new \app\admin\model\flow\Scheme;
        $taskid = $this->request->request('taskid');
        $task = $this->task->get($taskid);
        $activityId = $task['stepid'];
        $flowcode = $this->request->request('flowcode');
        if (!$flowcode) {
            $this->error(__('No Results were found'));
        }
        $row = $this->scheme->where('flowcode', $flowcode)->find();
        $taskList = Db::name('flow_task')
            ->alias('main')
            ->join('__ADMIN__ admin', 'admin.id=main.receiveid', 'LEFT')
            ->where('instanceid', $task['instanceid'])
            ->field(["main.instanceid", "main.stepid", "main.status", "admin.nickname", "main.completedtime", "main.createtime"])
            ->order('main.createtime', 'desc')
            ->select();
        $this->assignconfig('taskList', $taskList);
        $this->assignconfig("activityId", $activityId);
        $this->assignconfig("flowContent", $row['flowcontent']);
        $this->view->assign("flowContent", $row['flowcontent']);
        return $this->view->fetch();
    }

    public function node()
    {
        return $this->view->fetch();
    }

    /**
     * 导出
     */
    public function export()
    {
        if ($this->request->isPost()) {
            set_time_limit(0);
            $search = $this->request->post('search');
            $ids = $this->request->post('ids');
            $filter = $this->request->post('filter');
            $op = $this->request->post('op');

            $whereIds = $ids == 'all' ? '1=1' : ['id' => ['in', explode(',', $ids)]];
            $this->request->get(['search' => $search, 'ids' => $ids, 'filter' => $filter, 'op' => $op]);
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $line = 1;
            $list = [];
            $item = Db::name('flow_scheme')
                ->field(['flowcode', 'flowname', 'flowcontent', 'bizscheme'])
                ->where($where)
                ->where($whereIds)
                ->find();
            //$item = collection($item)->toArray();

            $sql = "show create table " . $item['bizscheme'];//Create Table
            $struct = Db::query($sql);
            $item['bizscemesql'] = $struct[0]['Create Table'];

            $json = str_replace('\n', '', json_encode($item, JSON_UNESCAPED_UNICODE));
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $item['flowcode'] . '.json"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            echo $json;
            return;
        }
    }

    /**
     * 导入
     */
    public function import()
    {
        $file = $this->request->request('file');
        if (!$file) {
            return json(array("code" => 0, "msg" => __('Parameter %s can not be empty', 'file'), "data" => "", "wait" => 3));
        }
        $filePath = ROOT_PATH . DS . 'public' . DS . $file;
        if (!is_file($filePath)) {
            return json(array("code" => 0, "msg" => __('No results were found', 'file'), "data" => "", "wait" => 3));
        }
        if (strpos($file, 'json') == false) {
            unlink($filePath);
            return json(array("code" => 0, "msg" => __('文件格式不正确', 'file'), "data" => "", "wait" => 3));
        }
        try {
            $json_string = file_get_contents($filePath);
            $data = json_decode($json_string, true);
            if ($data['flowcode'] == '' || $data['flowname'] == '' || $data['bizscemesql'] == '') {
                return json(array("code" => 0, "msg" => __('数据格式不正确!!!', 'file'), "data" => "", "wait" => 3));
            }
            $isExist = Db::name('flow_scheme')->where('flowcode', $data['flowcode'])->find();
            if ($isExist) {
                return json(array("code" => 0, "msg" => __('流程代码已存在,请先删除再导入.', 'file'), "data" => "", "wait" => 3));
            }
            $this->model->insert(['flowcode' => $data['flowcode'], 'flowname' => $data['flowname'], 'bizscheme' => strtolower($data['bizscheme']), 'flowcontent' => $data['flowcontent'], 'isenable' => '1']);
            Db::execute($data['bizscemesql']);
            $flowcode = strtolower($data['flowcode']);
            $bizScheme = strtolower($data['bizscheme']);
            $commandtype = 'FlowCrud';
            $argv = array("--table=$bizScheme", "--controller=flow/$flowcode", "--model=flow/$flowcode");
            array_push($argv, "-force=1");
            $commandName = "\\app\\admin\\command\\" . ucfirst($commandtype);
            $input = new Input($argv);
            $output = new \app\admin\model\flow\Output();
            $command = new $commandName($commandtype);
            $data = [
                'type'        => $commandtype,
                'params'      => json_encode($argv),
                'command'     => "php think {$commandtype} " . implode(' ', $argv),
                'executetime' => time(),
            ];
            $command->run($input, $output);
            $result = implode("\n", $output->getMessage());
            if (strpos($result, 'Successed') == false) {
                throw new \Exception($result);
            }
        } catch (\think\exception\PDOException $exception) {
            $this->error($exception->getMessage());
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success();
    }

    /**
     * 选择管理员
     *
     * @internal
     */
    public function selectuserpage()
    {
        $this->model = new \app\admin\model\Admin();
        return parent::selectpage();
    }

    /**
     * 选择角色组
     */
    public function selectrolepage()
    {
        $this->model = new \app\admin\model\AuthGroup();
        return parent::selectpage();
    }
}
