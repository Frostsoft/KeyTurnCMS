<?php
session_start();

include("config.php");

$connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 18000)) {
    // last request was more than 5 hours ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

if(isset($_SESSION['user'])){

    $sql = "SELECT username, userlevel, options 
    FROM users
    WHERE username = :username";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':username', $_SESSION['user'], PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetch();

    if($result){
        $user_level = $result['userlevel'];
        $user_options = $result['options'];

        $options = json_decode($user_options, true);

        $isDeveloper = $options['dev_ops'];
    }else{
        header("Location:login.php?ref=1");
        exit();
    }

    $stmt = $connection->prepare("DELETE FROM `actions` WHERE `time` < NOW() - INTERVAL 7 DAY");
    $stmt->execute();

    file_put_contents("DEBUG_INIT.txt", $stmt->errorCode());

}else{
  header("Location:login.php?ref=1");
  exit();
}