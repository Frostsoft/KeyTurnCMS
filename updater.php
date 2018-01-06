<?php
include_once("init.php");

if($user_level == 2){


  // UPDATER FUNCTIONS

  function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

// Function to Copy folders and files       
function rcopy($src, $dst) {
  if (is_dir ( $src )) {
      $files = scandir ( $src );
      foreach ( $files as $file )
          if ($file != "." && $file != "..")
              rcopy ( "$src/$file", "$dst/$file" );
  } else if (file_exists ( $src ))
      copy ( $src, $dst );
}

// END UPDATER FUNCTIONS


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
    file_put_contents("tmpupdate.zip", fopen("http://github.com/Frostsoft/KeyTurnCMS/archive/" . $tag . ".zip", 'r', false, stream_context_create($opts)));


    $path = pathinfo(realpath("tmpupdate.zip"), PATHINFO_DIRNAME);
    
    $zip = new ZipArchive;
    $res = $zip->open("tmpupdate.zip");
    if ($res === TRUE) {
      $zip->extractTo($path);
      $zip->close();
      file_put_contents("version.dat", $tag);
      unlink("tmpupdate.zip");

      $options['patch_noshow'] = false;
      
      $options = json_encode($options);
    
      $stmt = $connection->prepare("UPDATE `users`   
      SET `options` = :options
      WHERE `username` = :name");

      $stmt->bindValue(":options", $options);
      $stmt->bindValue(":name", $_SESSION['user']);

      $stmt->execute();

      $dir = realpath(dirname(__FILE__)) . "/KeyTurnCMS-".$tag;
      rcopy($dir, realpath(dirname(__FILE__)));
      deleteDir($dir);

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