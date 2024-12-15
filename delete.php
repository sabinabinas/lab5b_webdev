<?php
include 'database.php';

// Check if matric is passed in URL
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Prepare delete query
    $delete_sql = "DELETE FROM users WHERE matric = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        echo "<script>
                alert('User deleted successfully!');
                if (confirm('Do you want to return to the welcome page?')) {
                    window.location.href = 'welcome.php';
                }
              </script>";
    } else {
        echo "Error deleting user.";
    }
} else {
    echo "Invalid request.";
}
?>
