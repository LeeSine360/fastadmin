<?php

namespace app\admin\controller\company;

use app\common\controller\Backend;

/**
 * 供应商信息
 *
 * @icon fa fa-circle-o
 */
class Info extends Backend
{

    /**
     * Info模型对象
     * @var \app\admin\model\company\Info
     */
    protected $model = null;

    public function _initialize()
    {
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
            $total                                       = $this->model

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
            $list   = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function test()
    {
        $key = $this->request->get("key", '');
        $url    = "https://xin.baidu.com/";
        $txt    = file_get_contents($url . "s?q=" . $key);

        $start  = stripos($txt, 'zx-list-op-mask');
        $end    = stripos($txt, 'zx-side-con') - $start;
        $subString = substr($txt, $start, $end);

        preg_match_all("/zx-list-item-url(.*)company/U", $subString, $pat_array);

        foreach ($pat_array[0] as $key => $value) {
            preg_match("/compinfo\?pid=(.*)\"/U", $value, $url_array);
            preg_match("/title=\"(.*)\"/U", $value, $name_array);

            if ($name_array[1] == $key) {
                $jsonTxt = file_get_contents($url . "detail/basicAjax?pid=" . $url_array[1]);
                $arrayResult = json_decode($jsonTxt,true);
                var_dump($arrayResult['data']);
            }
        }
    }
}
