<?php
    $errors=array('email'=>'','password'=>'','name'=>'','surname'=>'','exists'=>'');//WE KEEP THE ERROR MESSAGES IN THIS ARRAY.
    //IF THE SIGNUP BUTTON WAS PRESSED
    if(isset($_POST['signup-btn'])){

        //IF THE NAME INPUT IS EMPTY
        if(empty($_POST['name'])){
            $errors['name']="*Το πεδίο Όνομα δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE NAME
            $name=$_POST['name'];
        }
        //IF THE SURNAME INPUT IS EMPTY
        if(empty($_POST['surname'])){
            $errors['surname']="*Το πεδίο Επώνυμο δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE SURNAME
            $surname=$_POST['surname'];
        }
        //IF THE EMAIL INPUT IS EMPTY
        if(empty($_POST['email'])){
            $errors['email']="*Το πεδίο E-mail δεν μπορει να είναι κενό.<br/>";
        }else{
            //IF THE  EMAIL FORM IS INVALID
            if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                $errors['email']="*Το E-mail δεν έχει την σωστή μορφή.<br/>";
                $email=$_POST['email'];
            }
        }
        //IF THE PASSWORD INPUT IS EMPTY
        if(empty($_POST['password'])){
            $errors['password']="*Το πεδίο password δεν μπορεί να είναι κενό.";
        }

        //IF THERE ARE NO ERRORS 
        if(!array_filter($errors)){//RETURNS FALSE IF THE ELEMENTS OF THE ARRAY ARE EMPTY
            //CONNECT TO THE DATABASE
            require "connect_db.php";

            //PREVENT MALICIOUS CONTENT AND INITIALIZE FIELDS
            $email=mysqli_real_escape_string($connect,$_POST['email']);
            $name=mysqli_real_escape_string($connect,$_POST['name']);
            $surname=mysqli_real_escape_string($connect,$_POST['surname']);
            $password=mysqli_real_escape_string($connect,$_POST['password']);
            $role=$_POST['role'];


            //CHECK IF USER ALREADY EXISTS

            //WRITE QUERY TO GET ALL EMAILS
            $sql='SELECT Email FROM  Users';
            $result=mysqli_query($connect,$sql);
            if ($result) {
                $emails = array();
                //MAKE AN ARRAY FROM THE RESULT
                while ($row = mysqli_fetch_assoc($result)) {
                    $emails[] = $row['Email'];
                }
                //FREE RESULT
                mysqli_free_result($result);  
                foreach($emails as $em){
                    if($em==$email){//IF THE EMAIL EXISTS IN THE DATABASE
                        $errors['exists']='Το e-mail χρησιμοποιείται ήδη.';
                        break;//NO NEED TO KEEP LOOKING
                    }
                }
            }

            //SAVE THE NEW USER IN THE DATABASE
            if(empty($errors['exists'])){//IF THE USER DOES NOT EXIST
                
                //QUERY TO SAVE THE FIELDS TO THE DATABASE
                $sql="INSERT INTO Users(Email,Name,Surname,Password,Role) VALUES('$email',
                '$name','$surname','$password','$role')";   
                
                //SAVE TO THE DATABASE
                
                if(mysqli_query($connect,$sql)){//IF IT WAS SUCCESFULLY SAVED
                    //CLOSE CONNECTION
                    mysqli_close($connect);   
                    //REDIRECT TO LOGIN PAGE
                    header('Location: index.php');
                }else{//IF THERE WAS AN ERROR
                    echo 'Error:' . mysqli_error($connect);
                }


            }

            //CLOSE CONNECTION
            mysqli_close($connect);

        }
        


    }

?>

<!DOCTYPE html>
    <html lang="en">
    <head>  
        <meta charset="utf-8">  
        <title>Εγγραφή</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/signup.css">

    </head>
    <body>
        <h1>Εγγραφή</h1>
        <div class="signup-container">
            <!-- SIGNUP FORM -->
            <form action="signup.php" class="signup-form" method="POST">
                <!-- NAME -->
                <label for="name">Όνομα:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name)?>">
                <div class="error"><?php echo $errors['name']?> </div>
                <!-- SURNAME -->
                <label for="surname">Επώνυμο:</label>
                <input type="text" name="surname" id="surname" value="<?php echo htmlspecialchars($surname)?>">
                <div class="error"><?php echo $errors['surname']?> </div>
                <!-- EMAIL -->
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email)?>">
                <div class="error"><?php echo $errors['email']?> </div>
                <!--PASSWORD -->
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <div class="error"><?php echo $errors['password']?> </div>
                <!--ROLE-->
                <!-- STUDENT -->
                <label for="student">Μαθητής:</label>
                <input type="radio" name="role" id="student" value="student" checked>
                <!-- TUTOR -->
                <label for="tutor">Διδάσκων:</label>
                <input type="radio" name="role" id="tutor" value="tutor">
                <!--SIGNUP BUTTON -->
                <input type="submit" name="signup-btn" value="Εγγραφή" class="form-btn" >
            </form>
            <div class="error"><?php echo $errors['exists']?> </div>
            <div class='login-msg'>Έχετε ήδη λογαριασμό; Συνδεθείτε <a href="index.php">εδώ</a>. </div>

        </div>

        
    </body>
</html>