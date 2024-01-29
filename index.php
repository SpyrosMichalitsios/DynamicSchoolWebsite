<?php
    $errors=array('email'=>'','password'=>'','invalid'=>'');//WE KEEP THE ERROR MESSAGES IN THIS ARRAY.

    //IF THE LOGIN BUTTON WAS PRESSED
    if(isset($_POST['login-btn'])){

        //IF THE EMAIL INPUT IS EMPTY
        if(empty($_POST['email'])){
            $errors['email']="*Το πεδίο του email δεν μπορει να είναι κενό.<br/>";
        }else{
            {//IF THE  EMAIL IS NOT IN A VALID FORM
            if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
                $errors['email']="*Το e-mail δεν έχει την σωστή μορφή.<br/>";
            }
        }
        //IF PASSWORD INPUT IS EMPTY
        if(empty($_POST['password'])){
            $errors['password']="*Το πεδίο του password δεν μπορεί να είναι κενό.";
        }

        //IF THERE ARE NO ERRORS
        if(!array_filter($errors)){

            //CONNECT TO THE DATABASE
            require "connect_db.php";

            //PREVENT MALICIOUS CONTENT AND INITIALIZE FIELDS
            $email=mysqli_real_escape_string($connect,$_POST['email']);
            $password=mysqli_real_escape_string($connect,$_POST['password']);

            //AUTHENTICATE THE USER
            require 'authenticate.php';

            

        }

    }

?>



<!DOCTYPE html>
    <html lang="en">
    <head>  
        <meta charset="utf-8">  
        <title>Είσοδος</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/index.css">

    </head>
    <body>
        <h1>Είσοδος</h1>
        <div class="login-container">
            <!-- LOGIN FORM -->
            <form action="index.php" class="login-form" method="POST">
                <!-- EMAIL -->
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email)?>">
                <div class="error"><?php echo $errors['email']?> </div>
                <!--PASSWORD -->
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <div class="error"><?php echo $errors['password']?> </div>
                <!-- LOGIN BUTTON -->
                <input type="submit" name="login-btn" value="Είσοδος" class="form-btn">
            </form>
            <div class="error"><?php echo $errors['invalid']?> </div>
            <div class='signup-msg'>Δεν έχετε λογαριασμό; Δημιουργήστε έναν <a href="signup.php">εδώ</a>. </div>
        </div>

        
    </body>
</html>