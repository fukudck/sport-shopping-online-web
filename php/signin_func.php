<?php 
function signin($conn, $email, $password, $remember_me) {
    // Làm sạch dữ liệu email và password
    $email = sanitize($email);
    $password_hash = hash('sha256', sanitize($password));
  
    // Sử dụng Prepared Statements để tránh SQL injection
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND password_hash = ?");
    $stmt->bind_param("ss", $email, $password_hash);
    $stmt->execute();
    $result = $stmt->get_result();
  
    // Kiểm tra kết quả truy vấn
    if ($result->num_rows > 0) {
        // Lấy hàng dữ liệu
        $row = $result->fetch_assoc();
        
        // Lưu user_id vào session
        $_SESSION['user'] = [
            'id' => $row['user_id'],
            'logged_in' => true
        ];
  
        // Chuyển hướng đến trang khác
        header("Location: ../test.php");

        
        exit(); // Dừng thực thi sau khi chuyển hướng
    } else {
        return "Email hoặc mật khẩu không đúng!";
    }
  
    // Đóng statement
    $stmt->close();
  }
?>