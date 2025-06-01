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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #e0f0ff, #f4f4f4);
            color: #333;
        }

        .details-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            animation: fadeIn 0.8s forwards ease-in-out;
        }

        h2 {
            color: #2b6cb0;
            font-size: 26px;
            margin-bottom: 25px;
            text-align: center;
        }

        p {
            margin: 12px 0;
            font-size: 1.05rem;
            line-height: 1.5;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 6px;
        }

        strong {
            color: #555;
        }

        button,
        input[type="submit"] {
            padding: 10px 18px;
            margin-top: 20px;
            margin-right: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button {
            background: linear-gradient(to right, #4a90e2, #357ABD);
            color: white;
        }

        button:hover {
            background: linear-gradient(to right, #357ABD, #2b6cb0);
            transform: translateY(-1px);
        }

        input[type="submit"] {
            background: linear-gradient(to right, #e74c3c, #c0392b);
            color: white;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to right, #c0392b, #a8322d);
            transform: translateY(-1px);
        }

        .detail-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
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

        @media screen and (max-width: 640px) {
            .details-container {
                margin: 80px 20px;
                padding: 25px 20px;
            }

            button, input[type="submit"] {
                width: 100%;
                margin: 10px 0 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'regi_navbar.php'; ?>

    <div class="details-container">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        
        <div class="detail-row"><span>NIC:</span><span><?php echo htmlspecialchars($user['nic']); ?></span></div>
        <div class="detail-row"><span>Gender:</span><span><?php echo htmlspecialchars($user['gender']); ?></span></div>
        <div class="detail-row"><span>Address:</span><span><?php echo htmlspecialchars($user['address']); ?></span></div>
        <div class="detail-row"><span>Phone:</span><span><?php echo htmlspecialchars($user['phone']); ?></span></div>
        <div class="detail-row"><span>Email:</span><span><?php echo htmlspecialchars($user['email']); ?></span></div>
        <div class="detail-row"><span>Course:</span><span><?php echo htmlspecialchars($user['course']); ?></span></div>

        <a href="edit_account.php"><button>Edit Account</button></a>
        <form action="delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');" style="display:inline;">
            <input type="hidden" name="nic" value="<?php echo htmlspecialchars($user['nic']); ?>">
            <input type="submit" value="Delete Account">
        </form>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Student Portal System. All rights reserved.
    </footer>
</body>
</html>
