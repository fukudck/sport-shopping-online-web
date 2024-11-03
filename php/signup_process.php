<?php
session_start();
require_once("conn.php");
require_once("signin_func.php");

// Kiểm tra nếu form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và làm sạch
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = sanitize($_POST['password']);
    $password_confirm = sanitize($_POST['password_confirm']);

    // Kiểm tra xem mật khẩu có khớp không
    if ($password !== $password_confirm) {
        echo "Mật khẩu xác nhận không khớp!";
        exit();
    }  
    
    $password_hash = hash('sha256', $password);

    // Kiểm tra xem email đã tồn tại chưa
    $check_email_query = "SELECT email FROM users WHERE email = ?";
    $stmt_check_email = $conn->prepare($check_email_query);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_email->num_rows > 0) {
        // Email đã tồn tại
        $error_code = "2";
        header("Location: ../account-signin.php?error_code=" . urlencode($error_code));
        exit();
    }

    // Nhận ID User tiếp theo
    $query = "SELECT MAX(user_id) AS max_id FROM users";
    $result = $conn->query($query);
    $next_user_id = 1; // Giá trị mặc định cho user_id

    if ($result) {
        $row = $result->fetch_assoc();
        $max_id = $row['max_id'];
        if ($max_id) {
            $next_user_id = $max_id + 1;
        }
    }

    // Thêm người dùng mới vào bảng users
    $stmt = $conn->prepare("INSERT INTO users (user_id, username, email, password_hash, first_name, last_name, user_type, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $username = strtolower($first_name . '.' . $last_name); // Ví dụ tạo username từ tên và họ
    $username =  $next_user_id;
    $user_type = 'Customer'; // Đặt user_type là Customer
    $stmt->bind_param("isssssss", $next_user_id, $username, $email, $password_hash, $first_name, $last_name, $user_type, $phone);
    if ($stmt->execute()) {
        echo "Đăng ký thành công cho $first_name $last_name!";
    } else {
        $error_code = "2";
        header("Location: ../account-signin.php?error_code=". urlencode($error_code));
    }

    $stmt->close();

    $remember_me = isset($_POST['remember_me']) ? true : false;

    // Gọi hàm signin
    $error_message = signin($conn, $email, $password, $remember_me);
    if (isset($error_message)) {
        echo $error_message; // Hiển thị thông báo lỗi nếu có
    }
    
}
$conn->close();

// Hàm làm sạch dữ liệu đầu vào
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
