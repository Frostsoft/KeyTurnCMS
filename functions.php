<?php


function userActionPage($connection, $page, $type, $action){
    $stmt = $connection->prepare("INSERT INTO `actions` (`action`, `page`, `user`, `type`) VALUES (:action, :page, :user, :type)");
    $stmt->bindValue(":action", $action);
    $stmt->bindValue(":page", $page);
    $stmt->bindValue(":user", $_SESSION['user']);
    $stmt->bindValue(":type", $type);
    $stmt->execute();
}

function userAction($connection, $type, $action){
    $stmt = $connection->prepare("INSERT INTO `actions` (`action`, `user`, `type`) VALUES (:action, :user, :type)");
    $stmt->bindValue(":action", $action);
    $stmt->bindValue(":user", $_SESSION['user']);
    $stmt->bindValue(":type", $type);
    $stmt->execute();
}