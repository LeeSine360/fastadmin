<?php

namespace app\common\controller;

use app\common\controller\Backend;
use think\Loader;
use app\common\library\FlowEngine;
use think\Db;
use think\Config;

/**
 * 后台控制器基类
 */
class FlowBackend extends Backend
{

    protected $model = null;
    protected $task = null;
    protected $flow = null;
    protected $currentNode = null;
    protected $nextNode = null;
    protected $scheme = null;
    protected $instance = null;
    protected $prefix = "";

    public function _initialize()
    {
        $this->task = new \app\admin\model\flow\Task();
        $this->instance = new \app\admin\model\flow\Instance();
        $this->scheme = new \app\admin\model\flow\Scheme();
        parent::_initialize();
        $this->prefix = Config::get('database.prefix');
    }

    /**
     * 保存草稿qq
     */
    public function save()
    {
        $params = $this->request->post("row/a");
        if ($this->request->isPost()) {
            if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                $params[$this->dataLimitField] = $this->auth->id;
            }
            try {
                //是否采用模型验证
                if ($this->modelValidate) {
                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                    $this->model->validate($validate);
                }
                $this->flow->save($params);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }

    /**
     * 直接提交流程
     */
    public function add()
    {
        $params = $this->request->post("row/a");
        $flowTmp = $this->scheme->get($this->request->request("ids"));
        if ($this->request->isPost()) {
            try {
                //是否采用模型验证
                if ($this->modelValidate) {
                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                    $this->model->validate($validate);
                }
                $this->flow->start($params);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        $this->assignconfig('flowCode', $flowTmp['flowcode']);
        return $this->view->fetch();
    }

    /**
     * 寻找下一个审批节点,同意按钮执行的方法
     */
    public function edit($ids = NULL)
    {
        $ids = $this->request->request('ids');
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        $taskid = $this->request->request('taskid');
        $task = null;
        $mode = $this->request->request('mode');
        if ($mode == 'view') {
            $task = $this->task->where(['id' => $taskid])->find();
        } else {
            $task = $this->task->where(['id' => $taskid])->where('status', 0)->find();
        }
        if (!$task)
            $this->error(__('找不到当前任务'));
        $schme = $this->scheme->get($task['flowid']);
        $instance = $this->instance->get($task['instanceid']);
        if ($this->request->isPost()) {
            $comment = $this->request->post('comment') == '' ;
            try{
                //是否采用模型验证
                if ($this->modelValidate) {
                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                    $this->model->validate($validate);
                }
                $this->flow->next($taskid,$this->request->request("row/a"),$comment);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        $history = Db::table($this->prefix . 'flow_task')
            ->alias('main')
            ->join($this->prefix . 'admin admin', 'admin.id=main.receiveid', 'LEFT')
            ->where(['instanceid' => $task['instanceid'], 'main.status' => 2])
            ->field(["main.receiveid", "main.stepname", "main.comment", "admin.nickname", "main.completedtime"])
            ->order('main.createtime asc,main.completedtime asc')
            ->select();

        $this->assignconfig('task', $task);
        $this->assignconfig('flowCode', $schme['flowcode']);
        $this->view->assign("history", $history);
        $this->view->assign("mode", $mode);
        $this->view->assign("instance", $instance);
        $this->view->assign("row", $row);
        $this->view->assign("auth", $this->auth);
        return $this->view->fetch();
    }

    /**
     * 拒绝流程
     */
    public function refuse()
    {
        if ($this->request->isPost()) {
            try {
                $taskid = $this->request->request('taskid');
                $comment = $this->request->post('comment') == '' ? '[取消]' : $this->request->post('comment');
                $this->flow->refuse($taskid,$comment);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        return $this->view->fetch();
    }

    /**
     * 取消流程
     */
    public function cancel()
    {
        if ($this->request->isPost()) {
            try {
                $taskid = $this->request->request('taskid');
                $comment = $this->request->post('comment') == '' ? '[取消]' : $this->request->post('comment');
                $this->flow->cancel($taskid,$comment);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
