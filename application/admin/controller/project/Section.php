<?php

namespace app\admin\controller\project;

use app\common\controller\Backend;
use think\Db;

/**
 * 标段信息
 *
 * @icon fa fa-circle-o
 */
class Section extends Backend
{
    
    /**
     * Section模型对象
     * @var \app\admin\model\project\Section
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\ProjectSection;

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
            $total = Db::table([                             
                                '__PROJECT_SECTION__' => 'project_section'
                            ])
                    ->join('__PROJECT_INFO__ project_info','project_section.project_info_id = project_info.id')
                    ->where($where)
                    ->order($sort, $order) 
                    ->count();

            $list = Db::table([                             
                                '__PROJECT_SECTION__' => 'project_section'
                            ])  
                    ->field('
                        project_section.id as id,
                        project_info.name as projectName,
                        project_section.name as sectionName,
                        project_section.price as price,
                        project_manager.name as managerName,
                        project_section.createtime as createtime
                    ')
                    ->join('__PROJECT_INFO__ project_info','project_section.project_info_id = project_info.id')
                    ->join('__PROJECT_MANAGER__ project_manager','project_section.project_manager_id = project_manager.id')
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();


            /*foreach ($list as $row) {
                $row->visible(['id','name','price','createtime','admin_id']);
                $row->visible(['projectinfo']);
				$row->getRelation('projectinfo')->visible(['name']);
				$row->visible(['projectmanager']);
				$row->getRelation('projectmanager')->visible(['name']);
				$row->visible(['admin']);
				$row->getRelation('admin')->visible(['username']);
            }*/
            //$list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function detail(){
        return $this->view->fetch();
    }
}
