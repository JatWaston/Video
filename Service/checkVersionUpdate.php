<?php

require_once('./MessageResponse.class.php');
require_once('./Database.class.php');
require_once('./commonParams.php');

header("Content-Type: text/html;charset=utf-8");

$database = Database::getInstance();

echo MessageResponse::createJSONMessage(0,'获取成功',array());

?>