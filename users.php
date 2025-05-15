<?php
session_start();
require 'connection.php';
$con = connection();

// 1) Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = intval($_POST['user_id']);

    if ($action === 'update') {
        // sanitize inputs
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $email    = mysqli_real_escape_string($con, $_POST['email']);
        $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
        $admin    = intval($_POST['admin']);

        $sql = "
          UPDATE `users` SET
            `Username` = '$username',
            `Password` = '$password',
            `Email`    = '$email',
            `FullName` = '$fullname',
            `admin`    = $admin
          WHERE `UserID` = $id
        ";
        
        if (mysqli_query($con, $sql)) {
        echo "<script>alert('User Has Been Updated successfully!');</script>";
        } else {
        // grab the real MySQL error
        $err = addslashes(mysqli_error($con));
        echo "<script>alert( Error: {$err}');</script>";
        }

    } elseif ($action === 'delete') {
        
        if (mysqli_query($con, "DELETE FROM `users` WHERE `UserID` = $id")) {
        echo "<script>alert('User Has Been Deleted successfully!');</script>";
        } else {
        // grab the real MySQL error
        $err = addslashes(mysqli_error($con));
        echo "<script>alert( Error: {$err}');</script>";
        }
    }
}

// 2) Fetch all users
$res   = mysqli_query($con, "
  SELECT `UserID`, `Username`, `Password`, `Email`, `FullName`, `admin`, `Date`
  FROM `users`
");
$users = mysqli_fetch_all($res, MYSQLI_ASSOC);

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <link rel="stylesheet" href="layout/admin.css">
  <style>
    /* reuse the same table styles */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .items-table th,
    .items-table td {
      border: 1px solid #ccc;
      padding: 8px;
      vertical-align: middle;
    }
    .items-table input,
    .items-table select {
      width: 100%;
      box-sizing: border-box;
      padding: 4px;
      border: 1px solid #bbb;
      border-radius: 4px;
      height: 36px;
    }
    .items-table button {
      padding: 6px 12px;
      background: #2980b9;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      height: 36px;
    }
    .items-table button.delete {
      background: #e74c3c;
    }
    .items-table button:hover {
      opacity: 0.9;
    }
    /* stack title and table vertically */
    .main-content.users-page {
      flex-direction: column;
      align-items: flex-start;
      gap: 1.5rem;
    }
  </style>
</head>
<body class="admin-page">
  <div class="admin-container">
    <?php include 'partials/sidebare.php'; ?>

    <main class="main-content users-page">
      <h1><strong>Manage Users</strong></h1>

      <table class="items-table">
        <thead>
          <tr>
            <th>UserID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>FullName</th>
            <th>Admin</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <form method="post" onsubmit="return <?= ($_POST['action'] ?? '')==='delete' ? "confirm('Really delete this user?')" : 'true' ?>">
              <td>
                <?= $u['UserID'] ?>
                <input type="hidden" name="user_id" value="<?= $u['UserID'] ?>">
              </td>
              <td>
                <input type="text" name="username" value="<?= htmlspecialchars($u['Username']) ?>">
              </td>
              <td>
                <input type="text" name="password" value="<?= htmlspecialchars($u['Password']) ?>">
              </td>
              <td>
                <input type="email" name="email" value="<?= htmlspecialchars($u['Email']) ?>">
              </td>
              <td>
                <input type="text" name="fullname" value="<?= htmlspecialchars($u['FullName']) ?>">
              </td>
              <td>
                <select name="admin">
                  <option value="0" <?= $u['admin']==0?'selected':'' ?>>No</option>
                  <option value="1" <?= $u['admin']==1?'selected':'' ?>>Yes</option>
                </select>
              </td>
              <td>
                <?= htmlspecialchars($u['Date']) ?>
              </td>
              <td style="display:flex; gap:4px;">
                <button type="submit" name="action" value="update">Edit</button>
                <button type="submit" name="action" value="delete" class="delete">Delete</button>
              </td>
            </form>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
