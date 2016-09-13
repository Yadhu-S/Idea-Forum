<?php
//signout.php
require('../includes/connect.php');
require('../includes/header.php');
require('../includes/function.php');

//check if user if signed in
if($_SESSION['signed_in'] == true)
{
	//unset all variables
	$_SESSION['signed_in'] = NULL;
	$_SESSION['user_name'] = NULL;
	$_SESSION['user_id']   = NULL;
	$_SESSION['user_level'] = NULL;
	redirect_to("index.php");
}

include '../includes/footer.php';
?>