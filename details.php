<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .details-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background: #f4f4f4;
            border-radius: 10px;
        }

        h2 {
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        button, input[type="submit"] {
            padding: 10px 15px;
            margin-top: 15px;
            margin-right: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #dc3545;
        }

        button:hover, input[type="submit"]:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <?php include 'regi_navbar.php'; ?>

    <div class="details-container">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        <p><strong>NIC:</strong> <?php echo htmlspecialchars($user['nic']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Course:</strong> <?php echo htmlspecialchars($user['course']); ?></p>

        <a href="edit_account.php"><button>Edit Account</button></a>
        <form action="delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');" style="display:inline;">
            <input type="hidden" name="nic" value="<?php echo htmlspecialchars($user['nic']); ?>">
            <input type="submit" value="Delete Account">
        </form>
    </div>
</body>
</html>
