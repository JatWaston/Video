<?php

require_once('./ImageSpider.class.php');
require_once('./MessageResponse.class.php');
require_once('./Youku.class.php');
require_once('./YoukuM3U8.class.php');
header("Content-Type: text/html;charset=utf-8");

// $url = "http://v.youku.com/v_show/id_XODAwMDc5Nzg0.html";
// $data = Youku::parse($url);
// print_r($data);
echo youku_m3u8::get_m3u8_url('XODAwMDc5Nzg0');
return;

$imageSpider = new ImageSpider();

//$imageSpider->fetchVideoPageCount('http://www.gaoxiaodashi.com/egaozhenggu/');
$result = $imageSpider->fetchContent('http://www.gaoxiaodashi.com/egaozhenggu/');

echo MessageResponse::createJSONMessage(0,'获取成功',$result);


?>