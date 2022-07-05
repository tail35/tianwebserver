<?php
$host = '211.149.245.176';
$database = 'autodown';
$username = 'root';
$password = 't5m5y2b7';

$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);//创建一个pdo对象
if(!$pdo){
	echo json_encode(array("code" => "1", "errmsg" => "nullpdo"));
} 
$pdo->exec("set names 'utf8'");
?>