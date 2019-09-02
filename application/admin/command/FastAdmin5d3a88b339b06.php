<?php

namespace app\admin\command;

use app\common\controller\Backend;
use fast\Http;

/**
 * 钢材市场行情
 *
 * @icon fa fa-circle-o
 */
class Steellist extends Backend
{
    
    /**
     * Steellist模型对象
     * @var \app\admin\model\company\Steellist
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\CompanySteellist;
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
            /*if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }*/
            $time = null;
            $filter = $this->request->get("filter", '');
            $filter = (array)json_decode($filter, true);
            if(isset($filter['date'])){
                $time = date('Y-m-d',strtotime($filter['date']));
            }else{
                $time = date('Y-m-d',time());
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();            
return $sort;
            $total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            if(!$total){
                $steelArray = $this->refresh($time);
                if($steelArray){
                    $time = ['date' => strtotime($steelArray['date'])];
                    foreach ($steelArray['contents'] as $key => $value) {
                        array_push($steelArray['contents'][$key],$time);                        
                    }

                    $result = $this->model->saveAll($steelArray['contents']);

                    if($result !== false){
                        $total = $this->model
                        ->where($where)
                        ->order($sort, $order)
                        ->count();
                    }                    
                }
            }

            /*$list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->visible(['breed','category','material','place','price','raise','rowId','spec','unit','note']);
                $row->visible(['companysteel']);
				$row->getRelation('companysteel')->visible(['date']);
            }
            $list = collection($list)->toArray();*/
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function refresh($time = null){
        $urlId =  "http://open.api.mysteel.cn/haoyu/api_marketl_hunanhaoyujianshe.html?page=1&tableId=15331&pageSize=10&token=mjdsBu3cplZlARmdatgosMYaATkAnC1y&startTime=$time&endTime=$time";        

        $urlIdResult = Http::get($urlId);
        $urlIdResult = mb_convert_encoding($urlIdResult, "utf-8", "gbk");

        $arr = json_decode($urlIdResult,true);        

        if($arr){
            $url = $arr['markets'][0]['url'];
            $urlListResult = Http::get($url);

            $str = mb_convert_encoding($urlListResult, "utf-8", "gbk");

            return json_decode($str,true);
        }
    }
}
