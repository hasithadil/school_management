<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0; 
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: right;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #333;
  color: white;
}

.topnav a.active:hover {
    background-color: #ddd;
    color: black;
}

</style>
</head>
<body>

<div class="topnav">
    <a class="active" href="#" onclick="confirmLogout(event)">Logout</a>

    <script>
    function confirmLogout(event) {
        event.preventDefault(); // Prevent default link behavior
        if (confirm("Are you sure you want to logout?")) {
            // If confirmed, redirect to logout.php with a query parameter to show alert
            window.location.href = "logout.php?logout=1";
        }
    }
    </script>

</div>

</body>
</html>
