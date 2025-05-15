<?php
session_start();
require 'connection.php';
$con = connection();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $e = trim($_POST['email']);
    $p = trim($_POST['password']);
    $c = trim($_POST['confirm']);

    if ($u === '' || $e === '' || $p === '' || $c === '') {
        $msg = 'All fields are required.';
    } elseif (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Invalid email.';
    } elseif ($p !== $c) {
        $msg = 'Passwords don’t match.';
    } else {
        // check email uniqueness
        $e_esc = mysqli_real_escape_string($con, $e);
        $sql   = "SELECT UserID FROM users WHERE Email='$e_esc' LIMIT 1";
        $res   = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) > 0) {
            $msg = 'Email already used.';
        } else {
            $u_esc = mysqli_real_escape_string($con, $u);
            
            $sql   = "INSERT INTO users (Username, Password, Email, Date)
                      VALUES ('$u_esc','$p','$e_esc', CURDATE())";
            if (mysqli_query($con, $sql)) {
                $_SESSION['user'] = $u;
                header('Location:  homepage.php');
                exit;
            } else {
                $msg = 'Error: ' . mysqli_error($con);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up – MyShop</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="layout/style.css">
</head>
<body class="login-page">

  <div class="login-container">

    <!-- LEFT: white form panel -->
    <div class="login-panel">
      <div class="form-wrapper">
        <h2>Sign Up</h2>
        <?php if($msg): ?>
          <p class="error"><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>
        <form method="post" action="register.php">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" required>

          <label for="email">Email</label>
          <input id="email" name="email" type="email" required>

          <label for="password">Password</label>
          <input id="password" name="password" type="password" required>

          <label for="confirm">Confirm Password</label>
          <input id="confirm" name="confirm" type="password" required>

          <button type="submit" class="btn">Register</button>
        </form>
      </div>
    </div>

    <!-- RIGHT: background image panel -->
    <div class="image-panel">
      <img src="images/background-login-register.jpg" alt="Hero graphic">
    </div>

  </div>

</body>
</html>
