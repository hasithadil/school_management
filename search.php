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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 50, 0.7), rgba(0, 0, 70, 0.7)),
                        url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
            color: #fff;
            background: rgba(214, 208, 208, 0.95);
        }

        .register-page .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.95);
            margin: 70px auto 40px auto;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
            color: #2c3e50;
        }

        .register-page h2 {
            margin-bottom: 25px;
            font-size: 26px;
            color: rgb(106, 106, 229);
        }

        .register-page input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .register-page input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .register-page input[type="submit"]:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .register-page .details {
            text-align: left;
            margin-top: 30px;
        }

        .register-page .details h3 {
            color: rgb(38, 188, 225);
            margin-bottom: 15px;
        }

        .register-page .details p {
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        .register-page .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        font-size: 1.05rem;
    }

    .detail-row span:first-child {
        font-weight: 600;
        color: #444;
        min-width: 100px;
    }

    .detail-row span:last-child {
        color: #222;
        text-align: left;
        flex: 1;
        padding-left: 15px;
        word-break: break-word;
    }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            <div class="detail-row"><span>Name:</span><span><?php echo htmlspecialchars($searchResult['name']); ?></span></div>
            <div class="detail-row"><span>NIC:</span><span><?php echo htmlspecialchars($searchResult['nic']); ?></span></div>
            <div class="detail-row"><span>Gender:</span><span><?php echo htmlspecialchars($searchResult['gender']); ?></span></div>
            <div class="detail-row"><span>Address:</span><span><?php echo htmlspecialchars($searchResult['address']); ?></span></div>
            <div class="detail-row"><span>Phone:</span><span><?php echo htmlspecialchars($searchResult['phone']); ?></span></div>
            <div class="detail-row"><span>Email:</span><span><?php echo htmlspecialchars($searchResult['email']); ?></span></div>
            <div class="detail-row"><span>Course:</span><span><?php echo htmlspecialchars($searchResult['course']); ?></span></div>
        </div>

        <?php endif; ?>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Student Portal System. All rights reserved.
    </footer>
</body>
</html>
