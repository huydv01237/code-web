<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="user.css">
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
            // Kết nối với cơ sở dữ liệu
            include "Connect.php";

            // Thêm người dùng mới
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
                $email = mysqli_real_escape_string($conn, $_POST['email']);

                // Thêm người dùng vào cơ sở dữ liệu
                $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

                if (mysqli_query($conn, $sql)) {
                    echo "User added successfully.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }

            // Cập nhật thông tin người dùng
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
                $user_id = intval($_POST['user_id']);
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu mới
                $email = mysqli_real_escape_string($conn, $_POST['email']);

                // Cập nhật thông tin người dùng trong cơ sở dữ liệu
                $sql = "UPDATE users SET username='$username', password='$password', email='$email' WHERE user_id=$user_id";

                if (mysqli_query($conn, $sql)) {
                    echo "User updated successfully.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }

            // Xóa người dùng
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_user'])) {
                $user_id = intval($_GET['delete_user']);

                // Xóa người dùng khỏi cơ sở dữ liệu
                $sql = "DELETE FROM users WHERE user_id=$user_id";

                if (mysqli_query($conn, $sql)) {
                    echo "User deleted successfully.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }

            // Lấy tất cả người dùng để hiển thị
            $sql = "SELECT * FROM users";
            $result = mysqli_query($conn, $sql);
            ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>User Management</title>
            </head>

            <body>

                <table border="1" cellpadding="10">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    // Hiển thị danh sách người dùng
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>
                    <form action='user.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                        <input type='username' name='username' value='" . htmlspecialchars($row['username']) . "' required>
                        <input type='email' name='email' value='" . htmlspecialchars($row['email']) . "' required>
                        <input type='password' name='password' placeholder='New Password'>
                        <button type='submit' name='edit_user'>Edit</button>
                        
                    </form>
                    <a style='border: 1px solid #ccc; padding: 5px 10px; margin-top: 10px; display: inline-block;' href='user.php?delete_user=" . $row['user_id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No users found.</td></tr>";
                    }
                    ?>
                </table>

            </body>

            </html>

            <?php
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