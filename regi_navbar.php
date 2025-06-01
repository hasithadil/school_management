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
    background-color:rgb(189, 18, 18);
    color: black;
}

/* Custom confirmation modal */
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

#cancelLogoutBtn {
  background: #ccc;
  color: #333;
}

#cancelLogoutBtn:hover {
  background: #bbb;
}

#confirmLogoutBtn {
  background: #c0392b;
  color: white;
}

#confirmLogoutBtn:hover {
  background: #a93226;
}

@keyframes fadeIn {
  to {
    opacity: 1;
  }
}
</style>
</head>
<body>

<div class="topnav">
  <a class="active" href="#" onclick="showLogoutConfirm(event)">Logout</a>
</div>

<!-- Logout confirmation modal -->
<div id="logoutConfirmBox" class="confirm-box">
  <div class="confirm-content">
    <p>Are you sure you want to logout?</p>
    <div class="confirm-actions">
      <button id="cancelLogoutBtn">Cancel</button>
      <button id="confirmLogoutBtn">Yes, Logout</button>
    </div>
  </div>
</div>

<script>
function showLogoutConfirm(event) {
  event.preventDefault();
  document.getElementById('logoutConfirmBox').style.display = 'flex';
}

document.getElementById('cancelLogoutBtn').addEventListener('click', function() {
  document.getElementById('logoutConfirmBox').style.display = 'none';
});

document.getElementById('confirmLogoutBtn').addEventListener('click', function() {
  window.location.href = "logout.php?logout=1";
});
</script>

</body>
</html>
