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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background: linear-gradient(to bottom right, #e0f0ff, #f4f4f4);
            color: #2c3e50;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 35px 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeIn 0.8s forwards ease-in-out;
            transition: box-shadow 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
        }

        h2 {
            color: #2b6cb0;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 28px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: 600;
            font-size: 1rem;
            color: #34495e;
            user-select: none;
        }

        input[type="text"], select {
            width: 100%;
            padding: 12px 14px;
            margin-top: 8px;
            border: 1.5px solid #b0bec5;
            border-radius: 8px;
            font-size: 1rem;
            color: #34495e;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #2b6cb0;
            outline: none;
            box-shadow: 0 0 6px rgba(43, 108, 176, 0.3);
        }

        input[type="submit"] {
            margin-top: 30px;
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(90deg, #28a745, #218838);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.4);
            transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
            user-select: none;
        }

        input[type="submit"]:hover {
            background: linear-gradient(90deg, #218838, #1e7e34);
            box-shadow: 0 8px 20px rgba(33, 136, 52, 0.6);
            transform: translateY(-2px);
        }

        .message {
            margin-top: 25px;
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            user-select: none;
        }

        .success {
            color: #28a745;
        }

        .error {
            color: #e74c3c;
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
            user-select: none;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Confirmation modal styles */
        .confirm-box {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            display: none;
        }

        .confirm-content {
            background: white;
            padding: 25px 30px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.3s ease-in-out;
        }

        .confirm-content p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 20px;
        }

        .confirm-actions {
            display: flex;
            justify-content: space-around;
        }

        .confirm-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background 0.3s ease;
        }

        #cancelBtn {
            background: #ccc;
            color: #333;
        }

        #cancelBtn:hover {
            background: #bbb;
        }

        #confirmUpdateBtn {
            background: #28a745;
            color: white;
        }

        #confirmUpdateBtn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<?php include 'regi_navbar.php'; ?>

<div class="container">
    <h2>Edit Account</h2>
    <form id="updateForm" method="POST">
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

<!-- Confirmation modal -->
<div id="confirmBox" class="confirm-box">
    <div class="confirm-content">
        <p>Are you sure you want to update your account?</p>
        <div class="confirm-actions">
            <button id="cancelBtn">Cancel</button>
            <button id="confirmUpdateBtn">Yes, Update</button>
        </div>
    </div>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> Student Portal System. All rights reserved.
</footer>

<script>
    const updateForm = document.getElementById('updateForm');
    const confirmBox = document.getElementById('confirmBox');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmUpdateBtn = document.getElementById('confirmUpdateBtn');

    updateForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        confirmBox.style.display = 'flex'; // Show confirmation modal
    });

    cancelBtn.addEventListener('click', function() {
        confirmBox.style.display = 'none'; // Hide modal
    });

    confirmUpdateBtn.addEventListener('click', function() {
        updateForm.submit(); // Proceed with actual form submission
    });
</script>

</body>
</html>
