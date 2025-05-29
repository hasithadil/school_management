<?php
session_start();
include 'config.php';

// Check if user is logged in and nic exists in session
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['nic'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use nic from session to delete user
    $nic = $_SESSION['user']['nic'];

    $stmt = $conn->prepare("DELETE FROM users WHERE nic = ?");
    $stmt->bind_param("s", $nic);

    if ($stmt->execute()) {
        // Delete success - clear session and redirect
        session_unset();
        session_destroy();

        echo "<script>
            alert('Your account has been successfully deleted.');
            window.location.href = 'index.php'; // or login.php or homepage
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error deleting account: " . addslashes($stmt->error) . "');
            window.history.back();
        </script>";
        exit();
    }
} else {
    // If accessed without POST, redirect back
    header("Location: details.php");
    exit();
}

$stmt->close();
$conn->close();
?>
