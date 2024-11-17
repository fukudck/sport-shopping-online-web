<?php 
  require_once("already_signin.php");
  if (!isLoggedIn()) {
    header("Location: account-signin.php");
    exit();
  }
  require_once("conn.php");
  $user_id = $_SESSION['user']['id'];
  if (isset($_GET['payment_id']) && is_numeric($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    $sql = "DELETE FROM user_payment_methods WHERE payment_method_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $payment_id, $user_id); 

    if ($stmt->execute()) {
        header("Location: ../account-payment.php?success=2");
    } else {
        // Nếu có lỗi, thông báo
        header("Location: ../account-payment.php?error=2");
    }
} else {
    echo "Invalid payment ID.";
}


?>