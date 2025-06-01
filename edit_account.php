<?php
session_start();
include 'config.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$successMessage = "";
$errorMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);
    $nic = $user['nic']; // NIC is the primary key

    // Update user in DB
    $stmt = $conn->prepare("UPDATE users SET name = ?, gender = ?, address = ?, phone = ?, course = ? WHERE nic = ?");
    $stmt->bind_param("ssssss", $name, $gender, $address, $phone, $course, $nic);

    if ($stmt->execute()) {
        // Update session
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['gender'] = $gender;
        $_SESSION['user']['address'] = $address;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['course'] = $course;

        $successMessage = "Account updated successfully!";
        header("Location: details.php");
        exit();
    } else {
        $errorMessage = "Error updating account: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            background: #f4f4f4;
            border-radius: 10px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .message {
            margin-top: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update your account?");
        }
    </script>
</head>
<body>

<?php include 'regi_navbar.php'; ?>

<div class="container">
    <h2>Edit Account</h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php if ($user['gender'] === 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($user['gender'] === 'Female') echo 'selected'; ?>>Female</option>
        </select>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

        <label>Course:</label>
        <input type="text" name="course" value="<?php echo htmlspecialchars($user['course']); ?>" required>

        <input type="submit" value="Update Account">
    </form>

    <?php if (!empty($successMessage)): ?>
        <p class="message success"><?php echo htmlspecialchars($successMessage); ?></p>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <p class="message error"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
</div>

</body>
</html>
