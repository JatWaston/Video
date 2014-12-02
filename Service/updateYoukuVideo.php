<?php

require_once('./ImageSpider.class.php');
require_once('./MessageResponse.class.php');
require_once('./Youku.class.php');
require_once('./YoukuM3U8.class.php');
require_once('./Database.class.php');

header("Content-Type: text/html;charset=utf-8");

// $sql = "SELECT id,title FROM videoList;";
// $database = Database::getInstance();
// $res = $database->fetch_obj_arr($sql);
// $count = 0;
// foreach ($res as $key => $value) {
// 	if (!empty($value->title)) {
// 		// echo $value->title . "<br/>";
// 		$newTitle = trim($value->title,' ');
// 		$newTitle = trim($newTitle,'"');
// 		//echo $newTitle . "<br/>";
// 		if (!empty($newTitle)) {
// 			$sql = "UPDATE `videoList` SET `title` = '{$newTitle}' WHERE `id` = '{$value->id}';";
// 			$database->query($sql);
// 			$count++;
// 			// echo "success" . "<br/>";
// 		} else {
// 			// echo "failure" . "<br/>";
// 			// echo $sql . "<br/>";
// 		}
// 	}
// 	//break;
// }
// echo "更新[ " . $count . " ]条标题" . "<br/>";

// // $title = ' "恶作剧请务必选对人！真给咱china丢人啊！"';
// // echo $title . "<br/>";
// // $newTitle = trim($title,' ');
// // $newTitle = trim($newTitle,'"');
// // if (empty($newTitle)) {
// // 	echo "empty" . "<br/>";
// // }
// // echo $newTitle . "<br/>";


// return;

$sql = "SELECT id,coverImgURL FROM videoList WHERE coverImgWidth = 0;";
$database = Database::getInstance();
$res = $database->fetch_obj_arr($sql);
$count = 0;
foreach ($res as $key => $value) {
	if (!empty($value->coverImgURL)) {
		$image_size = getimagesize($value->coverImgURL);
		$img_width = $image_size[0];
		$img_height = $image_size[1];
		if ($img_width != 0) {
			$sql = "UPDATE `videoList` SET `coverImgHeight` = {$img_height},`coverImgWidth` = {$img_width} WHERE `id` = '{$value->id}';";
			$database->query($sql);
			$count++;
			// echo "success" . "<br/>";
		} else {
			// echo "failure" . "<br/>";
			// echo $sql . "<br/>";
		}
	}
	//break;
}
echo "更新[ " . $count . " ]条图片" . "<br/>";

//return;

$sql = "SELECT id,webURL FROM videoList WHERE videoURL = '';";

$database = Database::getInstance();
$res = $database->fetch_obj_arr($sql);
$count = 0;
foreach ($res as $key => $value) {

	$in = strstr($value->webURL,'youku'); //检测url是否是youku链接
	if ($in) {
		//echo $value->webURL  . "<br/>";
		$youkuID = explode('id_',$value->webURL);
		$youkuID = explode('.html',$youkuID[1]);
		$youkuVideo = youku_m3u8::get_m3u8_url($youkuID[0]);
		//echo $youkuVideo . "<br/>";
		$sql = "UPDATE `videoList` SET `videoURL` = '{$youkuVideo}' WHERE `id` = '{$value->id}';";
		//echo $sql . "<br/>";
		if ($database->query($sql)) {
			//echo "success" . "<br/>";
			$count++;
		} else {
			echo "error" . mysql_error() . "<br/>";
			echo $sql . "<br/>";
		}
	}
}

echo "更新[ " . $count . " ]条youku数据" . "<br/>";
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