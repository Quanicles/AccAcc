<?php
// core configuration
include_once "config/core.php";

// destroy session, it will remove ALL session settings
setcookie("user","",time()-3600);
//redirect to login page
header("Location: {$home_url}");

exit();
?>
