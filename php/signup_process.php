<?php 
session_start();
require_once("conn.php");
require_once("signin_func.php");
require_once("already_signin.php");
if (isLoggedIn()) {
    header("Location: home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = sanitize($_POST['password']);
    $password_confirm = sanitize($_POST['password_confirm']);

    if ($password !== $password_confirm) {
        $error_code = "3";
        header("Location: ../account-signin.php?error_code=". urlencode($error_code));
        exit();
    }  
    $password_hash = hash('sha256', $password);

    $check_email_query = "SELECT email FROM users WHERE email = ?";
    $stmt_check_email = $conn->prepare($check_email_query);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_email->num_rows > 0) {
        $error_code = "2";
        header("Location: ../account-signin.php?error_code=" . urlencode($error_code));
        exit();
    }
    $stmt_check_email->close();

    $stmt = $conn->prepare("INSERT INTO users (email, password_hash, first_name, last_name, user_type, phone_number) VALUES (?, ?, ?, ?, ?, ?)");
    $user_type = 'Customer';    
    $stmt->bind_param("ssssss", $email, $password_hash, $first_name, $last_name, $user_type, $phone);
    if ($stmt->execute()) {
        echo "Success!";
    } else {
        $error_code = "4";
        header("Location: ../account-signin.php?error_code=". urlencode($error_code));
    }

    $stmt->close();
    $error_message = signin($conn, $email, $password);
    if (isset($error_message)) {
        header("Location: ../account-signin.php?error_code=". urlencode($error_message));
    }

}
else {
    header("Location: home.php");
}

// Hàm làm sạch dữ liệu đầu vào
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

?>