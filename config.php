<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "projet";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
/*
$conn = mysqli_connect('localhost','root','','projet') or die('connection failed');
*/
?>
