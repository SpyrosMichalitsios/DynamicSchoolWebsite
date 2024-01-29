<?php
    //CANCEL BUTTON
    if(isset($_POST['cancel-btn'])){
        header('Location: users.php');
        exit();
    }
    //WE KEEP THE ERROR MESSAGES IN THIS ARRAY.
    $errors=array('email'=>'','name'=>'','surname'=>'','password'=>'','exists'=>'');

    //IF WE WANT TO EDIT WE HAVE TO RETRIEVE THE VALUES FROM THE DATABASE
    if(isset($_POST['edit-user']) || isset($_POST['edit-user-btn'])){
        
        //CONNECT TO THE DATABASE
        require "connect_db.php";
        $edit_user=$_POST['user-to-edit'];
        //WRITE QUERY
        $sql="SELECT * FROM Users WHERE Email='$edit_user' ";

        //GET RESULT
        $result=mysqli_query($connect,$sql);

        //MAKE IT AN ASSOCIATIVE ARRAY
        $userDetails=mysqli_fetch_assoc($result);
        //INITIALIZE FIELDS
        $name=$userDetails['Name'];
        $surname=$userDetails['Surname'];
        $email=$userDetails['Email'];
        $password=$userDetails['Password'];

        //FREE RESULT
        mysqli_free_result($result);   

        //CLOSE CONNECTION
        mysqli_close($connect);
    }

    //IF ONE OF THE BUTTONS IS PRESSED
    if(isset($_POST['add-user-btn']) || isset($_POST['edit-user-btn'])){
        //WE EMPTY THE VARIABLES  TO OUTPUT THE CORRECT VALUES
        $email=$name=$surname=$password="";

        //IF THE EMAIL INPUT IS EMPTY
        if(empty($_POST['email'])){
            $errors['email']="*Το πεδίο E-mail δεν μπορει να είναι κενό.<br/>";
        }else{
            //IF THE  EMAIL FORM IS INVALID
            if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                $errors['email']="*Το E-mail δεν έχει την σωστή μορφή.<br/>";
            }
            //INITIALIZE EMAIL
            $email=$_POST['email'];
        }

        //IF THE NAME INPUT IS EMPTY
        if(empty($_POST['name'])){
            $errors['name']="*Το Όνομα δεν μπορει να είναι κενό.<br/>";
        }else{//INITIALIZE NAME
            $name=$_POST['name'];
        }

        //IF THE SURNAME INPUT IS EMPTY
        if(empty($_POST['surname'])){
            $errors['surname']="*Το Επώνυμο δεν μπορει να είναι κενό.<br/>";
        }else{//INITIALIZE SURNAME
            $surname=$_POST['surname'];
        }

        //IF THE PASSWORD INPUT IS EMPTY
        if(empty($_POST['password'])){
            $errors['password']="*Το Password δεν μπορει να είναι κενό.<br/>";
        }else{//INITIALIZE PASSWORD
            $password=$_POST['password'];
        }

        //IF THERE ARE NO ERRORS
        if(!array_filter($errors)){

            //CONNECT TO THE DATABASE
            require "connect_db.php";

            //PREVENT MALICIOUS CONTENT
            $email=mysqli_real_escape_string($connect,$_POST['email']);
            $name=mysqli_real_escape_string($connect,$_POST['name']);
            $surname=mysqli_real_escape_string($connect,$_POST['surname']);
            $password=mysqli_real_escape_string($connect,$_POST['password']);
            $role="student";//THE ROLE IS ALWAYS STUDENT

            //THE EDIT_USER IS LOST SO WE HAVE TO INITIALIZE IT AGAIN
            $edit_user= $_POST['user-to-edit'];


            //CHECK IF USER ALREADY EXISTS
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
                    //IF THE EMAIL EXISTS IN THE DATABASE (IF WE TRY TO EDIT THE EMAIL AND THE EMAIL MATCHES AN EXISTING EMAIL)
                    if($em==$email && $em!=$edit_user){
                        $errors['exists']='Το e-mail χρησιμοποιείται ήδη.';
                        break;//NO NEED TO KEEP LOOKING
                    }
                }
            }
        
            //IF WE WANT TO EDIT A USER
            if(isset($_POST["edit-user-btn"])){
                $sql = "UPDATE Users SET Email='$email', Name='$name', Surname='$surname', Password='$password'
                WHERE Email='$edit_user' ";
                //IF IT WAS SUCCESFULL
                if(mysqli_query($connect,$sql)){            
                    //CLOSE CONNECTION
                    mysqli_close($connect);   
                    //REDIRECT TO USERS PAGE
                    header('Location: users.php');
                    exit();
                }else{//IF THERE WAS AN ERROR
                    echo 'Error:' . mysqli_error($connect);
                }
            }else{//IF WE WANT TO ADD A USER TO THE DATABASE
                if((empty($errors['exists']))){//IF THE USER DOESNT EXIST ALREADY
                    $sql="INSERT INTO Users(Email,Name,Surname,Password,Role) VALUES('$email',
                    '$name','$surname','$password','$role')";
                    //IF IT WAS SUCCESFULL
                    if(mysqli_query($connect,$sql)){            
                        //CLOSE CONNECTION
                        mysqli_close($connect);   
                        //REDIRECT TO USERS PAGE
                        header('Location: users.php');
                        exit();
                    }else{//IF THERE WAS AN ERROR
                        echo 'Error:' . mysqli_error($connect);
                    } 
                }
            }

        }

    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Νέος Χρήστης</title>
    <link rel="stylesheet" href="css/common.css">

</head>
<body>
    <!-- DIFFRENT HEADINGS FOR ADDING OR EDITING A USER -->
    <h1>
        <?php if(isset($_POST['edit-user']) || isset($_POST['edit-user-btn']) ){?>
            Επεξεργασία Χρήστη
        <?php }else{?>
            Νέος Χρήστης
        <?php }?>
        <a id='logout-link' href='logout.php'>Έξοδος</a>
    </h1>


    <form action="user_form.php" class="add-edit-form" method="POST">
        
        <!--NAME -->
        <label for="name">Όνομα:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name)?>">
        <div class="error"><?php echo $errors['name']?> </div>
        <!--SURNAME -->
        <label for="surname">Επώνυμο:</label>
        <input type="text" name="surname" id="surname" value="<?php echo htmlspecialchars($surname)?>">
        <div class="error"><?php echo $errors['surname']?> </div>
        <!--EMAIL -->
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email)?>">
        <div class="error"><?php echo $errors['email']?> </div>
        <!--PASSWORD -->
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password)?>">
        <div class="error"><?php echo $errors['password']?> </div>

        <!-- IF WE WANT TO EDIT THE USER -->
        <?php if(isset($_POST['edit-user']) || isset($_POST['edit-user-btn'])){?>
            <input type="hidden" name='user-to-edit' value='<?php echo htmlspecialchars($userDetails['Email']) ?>'>
            <input type="submit" name="edit-user-btn" value="Επεξεργασία Χρήστη" class="form-btn">
        <?php }else{ ?>
            <input type="submit" name="add-user-btn" value="Προσθήκη Χρήστη" class="form-btn">
        <?php }?>
        <input type="submit" name="cancel-btn" value="Άκυρο" class="form-btn">
        <div class="error"><?php echo $errors['exists']?> </div>
    </form>
   

</body>
</html>