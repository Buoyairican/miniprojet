<?php
session_start();
require 'connection.php';
$con = connection();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $e = trim($_POST['email']);
    $p = trim($_POST['password']);

    if ($e === '' || $p === '') {
        $msg = 'Fill both fields.';
    } else {
        $e_esc = mysqli_real_escape_string($con, $e);
        
        $sql   = "SELECT UserID, FullName , admin
                  FROM users 
                  WHERE Email='$e_esc' 
                    AND Password='$p' 
                  LIMIT 1";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) === 1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['user'] = $row['FullName'];
            $_SESSION['user_id'] = $row['UserID']; 
            $_SESSION['is_admin'] = (int)$row['admin'];  
             if ($_SESSION['is_admin'] === 1) {
            header('Location: admin.php');
                  exit;
              } else {
            header('Location: homepage.php');
        exit;
    }
        } else {
            $msg = 'Wrong email or password.';
        }
    }
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log In</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="layout/style.css">
</head>
<body class="login-page">

  <div class="login-container">
    <!-- LEFT: form panel -->
    <div class="login-panel">
      <div class="form-wrapper">
        <h2>Log In</h2>
        <form method="post" action="">
          <label for="email">Email</label>
          <input id="email" name="email"  type="email" placeholder="Enter your email" required>

          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Enter your password" required>

          <button type="submit" class="btn">Login</button>
        </form>
      </div>
    </div>

    <!-- RIGHT: image panel -->
    <div class="image-panel">
      <img src="images/background-login-register.jpg" >
    </div>
  </div>

</body>
</html>
