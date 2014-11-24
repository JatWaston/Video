<?php

require_once('./ImageSpider.class.php');
require_once('./MessageResponse.class.php');
require_once('./Youku.class.php');
header("Content-Type: text/html;charset=utf-8");

$url = "v.youku.com/v_show/id_XODMzNzAwNzcy.html";
$data = Youku::parse($url);
print_r($data);
return;

$imageSpider = new ImageSpider();

//$imageSpider->fetchVideoPageCount('http://www.gaoxiaodashi.com/egaozhenggu/');
$result = $imageSpider->fetchContent('http://www.gaoxiaodashi.com/egaozhenggu/');

echo MessageResponse::createJSONMessage(0,'获取成功',$result);


?>