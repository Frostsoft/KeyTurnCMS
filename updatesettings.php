<?php

include_once('init.php');

if($user_level < 1){
	header("Location: settings.php?denied=1");
}

if(isset($_POST['submit'])){

	$stmt = $connection->prepare("UPDATE settings   
	SET `value` = :value,
		`lastedit` = TIMESTAMP
	WHERE `name` = :name");

	$stmt->bindValue(":value", $_POST['web_url']);
	$stmt->bindValue(":name", "website");
	$stmt->execute();

	$stmt->bindValue(":value", $_POST['company_name']);
	$stmt->bindValue(":name", "company");
	$stmt->execute();

	if(isset($_POST['devop'])){
		$devop = true;
	}else{
		$devop = false;
	}

	$options['dev_ops'] = $devop;

	$options = json_encode($options);

	$stmt = $connection->prepare("UPDATE `users`   
	SET `options` = :options
	WHERE `username` = :name");

	$stmt->bindValue(":options", $options);
	$stmt->bindValue(":name", $_SESSION['user']);
	$stmt->execute();

	header("Location: settings.php");
}else{
	header("Location: settings.php?err=1");
}

?>