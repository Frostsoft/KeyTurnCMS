<?php
include_once("config.php");
$connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

$stmt = $connection->prepare("SELECT `enabled` FROM `trackers` WHERE `page` = '$page'");
$stmt->execute();
if($stmt->fetchColumn() == 1){
	$stmt = $connection->prepare("UPDATE trackers SET value = value + 1 WHERE page = '$page'");
	$stmt->execute();
}