<?php
session_start();
require 'connection.php';

$con = connection();
$catRes = mysqli_query($con, "SELECT id, name FROM categories");
$categories = mysqli_fetch_all($catRes, MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // grab & sanitize form inputs
    $name        = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price       = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $country     = mysqli_real_escape_string($con, $_POST['country']);
    $added_on    = mysqli_real_escape_string($con, $_POST['added_on']);
    $tags        = mysqli_real_escape_string($con, $_POST['tags']);
    $image       = mysqli_real_escape_string($con, $_POST['image']);
    $member_id   = intval($_SESSION['user_id']);  // pull logged-in user

    // Build SQL with Member_ID
    $sql = "
      INSERT INTO `items`
        (`Name`,`Description`,`Price`,`Cat_ID`,
         `Country_Made`,`Add_Date`,`tags`,`Image`,
         `Member_ID`)
      VALUES (
        '$name',
        '$description',
         $price,
         $category_id,
        '$country',
        '$added_on',
        '$tags',
        '$image',
         $member_id
      )
    ";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Item added successfully!');</script>";
    } else {
        // grab the real MySQL error
        $err = addslashes(mysqli_error($con));
        echo "<script>alert( Error: {$err}');</script>";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Item</title>
  <link rel="stylesheet" href="layout/admin.css">
</head>
<body class="admin-page">

  <div class="admin-container">

    <!-- LEFT SIDEBAR -->
    <?php include 'partials/sidebare.php'; ?>

    <!-- RIGHT MAIN CONTENT -->
    <main class="main-content">
      <h1><strong> New Product</strong></h1>

      <?php if (!empty($error)): ?>
        <p class="error">Error: <?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

<form method="post" class="admin-form">
  <label>
    Name
    <input type="text" name="name" required>
  </label>

  <label>
    Description
    <textarea name="description" rows="3" required></textarea>
  </label>

  <label>
    Price (MAD)
    <input type="number" name="price" step="0.01" required>
  </label>

  <label>
    Category
    <select name="category_id" required>
      <option value="" disabled selected>— Select one —</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </label>

  <label>
    Country
    <input type="text" name="country" required>
  </label>

  <label>
    Added on
    <input type="date" name="added_on" required>
  </label>

  <label>
    Tags
    <input
      type="text"
      name="tags"
      placeholder="eg: TEC,network,cable,internet"
    >
  </label>

  <label>
    Image Path
    <input type="text" name="image">
  </label>

  <button type="submit" class="btn-submit">Add Item</button>
</form>

    </main>

  </div>

  

</body>
</html>

