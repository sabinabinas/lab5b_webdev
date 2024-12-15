<?php
include 'database.php';

session_start(); 

$error = ""; // Variable to store error message

// Step 3: Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Query to fetch user data based on matric
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['Password'])) {
            // Authentication successful
            $_SESSION['matric'] = $row['matric'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirect to the table page (welcome.php)
            header("Location: welcome.php");
            exit();
        } else {
            $error = "Invalid password. Please try <a href='login.php'>login</a> again.";
        }
    } else {
        $error = "No user found with that matric number. Please try <a href='login.php'>login</a> again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(230, 222, 222);
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            color: black;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color:rgb(106, 171, 108);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            opacity: 0.9;
        }

        .error {
            color: #f44336;
            text-align: center;
            margin-top: 10px;
        }

        .link {
            text-align: center;
            margin-top: 20px;
        }

        .link a {
            color:rgb(99, 181, 102);
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Login Page</h1>

    <div class="container">
        <form action="login.php" method="post">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Login</button><br>

            <!-- Display error message -->
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Link to registration page -->
            <div class="link">
                <p>Not registered? <a href="registration.php">Register here</a></p>
            </div>
        </form>
    </div>

</body>
</html>

