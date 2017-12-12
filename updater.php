<?php
include_once("init.php");

if($user_level == 2){

$my_version = file_get_contents("data/version.dat");
$web_version = file_get_contents("http://keyturnmedia.com/dev/repo/version_api.php");

if($my_version != $web_version){
    file_put_contents("tmpupdate.zip", fopen("http://keyturnmedia.com/dev/repo/keyturncms" . $web_version . ".zip", 'r'));


    $path = pathinfo(realpath("tmpupdate.zip"), PATHINFO_DIRNAME);
    
    $zip = new ZipArchive();
    $res = $zip->open("tmpupdate.zip");
    if ($res === TRUE) {
      $zip->extractTo($path);
      $zip->close();
      file_put_contents("version.dat", $web_version);
      unlink("tmpupdate.zip");

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