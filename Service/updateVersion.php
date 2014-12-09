<?php

require_once('./MessageResponse.class.php');
require_once('./Database.class.php');
require_once('./commonParams.php');
require_once('./respond.config.php');

header("Content-Type: text/html;charset=utf-8");

$database = Database::getInstance();

$latestVersion = $_GET['latest_version'];
$updateContet = $_GET['update_content'];
$storeName = $_GET['store'];



if (isset($_GET['save'])) {
	echo "保存版本" . "<br/>";
	$sql = "UPDATE `versionUpdate` SET `latestVersion` = '{$latestVersion}',`updateMessage` = '{$updateContet}',`isPublish` = '0' WHERE `storeName` = '{$storeName}';";
	echo $sql . "<br/>";
	$database->query($sql);
} else if ($_GET['publish']) {
	echo "发布版本" . "<br/>";
	$sql = "UPDATE `versionUpdate` SET `isPublish` = '1' WHERE `storeName` = '{$storeName}';";
	echo $sql . "<br/>";
	$database->query($sql);
}

echo "更新内容: " . $_GET['update_content'];
echo "平台: " . $_GET['store'];
echo "强制更新: " . $_GET['force_update'];
echo "最新版本: " . $_GET['latest_version'];

?>