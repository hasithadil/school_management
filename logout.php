<?php
session_start();
session_unset();
session_destroy();

if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    echo "<script>
        alert('Successfully logged out!');
        window.location.href = 'login.php'; // Redirect to login page after alert
    </script>";
    exit();
} else {
    // Direct access without confirmation parameter — just redirect to login page
    header("Location: login.php");
    exit();
}
?>
