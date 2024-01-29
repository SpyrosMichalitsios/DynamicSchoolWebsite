<?php session_start();?>
<ul class="navigation-list">
    <li><a class="navigation" href='welcome.php'">Αρχική Σελίδα</a></li>
    <li><a class="navigation" href='announcements.php'">Ανακοινώσεις</a></li>
    <li><a class="navigation" href='communication.php'">Επικοινωνία</a></li>
    <li><a class="navigation" href='documents.php'">Έγγραφα Μαθήματος</a></li> 
    <li><a class="navigation" href='homework.php'">Εργασίες</a></li>
    <?php if($_SESSION['user-role']=='tutor'){ ?>
        <li><a class="navigation" href='users.php'">Χρήστες</a></li>
    <?php }?>    
</ul>
