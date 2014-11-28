<?php

require_once('./ImageSpider.class.php');
require_once('./MessageResponse.class.php');
require_once('./Youku.class.php');
require_once('./YoukuM3U8.class.php');
require_once('./Database.class.php');

header("Content-Type: text/html;charset=utf-8");

$sql = "SELECT id,webURL FROM videoList WHERE videoURL = '';";

$database = Database::getInstance();
$res = $database->fetch_obj_arr($sql);
foreach ($res as $key => $value) {

	$in = strstr($value->webURL,'youku'); //检测url是否是youku链接
	if ($in) {
		echo $value->webURL  . "<br/>";
		$youkuID = explode('id_',$value->webURL);
		$youkuID = explode('.html',$youkuID[1]);
		$youkuVideo = youku_m3u8::get_m3u8_url($youkuID[0]);
		echo $youkuVideo . "<br/>";
		$sql = "UPDATE `videoList` SET `videoURL` = '{$youkuVideo}' WHERE `id` = '{$value->id}';";
		//echo $sql . "<br/>";
		if ($database->query($sql)) {
			echo "success" . "<br/>";
		} else {
			echo "error" . mysql_error() . "<br/>";
			echo $sql . "<br/>";
		}
	}
}
//var_dump($res);
// if (empty($res))
// {
// 	echo $res['webURL'];
// }

return;

// $url = "http://v.youku.com/v_show/id_XODMzNTg4ODIw.html";
// $data = Youku::parse($url);
// print_r($data);
echo youku_m3u8::get_m3u8_url('XODAwMDc5Nzg0');
// return;
// 
return;

//$imageSpider->fetchVideoPageCount('http://www.gaoxiaodashi.com/egaozhenggu/');
$result = $imageSpider->fetchContent('http://www.gaoxiaodashi.com/daanminganyaoanzaishen/');
$page = $imageSpider->fetchVideoPageCount('http://www.gaoxiaodashi.com/daanminganyaoanzaishen/');
echo "page = " . $page;
//print_r($result);
echo MessageResponse::createJSONMessage(0,'获取成功',$result);


?>