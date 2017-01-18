<?php
ini_set('disply_errors', 1);
error_reporting(E_ALL);

define('APP_PATH', dirname(dirname(__FILE__)));

$app = new \Yaf\Application(require APP_PATH . '/conf/app.php');

$app->bootstrap()->run();
?>
