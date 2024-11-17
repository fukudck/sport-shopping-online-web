<?php 
print_r($_POST);
require_once("already_signin.php");
  if (!isLoggedIn()) {
    header("Location: account-signin.php");
    exit();
  }
  require_once("conn.php");
$user_id = $_SESSION['user']['id'];
$card_number = $_POST['number'];
$card_holder_name = $_POST['name'];
$expiry = $_POST['expiry'];
$expiry_parts = explode('/', $expiry);
$month = str_pad($expiry_parts[0], 2, '0', STR_PAD_LEFT);  // Đảm bảo tháng có 2 chữ số
$year = '20' . str_pad($expiry_parts[1], 2, '0', STR_PAD_LEFT);  // Thêm tiền tố '20' để tạo năm đầy đủ
$expiration_date = $year . '-' . $month . '-01';  // Sử dụng ngày 1 của tháng (Ngày hết hạn thực tế không quan trọng)

$sql = "INSERT INTO user_payment_methods (user_id, card_number, card_holder_name, expiration_date)
            VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id,  $card_number, $card_holder_name, $expiration_date);


if ($stmt->execute()) {
  header("Location: ../account-payment.php?success=1");
} else {
  // Nếu có lỗi, thông báo
  header("Location: ../account-payment.php?error=1");
}

// Đóng kết nối
$stmt->close();
$conn->close();

?>