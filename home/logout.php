<?php

require_once "../model/common.php";
session_start();
// unset specific session variable
unset($_SESSION['email']);
unset($_SESSION['user']);
unset($_SESSION['position']);

// clear all session variables
session_unset(); // same as doing $_SESSION = array();
// Your session is still alive
// after this, you can still register a new session variable to the current session

// destroys the whole session
session_destroy(); // opposite of session_start();

// forward the user back to home.php
header('Location: home.php');
return;

?>