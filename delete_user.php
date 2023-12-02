<?php

include 'session.php';

include 'config.php';

/*
$id = $_GET['id'];
$select_users = mysqli_query($conn, "DELETE FROM `users` WHERE id=$id") or die('query failed');

header("Location:modify.php");
exit(); // Added exit to stop script execution
*/

$id = $_GET['id'];
$sql_delete_user = "DELETE FROM `users` WHERE id=$id";

if (mysqli_query($conn, $sql_delete_user)) {
    header("Location: modify.php");
    exit(); // Stops script execution after sending the header
} else {
    die('Query failed: ' . mysqli_error($conn));
}


?>