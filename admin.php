<?php
session_start();
// only allow admins
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header('Location: homepage.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Control Station</title>
  <link rel="stylesheet" href="layout/admin.css">
</head>
<body class="admin-page">
  <div class="admin-container">

    <!-- LEFT SIDEBAR -->
    <?php include 'partials/sidebare.php'; ?>

    <!-- RIGHT MAIN CONTENT -->
    <main class="main-content">
      <h1>Welcome to Admin Control Station</h1>
    </main>
    
  </div>
</body>
</html>
