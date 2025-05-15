<?php
session_start();
require 'connection.php';
$con = connection();

// 1) Handle an update POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    $id          = intval($_POST['item_id']);
    $name        = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price       = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $country     = mysqli_real_escape_string($con, $_POST['country']);
    $added_on    = mysqli_real_escape_string($con, $_POST['added_on']);
    $tags        = mysqli_real_escape_string($con, $_POST['tags']);
    $image       = mysqli_real_escape_string($con, $_POST['image']);

    $sql = "
      UPDATE `items` SET
        `Name`         = '$name',
        `Description`  = '$description',
        `Price`        = $price,
        `Cat_ID`       = $category_id,
        `Country_Made` = '$country',
        `Add_Date`     = '$added_on',
        `tags`         = '$tags',
        `Image`        = '$image'
      WHERE `Item_ID` = $id
    ";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Item Has Been Edited successfully!');</script>";
    } else {
        // grab the real MySQL error
        $err = addslashes(mysqli_error($con));
        echo "<script>alert( Error: {$err}');</script>";
    }
   
}

// 2) Fetch all items
$res   = mysqli_query($con, "SELECT * FROM `items`");
$items = mysqli_fetch_all($res, MYSQLI_ASSOC);

// 3) Fetch categories for the dropdown
$catRes     = mysqli_query($con, "SELECT id, name FROM categories");
$categories = mysqli_fetch_all($catRes, MYSQLI_ASSOC);

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Items</title>
  <link rel="stylesheet" href="layout/admin.css">
  <style>
   /* Simple table styling */
.items-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  table-layout: auto;        /* let columns size naturally */
}

.items-table th,
.items-table td {
  border: 1px solid #ccc;
  padding: 8px;
  height: 60px;              /* fixed row height */
  vertical-align: middle;    /* center content vertically */
}

.items-table input,
.items-table select {
  width: 100%;
  box-sizing: border-box;
  padding: 4px;
  height: 36px;              /* make inputs taller */
  line-height: 1.2;
  border: 1px solid #bbb;
  border-radius: 4px;
}

.items-table button {
  padding: 6px 12px;
  height: 36px;              /* match input height */
  line-height: 1.2;
  background: #2980b9;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.items-table button:hover {
  background: #3498db;
}
.main-content.edit-page {
  flex-direction: column;      /* stack children top to bottom */
  align-items: flex-start;     /* keep them left-aligned */
  gap: 1.5rem;                 /* space between h1 and table */
}

/* Make sure the table fills the width */
.main-content.edit-page .items-table {
  width: 100%;
}


  </style>
</head>
<body class="admin-page">
    <div class="admin-container">
  <?php include 'partials/sidebare.php'; ?>

  <main class="main-content edit-page"">
    
<h1><strong> Existing Items</strong></h1>
    <table class="items-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Category ID</th>
          <th>Country</th>
          <th>Added On</th>
          <th>Tags</th>
          <th>Image Path</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($items as $row): ?>
        <tr>
          <form method="post">
            <td>
              <?= $row['Item_ID'] ?>
              <input type="hidden" name="item_id" value="<?= $row['Item_ID'] ?>">
            </td>
            <td>
              <input type="text" name="name" value="<?= htmlspecialchars($row['Name']) ?>">
            </td>
            <td>
              <input type="text" name="description" value="<?= htmlspecialchars($row['Description']) ?>">
            </td>
            <td>
              <input type="number" name="price" step="0.01" value="<?= $row['Price'] ?>">
            </td>
            <td>
              <input type="number" name="category_id" value="<?= $row['Cat_ID'] ?>">
            </td>
            <td>
              <input type="text" name="country" value="<?= htmlspecialchars($row['Country_Made']) ?>">
            </td>
            <td>
              <input type="date" name="added_on" value="<?= htmlspecialchars($row['Add_Date']) ?>">
            </td>
            <td>
              <input type="text" name="tags" value="<?= htmlspecialchars($row['tags']) ?>">
            </td>
            <td>
              <input type="text" name="image" value="<?= htmlspecialchars($row['Image']) ?>">
            </td>
            <td>
              <button type="submit" name="action" value="update">Edit</button>
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
