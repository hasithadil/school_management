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
                $_SESSION['user'] = $user;
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

        body{
            background: linear-gradient(to bottom right, #e0f0ff, #f4f4f4);
        }
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
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: left;
            opacity: 0;
            animation: fadeIn 0.8s forwards ease-in-out;
        }

        .signin-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-size: 24px;
        }

        .signin-container form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .signin-container form input[type="email"],
        .signin-container form input[type="password"] {
            width: 370px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .signin-container form input[type="email"]:focus,
        .signin-container form input[type="password"]:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(70, 130, 230, 0.3);
        }

        .signin-container form input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #4a90e2, #357ABD);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 12px rgba(70, 130, 230, 0.3);
        }

        .signin-container form input[type="submit"]:hover {
            background: linear-gradient(to right, #357ABD, #2b6cb0);
            transform: translateY(-1px);
        }

        .signin-container .message {
            margin-top: 15px;
            color: red;
            text-align: center;
        }

        .signin-container p {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95rem;
        }

        .signin-container a {
            color: #007bff;
            text-decoration: none;
        }

        .signin-container a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            text-align: center;
            padding: 12px 0;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            font-size: 0.9rem;
            letter-spacing: 0.4px;
            box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="signin-page">
    <?php include 'un_navbar.php'; ?>

    <div class="signin-container">
        <h2>Sign In</h2>
        <form method="POST" action="">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Sign In">
        </form>

        <?php if (!empty($loginMessage)): ?>
            <div class="message"><?php echo htmlspecialchars($loginMessage); ?></div>
        <?php endif; ?>

        <p>
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Student Portal System. All rights reserved.
    </footer>
</body>
</html>
