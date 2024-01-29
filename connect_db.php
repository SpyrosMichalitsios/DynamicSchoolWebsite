<?php
    //CONNECT TO THE DATABASE
    $connect=mysqli_connect('webpagesdb.it.auth.gr:3306','Spyridom','randompassword','student3211partB');
    if(!$connect){
        echo "Connection failed:" . mysqli_connect_error();
    }
?>