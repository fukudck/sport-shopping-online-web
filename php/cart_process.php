<?php
include('conn.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    echo "Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng.";
    exit;
}

// Lấy thông tin từ session và POST
$user_id = $_SESSION['user']['id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$size = isset($_POST['size']) ? $_POST['size'] : null;


if ($product_id && $quantity > 0) {
    // Kiểm tra nếu sản phẩm có tồn tại trong bảng sản phẩm
    $sql_check_product = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql_check_product);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Sản phẩm tồn tại, tiến hành xử lý giỏ hàng
        // Kiểm tra giỏ hàng tồn tại hay không
        $sql_check_cart = "SELECT cart_id FROM carts WHERE user_id = ?";
        $stmt = $conn->prepare($sql_check_cart);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $cart = $result->fetch_assoc();
            $cart_id = $cart['cart_id'];
        } else {
            // Tạo mới giỏ hàng
            $sql_create_cart = "INSERT INTO carts (user_id) VALUES (?)";
            $stmt = $conn->prepare($sql_create_cart);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $cart_id = $conn->insert_id; // Lấy ID của giỏ hàng vừa tạo
        }

        // Kiểm tra sản phẩm có tồn tại trong giỏ không
        $sql_check_item = "SELECT cart_item_id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? AND size = ?";
        $stmt = $conn->prepare($sql_check_item);
        $stmt->bind_param("iis", $cart_id, $product_id, $size);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Nếu tồn tại thì cập nhật số lượng
            $item = $result->fetch_assoc();
            $new_quantity = $item['quantity'] + $quantity;

            $sql_update_item = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?";
            $stmt = $conn->prepare($sql_update_item);
            $stmt->bind_param("ii", $new_quantity, $item['cart_item_id']);
            $stmt->execute();
        } else {
            // Thêm mới
            $sql_add_item = "INSERT INTO cart_items (cart_id, product_id, quantity, size) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_add_item);
            $stmt->bind_param("iiis", $cart_id, $product_id, $quantity, $size);
            $stmt->execute();
        }
    }
}


function displayCartItems($conn, $user_id) {
    $sql = "SELECT ci.cart_item_id, ci.quantity AS cart_quantity, ci.size, p.name, p.price, 
            MIN(pi.image_url) AS image_url, pq.quantity AS available_quantity 
            FROM cart_items ci
            INNER JOIN carts c ON ci.cart_id = c.cart_id
            INNER JOIN products p ON ci.product_id = p.product_id
            LEFT JOIN product_images pi ON p.product_id = pi.product_id
            LEFT JOIN product_quantity pq ON p.product_id = pq.product_id AND ci.size = pq.size
            WHERE c.user_id = ? 
            GROUP BY ci.cart_item_id, ci.size, p.name, p.price, pq.quantity";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hiển thị dữ liệu
    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }

    return $cart_items;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if ($action == 'delete_item') {
        $cart_item_id = isset($_POST['cart_item_id']) ? $_POST['cart_item_id'] : 0;
    
        if ($cart_item_id > 0) {
            $sql_delete_item = "DELETE FROM cart_items WHERE cart_item_id = ?";
            $stmt = $conn->prepare($sql_delete_item);
            $stmt->bind_param("i", $cart_item_id);
    
            if ($stmt->execute()) {
                // Kiểm tra xem còn sản phẩm nào trong giỏ hàng không
                $sql_check_cart = "SELECT COUNT(*) AS total_items FROM cart_items WHERE cart_id = (SELECT cart_id FROM carts WHERE user_id = ?)";
                $stmt_check = $conn->prepare($sql_check_cart);
                $stmt_check->bind_param("i", $user_id);
                $stmt_check->execute();
                $result = $stmt_check->get_result();
                $row = $result->fetch_assoc();
    
                if ($row['total_items'] == 0) {
                    echo "empty_cart"; 
                } else {
                    echo "success"; 
                }
            } else {
                echo "error";
            }
        } else {
            echo "invalid_item";
        }
    }    
    if ($action === 'update_quantity') {
        $cart_item_id = isset($_POST['cart_item_id']) ? intval($_POST['cart_item_id']) : 0;
        $new_quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    
        if ($cart_item_id > 0 && $new_quantity > 0) {
            // Cập nhật số lượng trong cơ sở dữ liệu
            $sql_update_quantity = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?";
            $stmt = $conn->prepare($sql_update_quantity);
            $stmt->bind_param("ii", $new_quantity, $cart_item_id);
    
            if ($stmt->execute()) {
                // Lấy giá tổng và giá từng sản phẩm sau khi cập nhật
                $sql_get_total = "SELECT SUM(ci.quantity * p.price) AS total_price 
                                  FROM cart_items ci 
                                  INNER JOIN products p ON ci.product_id = p.product_id
                                  WHERE ci.cart_id = (SELECT cart_id FROM carts WHERE user_id = ?)";
                $stmt_total = $conn->prepare($sql_get_total);
                $stmt_total->bind_param("i", $user_id);
                $stmt_total->execute();
                $result = $stmt_total->get_result();
                $row = $result->fetch_assoc();
                $total_price = $row['total_price'];
    
                // Lấy giá sản phẩm vừa cập nhật
                $sql_get_item_price = "SELECT ci.quantity * p.price AS updated_item_price 
                                       FROM cart_items ci 
                                       INNER JOIN products p ON ci.product_id = p.product_id
                                       WHERE ci.cart_item_id = ?";
                $stmt_item = $conn->prepare($sql_get_item_price);
                $stmt_item->bind_param("i", $cart_item_id);
                $stmt_item->execute();
                $result_item = $stmt_item->get_result();
                $item_row = $result_item->fetch_assoc();
                $updated_item_price = $item_row['updated_item_price'];
    
                echo json_encode([
                    'status' => 'success',
                    'total_price' => $total_price,
                    'updated_item_price' => $updated_item_price
                ]);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } else {
            echo json_encode(['status' => 'invalid_data']);
        }
        exit;
    }
}


?>
