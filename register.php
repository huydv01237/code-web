<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            text-decoration: none;
            color: #4CAF50;
        }

        .register-link a:hover {
            color: #45a049;
        }

        /* Media queries for responsiveness */
        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="text"],
            input[type="password"],
            input[type="email"] {
                font-size: 14px;
            }

            button[type="submit"] {
                font-size: 14px;
            }
        }
    </style>

    <script>
        function validateForm() {
            var x = document.getElementById("Username").value;
            var y = document.getElementById("Email").value;
            if (x == null || x == "") {
                alert("Username can not be empty!");
                return false;
            } else if (y == null || y == "") {
                alert("Email can not be empty!");
                return false;
            }
        }
    </script>
</head>

<body>
    <div class="login-container">
        <h2>Register</h2>
        <form action="" onsubmit="return validateForm()" method="POST">
            <div class="form-group">
                <label for="Username">Username:</label>
                <input type="text" class="form-control" id="Username" placeholder="Enter your Username" name="Username">
            </div>
                
            <div class="form-group">
                <label for="Password">Password:</label>
                <input type="password" class="form-control" id="Password" placeholder="Enter your Password" name="Password" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" placeholder="Enter your Email" name="Email">
            </div>

            <button type="submit" name="submit" class="btn btn-success btn-block">Register</button>

            <div class="register-link">
                <p>Already have an account? <a href="Login.php">Login Now</a></p>
            </div>
        </form>
    </div>

    <?php
    include "Connect.php";
    
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $username = $_POST["Username"];
        $password = $_POST["Password"];
        $email = $_POST["Email"];
        
        // Insert user into database
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        
        // Execute query
        $result = mysqli_query($conn, $sql);

        // Check for success or failure
        if ($result) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Registration failed!');</script>";
        }
        
        // Close database connection
        mysqli_close($conn);
    }
    ?>
</body>

</html>
