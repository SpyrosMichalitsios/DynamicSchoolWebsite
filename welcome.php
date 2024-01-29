<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Αρχική Σελίδα</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/welcome.css">
    </head>
    <body>

        
        <h1 class='inner-h1'>Αρχική Σελίδα<a id='logout-link' href='logout.php'>Έξοδος</a></h1>
            
        

        <div class="page-container">
            
            <!-- NAVIGATION BAR -->
            <?php require('navigation.php');?>
            

            <!-- WELCOMING TEXT AND IMAGE-->
            <div class="main-content">
                <div class="welcome-text">
                    <p class="welcome-txt">Καλωσήρθατε στην ιστοσελίδα του μαθήματρος εκμάθησης HTML/PHP.
                            Εδώ θα βρείτε ότι θα χρειαστείτε για να ξεκινήσετε το ταξίδια σας στον κόσμο των ιστοσελίδων!
                            Στο navigation bar στα αριστερά της ιστοσελίδας θα βρείτε τις ανακοινώσεις του μαθήματος, τους τρόπους επικοινωνίας με τον διδάσκοντα, το υλικό του μαθήματος όπως και τις εργασίες που έχουν ανακοινωθεί για το μάθημα.
                            Στόχος είναι στο τέλος του εξαμήνου να έχετε την δυνατότητα να αναπτύσσετε ιστοσελίδες, όπως και να τις διαμορφώνεται με όποιον τρόπο θέλετε εσείς.
                    </p>
                </div>
                <div class="welcome-image">
                    <img src="./img/mainpage.jpg" class="welcome-img">
                </div>
            </div>
        </div>
        
    </body>
</html>
