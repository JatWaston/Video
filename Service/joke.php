<?php

require_once('./JokeSpider.class.php');
require_once('./MessageResponse.class.php');
require_once('./Youku.class.php');
require_once('./YoukuM3U8.class.php');
require_once('./Database.class.php');

header("Content-Type: text/html;charset=utf-8");


$spider = new JokeSpider();
$database = Database::getInstance();
$date = date("Y-m-d h:m:s");
for ($i=1; $i <=979; $i++) { 
	$url = "http://www.waduanzi.com/joke/page/" . $i;
	$res = $spider->fetchContent($url);
	// print_r($res);
	// break;
	$count = count($res);
	foreach ($res as $key => $value) {
		$content = $value['content'];
		$title = $value['title'];
		$id = md5($content);
		$sql = "INSERT INTO `jokeList` (`id`,`title`,`content`,`createDate`,`likeCount`,`unlikeCount`,`shareCount`)
								 VALUES ('$id','$title','$content','$date','0','0','0');";
		// echo $sql . "<br/>";
		// break;
		if ($database->query($sql)) {
			echo "success" . "<br/>";
		} else {
			echo "error" . mysql_error() . "<br/>";
			echo $sql . "<br/>";
			break;
		}
	}
}

echo "============ END ============" . "<br/>";


// print_r($res);


?>