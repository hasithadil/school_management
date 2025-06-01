<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome</title>

  <style>
    .index-page body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(rgba(0, 0, 50, 0.7), rgba(0, 0, 70, 0.7)),
                  url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
      background: rgba(214, 208, 208, 0.95);
    }

    .index-page .container {
      text-align: center;
      background: rgba(255, 255, 255, 0.95);
      margin: 20px auto;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      animation: fadeIn 1s ease-in-out;
      color: #2c3e50; /* override text color inside container */
    }

    .index-page h1 {
      font-size: 28px;
      margin-bottom: 10px;
      color:rgb(106, 106, 229);
    }

    .index-page p {
      font-size: 16px;
      color: #333;
      margin-bottom: 25px;
      line-height: 1.6;
    }

    .index-page .btn {
      display: inline-block;
      color: #fff;
      background-color: #007bff;
      margin: 10px 15px;
      padding: 12px 28px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
    }

    .index-page .btn:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }

    .index-page .btn-secondary {
      background-color: #28a745;
      box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
    }

    .index-page .btn-secondary:hover {
      background-color: #218838;
      transform: translateY(-2px);
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

    /* Logo container */
    .logo-container {
      text-align: center;
      margin-top: 10px;
      margin-bottom: 30px;
      animation: fadeIn 1s ease forwards;
      color: white;
    }

    .logo-container img {
      width: 90px;
      height: 90px;
      display: block;
      margin: 0 auto 10px auto;
      border-radius: 50%;
      box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
    }

    .logo-container h1 {
      font-size: 2.5rem;
      margin: 0 0 5px 0;
      color:rgb(38, 188, 225);
    }

    .logo-container p {
      font-size: 1.1rem;
      font-style: italic;
      margin: 0;
      color: rgba(17, 30, 114, 0.8);
    }

    /* Footer fixed at bottom */
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

<body class="index-page">
  <?php include 'un_navbar.php'; ?>

  <!-- Logo + Title -->
  <div class="logo-container">
    <img src="logo.png" alt="Student Portal Logo" />
    <h1>Student Portal System</h1>
    <p>Empowering Students Digitally</p>
  </div>

  <!-- Main container (unchanged class name) -->
  <div class="container">
    <h1>Welcome to Our Web Application</h1>
    <p>
      Welcome to Our <strong>Student Management System</strong> — a simple and efficient platform for students to register, sign in, and manage their academic details with ease.
    </p>
    <a href="register.php" class="btn btn-secondary">Register</a>
    <a href="login.php" class="btn">Sign In</a>
  </div>

  <!-- Footer -->
  <footer>
    &copy; <?php echo date("Y"); ?> Student Portal System. All rights reserved.
  </footer>
</body>
</html>
