<?php

require_once('./JokeSpider.class.php');
require_once('./MessageResponse.class.php');
require_once('./Youku.class.php');
require_once('./YoukuM3U8.class.php');
require_once('./Database.class.php');

header("Content-Type: text/html;charset=utf-8");


$spider = new JokeSpider();
$database = Database::getInstance();

$index = 0;
for ($i=1; $i <=979; $i++) { 
	$finish = false;
	$url = "http://www.waduanzi.com/joke/page/" . $i;
	$res = $spider->fetchContent($url);
	$count = count($res);
	foreach ($res as $key => $value) {
		$content = $value['content'];
		echo $content . "<br/>";
		$title = $value['title'];
		$id = md5($content);
		$date = date("Y-m-d H:m:s"); //"Y-m-d H:m:s" 24小时制 "Y-m-d h:m:s" 12小时制
		$sql = "INSERT INTO `jokeList` (`id`,`title`,`content`,`createDate`,`likeCount`,`unlikeCount`,`shareCount`)
								 VALUES ('$id','$title','$content','$date','0','0','0');";
		// echo $sql . "<br/>";
		// break;
		if ($database->query($sql)) {
			//echo "success" . "<br/>";
			$index++;
		} else {
			echo "error" . mysql_error() . "<br/>";
			echo $sql . "<br/>";
			$finish = true;
			break;
		}
	}
	if ($finish) {
		echo "第 " . $i . " 页" . "<br/>";
		break;
	}
}
//替换多余的换行
$sql = "UPDATE jokeList SET `content` = REPLACE(`content`, '\n\n', '\n')";
$database->query($sql);

echo "更新[ " . $index . " ]条笑话" . "<br/>";


// print_r($res);


?>