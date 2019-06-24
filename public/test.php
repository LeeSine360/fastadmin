<?php

$demo = new Demo();
$param = array(
    'invoiceCode' => '4300183130',
    'invoiceNumber' => '05390761',
    'billTime' => '2019-06-04',
    'checkCode' => '',
    'invoiceAmount' => '18902.65',
);

$getData = $demo->getQuery($param);
var_dump($getData);

Class Demo
{
    private $appKey ="";
    private $appSecret = "";

    function __construct(){
        $this->appKey ="cd9b1bd64929422ea913591d8b7f636f";
        $this->appSecret = "e30493bb-0d53-437c-9ed6-46d0578cd587";
    }
//https://open.leshui365.com/api/getInvoiceModel
  
    public function getTest($param){
        if(!$param['token']) $param['token'] = $this->getToken();
        $url = "https://open.leshui365.com/api/getInvoiceModel";
        return $this->getResponse($url,$param);
    }

    public function getQuery($param){
        if(!$param['token']) $param['token'] = $this->getToken();
        $url = "https://open.leshui365.com/api/invoiceInfoForCom";
        return $this->getResponse($url,$param);
    }
    public function getToken()
    {
        $url = "https://open.leshui365.com/getToken?appKey=".$this->appKey."&appSecret=".$this->appSecret;
        //var_dump($this->getResponse($url));
        $token = $this->getResponse($url)['token'];
        return $token;
    }

    protected function getResponse($url, $data = array())
    {
        $ch = curl_init();
        $headers = array(
            "Content-type: application/json"
        );
        $param = json_encode($data);
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $datas = curl_exec($ch);//运行curl
        curl_close($ch);
        $array = json_decode($datas, true);
        return $array;
    }
}
