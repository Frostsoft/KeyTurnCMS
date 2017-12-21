<?php
include_once("init.php");

if($user_level == 2){

$my_version = file_get_contents("data/version.dat");

$opts = [
  'http' => [
          'method' => 'GET',
          'header' => [
                  'User-Agent: PHP'
          ]
  ]
];


$web_version = file_get_contents("https://api.github.com/repos/Frostsoft/KeyTurnCMS/releases/latest", false, stream_context_create($opts));
$json = json_decode($web_version, true);

$tag = $json['tag_name'];

if($my_version != $web_version){
    file_put_contents("tmpupdate.zip", fopen("http://github.com/repos/Frostsoft/KeyTurnCMS/archive/" . $tag . ".zip", 'r'));


    $path = pathinfo(realpath("tmpupdate.zip"), PATHINFO_DIRNAME);
    
    $zip = new ZipArchive();
    $res = $zip->open("tmpupdate.zip");
    if ($res === TRUE) {
      $zip->extractTo($path);
      $zip->close();
      file_put_contents("version.dat", $tag);
      unlink("tmpupdate.zip");

      $options['patch_noshow'] = "false";
      
      $options = json_encode($options);
    
      $stmt = $connection->prepare("UPDATE `users`   
      SET `options` = :options
      WHERE `username` = :name");

      $stmt->bindValue(":options", $options);
      $stmt->bindValue(":name", $_SESSION['user']);

      if(file_exists("update_operations.php"))
        include("update_operations.php");

      header("Location: index.php?update=0");
    } else {
      header("Location: index.php?update=1");
    }
}else{
    header("Location: index.php?update=2");
}
}else{
  header("Location: index.php?noperm=1");
}

?>