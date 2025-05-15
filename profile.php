<?php
session_start();
require 'connection.php';
require 'partials/header.php';
$con = connection();

// 1) Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$uid = intval($_SESSION['user_id']);
$msg = '';

// 2) Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    // Build an optional password fragment if they set one
    $passFragment = '';
    if (!empty($_POST['password'])) {
        $hash = $_POST['password'];
        $passFragment = ", Password='$hash'";
    }
    // Escape inputs
    $fn = mysqli_real_escape_string($con, $fullname);
    $em = mysqli_real_escape_string($con, $email);

    $sql = "UPDATE users
               SET FullName='$fn',
                   Email='$em'
                   $passFragment
             WHERE UserID = $uid";
    if (mysqli_query($con, $sql)) {
        $msg = 'Profile updated successfully.';
        $_SESSION['user'] = $fullname;  // update display name in session
    } else {
        $msg = 'Error: ' . mysqli_error($con);
    }
}

// 3) Fetch current user info
$res = mysqli_query($con,
    "SELECT Username, Email, FullName, Date
       FROM users
      WHERE UserID = $uid
      LIMIT 1"
);
$user = mysqli_fetch_assoc($res);
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Profile – DimaBuy</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="layout/profile.css">
</head>
<body>
  <?php render_header('Search Results – DimaBuy');?>

  <main class="content">
    <h2>Your Profile</h2>
    <?php if ($msg): ?>
      <p class="success"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="post" class="profile-form">
      <label>
        Username
        <input type="text"
               value="<?= htmlspecialchars($user['Username']) ?>"
               disabled>
      </label>

      <label>
        Full Name
        <input type="text"
               name="fullname"
               value="<?= htmlspecialchars($user['FullName']) ?>"
               required>
      </label>

      <label>
        Email
        <input type="email"
               name="email"
               value="<?= htmlspecialchars($user['Email']) ?>"
               required>
      </label>

      <label>
        New Password
        <input type="password"
               name="password"
               placeholder="Leave blank to keep current">
      </label>

      <label>
        Member Since
        <input type="text"
               value="<?= htmlspecialchars($user['Date']) ?>"
               disabled>
      </label>

      <button type="submit" class="btn">Save Changes</button>
    </form>
  </main>

  <?php render_footer();?>
</body>
</html>
