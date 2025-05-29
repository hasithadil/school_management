<?php
session_start();
include 'config.php';

$searchResult = null;
$searchError = "";
$nicInput = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nicInput = trim($_POST['nic']);

    if (empty($nicInput)) {
        $searchError = "Please enter a valid NIC number.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE nic = ?");
        $stmt->bind_param("s", $nicInput);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $searchResult = $result->fetch_assoc();
        } else {
            $searchError = "No student found with the provided NIC number.";
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Student</title>

    <style>
        .register-page body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            min-height: 100vh;
            flex-direction: column;
        }

        .register-page .container {
            max-width: 600px;
            margin: 100px auto;
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

        .register-page input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .register-page input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .register-page input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .register-page .details {
            text-align: left;
            margin-top: 30px;
        }

        .register-page p {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .register-page .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body class="register-page">
    <?php include 'un_navbar.php'; ?>

    <div class="container">
        <h2>Search Student by NIC</h2>
        <form method="POST" action="">
            <input type="text" name="nic" placeholder="Enter NIC number" value="<?php echo htmlspecialchars($nicInput); ?>" required>
            <input type="submit" value="Search">
        </form>

        <?php if (!empty($searchError)) : ?>
            <p class="error"><?php echo htmlspecialchars($searchError); ?></p>
        <?php endif; ?>


        <?php if ($searchResult): ?>
            <div class="details">
                <h3>Student Details</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($searchResult['name']); ?></p>
                <p><strong>NIC:</strong> <?php echo htmlspecialchars($searchResult['nic']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($searchResult['gender']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($searchResult['address']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($searchResult['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($searchResult['email']); ?></p>
                <p><strong>Course:</strong> <?php echo htmlspecialchars($searchResult['course']); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
