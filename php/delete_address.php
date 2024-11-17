<?php 
  require_once("already_signin.php");
  if (!isLoggedIn()) {
    header("Location: account-signin.php");
    exit();
  }
  require_once("conn.php");
  $user_id = $_SESSION['user']['id'];
  if (isset($_GET['address_id']) && is_numeric($_GET['address_id'])) {
    $address_id = $_GET['address_id'];

    $sql = "DELETE FROM user_shipping_addresses WHERE address_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $address_id, $user_id); 

    if ($stmt->execute()) {
        header("Location: ../account-address.php?success=2");
    } else {
        // Nếu có lỗi, thông báo
        header("Location: ../account-address.php?error=2");
    }
} else {
    echo "Invalid address ID.";
}


?>