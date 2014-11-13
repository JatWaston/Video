<?php

require_once('./ImageSpider.class.php');
require_once('./MessageResponse.class.php');

header("Content-Type: text/html;charset=utf-8");


$imageSpider = new ImageSpider();

$imageSpider->fetchContent('http://www.gaoxiaodashi.com/egaozhenggu/');


?>