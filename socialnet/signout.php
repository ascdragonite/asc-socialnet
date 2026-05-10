<?php

session_start();

// Clear session variables
$_SESSION = [];

// Destroy session
session_destroy();

// Redirect to signin page (or home if you prefer)
header("Location: /socialnet/signin.php");
exit;
