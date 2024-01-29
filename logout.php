<?php
    //END SESSION
    session_unset();
    session_destroy();
    //BACK TO LOGIN PAGE
    header("Location: index.php");
    exit();
?>