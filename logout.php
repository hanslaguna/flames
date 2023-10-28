<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Show success message
echo '<div class="alert alert-success">You have successfully logged out.</div>';

// Redirect the user to the login page
header("Location: home.php");
exit();
?>
