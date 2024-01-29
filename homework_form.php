<?php
    //CANCEL BUTTON
    if(isset($_POST['cancel-btn'])){
        header('Location: homework.php');
        exit();
    }
    //WE KEEP THE ERROR MESSAGES IN THIS ARRAY.
    $errors=array('goals'=>'','link'=>'','deliverable'=>'','deadline'=>'');

    //IF WE WANT TO EDIT WE HAVE TO RETRIEVE THE VALUES FROM THE DATABASE
    if(isset($_POST['edit-homework']) || isset($_POST['edit-homework-btn'])){
        
        //CONNECT TO THE DATABASE
        require "connect_db.php";

        //PROTECT THE DATABASE.MAKING SURE NO SPECIAL CHARACTERS ARE ENTERED
        $edit_id=mysqli_real_escape_string($connect,$_POST['id-to-edit']);

        //WRITE QUERY
        $sql="SELECT * FROM Homework WHERE id=$edit_id ";

        //GET RESULT
        $result=mysqli_query($connect,$sql);

        //MAKE IT AN ASSOCIATIVE ARRAY
        $homeworkDetails=mysqli_fetch_assoc($result);
        //INITIALIZE FIELDS
        $goals=$homeworkDetails['Goals'];
        $link=$homeworkDetails['Link'];
        $deliverable=$homeworkDetails['Deliverable'];
        $deadline=$homeworkDetails['Deadline'];


        //FREE RESULT
        mysqli_free_result($result);   

        //CLOSE CONNECTION
        mysqli_close($connect);
    }

    $homeworkNumber=$_POST['homework-number'];//THE NUMBER OF THE HOMEWORK

    //IF ONE OF THE BUTTONS IS PRESSED
    if(isset($_POST['add-homework-btn']) || isset($_POST['edit-homework-btn'])){

        //WE EMPTY THE VARIABLES  TO OUTPUT THE CORRECT VALUES
        $goals=$link=$deliverable=$deadline="";

        //IF THE GOALS INPUT IS EMPTY
        if(empty($_POST['goals'])){
            $errors['goals']="*Το πεδίο Στόχοι δεν μπορει να είναι κενό.<br/>";
        }else{//INITIALIZE GOALS
            $goals=$_POST['goals'];
        }

        //IF LINK INPUT IS EMPTY
        if(empty($_POST['link'])){
            $errors['link']="*Το πεδίο Εκφώνηση δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE LINK
            $link=$_POST['link'];
        }

        //IF DELIVERABLE INPUT IS EMPTY
        if(empty($_POST['deliverable'])){
            $errors['deliverable']="*Το πεδίο Παραδοτέα δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE DELIVERABLE
            $deliverable=$_POST['deliverable'];
        }

        //IF DEADLINE INPUT IS EMPTY
        if(empty($_POST['deadline'])){
            $errors['deadline']="*Το πεδίο Ημερομηνία Παράδοσης δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE DEADLINE
            $deadline=$_POST['deadline'];
        }


        //IF THERE ARE NO ERRORS
        if(!array_filter($errors)){

            //CONNECT TO THE DATABASE
            require "connect_db.php";

            //PREVENT MALICIOUS CONTENT
            $goals=mysqli_real_escape_string($connect,$_POST['goals']);
            $link=mysqli_real_escape_string($connect,$_POST['link']);
            $deliverable=mysqli_real_escape_string($connect,$_POST['deliverable']);
            $deadline=mysqli_real_escape_string($connect,$_POST['deadline']);
            //THE EDIT_ID IS LOST SO WE HAVE TO INITIALIZE IT AGAIN
            $edit_id=$_POST['id-to-edit'];

            //IF WE WANT TO EDIT THE HOMEWORK
            if(isset($_POST["edit-homework-btn"])){
                $sql = "UPDATE Homework SET Goals='$goals', Link='$link', 
                Deliverable='$deliverable',Deadline='$deadline'
                WHERE id='$edit_id'";
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
                //IF WE WANT TO SAVE THE HOMEWORK TO THE DATABASE
                $sql="INSERT INTO Homework(Goals,Link,Deliverable,Deadline) VALUES('$goals',
                '$link','$deliverable','$deadline')"; 
                //IF IT WAS SUCCESFULL WE ALSO WANT TO ADD AN ANNOUNCEMENT FOR THE HOMEWORK THAT WAS ADDED
                if(mysqli_query($connect,$sql)){ 
                    $date=date('Y-m-d');//THE DATE SHOULD BE THE DATE THE NEW HOMEWORK WAS ADDED
                    $homeworkNumber =$_POST['homework-number'];//WE PASSED THE HOMEWORK NUMBER TO MATCH THE ANNOUNCEMENTS TITLE
                    //ADD AN ANNOUNCEMENT ABOUT THE HOMEWORK
                    $sql="INSERT INTO Announcements(Date,Subject,Maintext) VALUES('$date',
                    'Αναρτήθηκε η εργασία $homeworkNumber','Η ημερομηνία παράδοσης της εργασίας είναι $deadline')";            
                    if(mysqli_query($connect,$sql)){
                        //CLOSE CONNECTION
                        mysqli_close($connect);   
                        //REDIRECT TO HOMEWORK PAGE
                        header('Location: homework.php');
                        exit();
                    }
                    
                }else{//IF THERE WAS AN ERROR
                    echo 'Error:' . mysqli_error($connect);
                }
                
            }

            

        }

    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Νέα εργασία</title>
    <link rel="stylesheet" href="css/common.css">

</head>
<body>
    <!-- DIFFRENT HEADINGS FOR ADDING OR EDITING HOMEWORK -->
    <h1>
        <?php if(isset($_POST['edit-homework']) || isset($_POST['edit-homework-btn'])){?>
            Επεξεργασία Εργασίας
        <?php }else{?>
            Νέα Εργασία
        <?php }?>
        <a id='logout-link' href='logout.php'>Έξοδος</a>
    </h1>

    <form action="homework_form.php" class="add-edit-form" method="POST">
        <!--GOALS-->
        <label for="goals">Στόχοι:</label>
        <textarea id="goals" name="goals"><?php echo htmlspecialchars($goals);?></textarea>
        <div class="error"><?php echo $errors['goals']?> </div>
        <!-- LINK -->
        <label for="link">Εκφώνηση:</label>
        <input type="text" name="link" id="link" value="<?php echo htmlspecialchars($link)?>">
        <div class="error"><?php echo $errors['link']?> </div>
        <!--DELIVERABLE-->
        <label for="deliverable">Παραδοτέα:</label>
        <textarea id="deliverable" name="deliverable"><?php echo htmlspecialchars($deliverable);?></textarea>
        <div class="error"><?php echo $errors['deliverable']?> </div>
        <!--DEADLINE-->
        <label for="deadline">Ημερομηνία παράδοσης:</label>
        <input type="date" name="deadline" id="deadline" value="<?php echo htmlspecialchars($deadline);?>">   
        <div class="error"><?php echo $errors['deadline']?> </div>

        <!-- IF THE USER WANTS TO EDIT THE HOMEWORK -->
        <?php if(isset($_POST['edit-homework']) || isset($_POST['edit-homework-btn'])){?>
            <input type="hidden" name='id-to-edit' value='<?php echo htmlspecialchars($homeworkDetails['id']) ?>'>
            <input type="submit" name="edit-homework-btn" value="Επεξεργασία Εργασίας" class="form-btn">
        <?php }else{ ?><!-- IF THE USER WANTS TO ADD HOMEWORK -->
            <input type="hidden" name='homework-number' value='<?php echo $_POST['homework-number']?>'>
            <input type="submit" name="add-homework-btn" value="Προσθήκη Εργασίας" class="form-btn">
        <?php }?>
        <input type="submit" name="cancel-btn" value="Άκυρο" class="form-btn">
    </form>
       

</body>
</html>