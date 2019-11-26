<?php
// show error reporting
error_reporting(E_ALL);

// start php session
session_start();

// set your default time-zone
date_default_timezone_set('Asia/Manila');

// home page url
$home_url="http://localhost:8888/acc3/login.php";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

//define errors variable
$errors = [];

//after how long the password will become expired
// Example of value https://www.php.net/manual/en/function.strtotime.php
$expired = '+1 month';

?>
