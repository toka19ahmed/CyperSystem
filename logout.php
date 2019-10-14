<?php 
      session_start();

     session_destroy();
     //unset($_SESSION['user_Auth']);
     header("Location: signin.php");


?>