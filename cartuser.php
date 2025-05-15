<?php
session_start();
require 'connection.php';
require 'partials/header.php';
$con = connection();

// 1) Ensure logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$uid = intval($_SESSION['user_id']);

// 2) Fetch cart items with JOIN to pull item details
$sql = "SELECT 
          c.Quantity,
          i.Item_ID,
          i.Name,
          i.Price,
          i.Image
        FROM cart AS c
        JOIN items AS i
          ON c.Item_ID = i.Item_ID
        WHERE c.UserID = $uid";
$res = mysqli_query($con, $sql);
$cartItems = mysqli_fetch_all($res, MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_sale'])) {
    // 1) Fetch everything in the cart
    $res = mysqli_query($con,
      "SELECT c.Item_ID, c.Quantity, i.Price
         FROM cart AS c
         JOIN items AS i ON c.Item_ID = i.Item_ID
        WHERE c.UserID = $uid"
    );
    // 2) Insert each into sold_items
    while ($row = mysqli_fetch_assoc($res)) {
        $item   = intval($row['Item_ID']);
        $qty    = intval($row['Quantity']);
        $price  = floatval($row['Price']);
        mysqli_query($con,
          "INSERT INTO sold_items (UserID, Item_ID, Quantity, UnitPrice)
           VALUES ($uid, $item, $qty, $price)"
        );
    }
    // 3) Clear the cart
    mysqli_query($con,
      "DELETE FROM cart WHERE UserID = $uid"
    );
    echo "<script>
    alert('Thank you! Your purchase has been recorded.');
    window.location.href = 'homepage.php';
    </script>";
    
    
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $itemId = intval($_POST['item_id']);
    if ($_POST['action'] === 'update') {
        $qty = max(1, intval($_POST['quantity']));
        mysqli_query($con,
          "UPDATE cart
             SET Quantity = $qty
           WHERE UserID = $uid AND Item_ID = $itemId"
        );
    } elseif ($_POST['action'] === 'delete') {
        mysqli_query($con,
          "DELETE FROM cart
           WHERE UserID = $uid AND Item_ID = $itemId"
        );
    }
    header('Location: cartuser.php');
    exit;
}



mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DimaBuy</title>
  <link rel="stylesheet" href="layout/homepage.css">
</head>
<body>
  <?php render_header('DimaBuy');?>

  <main class="content">
    <h2>Your Cart</h2>

    <?php if (empty($cartItems)): ?>
      <p style="margin-left: 3%;">Your cart is empty.</p>
    <?php else: ?>
      <table class="cart-table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
        <?php $total = 0; ?>
        <?php foreach ($cartItems as $row): ?>
          <?php 
            $sub = $row['Price'] * $row['Quantity'];
            $total += $sub;
          ?>
          <tr>
            <td>
              <img src="images/<?= htmlspecialchars($row['Image']) ?>"
                   alt="" style="height:50px">
            </td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= number_format($row['Price'],2) ?> MAD</td>
            <td>
    <form method="post" style="display:flex; gap:4px; align-items:center;">
      <input type="hidden" name="item_id" value="<?= $row['Item_ID'] ?>">
      <input 
        type="number" 
        name="quantity" 
        value="<?= intval($row['Quantity']) ?>" 
        min="1" 
        style="width: 50px;">
      <button type="submit" 
              name="action" 
              value="update" 
              style="padding:4px 8px;">
        Update
      </button>
    </form>
  </td>

  <!-- Delete link -->
  <td>
    <form method="post">
      <input type="hidden" name="item_id" value="<?= $row['Item_ID'] ?>">
      <button type="submit"
              name="action"
              value="delete"
              style="padding:4px 8px; background:crimson; color:white;">
        Delete
      </button>
    </form>
  </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" style="text-align:right">Total:</th>
            <th><?= number_format($total,2) ?> MAD</th>
          </tr>
        </tfoot>
      </table>
    <?php if (!empty($cartItems)): ?>
  <form method="post" class="confirm-form">
  <button type="submit" name="confirm_sale" class="btn-confirm">
    Confirm Your Purchase
  </button>
</form>
<?php endif; ?>

    <?php endif; ?>

  </main>

  <?php render_footer();?>
</body>
</html>
