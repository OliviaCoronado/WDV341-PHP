<?php 
session_start();
    //clear any seesion variables related to this user

    session_unset();

    session_destroy();

    //close any connections for this user
    //redirect back to the site home page



    header("Location: login.php");



?>
