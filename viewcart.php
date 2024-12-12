<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="viewcart.css">
</head>

<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>The Chic & Timeless Women's Fashion Collection</h1>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#detail.php">View Product</a></li>
                    <li><a href="viewcart.php">View Cart</a></li>
                    <li><a href="user.php">User Profile</a></li>
                    <li><a href="login.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>

        <aside>
            <h3>Categories</h3>
            <ul>
                <li><a href="#home">Casual Wear</a></li>
                <li><a href="#home">Evening Wear</a></li>
                <li><a href="#home">Activewear</a></li>
            </ul>
        </aside>
        <section class="product-section">
        <?php
session_start();
include "Connect.php";

// Kiểm tra nếu có yêu cầu POST và có thay đổi số lượng sản phẩm trong giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra cập nhật số lượng sản phẩm
    if (isset($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $product_id => $new_quantity) {
            $product_id = intval($product_id); // Chuyển ID sản phẩm thành số nguyên
            $new_quantity = intval($new_quantity); // Chuyển số lượng thành số nguyên

            // Nếu số lượng <= 0, xóa sản phẩm khỏi giỏ hàng, ngược lại cập nhật số lượng mới
            if ($new_quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id] = $new_quantity;
            }
        }
    }

    // Kiểm tra nếu có yêu cầu xóa sản phẩm
    if (isset($_POST['remove'])) {
        $product_id_to_remove = intval($_POST['remove']); // Lấy ID sản phẩm cần xóa
        if (isset($_SESSION['cart'][$product_id_to_remove])) {
            unset($_SESSION['cart'][$product_id_to_remove]); // Xóa sản phẩm khỏi giỏ hàng
        }
    }

    // Sau khi cập nhật hoặc xóa, chuyển hướng lại trang giỏ hàng để cập nhật giỏ hàng
    header("Location: viewcart.php");
    exit;
}


// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
} else {
    $cart = $_SESSION['cart'];
    $product_ids = implode(",", array_keys($cart));

    $sql = "SELECT * FROM products WHERE product_id IN ($product_ids)";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $total_price = 0; // Biến để tính tổng giá tiền

        echo '<form action="viewcart.php" method="POST">';
        echo '<table border="1" cellpadding="10" cellspacing="0">';
        echo '<tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
              </tr>';

        while ($product = mysqli_fetch_assoc($result)) {
            $product_id = $product['product_id'];
            $quantity = $cart[$product_id]; // Lấy số lượng từ session
            $subtotal = $product['price'] * $quantity; // Tính tổng phụ cho sản phẩm này
            $total_price += $subtotal; // Cộng vào tổng giá tiền

            echo '<tr>';
            echo '<td><img src="images/' . htmlspecialchars($product['ImageURL']) . '" alt="' . htmlspecialchars($product['name']) . '" style="width:100px;height:auto;"></td>';
            echo '<td>' . htmlspecialchars($product['name']) . '</td>';
            echo '<td>' . number_format($product['price'], 0, ',', '.') . ' VNĐ</td>';
            echo '<td>
                    <input type="number" name="quantity[' . $product_id . ']" value="' . $quantity . '" min="1" style="width:50px;">
                  </td>';
            echo '<td>' . number_format($subtotal, 0, ',', '.') . ' VNĐ</td>';
            echo '<td>
                    <button type="submit" name="remove" value="' . $product_id . '" class="btn btn-danger">Remove</button>
                  </td>';
            echo '</tr>';
        }

        echo '<tr>
                <td colspan="4" style="text-align:right;"><b>Total Price:</b></td>
                <td><b>' . number_format($total_price, 0, ',', '.') . ' USD</b></td>
                <td></td>
              </tr>';
        echo '</table>'; 
        echo '<br><button type="submit" class="btn btn-primary">Update Cart</button>';
        echo '</form>';
    } else {
        echo "<p>Could not retrieve product details.</p>";
    }
}
mysqli_close($conn);
?>

        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Your E-Commerce Site. All Rights Reserved.</p>
    </footer>
</body>

</html>