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



// Kiểm tra nếu form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ form
  $email = $_POST['email'];
  $password = $_POST['password'];
  $remember_me = isset($_POST['remember_me']) ? true : false;

  // Gọi hàm signin
  $error_code = signin($conn, $email, $password, $remember_me);
  if (isset($error_code)) {
      header("Location: ../account-signin.php?error_code=". urlencode($error_code));

  }
}
$conn->close();
?>