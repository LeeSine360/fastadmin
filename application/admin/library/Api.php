<?php
namespace app\admin\library;
use app\common\model\Config as ConfigModel;

/* 企业基本信息查询、税票信息查询接口*/
class Api
{
	protected $model = null;

	public function _initialize()
    {
        parent::_initialize();
        $this->model = model('\app\common\model\Config');
    }

	//企业信息查询
	public function queryCompany($data){
		$url = "https://bankpros.market.alicloudapi.com/comdata";		

		$appCodeValue = ConfigModel::where('id',26)->value('value');
		$appCodeArray = json_decode($appCodeValue,true);
		$appCode = $appCodeArray['AppCode'];
    	
    	$headers = array(
    		"Authorization:APPCODE " . $appCode,
    		"Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8"
    	);

		return $this->getResponse($url, $data,$headers);
	}
	//发票信息查询
	public function queryTax($data){
		$url = "https://open.cs.zbj.com/v2/invoice/query";

		$appKeyValue = ConfigModel::where('id',27)->value('value');
		$appKeyArray = json_decode($appKeyValue,true);
		$appKey = $appKeyArray['AppKey'];
		$appSecrect = $appKeyArray['AppSecrect'];

		$time = time();
		$uuid = $this->guid();
		$headers = array(
            "Content-type: application/json;charset=utf-8",
            "X-CS-Authorization: HMAC-SHA256",
            "X-CS-Key: ".$appKey,
            "X-CS-Nonce: ".$uuid,
            "X-CS-Timestamp: ". $time,
            "X-CS-Version: v2",
            "X-CS-Signature: ".$this->getSign($appKey,$appSecrect,$uuid,$time)
        );

        return $this->getResponse($url, $data,$headers,true);
	}

	//发票信息查询：使用密钥AppSecrect获得签名
	private function getSign($appKey,$appSecrect,$uuid,$time){
        $head = array(
            "POST",
            "X-CS-Authorization=HMAC-SHA256",
            "X-CS-Key=".$appKey,
            "X-CS-Nonce=".$uuid,
            "X-CS-Timestamp=".$time,
            "X-CS-Version=v2"
        );
        $s = hash_hmac('sha256', implode('|',$head), $appSecrect,true);
        return base64_encode($s);
    }

    //发票信息查询：获得随机UUID
    private function guid() {
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

    private function getResponse($url, $data = array(),$headers =null,$isJson=false){
        $ch = curl_init();
        
        $param = $isJson ? json_encode($data) : http_build_query($data);
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