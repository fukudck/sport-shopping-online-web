<?php
session_start(); // Bắt đầu session

// Xóa tất cả các biến trong session
$_SESSION = [];

// Nếu muốn xóa cookie lưu session trên trình duyệt (nếu có)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cuối cùng, hủy session
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chủ
header("Location: account-signin.php"); 
exit();
?>
