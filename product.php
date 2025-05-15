<?php
session_start();
require 'connection.php';
require 'partials/header.php';
$con = connection();

$id = intval($_GET['id'] ?? 0);
if (!$id) {
  header('Location: homepage.php');
  exit;
}

$sql = "SELECT * FROM items WHERE Item_ID = $id LIMIT 1";
$res = mysqli_query($con, $sql);
if (!$res || mysqli_num_rows($res) === 0) {
  echo "Product not found.";
  exit;
}
$p = mysqli_fetch_assoc($res);
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($p['Name']) ?> – DimaBuy</title>
  <link rel="stylesheet" href="layout/product.css">
</head>
<body>

<?php render_header('DimaBuy');?>

<main class="product-detail">
  <div class="detail-container">

    <div class="detail-image">
      <img
        src="images/<?= htmlspecialchars($p['Image']) ?>"
        alt="<?= htmlspecialchars($p['Name']) ?>">
    </div>

    <div class="detail-info">
      <div class="detail-title">
        <h1><?= htmlspecialchars($p['Name']) ?></h1>
      </div>

      <div class="detail-desc">
        <p><?= nl2br(htmlspecialchars($p['Description'])) ?></p>
      </div>

      <div class="detail-meta">
        <p><strong>Country:</strong> <?= htmlspecialchars($p['Country_Made']) ?></p>
        <p><strong>Added on:</strong> <?= htmlspecialchars($p['Add_Date']) ?></p>
        <p><strong>Tags:</strong> <?= htmlspecialchars($p['tags']) ?></p>
        <p class="price"><strong><?= number_format($p['Price'],2) ?> MAD</strong></p>
        
      </div>

      <!-- Unified form for quantity + add to cart -->
      <form method="get" action="productddtocart.php" class="detail-action">
        <p><strong>Quantity</strong></p>
        <input type="hidden" name="id" value="<?= $p['Item_ID'] ?>">
        <input
          type="number"
          name="quantity"
          class="quantity-input"
          value="1"
          min="1">
        <button type="submit" class="btn-buy">
          Add to Cart
        </button>
      </form>
      
    </div>
  </div>
</main>


    </div>
  </div>
</main>

<?php render_footer();?>

</body>
</html>
