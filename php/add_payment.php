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
$cvc = $_POST['cvc'];

$sql = "INSERT INTO user_payment_methods (user_id, card_number, card_holder_name, expiration_date, cvc)
            VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssi", $user_id,  $card_number, $card_holder_name, $expiration_date, $cvc);



if ($stmt->execute()) {
    $address_id = $conn->insert_id;

    // Lấy tên file từ HTTP_REFERER
    $referer_path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
    $referer_file = basename($referer_path);

    // Kiểm tra nếu file là checkout-details.php
    if ($referer_file === "checkout-payment.php") {
        header("Location: ../checkout-payment.php?payment_id=" . $address_id);
    } else {
        header("Location: ../account-payment.php?success=1");
    }
} else {
    header("Location: ../account-payment.php?error=1");
}


// Đóng kết nối
$stmt->close();
$conn->close();

?>