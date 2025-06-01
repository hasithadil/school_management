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
            $successPopup = true;
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>

  <style>
    body.register-page {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f4f4;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .container {
      width: 100%;
      max-width: 600px;
      min-width: 400px;
      background: #fff;
      margin: auto;
      margin-top: 30px;
      margin-bottom: 40px;
      padding: 30px 25px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .container h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 26px;
      color: #333;
    }

    .message-error {
      background-color: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 6px;
      font-weight: 600;
    }

    .message-success {
      background-color: #d1e7dd;
      color: #0f5132;
      border: 1px solid #badbcc;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 6px;
      font-weight: 600;
    }

    .container label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #333;
    }

    .container input[type="text"],
    .container input[type="email"],
    .container input[type="password"],
    .container select {
      width: 100%;
      padding: 10px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      box-sizing: border-box;
    }

    .container input[type="text"]:focus,
    .container input[type="email"]:focus,
    .container input[type="password"]:focus,
    .container select:focus {
      border-color: #007bff;
      outline: none;
    }

    .container input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .container input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .container p {
      text-align: center;
      margin-top: 15px;
    }

    .container a {
      color: #007bff;
      text-decoration: none;
    }

    .container a:hover {
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
  </style>
</head>

<body class="register-page">
  <?php include 'un_navbar.php'; ?>

  <div class="container">
    <h2>Register</h2>

    <?php if ($showPopup): ?>
      <div class="message-error">
        <?php echo htmlspecialchars($registrationMessage); ?>
      </div>
    <?php endif; ?>

    <?php if ($successPopup): ?>
      <div class="message-success">
        Registration successful! Redirecting...
      </div>
      <script>
        setTimeout(function() {
          window.location.href = "details.php";
        }, 1500);
      </script>
    <?php endif; ?>

    <form method="POST" action="">
      <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div style="flex: 1; min-width: 200px;">
          <label for="nic">NIC:</label>
          <input type="text" id="nic" name="nic" required>
        </div>

        <div style="flex: 1; min-width: 200px;">
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="o">Other</option>
          </select>
        </div>

        <div style="flex: 1; min-width: 200px;">
          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required>
        </div>

        <div style="flex: 1; min-width: 200px;">
          <label for="phone">Phone:</label>
          <input type="text" id="phone" name="phone" required>
        </div>

        <div style="flex: 1; min-width: 200px;">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div style="flex: 1; min-width: 200px;">
          <label for="course">Course:</label>
          <input type="text" id="course" name="course" required>
        </div>

        <div style="flex: 1; min-width: 200px;">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
      </div>

      <input type="submit" value="Register">
    </form>

    <p>
      Already have an account? <a href="login.php">Sign in here</a>
    </p>
  </div>

  <footer>
    &copy; <?php echo date("Y"); ?> Your Institute Name. All rights reserved.
  </footer>
</body>
</html>
