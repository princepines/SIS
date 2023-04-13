<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
if (isset($_SESSION['loggedin'])) {
	if($_SESSION['account'] == "student"){
		header("location: accounts/student.php");
	}
	// Redirect user to teacher page if account is teacher
	elseif($_SESSION['account'] == "teacher"){
		header("location: accounts/teacher.php");
	}
	// Redirect user to cashier page if account is cashier
	elseif($_SESSION['account'] == "cashier"){
		header("location: accounts/cashier.php");
	}
	// Redirect user to registrar page if account is registrar
	elseif($_SESSION['account'] == "registrar"){
		header("location: accounts/registrar.php");
	}
	exit;
}

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
?>