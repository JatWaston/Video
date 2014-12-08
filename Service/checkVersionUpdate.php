<?php

require_once('./MessageResponse.class.php');
require_once('./Database.class.php');
require_once('./commonParams.php');
require_once('./respond.config.php');

header("Content-Type: text/html;charset=utf-8");

$database = Database::getInstance();

$store = $params['store'];
$version = $params['version'];
$sql = "SELECT * FROM `versionUpdate` WHERE `store` = '{$store}' AND `isPublish` = '1' AND `latestVersion` > '{$version}';";

// $content = nl2br("1.测试内容\n 2.测试内容2\n 3.测试内容3\n");
// $sql = "UPDATE `versionUpdate` SET `updateMessage` = '{$content}'";

// $database->query($sql);
// return;
//echo $sql . "<br/>";
$res = $database->fetch_obj_arr($sql);
//var_dump($res);
$code = SUCCESS;
$message = "数据获取成功";
if (empty($res)) 
{
	$message = "无此数据";
	$code = FAILURE;
}
return MessageResponse::message($code,$message,$res);

?>