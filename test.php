<?php
    session_start(); 
    echo "Đăng nhập thành công! Xin chào, người dùng ID: " . $_SESSION['user']['id'];
?>
<a href="logout.php">Logout</a>