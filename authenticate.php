<?php
    //WRITE QUERY
    $sql='SELECT Email,Password,Role FROM Users';
    //GET RESULT
    $result=mysqli_query($connect,$sql);
    //MAKE IT AN ASSOCIATIVE ARRAY
    $credentials=mysqli_fetch_all($result,MYSQLI_ASSOC);
    //FREE RESULT
    mysqli_free_result($result);   
    //CLOSE CONNECTION
    mysqli_close($connect);

    foreach($credentials as $credential){
        //IF THE CREDENTIALS ARE CORRECT
        if($credential['Email']==$email && $credential['Password']==$password){
            //START A SESSION WITH THE USER'S ROLE TO SHOW THE PAGES ACCORDINGLY
            session_start();
            $_SESSION['user-role']=$credential['Role'];
            //REDIRECT TO THE WELCOME PAGE
            header('Location: welcome.php');
            exit();
        }
    }  
    //IF THE CREDENTIALS ARE WRONG
    $errors['invalid']="Το e-mail ή/και το password δεν αντιστοιχούν σε κάποιον λογαριασμό.";


?>