<?php

// Include database connection
include 'database.php';

// Step 2: SQL query to fetch data
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

// Step 3: Generate HTML table with Action column
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>User Table</title>
    <style>
    
        table {
            width: 70%;
            border-collapse: collapse;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        .action-btn {
            margin: 5px;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .update-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .logout-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #f1c40f;
            color: white;
            border: none;
            cursor: pointer;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Users Table</h2>
    <form method='post'>
        <button type='submit' name='logout' class='logout-btn'>Logout</button>
    </form>";

    // Logout functionality
    if (isset($_POST['logout'])) {
        session_unset(); // Remove all session variables
        session_destroy(); // Destroy the session
        header("Location: login.php"); // Redirect to the login page after logout
        exit();
    }

echo "<table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>";

// Step 4: Populate table rows with data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['matric']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['role']) . "</td>
                <td>
                    <!-- Action Buttons: Update and Delete -->
                    <a href='update.php?matric=" . $row['matric'] . "' class='action-btn update-btn'>Update</a>
                    <a href='delete.php?matric=" . $row['matric'] . "' class='action-btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No records found</td></tr>";
}

// Step 5: Close table and connection
echo "    </table>
</body>
</html>";

$conn->close();
?>
