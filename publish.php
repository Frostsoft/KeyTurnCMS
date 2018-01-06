<?php

	include_once('init.php');
	include_once('functions.php');

	//publish only available to those higher than editor
	if($user_level < 1){
		header("Location: index.php");
	}

	$stmt = $connection->prepare("SELECT value FROM settings WHERE name = 'website'");
	$stmt->execute();
	$website = $stmt->fetchColumn();

	function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
	
		return $length === 0 || 
		(substr($haystack, -$length) === $needle);
	}

	$url = $website;
	if(!endsWith($url, "/"))
		$url = $url . "/";
	
	//Grab global css and scripts from globals table
	//Grab content head and sub from page
	//build the header of the page using globals and the page head
	//build the body
	//build the sub using globals and page sub

	//this file builds the editors draft into a publishable page
	//use this function to unescape xml strings: htmlspecialchars_decode 
	$page = $_GET['p'];

	if(isset($_GET['global']) && isset($_GET['p'])){
		if($page == "menu" || $page == "landingmenu" || $page == "footer"){
			$stmt = $connection->prepare("SELECT content FROM globals WHERE name = '" . $page . "'");
			$stmt->execute();
			$code = $stmt->fetch()['content'];
			
			file_put_contents("../".$page.".php", $code);
			header("Location: globalelements.php");
		}
	}else{

	$stmt = $connection->prepare("SELECT head, sub, content, title, description, keywords FROM pages WHERE pagename = '" . $_GET['p'] . "'");
    $stmt->execute();
	$row = $stmt->fetch();

	if($page == "index"){
		$menu = "<?php include_once('landingmenu.php');?>";
	}else{
		$menu = "<?php include_once('menu.php');?>";
	}

	$footer = "<?php include_once('footer.php');?>";

	$sub = "";
	$head = "";

	$title = $row['title'];
	$desc = $row['description'];
	$keywords = $row['keywords'];
	$head .=  htmlspecialchars_decode($row['head']);
	$body =  htmlspecialchars_decode($row['content']);
	$sub .=  htmlspecialchars_decode($row['sub']);

	$body = str_replace("{%ROOT_URL%}", $url, $body);

	//Fetch all globals
	$stmt = $connection->prepare("SELECT type, content FROM globals");
	$stmt->execute();
	while($row = $stmt->fetch()){
		if($row['type'] == "meta" || $row['type'] == "css"){
			$head .= htmlspecialchars_decode($row['content']);
		}else if($row['type'] == "script"){
			$sub .= htmlspecialchars_decode($row['content']);
		}
	}

	$head = str_replace("{%ROOT_URL%}", $url, $head);
	$sub = str_replace("{%ROOT_URL%}", $url, $sub);

	$code = "<?php \$page='$page'; include_once('keyturn/tracker.php');?><html><head><title>$title</title><meta name=\"description\" content=\"" . $desc . "\"><meta name=\"keywords\" content=\"" . $keywords . "\">$head</head><body>$menu $body $footer $sub</body></html>";

	file_put_contents("../".$page.".php", $code);

	userActionPage($connection, $page, "publish", 1);

	header("Location: pages.php?p=$page&pub=1");	
}

?>