<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <style>
        /* Scoped styles for index.php */
        .index-page body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .index-page .container {
            text-align: center;
            background: #fff;
            margin-top: 30px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .index-page h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .index-page .btn {
            display: inline-block;
            color: #fff;
            background-color: #007bff;
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .index-page .btn:hover {
            background-color: #0056b3;
        }

        .index-page .btn-secondary {
            background-color: #28a745;
        }

        .index-page .btn-secondary:hover {
            background-color: #218838;
        }
    </style>
</head>

<body class="index-page">
    <!-- Include the navbar -->
    <?php include 'un_navbar.php'; ?>

    <!-- Main content -->
    <div class="container">
        <h1>Welcome to Our Web Application</h1>
        <p>Please choose an option below:</p>

        <!-- Button to navigate to the Registration Page -->
        <a href="register.php" class="btn btn-secondary">Register</a>

        <!-- Button to navigate to the Login Page -->
        <a href="login.php" class="btn">Sign-In</a>
    </div>
</body>
</html>