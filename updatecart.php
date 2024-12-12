<?php
session_start();

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove'])) {
    $product_id = intval($_POST['remove']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['message'] = "Product removed successfully!";
    } else {
        $_SESSION['message'] = "Product not found in cart.";
    }
}

// Cập nhật số lượng sản phẩm
if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $product_id = intval($product_id);
        $quantity = intval($quantity);

        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]); // Xóa nếu số lượng là 0
        }
    }
}

header("Location: viewcart.php");
exit;
?>
