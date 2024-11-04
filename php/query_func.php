<?php 
function sql_query($conn, $sql) {

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result;
        exit(); // Dừng thực thi sau khi chuyển hướng
    } else {
        return 404;
    }

}

?>