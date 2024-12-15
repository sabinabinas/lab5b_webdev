<?php
include 'database.php';

// Fetch data based on the matric passed in the URL
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    
    // Query to get user data based on matric
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "No user found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Handle form submission to update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $new_matric = $_POST['matric'];  // New matric number
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Update SQL query (checking if matric is unique could be a separate concern)
    $update_sql = "UPDATE users SET name = ?, role = ?, matric = ? WHERE matric = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssss", $name, $role, $new_matric, $matric);  // Binding parameters
    
    if ($stmt->execute()) {
        // Show JavaScript alert with a button to redirect to welcome.php
        echo "<script>
                alert('User updated successfully!');
                if (confirm('Do you want to return to the welcome page?')) {
                    window.location.href = 'welcome.php';
                }
              </script>";
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="button"] {
            background-color: #f44336;
        }

        button:hover {
            opacity: 0.9;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
    </style>
</head>
<body>

    <h2>Update User</h2>

    <div class="container">
        <form method="post">
            <label for="matric">Matric:</label>
            <input type="text" name="matric" value="<?php echo htmlspecialchars($user['matric']); ?>" required><br>

            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

            <label for="role">Role:</label>
            <select name="role" required>
                <option value="Lecturer" <?php echo ($user['role'] == 'Lecturer') ? 'selected' : ''; ?>>Lecturer</option>
                <option value="Student" <?php echo ($user['role'] == 'Student') ? 'selected' : ''; ?>>Student</option>
            </select><br>

            <div class="action-buttons">
                <button type="submit">Update</button>
                <button type="button" onclick="window.location.href='welcome.php';">Cancel</button>
            </div>
        </form>
    </div>

</body>
</html>
