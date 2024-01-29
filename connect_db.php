<?php
    //CONNECT TO THE DATABASE
    $connect=mysqli_connect('host','username','password','database name');
    if(!$connect){
        echo "Connection failed:" . mysqli_connect_error();
    }
?>
