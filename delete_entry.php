<?php
//CONNECT TO THE DATABASE
require "connect_db.php";
//INITIALIZE THE ID WE WANT TO DELETE
$delete_entry=mysqli_real_escape_string($connect,$_POST['entry-to-delete']);

//IF WE WANT TO DELETE AN ANNOUNCEMENT
if(isset($_POST['delete-announcement'])){
    //WRITE QUERY
    $sql="DELETE FROM Announcements WHERE id=$delete_entry";
    
    //IF IT WAS SUCCESFULL
    if(mysqli_query($connect,$sql)){
        //CLOSE CONNECTION
        mysqli_close($connect);   
        //REDIRECT TO ANNOUNCEMENT PAGE
        header('Location: announcements.php');
        exit();
    }else{//IF THERE WAS AN ERROR
        echo 'Error:' . mysqli_error($connect);
    }
}elseif(isset($_POST['delete-document'])){//IF WE WANT TO DELETE A DOCUMENT
    //WRITE QUERY
    $sql="DELETE FROM Documents WHERE id=$delete_entry";
    
    //IF IT WAS SUCCESFULL
    if(mysqli_query($connect,$sql)){
        //CLOSE CONNECTION
        mysqli_close($connect);   
        //REDIRECT TO ANNOUNCEMENT PAGE
        header('Location:documents.php');
        exit();
    }else{//IF THERE WAS AN ERROR
        echo 'Error:' . mysqli_error($connect);
    }
}elseif(isset($_POST['delete-homework'])){//WE WANT TO DELETE HOMEWORK
    //WRITE QUERY
    $sql="DELETE FROM Homework WHERE id=$delete_entry";
    
    //IF IT WAS SUCCESFULL
    if(mysqli_query($connect,$sql)){
        //CLOSE CONNECTION
        mysqli_close($connect);   
        //REDIRECT TO HOMEWORK PAGE
        header('Location: homework.php');
        exit();
    }else{//IF THERE WAS AN ERROR
        echo 'Error:' . mysqli_error($connect);
    }
    
}else{
    //WRITE QUERY
    $sql="DELETE FROM Users WHERE Email='$delete_entry'";
    
    //IF IT WAS SUCCESFULL
    if(mysqli_query($connect,$sql)){
        //CLOSE CONNECTION
        mysqli_close($connect);   
        //REDIRECT TO HOMEWORK PAGE
        header('Location: users.php');
        exit();
    }else{//IF THERE WAS AN ERROR
        echo 'Error:' . mysqli_error($connect);
    }
}


?>