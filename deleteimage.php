<?php

include_once('init.php');

if($user_level > 0){
    if(isset($_POST['file'])){
        unlink($_POST['file']);
        echo "ok";
    }else{
        echo "no post";
    }
}else{
    echo "forbidden";
}

?>