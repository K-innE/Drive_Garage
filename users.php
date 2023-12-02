<?php

include 'config.php';
/*
$username ="AAA";
$password = sha1("A1");
$password2= crypt("A114148148",'');
*/

$sql = "SELECT * FROM `users` WHERE email = 'v@gmail.com' AND password = 'v1' ";
$result = $conn->query($sql);
if ($result->num_rows == 1){
    echo "<br> User Exist <br>";}else{
        echo"user not found<br>" ;
    }
/*
    if (mysqli_num_rows($result) > 0) {
        echo "User exist";
        
    } else {

        echo $password;

        
    }*/
  


?>