<?php
session_start();

// reset the session so the php gc doesnt eat it
if (isset($_SESSION['user']))
$_SESSION['user'] = $_SESSION['user'];
else
header("Location: login.php?ref=1");

if(isset($_SESSION['LAST_ACTIVITY']))
$_SESSION['LAST_ACTIVITY'] = time();