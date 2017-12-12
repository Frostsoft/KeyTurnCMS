<?php

function userActionPage($page, $type, $action){
    $stmt = $connection->prepare("INSERT INTO `actions` VALUES `action` = :action, `page` = :page, `user` = :user, `type` = :type");
    $stmt->bindValue(":action", $action);
    $stmt->bindValue(":page", $page);
    $stmt->bindValue(":user", $_SESSION['user']);
    $stmt->bindValue(":type", $type);
    $stmt->execute();
}

function userAction($type, $action){
    $stmt = $connection->prepare("INSERT INTO `actions` VALUES `action` = :action, `user` = :user, `type` = :type");
    $stmt->bindValue(":action", $action);
    $stmt->bindValue(":user", $_SESSION['user']);
    $stmt->bindValue(":type", $type);
    $stmt->execute();
}