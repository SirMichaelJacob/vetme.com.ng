<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/controller.php';

if(!adminIsLoggedIn())
{

	header('Location:../login/');
	exit(); 
}



if(isset($_GET['logout']))
{
	session_start();
	unset($_SESSION['loggedIn']);
	unset($_SESSION['email']);
	unset($_SESSION['password']);
	unset($_SESSION['verified']);
	header('Location:.');
	exit();
}





include 'admin.html.php';
exit();

?>