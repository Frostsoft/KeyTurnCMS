<?php
function endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 || 
    (substr($haystack, -$length) === $needle);
}

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    //throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    //echo $errstr . "\n";
}

$url = $_GET['url'];
if(!endsWith($url, "/"))
    $url = $url . "/";

//echo "<h1>Parser Results</h1>";
//echo '<textarea rows="12" style="width:100%;">';

set_error_handler("exception_error_handler", E_WARNING);

$page = $_GET['page'];
$page_file = $page;

/*
if($_GET['page'] == "home"){
    $page = "home";
    $page_file = "index.php";
}else{
    $page = $_GET['page'];
    $page_file = $_GET['page'] . ".php";
}*/

$d = new DOMDocument;

$body_dom = new DOMDocument;
$head_dom = new DOMDocument;
$scripts_dom = new DOMDocument;

$d->loadHTML(file_get_contents($page_file));

$body = $d->getElementsByTagName('body')->item(0);
$head = $d->getElementsByTagName('head')->item(0);
$scripts = $d->getElementsByTagName('script');


foreach ($scripts as $child) {
        $scripts_dom->appendChild($scripts_dom->importNode($child, true));
}


foreach ($body->childNodes as $child){
    if($child->nodeName == "script"){
        //skip this tag
    /*}else if($child->nodeName == "img"){
        if(strpos($child->getAttribute("src"), "http://") === false && strpos($child->getAttribute("src"), "https://") === false){
             $child->setAttribute("src", $url.$child->getAttribute("src"));
             $body_dom->appendChild($body_dom->importNode($child, true));
        }else{
            $body_dom->appendChild($body_dom->importNode($child, true));
        }*/
    }else{
        $body_dom->appendChild($body_dom->importNode($child, true));
    }
}

foreach ($head->childNodes as $child){
    if($child->nodeName == "title"){
        //skip this tag
    }else{
        if($child->nodename == "script"){
            //skip this tag
        }else{
            $head_dom->appendChild($head_dom->importNode($child, true));
        }
    }
}

$body_html = preg_replace('/<\?.*?\?>/ms', '', $body_dom->saveHTML());

$pagename = str_replace("../", "", preg_replace('/\\.[^.\\s]{3,4}$/', '', $_GET['page']));

$response = array(
    "pageurl" => $_GET['page'],
    "pagename" => $pagename,
    "pretty_name" => $pagename,
    "content" => htmlspecialchars($body_html),
    "head" => htmlspecialchars($head_dom->saveHTML()),
    "sub" => htmlspecialchars($scripts_dom->saveHTML()),
    "description" => "",
    "keywords" => "",
    "title" => ""
);

$jsonvar = htmlspecialchars(json_encode($response, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_TAG), ENT_QUOTES, 'UTF-8');

echo $jsonvar;
restore_error_handler();

?>