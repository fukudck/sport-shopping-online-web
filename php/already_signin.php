<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
function isLoggedIn() {
  // Kiểm tra xem người dùng đã đăng nhập hay chưa
  return isset($_SESSION['user']['id']);
}
?>