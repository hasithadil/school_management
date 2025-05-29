<?php
session_start();
include 'config.php';

$loginMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user info in session

                $_SESSION['user'] = $user;  // ✅ must be set before redirecting

                // Redirect to a protected page (example: dashboard.php)
                header("Location: details.php");
                exit();
            } else {
                $loginMessage = "Invalid password.";
            }
        } else {
            $loginMessage = "User not found.";
        }
    } else {
        $loginMessage = "Database error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <style>
        body .signin-page {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signin-container {
            max-width: 400px;
            padding: 30px;
            margin: 100px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .signin-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .signin-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .signin-container input[type="email"],
        .signin-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .signin-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .signin-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .signin-container .message {
            margin-top: 15px;
            color: red;
        }
    </style>
</head>

<body class="signin-page">
    <?php include 'un_navbar.php'; ?>

    <div class="signin-container">
        <h2>Sign In</h2>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Sign In">
        </form>

        <?php if (!empty($loginMessage)): ?>
            <div class="message"><?php echo htmlspecialchars($loginMessage); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
