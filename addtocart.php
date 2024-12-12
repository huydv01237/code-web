<?php
session_start();
include "Connect.php";

// Kiểm tra xem giỏ hàng đã được khởi tạo chưa
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Lấy dữ liệu từ form
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($product_id > 0) {
    // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity; // Cộng dồn số lượng
    } else {
        $_SESSION['cart'][$product_id] = $quantity; // Thêm mới sản phẩm
    }
    header("Location: viewcart.php"); // Chuyển hướng tới trang giỏ hàng
    exit;
} else {
    echo "<p>Invalid product.</p>";
}
?>
