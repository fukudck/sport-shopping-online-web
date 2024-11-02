<?php 
session_start();
if (!isset($_SESSION['user']['id'])) {
    header("Location: ../account-signin.php");
    exit();
  }

?>