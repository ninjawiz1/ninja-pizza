<?php 
// connect to database
$conn = mysqli_connect('localhost', 'Aman', 'root', 'ninja_pizza');

// check connection
if(!$conn){
    echo 'connection error: ' . mysqli_connect_error();
}

?>