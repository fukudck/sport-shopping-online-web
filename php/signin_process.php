<?php 
require_once("conn.php");
require_once("already_signin.php");
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
  $error_message = signin($conn, $email, $password, $remember_me);
  if (isset($error_message)) {
      echo $error_message; // Hiển thị thông báo lỗi nếu có
  }
}
$conn->close();
?>