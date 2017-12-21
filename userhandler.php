<?php

include_once('init.php');

if($user_level!=2){
    header("Location:index.php");
}

$options = [
    'cost' => 12,
];

if(isset($_POST['lastname'])){
    $lastname = $_POST['lastname'];
    $stmt = $connection->prepare("DELETE FROM users WHERE username = '$lastname'");
    $stmt->execute();
}

/**
//for is admin is changing password
if(isset($_POST['save_changes'])){
    if(isset($_POST['change_pass']) && isset($_POST['lastname'])){
        foreach($userxml->user as $user){
            if($user->name == $_POST['lastname']){
                $user->pass = password_hash($_POST['change_pass'], PASSWORD_BCRYPT, $options);
                $userxml->asXML('data/users/users.xml');
                header("Location:users.php");
            }
        }
    }
}**/

if(isset($_POST['change_user'])){
    if(isset($_POST['change_pass']) && isset($_POST['change_level']) && isset($_POST['change_name'])){

        if($_POST['change_level'] == "Editor")
            $level = "0";
        if($_POST['change_level'] == "Manager")
            $level = "1";
        if($_POST['change_level'] == "Administrator")
            $level = "2";

        if($_POST['change_pass'] == ""){
            
            $stmt = $connection->prepare("UPDATE `users` SET `userlevel` = :level WHERE `username` = :name");
            $stmt->bindValue(":level", $level);
            $stmt->bindValue(":name", $_POST['change_name']);
            $stmt->execute();
            header("Location:users.php?s=1");
            exit();

        }else{

            $pass = password_hash($_POST['change_pass'], PASSWORD_BCRYPT, $options);
            $stmt = $connection->prepare("UPDATE `users` SET `userlevel` = :level, `password` = :pass WHERE `username` = :name");
            $stmt->bindValue(":level", $level);
            $stmt->bindValue(":pass", $pass);
            $stmt->bindValue(":name", $_POST['change_name']);
            $stmt->execute();
            header("Location:users.php?s=2");
            exit();

        }
    }
}

if(isset($_POST['create_user'])){
    if(isset($_POST['new_name']) && isset($_POST['new_pass']) && isset($_POST['new_level'])){

        if($_POST['new_level'] == "Editor")
            $level = 0;
        if($_POST['new_level'] == "Manager")
            $level = 1;
        if($_POST['new_level'] == "Administrator")
            $level = 2;

        $new_user = array(
            "username" => $_POST['new_name'],
            "password"  => password_hash($_POST['new_pass'], PASSWORD_BCRYPT, $options),
            "userlevel"     => $level,
            "options"       => "{\"dev_ops\": true,\"patch_noshow\":false}"
        );
    
        $SQL_userinfo = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $stmt = $connection->prepare($SQL_userinfo);
        $stmt->execute($new_user);

        header("Location:users.php");
    }else{
        header("Location:users.php?e=1");
    }
}else{
    header("Location:users.php?e=2");
}

?>