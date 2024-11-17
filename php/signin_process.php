<?php 
session_start(); 
require_once("conn.php");
require_once("signin_func.php");


function sanitize($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST['email'];
  $password = $_POST['password'];


  $error_code = signin($conn, $email, $password);
  if (isset($error_code)) {
      header("Location: ../account-signin.php?error_code=". urlencode($error_code));

  }
}
else {
  header("Location: ../account-signin.php");
}
$conn->close();
?>