<?php
    //WE NEED A COUNTER TO SHOW THE NUMBER OF EACH ANNOUNCEMENT
    $counter=1;
    //START A SESSION
    session_start();
    //CONNECT TO THE DATABASE
    require "connect_db.php";

    //WRITE QUERY
    $sql='SELECT * FROM Announcements';

    //GET RESULT
    $result=mysqli_query($connect,$sql);

    //MAKE IT AN ASSOCIATIVE ARRAY
    $announcements=mysqli_fetch_all($result,MYSQLI_ASSOC);

    //FREE RESULT
    mysqli_free_result($result);   

    //CLOSE CONNECTION
    mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ανακοινώσεις</title>
    <link rel="stylesheet" href="css/common.css">

</head>
<body>
    <h1>Ανακοινώσεις<a id='logout-link' href='./login_stuff/logout.php'>Έξοδος</a></h1>

    <div class="announcement-container page-container">
        <!-- NAVIGATION BAR -->
        <?php require('./navigation.php');?>      

        <!-- ANNNOUNCEMENTS -->
        <div class="main-content">
            
            <!-- IF THE USER IS A TUTOR GIVE HIM THE ABILLITY TO ADD ANNOUNCEMENTS -->
            <?php if($_SESSION['user-role']=='tutor'){?>
                <a href='announcement_form.php'>Προσθήκη νέας ανακοίνωησης</a>
            <?php }?>    
            <!-- FOR EVERY ANNOUNCEMENT IN THE DATABASE -->
            <?php foreach($announcements as $announcement){?> 
                <h2>Ανακοίνωση <!--ANNOUNCEMENT NUMBER -->
                    <?php echo $counter;//THE NUMBER OF THE CURRENT ANNOUNCEMENT
                        //IF THE USER IS A TUTOR GIVE THE ABILLITY TO DELETE AND EDIT 
                        if($_SESSION['user-role']=='tutor'){?>
                            <form action='announcement_form.php' method='POST'>
                                 <!--EDIT BTN-->
                                <input type="hidden" name='id-to-edit' value='<?php echo htmlspecialchars($announcement['id']) ?>'>
                                <input type="submit" name="edit-announcement" value="Επεξεργασία" class="edit-delete-btn">
                            </form>     
                            <form action='delete_entry.php' method='POST'>
                                <!--DELETE BTN -->
                                <input type="hidden" name='entry-to-delete' value='<?php echo $announcement['id'] ?>'>
                                <input type="submit" name="delete-announcement" value="Διαγραφή" class="edit-delete-btn">
                            </form>     

                     <?php }?> 
                </h2>
                <!-- DATE -->
                <p><strong>Ημερομηνία:</strong> <?php echo htmlspecialchars($announcement['Date']);?></p>
                <!-- SUBJECT -->
                <p><strong>Θέμα:</strong><?php echo htmlspecialchars($announcement['Subject']);?></p>
                <!-- MAIN TEXT -->
                <p> 
                    <!--WE REPLACE THE WORD "Εργασίες" WITH THE LINK TO THE HOMEWORK PAGE -->
                    <?php echo str_replace("Εργασίες", 
                        '<a href="homework.php">Εργασίες</a>',
                        nl2br(htmlspecialchars($announcement['MainText']))); 
                    ?>
                </p>            
                <hr>
            <?php $counter++; }  //INCREASE THE COUNTER}?>
                
            <!-- BACK TO TOP BUTTON -->
            <button onclick="window.location.href='#top'" id="toTopBtn"><img src="./img/up-arrow.jpg" alt="Back to top." width="50" height="50"></button>

        </div>
    </div>

</body>
</html>
