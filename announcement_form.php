<?php
    //CANCEL BUTTON
    if(isset($_POST['cancel-btn'])){
        header('Location: announcements.php');
        exit();
    }
    //WE KEEP THE ERROR MESSAGES IN THIS ARRAY.
    $errors=array('date'=>'','subject'=>'','maintext'=>'');

    //IF WE WANT TO EDIT WE HAVE TO RETRIEVE THE VALUES FROM THE DATABASE
    if(isset($_POST['edit-announcement']) || isset($_POST['edit-announcement-btn'])){
        
        //CONNECT TO THE DATABASE
        require "connect_db.php";
        //PROTECT THE DATABASE.MAKING SURE NO SPECIAL CHARACTERS ARE ENTERED
        $edit_id=mysqli_real_escape_string($connect,$_POST['id-to-edit']);

        //WRITE QUERY
        $sql="SELECT * FROM Announcements WHERE id=$edit_id ";

        //GET RESULT
        $result=mysqli_query($connect,$sql);

        //MAKE IT AN ASSOCIATIVE ARRAY
        $announcementDetails=mysqli_fetch_assoc($result);
        //INITIALIZE FIELDS
        $subject=$announcementDetails['Subject'];
        $maintext=$announcementDetails['MainText'];


        //FREE RESULT
        mysqli_free_result($result);   

        //CLOSE CONNECTION
        mysqli_close($connect);
    }

    //IF ONE OF THE BUTTONS IS PRESSED
    if(isset($_POST['add-announcement-btn']) || isset($_POST['edit-announcement-btn'])){
        //WE EMPTY THE VARIABLES  TO OUTPUT THE CORRECT VALUES
        $subject=$maintext="";

        //IF THE SUBJECT INPUT IS EMPTY
        if(empty($_POST['subject'])){
            $errors['subject']="*Το Θέμα δεν μπορει να είναι κενό.<br/>";
        }else{//INITIALIZE SUBJECT
            $subject=$_POST['subject'];
        }

        //IF MAINTEXT INPUT IS EMPTY
        if(empty($_POST['maintext'])){
            $errors['maintext']="*Το πεδίο δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE MAINTEXT
            $maintext=$_POST['maintext'];
        }

        //IF THERE ARE NO ERRORS
        if(!array_filter($errors)){

            //CONNECT TO THE DATABASE
            require "connect_db.php";

            //PREVENT MALICIOUS CONTENT
            $date=date('Y-m-d');//THE DATE IS THE CURRENT DATE THAT THE ANNOUNCEMENT IS CREATED OR EDITED.
            $subject=mysqli_real_escape_string($connect,$_POST['subject']);
            $maintext=mysqli_real_escape_string($connect,$_POST['maintext']);
            //THE EDIT_ID IS LOST SO WE HAVE TO INITIALIZE IT AGAIN
            $edit_id=$_POST['id-to-edit'];

            //IF WE WANT TO EDIT AN ANNOUNCEMENT
            if(isset($_POST["edit-announcement-btn"])){
                $date=$announcementDetails['date'];//WE KEEP THE ORIGINAL DATE NOT THE DATE WE ARE EDITING THE FILE
                $sql = "UPDATE Announcements SET Subject='$subject', MainText='$maintext'
                WHERE id='$edit_id'";
            }else{
                //IF WE WANT TO ADD AN ANNOUNCEMENT TO THE DATABASE
                $sql="INSERT INTO Announcements(Date,Subject,Maintext) VALUES('$date',
                '$subject','$maintext')"; 
            }

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

        }

    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Νέα ανακοίνωση</title>
    <link rel="stylesheet" href="css/common.css">

</head>
<body>
    <!-- DIFFRENT HEADINGS FOR ADDING OR EDITING AN ANNOUNCEMENT -->
    <h1>
        <?php if(isset($_POST['edit-announcement']) || isset($_POST['edit-announcement-btn'])){?>
            Επεξεργασία Ανακοίνωσης
        <?php }else{?>
            Νέα Ανακοίνωση
        <?php }?>
        <a id='logout-link' href='logout.php'>Έξοδος</a>
    </h1>


    <form action="announcement_form.php" class="add-edit-form" method="POST">
        <!--SUBJECT -->
        <label for="subject">Θέμα:</label>
        <input type="text" name="subject" id="subject" value="<?php echo htmlspecialchars($subject)?>">
        <div class="error"><?php echo $errors['subject']?> </div>
        <!-- MAIN TEXT -->
        <label for="maintext">Κυρίως κείμενο:</label>
        <textarea id="message-body" name="maintext"><?php echo htmlspecialchars($maintext);?></textarea>
        <div class="error"><?php echo $errors['maintext']?> </div>

        <!-- IF THE USER WANTS TO EDIT THE ANNOUNCEMENT -->
        <?php if(isset($_POST['edit-announcement']) || isset($_POST['edit-announcement-btn']) ){?>
            <input type="hidden" name='id-to-edit' value='<?php echo htmlspecialchars($announcementDetails['id']) ?>'>
            <input type="submit" name="edit-announcement-btn" value="Επεξεργασία Ανακοίνωσης" class="form-btn">
        <?php }else{ ?>
            <input type="submit" name="add-announcement-btn" value="Προσθήκη Ανακοίνωσης" class="form-btn">
        <?php }?>
        <input type="submit" name="cancel-btn" value="Άκυρο" class="form-btn">
    </form>
       

</body>
</html>