<?php

require_once('./MessageResponse.class.php');
require_once('./Database.class.php');
require_once('./respond.config.php');
require_once('./commonParams.php');
require_once('./config.ini.php');

header("Content-Type: text/html;charset=utf-8");

$page = $_GET['page'];
$pageSize = $_GET['pageSize'];
$contentType = $_GET['content'];

$md5 = md5($params['version'] . $params['store'] . $page . "Video");
if ($params['valid'] == $md5) {
	$from = ($page-1)*$pageSize;
	//$sql = "SELECT * FROM `videoList` WHERE type = {$type} ORDER BY createDate DESC LIMIT {$from},{$pageSize}";
	$table = 'videoList';
	if ($contentType == JWJokeType) {
		$table = 'jokeList';
	}
	$sql = "SELECT * FROM {$table} ORDER BY createDate DESC LIMIT {$from},{$pageSize}";
	//echo $sql . "<br/>";
	$database = Database::getInstance();
	$res = $database->fetch_obj_arr($sql);
	$message = "数据获取成功";
	$code = SUCCESS;
	if (empty($res)) 
	{
		$message = "无此数据";
		$code = FAILURE;
	}
	return MessageResponse::message($code,$message,$res);
} else {
	//echo "验证出错" . "<br/>";
	$code = FAILURE;
	$message = "验证出错";
	MessageResponse::message($code,$message);
}

?>