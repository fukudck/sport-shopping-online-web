<?php 
print_r($_POST);
require_once("already_signin.php");
  if (!isLoggedIn()) {
    header("Location: account-signin.php");
    exit();
  }
  require_once("conn.php");
$user_id = $_SESSION['user']['id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone_num = $_POST['phone-num'];
$city = $_POST['city'];
$district = $_POST['district'];
$ward = $_POST['ward'];
$particular_address = $_POST['particular-address'];


$sql = "INSERT INTO user_shipping_addresses (
    user_id, first_name, last_name, email, phone_number, city, district, ward, detailed_address
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?
)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    'issssssss', 
    $user_id, // Cần thay $user_id bằng ID của người dùng hiện tại
    $firstname, 
    $lastname, 
    $email, 
    $phone_num, 
    $city, 
    $district, 
    $ward, 
    $particular_address
);

if ($stmt->execute()) {
    $address_id = $conn->insert_id;

    // Lấy tên file từ HTTP_REFERER
    $referer_path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
    $referer_file = basename($referer_path);

    // Kiểm tra nếu file là checkout-details.php
    if ($referer_file === "checkout-details.php") {
        header("Location: ../checkout-details.php?address_id=" . $address_id);
    } else {
        header("Location: ../account-address.php?success=1");
    }
} else {
    header("Location: ../account-address.php?error=1");
}



$stmt->close();
$conn->close();

?>