<?php
session_start();
include 'config.php';

$name = $nic = $gender = $address = $phone = $email = $course = $password = "";
$registrationMessage = "";
$showPopup = false;
$successPopup = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $nic = trim($_POST['nic']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $checkNIC = $conn->prepare("SELECT nic FROM users WHERE nic = ?");
    $checkNIC->bind_param("s", $nic);
    $checkNIC->execute();
    $checkNIC->store_result();

    if ($checkNIC->num_rows > 0) {
        $registrationMessage = "A user with this NIC already exists.";
        $showPopup = true;
    } else {
        $sql = "INSERT INTO users (name, nic, gender, address, phone, email, course, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $name, $nic, $gender, $address, $phone, $email, $course, $password);

        if ($stmt->execute()) {
            $successPopup = true; // trigger popup + redirect in JS
        } else {
            $registrationMessage = "Error: " . $stmt->error;
            $showPopup = true;
        }

        $stmt->close();
    }

    $checkNIC->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <style>
        .register-page body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-page .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-page h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .register-page label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .register-page input[type="text"],
        .register-page input[type="email"],
        .register-page input[type="password"],
        .register-page select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .register-page input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .register-page input[type="submit"]:hover {
            background-color: #038c5a;
        }

        .register-page .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>

<body class="register-page">
    <?php include 'un_navbar.php'; ?>

    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="o">Other</option>
            </select>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Register">
        </form>
    </div>

    <?php if (!empty($registrationMessage) && $showPopup): ?>
        <script>
            alert("<?php echo htmlspecialchars($registrationMessage); ?>");
        </script>
    <?php endif; ?>

    <?php if ($successPopup): ?>
        <script>
            alert("Registration successful!");
            window.location.href = "course.php";
        </script>
    <?php endif; ?>
</body>
</html>
