<?php

include_once('init.php');
	
if(isset($_POST['page']) && isset($_POST['body'])){
$page = $_POST['page'];

$body = base64_decode($_POST['body']);

if($page == "menu" || $page == "landingmenu" || $page == "footer"){
    $stmt = $connection->prepare("UPDATE `globals`   
    SET `content` = :content
    WHERE `name` = :name");
    
    $stmt->bindValue(":content", $body);
    $stmt->bindValue(":name", $page);
    $stmt->execute();
    header("Location: globalelements.php?saved=1");
}else{

$stmt = $connection->prepare("UPDATE `pages`   
SET `content` = :content
WHERE `pagename` = :pagename");

$stmt->bindValue(":content", $body);
$stmt->bindValue(":pagename", $page);
$stmt->execute();

header("Location: pages.php?p=".$page."&saved=1");
}
}else{
header("Location: pages.php?p=".$page);
}

?>