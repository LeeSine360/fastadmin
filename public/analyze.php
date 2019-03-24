<?php
function curl_get($url, array $params = array(), $timeout = 5) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return $file_contents;
}
$url = "http://www.hebscztxyxx.gov.cn/noticehb/notice/view;JSESSIONID_NOTICE=_mavVXaV8vQ-rX5z3hmnchdqEN7vq1reyep9PCxCv-KhlpCN1lD6!762429470?uuid=.k1amfifVcjc2HJFh.pap0vHfi7k3zWc";
$data = curl_get($url);
$num = strlen($data);
$start = stripos($data, 'sub_tab_container');
$data = substr($data, $start, $num);

//$userinfo = "Name: <i>PHP</i> <br> Title: <b>Programming Language</b>";
preg_match_all("/<i>(.*)<\/i>/i", $data, $pat_array);
print_r($pat_array[0]);