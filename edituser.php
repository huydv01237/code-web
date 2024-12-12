<?php
include "Connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Lấy thông tin người dùng
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu mới
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Cập nhật thông tin người dùng trong cơ sở dữ liệu
    $sql = "UPDATE users SET username='$username', password='$password', email='$email' WHERE user_id=$user_id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: user.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>
<form action="edit_user.php?id=<?php echo $user_id; ?>" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
    <button type="submit" name="edit_user">Update User</button>
</form>

</body>
</html>

<?php
mysqli_close($conn);
?>
