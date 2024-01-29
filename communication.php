<?php 
    $sender=$message_body=$subject=$submit_message="";
    $errors=array('sender'=>'','subject'=>'','message-body'=>'');//WE KEEP THE ERROR MESSAGES IN THIS ARRAY.
    //VALIDATION
    if(isset($_POST['send-btn'])){

        if(empty($_POST['sender'])){//IF THE SENDER INPUT IS EMPTY
            $errors['sender']="*Το πεδίο του αποστολέα δεν μπορεί είναι κενό.<br/>";
        }else{
            $sender=$_POST['sender'];
            if(!filter_var($sender,FILTER_VALIDATE_EMAIL)){//IF THE SENDERS EMAIL IS NOT IN A VALID FORM
                $errors['sender']="*Το e-mail του αποστολέα δεν έχει την σωστή μορφή.<br/>";
            } 
        }

        if(empty($_POST['subject'])){//IF THE SUBJECT IS EMPTY
            $errors['subject']="*Το πεδίο θέμα δεν μπορεί να είναι κενό.<br/>";
        }else {     
            $subject=$_POST['subject'];
        }

        if(empty($_POST['message-body'])){//IF THE SUBJECT IS EMPTY
            $errors['message-body']="*Το πεδίο Κέιμενο δεν μπορεί να είναι κενό.<br/>";
        }else {     
            $message_body=$_POST['message-body'];
        }    



        if(!array_filter($errors)){//IF THERE ARE NO ERRORS
            
            //CONNECT TO THE DATABASE
            require "connect_db.php";
    
            //WRITE QUERY        
            $sql="SELECT Email FROM  Users WHERE Role='tutor'";
            $result=mysqli_query($connect,$sql);
            if ($result) {
                $emails = array();
                //MAKE AN ARRAY FROM THE RESULT
                while ($row = mysqli_fetch_assoc($result)) {
                    $emails[] = $row['Email'];
                }
                //FREE RESULT
                mysqli_free_result($result); 
                require "send_email.php"; 
                foreach($emails as $em){
                    sendEmail($sender,$em, $subject, $message_body);
                }
                $subject=$message_body=$sender="";
                $submit_message="Το μήνυμα στάλθηκε επιτυχώς στους διδάσκοντες.";
            }else{//IF THERE WAS AN ERROR
                echo 'Error:' . mysqli_error($connect);
            }
        }
    }




?> 



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Επικοινωνία</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/communication.css">
</head>
<body>
    <h1>Επικοινωνία<a id='logout-link' href='logout.php'>Έξοδος</a></h1>

    <div class="communication-container page-container">
        <!-- NAVIAGATION BAR -->
        <?php require('navigation.php');?>      
                
        <div class="main-content">
            <p>Υπάρχουν δύο τρόποι επικοινωνίας με τον διδάσκοντα του μαθήματος:</p>
            <!-- WEB FORM -->
            <h2>Αποστολή e-mail μέσω web φόρμας:</h2>
            <form class="email-form" action="communication.php" method="POST">
                <!-- SENDER -->
                <label for="sender"><strong>Αποστολέας:</strong></label><br>
                <input type="text" id="sender" name="sender" value="<?php echo htmlspecialchars($sender)?>">
                <div class="error"><?php echo $errors['sender']?> </div> 
                <!-- SUBJECT -->
                <label for="subject"><strong>Θέμα:</strong></label><br>
                <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($subject) ?>">
                <div class="error"><?php echo $errors['subject']?> </div>
                <!-- MESSAGE-BODY -->
                <label for="message-body"><strong>Κείμενο:</strong></label><br>   
                <textarea id="message-body" name="message-body"><?php echo htmlspecialchars($message_body);?></textarea>
                <div class="error"><?php echo $errors['message-body']?> </div>
                <!-- SUBMIT-BTN -->
                <input type="submit" name="send-btn" id="send-btn"  value="Αποστολή">
                <div class="succesfull-message"><?php echo $submit_message?> </div>

            </form>
            <!-- E-MAIL PAGE-->
            <h2>Αποστολή e-mail με χρήση e-mail διέυθυνσης.</h2>
            <p>Μπορείτε να στείλετε e-mail μέσω προγράμματος αποστολής e-mail στην παρακάτω διεύθυνση ηλεκτρονικού ταχυδρομείου.</p>
            <a href="https://www.google.com/gmail/about/" target="_blank" rel="noreferrer noopener">tutorsadress@csd.auth.gr</a><br><br>

        </div>
   </div>
</body>
</html>