<?php

$demo = new Ticket();
$param = array(
    'fpdm' => '4300183130',
    'fphm' => '05390761',
    'kprq' => '2019-06-04',
    'checkCode' => '',
    'noTaxAmount' => '18902.65',
);

$getData = $demo->getQuery($param);
var_dump($getData);

Class Ticket
{
    private $appKey ="63635FF0189349509D9E7EBF4D797559";
    private $appSecret = "7116edeab6384ceeb50fbc4d54dfb775";
    private $time ="";
    private $uuid = "";

    public function __construct(){
        $this->time = time();
        $this->uuid = $this->guid();
    }

    public function getQuery($param){
        $url = "http://open.cs.zbj.com/v2/invoice/query";
        return $this->getResponse($url,$param);
    }

    public function getSign(){
        $head = array(
            "POST",
            "X-CS-Authorization=HMAC-SHA256",
            "X-CS-Key=".$this->appKey,
            "X-CS-Nonce=".$this->uuid,
            "X-CS-Timestamp=".$this->time,
            "X-CS-Version=v2"
        );
        $s = hash_hmac('sha256', implode('|',$head), $this->appSecret,true);
        return base64_encode($s);
    }

    protected function getResponse($url, $data = array())
    {
        $ch = curl_init();
        $headers = array(
            "Content-type: application/json;charset=utf-8",
            "X-CS-Authorization: HMAC-SHA256",
            "X-CS-Key: ".$this->appKey,
            "X-CS-Nonce: ".$this->uuid,
            "X-CS-Timestamp: ".$this->time,
            "X-CS-Version: v2",
            "X-CS-Signature: ".$this->getSign()
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

    protected function guid() {
        if (function_exists('com_create_guid')){
            $uuid = com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12);
        }
        return $uuid;
    }
}
