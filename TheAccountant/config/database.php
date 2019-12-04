<?php

$servername = "accountantdb.cecg8fpgzvzf.us-east-1.rds.amazonaws.com";
$dbusername = "admin";
$dbpassword = "AppDomain!";
$dbname = "theaccdb";


$conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);



if(!$conn){
  die("Connection failed: " .mysqli_connect_error());
}
