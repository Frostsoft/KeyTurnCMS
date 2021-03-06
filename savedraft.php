<?php

include_once('init.php');
include_once('functions.php');
    
function endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 || 
    (substr($haystack, -$length) === $needle);
}

if(isset($_POST['page']) && isset($_POST['body'])){

$stmt = $connection->prepare("SELECT value FROM settings WHERE name = 'website'");
$stmt->execute();
$website = $stmt->fetchColumn();

$url = $website;
if(!endsWith($url, "/"))
    $url = $url . "/";

$page = $_POST['page'];

$body = base64_decode($_POST['body']);
$body = str_replace($url, "{%ROOT_URL%}", $body);
$url_nowww = str_replace("www.", "", $url);
$body = str_replace($url_nowww, "{%ROOT_URL%}", $body);

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

userActionPage($connection, $page, "publish", 2);

header("Location: pages.php?p=".$page."&saved=1");
}
}else{
header("Location: pages.php?p=".$page);
}

?>