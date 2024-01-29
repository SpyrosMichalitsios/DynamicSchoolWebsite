<?php
    //CANCEL BUTTON
    if(isset($_POST['cancel-btn'])){
        header('Location: documents.php');
        exit();
    }
    //WE KEEP THE ERROR MESSAGES IN THIS ARRAY.
    $errors=array('title'=>'','description'=>'','link'=>'');

    //IF WE WANT TO EDIT WE HAVE TO RETRIEVE THE VALUES FROM THE DATABASE
    if(isset($_POST['edit-document']) || isset($_POST['edit-document-btn']) ){
        
        //CONNECT TO THE DATABASE
        require "connect_db.php";
        //PROTECT THE DATABASE.MAKING SURE NO SPECIAL CHARACTERS ARE ENTERED
        $edit_id=mysqli_real_escape_string($connect,$_POST['id-to-edit']);

        //WRITE QUERY
        $sql="SELECT * FROM Documents WHERE id=$edit_id ";

        //GET RESULT
        $result=mysqli_query($connect,$sql);

        //MAKE IT AN ASSOCIATIVE ARRAY
        $documentmentDetails=mysqli_fetch_assoc($result);
        //INITIALIZE FIELDS
        $title=$documentmentDetails['Title'];
        $description=$documentmentDetails['Description'];
        $link=$documentmentDetails['Link'];


        //FREE RESULT
        mysqli_free_result($result);   

        //CLOSE CONNECTION
        mysqli_close($connect);
    }

    //IF ONE OF THE BUTTONS IS PRESSED
    if(isset($_POST['add-document-btn']) || isset($_POST['edit-document-btn'])){

        //WE EMPTY THE VARIABLES  TO OUTPUT THE CORRECT VALUES
        $title=$description=$link="";

        //IF THE TITLE INPUT IS EMPTY
        if(empty($_POST['title'])){
            $errors['title']="*Ο Τίτλος του εγγράφου δεν μπορει να είναι κενός.<br/>";
        }else{//INITIALIZE TITLE
            $subject=$_POST['title'];
        }

        //IF DESCRIPTION INPUT IS EMPTY
        if(empty($_POST['description'])){
            $errors['description']="*Το πεδίο Περιγραφή δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE DESCRIPTION
            $maintext=$_POST['description'];
        }

        //IF LINK INPUT IS EMPTY
        if(empty($_POST['link'])){
            $errors['link']="*Το πεδίο Θέση Αρχείου δεν μπορεί να είναι κενό.";
        }else{//INITIALIZE LINK
            $link=$_POST['link'];
        }

        //IF THERE ARE NO ERRORS
        if(!array_filter($errors)){

            //CONNECT TO THE DATABASE
            require "connect_db.php";

            //PREVENT MALICIOUS CONTENT
            $title=mysqli_real_escape_string($connect,$_POST['title']);//THE DATE IS THE CURRENT DATE THAT THE ANNOUNCEMENT IS CREATED OR EDITED.
            $description=mysqli_real_escape_string($connect,$_POST['description']);
            $link=mysqli_real_escape_string($connect,$_POST['link']);
            //THE EDIT_ID IS LOST SO WE HAVE TO INITIALIZE IT AGAIN
            $edit_id=$_POST['id-to-edit'];

            //IF WE WANT TO EDIT AN ANNOUNCEMENT
            if(isset($_POST["edit-document-btn"])){
                $sql = "UPDATE Documents SET Title='$title', Description='$description', Link='$link'
                WHERE id='$edit_id'";
            }else{
                //IF WE WANT TO SAVE AN ANNOUNCEMENT TO THE DATABASE
                $sql="INSERT INTO Documents(Title,Description,Link) VALUES('$title',
                '$description','$link')"; 
            }

            //IF IT WAS SUCCESFULL
            if(mysqli_query($connect,$sql)){            
                //CLOSE CONNECTION
                mysqli_close($connect);   
                //REDIRECT TO ANNOUNCEMENT PAGE
                header('Location: documents.php');
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
    <title>Νέο Έγγραφο Μαθήματος</title>
    <link rel="stylesheet" href="css/common.css">

</head>
<body>
    <!-- DIFFRENT HEADINGS FOR ADDING OR EDITING A DOCUMENT -->
    <h1>
        <?php if(isset($_POST['edit-document']) || isset($_POST['edit-document-btn'])){?>
            Επεξεργασία Εγγράφου μαθήματος
        <?php }else{?>
            Νέο Έγγραφο Μαθήματος
        <?php }?>
        <a id='logout-link' href='logout.php'>Έξοδος</a>
    </h1>

            
    <form action="document_form.php" class="add-edit-form" method="POST">
        <!--TITLE -->
        <label for="title">Τίτλος εγγράφου:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title)?>">
        <div class="error"><?php echo $errors['title']?> </div>
        <!-- DESCRIPTION-->
        <label for="description">Περιγραφή:</label>
        <textarea  name="description" id="description"><?php echo htmlspecialchars($description);?></textarea>
        <div class="error"><?php echo $errors['maintext']?> </div>
        <!-- LINK -->
        <label for="link">Θέση αρχείου:</label>
        <input  type="text" name="link" id="link" value="<?php echo htmlspecialchars($link);?>">
        <div class="error"><?php echo $errors['maintext']?> </div>
        <!-- IF THE USER WANTS TO EDIT THE DOCUMENT -->
        <?php if(isset($_POST['edit-document']) || isset($_POST['edit-document-btn'])){?>
            <input type="hidden" name='id-to-edit' value='<?php echo htmlspecialchars($documentmentDetails['id']) ?>'>
            <input type="submit" name="edit-document-btn" value="Επεξεργασία Εγγράφου" class="form-btn">
        <?php }else{ ?>
            <input type="submit" name="add-document-btn" value="Προσθήκη Εγγράφου Μαθήματος" class="form-btn">
        <?php }?>
        <input type="submit" name="cancel-btn" value="Άκυρο" class="form-btn">
    </form>
       

</body>
</html>