<?php
     //START A SESSION
     session_start();
     //CONNECT TO THE DATABASE
     require "connect_db.php";
 
     //WRITE QUERY
     $sql='SELECT * FROM Documents';
 
     //GET RESULT
     $result=mysqli_query($connect,$sql);
 
     //MAKE IT AN ASSOCIATIVE ARRAY
     $documents=mysqli_fetch_all($result,MYSQLI_ASSOC);
 
     //FREE RESULT
     mysqli_free_result($result);   
 
     //CLOSE CONNECTION
     mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Έγγραφα μαθήματος</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/documents.css">
</head>
<body>
    <h1>Έγγραφα Μαθήματος<a id='logout-link' href='logout.php'>Έξοδος</a></h1>

    <div class="documents-container page-container">
        <!-- NAVIGATION BAR -->
        <?php require('navigation.php');?>      
        <!-- DOCUMENTS FOR THE LESSON -->
        <div class="main-content">
            
            <!-- IF THE USER IS A TUTOR GIVE HIM THE ABILLITY TO ADD DOCUMENTS -->
            <?php if($_SESSION['user-role']=='tutor'){?>
                <a href='document_form.php'>Προσθήκη νέου εγγράφου μαθήματος</a>
            <?php }?> 
            <!-- FOR EACH DOCUMENT IN THE DATABASE -->
            <?php foreach($documents as $document){?> 
                <!-- TITLE -->
                <h2><strong> <?php echo htmlspecialchars($document['Title']) ?></strong>
                    <!-- IF THE USER IS A TUTOR GIVE THE ABILLITY TO DELETE AND EDIT -->
                    <?php if($_SESSION['user-role']=='tutor'){?>
                            <form action='document_form.php' method='POST'>
                                <!--EDIT BTN-->
                                <input type="hidden" name='id-to-edit' value='<?php echo htmlspecialchars($document['id']) ?>'>
                                <input type="submit" name="edit-document" value="Επεξεργασία" class="edit-delete-btn">
                            </form>     
                            <form action='delete_entry.php' method='POST'>
                                <!--DELETE BTN -->
                                <input type="hidden" name='entry-to-delete' value='<?php echo htmlspecialchars($document['id']) ?>'>
                                <input type="submit" name="delete-document" value="Διαγραφή" class="edit-delete-btn">
                            </form>     
                     <?php }?> 
                </h2>
                <!-- DESCRIPTION -->
                <p><strong>Περιγραφη:</strong><?php echo nl2br(htmlspecialchars($document['Description'])) ?></p>
                <!-- LINK TO THE FILE -->
                <a href="<?php echo htmlspecialchars($document['Link']) ?>" download>Κατέβασε το αρχείο</a>
                <hr>
            <?php }?>
     

        </div>
    </div>
    <!-- BACK TO TOP BUTTON -->
    <button onclick="window.location.href='#top'" id="toTopBtn"><img src="./img/up-arrow.jpg" alt="Back to top." width="50" height="50"></button>
</body>
</html>            
