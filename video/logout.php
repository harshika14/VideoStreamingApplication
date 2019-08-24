<?php
 session_start();
 echo "<script> alert('Logout Successful') </script>";
  session_destroy();   // function that Destroys Session 
  header("Location: index.php");
  
?>