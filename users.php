<?php
    //START A SESSION
    session_start();

    //WE NEED A COUNTER TO SHOW THE NUMBER OF EACH USER
    $counter=1;

    //CONNECT TO THE DATABASE
    require "connect_db.php";

    //WRITE QUERY
    $sql='SELECT * FROM Users WHERE Role="student" ';
 
    //GET RESULT
    $result=mysqli_query($connect,$sql);
 
    //MAKE IT AN ASSOCIATIVE ARRAY
    $users=mysqli_fetch_all($result,MYSQLI_ASSOC);
 
    //FREE RESULT
    mysqli_free_result($result);   
 
    //CLOSE CONNECTION
    mysqli_close($connect);
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Χρήστες</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/users.css">
    </head>
    <body>  
        <h1>Χρήστες<a id='logout-link' href='logout.php'>Έξοδος</a></h1>
    
        <div class=" page-container">
            <!-- NAVIGATION BAR -->
            <?php require('navigation.php');?>      

            <!-- USERS -->
            <div class="main-content users-content">
                <!-- ADD USER BUTTON -->
                <a href='user_form.php'>Προσθήκη νέου χρήστη</a>
                
                <!-- FOR EVERY USER IN THE DATABASE -->
                <?php foreach($users as $user){?> 
                    <h2>Χρήστης <?php echo $counter; //THE NUMBER OF THE CURRENT USER ?>
                        <form action='user_form.php' method='POST'>
                            <!--EDIT BTN-->
                            <input type="hidden" name='user-to-edit' value='<?php echo htmlspecialchars($user['Email']) ?>'>
                            <input type="submit" name="edit-user" value="Επεξεργασία" class="edit-delete-btn">
                        </form>     
                        <form action='delete_entry.php' method='POST'>
                            <!--DELETE BTN -->
                            <input type="hidden" name='entry-to-delete' value='<?php echo $user['Email'] ?>'>
                            <input type="submit" name="delete-user" value="Διαγραφή" class="edit-delete-btn">
                        </form>     
                    </h2>
                    <!-- EMAIL -->
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']);?></p>
                    <!-- NAME -->
                    <p><strong>Όνομα:</strong><?php echo htmlspecialchars($user['Name']);?></p>
                    <!--SURNAME -->
                    <p><strong>Επώνυμο:</strong><?php echo htmlspecialchars($user['Surname']);?></p>
                    <!-- PASSWORD-(HIDE IT FIRST) -->
                    <?php $hiddenPasswd= str_repeat('*',strlen(htmlspecialchars($user['Password']))) ?>
                    <p><strong>Password:</strong><?php echo $hiddenPasswd;?></p>

                    <hr>
                <?php $counter++;} //INCREASE THE COUNTER ?>
                    
                <!-- BACK TO TOP BUTTON -->
                <button onclick="window.location.href='#top'" id="toTopBtn"><img src="./img/up-arrow.jpg" alt="Back to top." width="50" height="50"></button>

            </div>
        </div>
    </body>
</html>    