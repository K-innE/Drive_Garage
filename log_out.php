<?php

include 'config.php';

session_start();
session_unset();
session_destroy();

// Update user's activity status to offline
$user_id = $_SESSION['user_id']; 
mysqli_query($conn, "UPDATE users_activity_status SET status='offline' WHERE user_id='$user_id'");


header('location:log_in.php');
exit(); // Added exit to stop script execution
?>