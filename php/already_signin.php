<?php 
session_start();
if (isset($_SESSION['user']['id'])) {
    header("Location: ../test.php");
    exit();
  }

?>