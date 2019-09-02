<?php

namespace app\common\library;

use app\admin\model\flow\Instance;
use app\admin\model\flow\Scheme;
use app\admin\model\flow\Task;
use think\Exception;
use think\Request;
use think\Db;
use think\Config;

class FlowEngine
{
    /**
     * 当前请求实例
     * @var Request
     */
    protected $request=null;
    protected $admin =null;
    protected $scheme = null;
    protected $instance = null;
    protected $task = null;
    protected $currentNode = null;
    protected $nextNode = null;
    protected $stepid = null;
    protected $prefix = "";

    public function __construct($name)
    {
        $this->admin = \think\Session::get('admin');
        $this->task = new \app\admin\model\flow\Task();
        $this->instance = new \app\admin\model\flow\Instance();
        $scheme = new \app\admin\model\flow\Scheme();
        $this->scheme=$scheme->where(['flowcode'=>$name])->find();
        if(!$this->scheme){
            throw new Exception('流程不存在');
        }
        $this->prefix = Config::get('database.prefix');
    }

    /**保存流程
     * @param array $data 业务表数据
     * @param string $instance 实例id
     * @return array 返回实例id,业务表id
     * @throws Exception
     */
    public function save($data=[],$instance='')
    {
        $ids=[];
        $instanceid=\fast\Random::uuid();
        $bizobjectid=\fast\Random::uuid();
        $ids['instanceid']=$instanceid;
        $ids['bizobjectid']=$bizobjectid;
        try {
            $instanceid = \fast\Random::uuid();
            $bizobjectid = \fast\Random::uuid();
            $flowTmp = $this->scheme;
            if($instance==''){
                //新建流程实例
                Db::name('flow_instance')->insert(array(
                    'id'             => $instanceid,
                    'originator'     => $this->admin['id'],
                    'scheme'         => $flowTmp['id'],
                    'createtime'     => date("Y-m-d h:i:s"),
                    'instancecode'   => time(),
                    'bizobjectid'    => $bizobjectid,
                    'instancestatus' => 0));
                $content = json_decode($flowTmp->flowcontent, true);
                //所有连线信息
                $lines = $content['lines'];
                //所有节点信息
                $nodes = $content['nodes'];
                $rtnNext = null;
                $nextNodeIndex = null;
                //如果是开始节点需要保存开始数据和下一个节点的代办数据
                $rtn = array_search('start', array_column($nodes, 'type'));
                $this->currentNode = $nodes[$rtn];
                $this->stepid = $this->currentNode['id'];
                Db::name('flow_task')->insert(array(
                    'id'         => \fast\Random::uuid(),
                    'flowid'     => $flowTmp['id'],
                    'stepname'   => $this->currentNode['name'],
                    'stepid'     => $this->currentNode['id'],
                    'receiveid'  => $this->admin['id'],
                    'instanceid' => $instanceid,
                    'senderid'   => $this->admin['id'],
                    'status'     => 0,
                    'createtime' => date("Y-m-d H:i:s"),
                    'comment'    => '提交'));
                $params = $data;
                $params['id'] = $bizobjectid;
                if($data){
                    Db::table($flowTmp['bizscheme'])->insert($params);
                }

            }
            else{
                if($data){
                    Db::table($flowTmp['bizscheme'])->update($data);
                }
            }
        } catch (\think\exception\PDOException $e) {
            throw new Exception($e->getMessage());
        } catch (\think\Exception $e) {
            throw new \think\Exception($e->getMessage());
        }
        return $ids;  
    }

    /**直接提交流程
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function start($data)
    {
        $instanceid = \fast\Random::uuid();
        $bizobjectid = \fast\Random::uuid();
        $ids['instanceid']=$instanceid;
        $ids['bizobjectid']=$bizobjectid;
        $flowTmp = $this->scheme;
        //新建流程实例
        $this->instance->isUpdate(false)->data(array(
            'id'             => $instanceid,
            'originator'     => $this->admin['id'],
            'scheme'         => $flowTmp['id'],
            'createtime'     => date("Y-m-d h:i:s"),
            'instancecode'   => time(),
            'bizobjectid'    => $bizobjectid,
            'instancestatus' => 1), true)->save();
        $content = json_decode($flowTmp->flowcontent, true);
        //所有连线信息
        $lines = $content['lines'];
        //所有节点信息
        $nodes = $content['nodes'];
        $rtnNext = null;
        $nextNodeIndex = null;
        //如果是开始节点需要保存开始数据和下一个节点的代办数据
        $rtn = array_search('start', array_column($nodes, 'type'));
        $this->currentNode = $nodes[$rtn];
        $this->stepid = $this->currentNode['id'];
        $this->task->isUpdate(false)->data(array(
            'id'            => \fast\Random::uuid(),
            'flowid'        => $flowTmp['id'],
            'stepname'      => $this->currentNode['name'],
            'stepid'        => $this->currentNode['id'],
            'receiveid'     => $this->admin['id'],
            'instanceid'    => $instanceid,
            'senderid'      => $this->admin['id'],
            'status'        => '2',
            'createtime'    => date("Y-m-d H:i:s"),
            'completedtime' => date("Y-m-d H:i:s"),
            'comment'       => '提交'), true)->save();
        $nextNodeArray = array_filter($lines, function ($t) {
            return $t['from'] == $this->stepid;
        });
        foreach ($nextNodeArray as $line) {
            $this->nextNode = array_filter($nodes, function ($t) use ($line) {
                return $t['id'] == $line['to'];

            });
            $this->nextNode = array_values($this->nextNode)[0];
            $nodeType = $this->nextNode['setInfo']['nodeDesignate'];
            $dataset = [];
            $userList = [];
            if ($nodeType == 'user') {
                if (is_array($this->nextNode['setInfo']['NodeDesignateData']['users'])) {
                    $userList = $this->nextNode['setInfo']['NodeDesignateData']['users'];
                } else {
                    $userList = explode(',', $this->nextNode['setInfo']['NodeDesignateData']['users']);
                }
                foreach ($userList as $user) {
                    $dataset[] = ['id'         => \fast\Random::uuid(),
                        'flowid'     => $flowTmp['id'],
                        'stepname'   => $this->nextNode['name'],
                        'stepid'     => $this->nextNode['id'],
                        'receiveid'  => $user,
                        'instanceid' => $instanceid,
                        'senderid'   => $this->admin['id'],
                        'status'     => '0',
                        'createtime' => date("Y-m-d H:i:s")];
                }
            }
            if ($nodeType == 'role') {
                $role = '';
                if (is_array($this->nextNode['setInfo']['NodeDesignateData']['role'])) {
                    $role = $this->nextNode['setInfo']['NodeDesignateData']['role'];
                    if (!$role) {
                        throw new Exception('找不到角色');
                    } else {
                        $role = $role[0];
                    }
                } else {
                    $role = $this->nextNode['setInfo']['NodeDesignateData']['role'];
                }
                $userList = $this->getuserbyrole($role);
                foreach ($userList as $user => $v) {
                    $dataset[] = ['id'         => \fast\Random::uuid(),
                        'flowid'     => $flowTmp['id'],
                        'stepname'   => $this->nextNode['name'],
                        'stepid'     => $this->nextNode['id'],
                        'receiveid'  => $v['id'],
                        'instanceid' => $instanceid,
                        'senderid'   => $this->admin['id'],
                        'status'     => '0',
                        'createtime' => date("Y-m-d H:i:s")];
                }
            }
            if (count($userList) == 0) {
                $dataset[] = ['id'         => \fast\Random::uuid(),
                    'flowid'     => $flowTmp['id'],
                    'stepname'   => $this->nextNode['name'],
                    'stepid'     => $this->nextNode['id'],
                    'receiveid'  => '',
                    'instanceid' => $instanceid,
                    'senderid'   => $this->admin['id'],
                    'status'     => '0',
                    'createtime' => date("Y-m-d H:i:s")];
                $this->task->isUpdate(false)->saveAll($dataset);
            }

            $this->task->isUpdate(false)->saveAll($dataset, false);
        }
        $params = $data;
        $params['id'] = $bizobjectid;
        if ($data) {
            Db::table($flowTmp['bizscheme'])->insert($params);
        }
        return $ids;
    }

    /** 审批流程
     * @param $taskid
     * @param string $data
     * @param string $comment
     * @return bool
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function next($taskid,$data='',$comment='')
    {
        $res = true;
        $task = $this->task->where(['id' => $taskid])->where('status', 0)->find();
        $instance=$this->instance->get($task['instanceid']);
        $flowTmp = $this->scheme;
        $this->stepid = $task['stepid'];
        //更改当前任务为完成
        $comment = $comment ? '[同意]' : $comment;
        $instanceid = $task['instanceid'];
        $this->task->where('id', $taskid)->update(['status' => 2, 'completedtime' => date("Y-m-d H:i:s"), 'comment' => $comment]);
        $unfinishList = $this->task->where(['instanceid' => $instanceid])->where('status', 'in', [0, 1])->find();

        if ($task['stepname'] == '开始') {
            $this->instance->where('id', $task['instanceid'])->update(['instancestatus' => 1]);
            if ($data) {
                Db::table($flowTmp['bizscheme'])->insert($data);
            }
        }
        if (!$unfinishList) {
            //寻找下一个待办任务
            $content = json_decode($flowTmp->flowcontent, true);
            //所有连线信息
            $lines = $content['lines'];
            //所有节点信息
            $nodes = $content['nodes'];
            $rtnNext = null;
            $nextNodeIndex = null;
            $nextNodeArray = array_filter($lines, function ($t) {
                return $t['from'] == $this->stepid;
            });
            foreach ($nextNodeArray as $line) {
                $this->nextNode = array_filter($nodes, function ($t) use ($line) {
                    return $t['id'] == $line['to'];
                });
                $this->nextNode = array_values($this->nextNode)[0];//0表示获取他的value
                $nodeType = null;
                $dataset = [];
                $userList = null;
                if (count($nextNodeArray) == 1 && $this->nextNode['name'] == '结束') {
                    //更改当前实例为结束
                    $this->instance->where('id', $task['instanceid'])->update(['instancestatus' => 2, 'completedtime' => date("Y-m-d H:i:s")]);
                    //插入结束节点task
                    Db::name("flow_task")->insert([
                        'id'            => \fast\Random::uuid(),
                        'flowid'        => $flowTmp['id'],
                        'stepname'      => $this->nextNode['name'],
                        'stepid'        => $this->nextNode['id'],
                        'receiveid'     => '',
                        'instanceid'    => $instanceid,
                        'senderid'      => $this->admin['id'],
                        'status'        => '2',
                        'createtime'    => date("Y-m-d H:i:s"),
                        'completedtime' => date("Y-m-d H:i:s"),
                        'comment'       => '结束'
                    ]);
                }
                if ($this->nextNode['name'] != '结束') {
                    $nodeType = $this->nextNode['setInfo']['nodeDesignate'];
                    if ($nodeType == 'user') {
                        if (is_array($this->nextNode['setInfo']['NodeDesignateData']['users'])) {
                            $userList = $this->nextNode['setInfo']['NodeDesignateData']['users'];
                        } else {
                            $userList = explode(',', $this->nextNode['setInfo']['NodeDesignateData']['users']);
                        }
                        foreach ($userList as $user) {
                            $dataset[] = ['id'         => \fast\Random::uuid(),
                                'flowid'     => $flowTmp['id'],
                                'stepname'   => $this->nextNode['name'],
                                'stepid'     => $this->nextNode['id'],
                                'receiveid'  => $user,
                                'instanceid' => $instanceid,
                                'senderid'   => $this->admin['id'],
                                'status'     => '0',
                                'createtime' => date("Y-m-d H:i:s")];
                        }
                    }
                    if ($nodeType == 'role') {
                        $role = '';
                        if (is_array($this->nextNode['setInfo']['NodeDesignateData']['role'])) {
                            $role = $this->nextNode['setInfo']['NodeDesignateData']['role'];
                            if (!$role) {
                                throw new Exception('找不到角色');
                            } else {
                                $role = $role[0];
                            }

                        } else {
                            $role = $this->nextNode['setInfo']['NodeDesignateData']['role'];
                        }
                        $userList = $this->getuserbyrole($role);
                        foreach ($userList as $user => $v) {
                            $dataset[] = ['id'         => \fast\Random::uuid(),
                                'flowid'     => $flowTmp['id'],
                                'stepname'   => $this->nextNode['name'],
                                'stepid'     => $this->nextNode['id'],
                                'receiveid'  => $v['id'],
                                'instanceid' => $instanceid,
                                'senderid'   => $this->admin['id'],
                                'status'     => '0',
                                'createtime' => date("Y-m-d H:i:s")];
                        }
                    }
                    if (count($userList) == 0) {
                        $dataset[] = ['id'         => \fast\Random::uuid(),
                            'flowid'     => $flowTmp['id'],
                            'stepname'   => $this->nextNode['name'],
                            'stepid'     => $this->nextNode['id'],
                            'receiveid'  => '',
                            'instanceid' => $instanceid,
                            'senderid'   => $this->admin['id'],
                            'status'     => '0',
                            'createtime' => date("Y-m-d H:i:s")];
                        $this->task->isUpdate(false)->saveAll($dataset);
                    }

                    Db::name("flow_task")->insertAll($dataset);
                }
            }
        }
        return $res;
    }

    /**拒绝流程
     * @param $taskid
     * @param string $comment
     * @return bool
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function refuse($taskid,$comment='')
    {
        $res = true;
        $task = $this->task->where(['id' => $taskid, 'status' => 0])->find();
        if (!$task)
            throw new Exception('找不到当前任务,或已处理，请联系管理员');
        //更改当前流程为拒绝状态
        $comment = $comment == '' ? '[拒绝]' : $comment;
        Db::name('flow_task')->where('id', $taskid)
            ->update(['status' => 2, 'completedtime' => date("Y-m-d H:i:s"), 'comment' => $comment]);
        //取消其他流程
        Db::name('flow_task')->where(['instanceid' => $task['instanceid'], 'status' => 0])
            ->update(['status' => 3, 'completedtime' => date("Y-m-d H:i:s")]);
        //更改流程实例为草稿状态
        Db::name('flow_instance')->where(['id' => $task['instanceid']])
            ->update(['instancestatus' => 0]);
        //寻找下一个待办任务
        $startNode = $this->task->where(['instanceid' => $task['instanceid'], 'stepname' => '开始'])->find();
        //$startNode->status = 0;
        $this->task->insert(['id'         => \fast\Random::uuid(),
            'flowid'     => $startNode['flowid'],
            'stepname'   => $startNode['stepname'],
            'stepid'     => $startNode['stepid'],
            'receiveid'  => $startNode['receiveid'],
            'instanceid' => $startNode['instanceid'],
            'senderid'   => $startNode['senderid'],
            'status'     => '0',
            'createtime' => date("Y-m-d H:i:s")]);
        return $res;
    }

    /**取消流程
     * @param $taskid
     * @param string $comment
     * @return bool
     * @throws \think\exception\DbException
     */
    public function cancel($taskid,$comment='')
    {
        $res=true;
        $task = $this->task->get($taskid);
        $comment = $comment == '' ? '[取消]' : $comment;
        //更改当前流程为取消状态
        $this->task->where(['instanceid' => $task['instanceid']])->where('status', 'in', [0, 1])->update(['status' => 3, 'completedtime' => date("Y-m-d H:i:s"), 'comment' => $comment]);
        $this->instance->where(['id' => $task['instanceid']])->update(['instancestatus' => 3]);
        return $res;
    }

    /**根据角色获取用户
     * @param $role
     * @return mixed
     */
    public function getuserbyrole($role)
    {
        $sql = "SELECT a.id FROM " . $this->prefix . "admin a 
                LEFT JOIN " . $this->prefix . "auth_group_access b ON a.id = b.uid
                LEFT JOIN " . $this->prefix . "auth_group c ON b.group_id=c.id
                WHERE c.`id`='" . $role . "'";
        $user = Db::query($sql);
        return $user;
    }
}