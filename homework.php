<?php
    //START A SESSION
    session_start();

    //WE NEED A COUNTER TO SHOW THE NUMBER OF EACH ANNOUNCEMENT
    $counter=1;

    //CONNECT TO THE DATABASE
    require "connect_db.php";

    //WRITE QUERY
    $sql='SELECT * FROM Homework';
 
    //GET RESULT
    $result=mysqli_query($connect,$sql);
 
    //MAKE IT AN ASSOCIATIVE ARRAY
    $homework=mysqli_fetch_all($result,MYSQLI_ASSOC);
 
    //FREE RESULT
    mysqli_free_result($result);   
 
    //CLOSE CONNECTION
    mysqli_close($connect);
?>







<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Εργασίες</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/homework.css">
    </head>
    <body>
        <h1>Εργασίες<a id='logout-link' href='logout.php'>Έξοδος</a></h1>
        <div class="homework-container page-container">
            <!-- NAVIGATION BAR -->
            <?php require('navigation.php');?>      

            <!--HOMEWORK-->
            <div class="main-content homework-content">

                <!-- IF THE USER IS A TUTOR GIVE HIM THE ABILLITY TO ADD HOMEWORK -->
                <?php if($_SESSION['user-role']=='tutor'){?>
                    <form action='homework_form.php' method='POST'>
                        <!-- WE PASS THE NUMBER OF THE NEXT HOMEWORK TO BE ADDED -->
                        <input type="hidden" name='homework-number' value='<?php echo count($homework)+1; ?>'>
                        <input type="submit" name="add-homework" value="Προσθήκη νέας εργασίας" id="add-homework">
                    </form>    
                <?php }?> 
                <!-- FOR EACH ELEMENT IN THE HOMEWORK TABLE -->
                <?php foreach($homework as $hw){?>
                <!-- HOMEWORK NUMBER -->
                <h2>Εργασία <?php echo $counter;//THE NUMBER OF THE CURRENT HOMEWORK?>
                    <!-- IF THE USER IS A TUTOR GIVE THE ABILLITY TO DELETE AND EDIT -->
                    <?php if($_SESSION['user-role']=='tutor'){?>
                            <form action='homework_form.php' method='POST'>
                                <!--EDIT BTN-->
                                <input type="hidden" name='id-to-edit' value='<?php echo htmlspecialchars($hw['id']) ?>'>
                                <input type="submit" name="edit-homework" value="Επεξεργασία" class="edit-delete-btn">
                            </form>     
                            <form action='delete_entry.php' method='POST'>
                                <!--DELETE BTN -->
                                <input type="hidden" name='entry-to-delete' value='<?php echo htmlspecialchars($hw['id']) ?>'>
                                <input type="submit" name="delete-homework" value="Διαγραφή" class="edit-delete-btn">
                            </form>     
                     <?php  $counter++;}//INCREASE THE COUNTER?> 
                </h2>
                <!-- GOALS -->
                <p><strong>Στόχοι:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($hw['Goals']))?></p>
                <!-- LINK TO THE ASSINGMENT DESCRIPTION -->
                <p><strong>Εκφώνηση:</strong></p>
                <p>Μπορειτε να κατεβάσετε την εκφώνηση της εργασίας <a href="<?php echo htmlspecialchars($hw['Link']) ?>">εδώ</a></p>
                <!-- DELIVERABLES -->
                <p><strong>Παραδοτέα:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($hw['Deliverable']))?></p>
                <!-- DEADLINE -->
                <strong><em>Ημερομηνία παράδοσης:<?php echo htmlspecialchars($hw['Deadline'])?></em></strong>

                <hr> 
                <?php }?>      
            </div>
        </div>
        <!-- BACK TO TOP BUTTON -->
        <button onclick="window.location.href='#top'" id="toTopBtn"><img src="./img/up-arrow.jpg" alt="Back to top." width="50" height="50"></button>
    </body>
</html>