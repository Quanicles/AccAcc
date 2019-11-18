<?php

$servername = "root.cgb1kkiboypt.us-east-1.rds.amazonaws.com";
$dbusername = "root";
$dbpassword = "admin123";
$dbname = "theaccdb";


$conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);



if(!$conn){
  die("Connection failed: " .mysqli_connect_error());
}
