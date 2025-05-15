<?php
session_start();
require 'connection.php';
$con = connection();

// 1) Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id = intval($_POST['item_id']);
    
     if (mysqli_query($con, "DELETE FROM `items` WHERE `Item_ID` = $id")) {
        echo "<script>alert('Item Has Been Deleted successfully!');</script>";
    } else {
        // grab the real MySQL error
        $err = addslashes(mysqli_error($con));
        echo "<script>alert( Error: {$err}');</script>";
    }
}

// 2) Fetch only the three columns we need
$res   = mysqli_query($con, "SELECT `Item_ID`, `Name`, `Description` FROM `items`");
$items = mysqli_fetch_all($res, MYSQLI_ASSOC);

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Items</title>
  <link rel="stylesheet" href="layout/admin.css">
  <style>
    /* you can omit this if items-table is already styled in admin.css */
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
    .items-table button {
      padding: 6px 12px;
      background: #e74c3c;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .items-table button:hover {
      background: #c0392b;
    }
    .main-content.delete-page {
  flex-direction: column;      /* stack children top to bottom */
  align-items: flex-start;     /* keep them left-aligned */
  gap: 1.5rem;                 /* space between h1 and table */
}

/* Make sure the table fills the width */
.main-content.delete-page .items-table {
  width: 100%;
}

  </style>
</head>
<body class="admin-page">
  <div class="admin-container">
    <?php include 'partials/sidebare.php'; ?>

    <main class="main-content delete-page">
      <h1><strong>Delete Items</strong></h1>

      <table class="items-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $row): ?>
          <tr>
            <form method="post" onsubmit="return confirm('Delete “<?= htmlspecialchars($row['Name']) ?>”?')">
              <td>
                <?= $row['Item_ID'] ?>
                <input type="hidden" name="item_id" value="<?= $row['Item_ID'] ?>">
              </td>
              <td><?= htmlspecialchars($row['Name']) ?></td>
              <td><?= htmlspecialchars($row['Description']) ?></td>
              <td>
                <button type="submit" name="action" value="delete">
                  Delete
                </button>
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
