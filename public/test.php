<?php

/*$time = '2019-07-26';
//$times =  strtotime($time);
$times = '1564070400';

echo date('Y-m-d H:i',$times);*/
/*$test =  strtotime(date('Y-m-d',time()));
//echo date('Y-m-d H:i:s',$test+37200);*/

/*$str = '';
$arr = json_decode($str,true);
var_dump($arr);
//echo var_dump($arr['markets'][0]['url']);

$str = "http://open.api.mysteel.cn/haoyu/api_marketd_hunanhaoyujianshe.html?token=mjdsBu3cplZlARmdatgosMYaATkAnC1y&i=gn1dpotuga4vi";

preg_match('/id=([\w]+)/i',$str, $matches);


if($matches){
	echo 'hello';
}else{
	echo 'world';
}*/
/*$filter = '{"etime":"2019-04-20 00:00:00 - 2019-05-01 23:59:59"}';
$filter = (array)json_decode($filter, true);
$sym = 'RANGE';
foreach ($filter as $k => $v) {
	$v = str_replace(' - ', ',', $v);
	$arr = array_slice(explode(',', $v), 0, 2);
	if (stripos($v, ',') === false || !array_filter($arr)) {
	    echo 'error';
	}

	$where = "";
	//当出现一边为空时改变操作符
	if (empty($arr[0])) {
	    $sym = $sym == 'RANGE' ? '<=' : '>';
	    $arr = $arr[1];
	} elseif ($arr[1] === '') {
	    $sym = $sym == 'RANGE' ? '>=' : '<';
	    $arr = $arr[0];
	}
	$where[] = [$k, str_replace('RANGE', 'BETWEEN', $sym) . ' time', $arr];
}
var_dump($where);*/
