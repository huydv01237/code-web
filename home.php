<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="home.css">
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
            include "Connect.php";
            $sql = "SELECT * FROM products LIMIT 6";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row_product = mysqli_fetch_assoc($result)) {
                    $product_id = $row_product['product_id'];
                    $name = $row_product['name'];
                    $description = $row_product['description'];
                    $price = $row_product['price'];
                    $stock = $row_product['stock'];
                    $ImageURL = $row_product['ImageURL'];
            ?>
                    <form class="single_product" action="addtocart.php" method="POST">
                        <h3><?php echo htmlspecialchars($name); ?></h3>
                        <img src="images/<?php echo htmlspecialchars($ImageURL); ?>" alt="<?php echo htmlspecialchars($name); ?>">
                        <p><?php echo htmlspecialchars($description); ?></p>
                        <p><b>Price: <?php echo number_format($price, 0, ',', '.'); ?> USD</b></p>
                        <a href="detail.php?id=<?php echo $product_id ?>" class="btn btn-info">Details</a>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-success">Add to Cart</button>
                    </form>

            <?php
                }
            } else {
                echo "<p>No products found.</p>";
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