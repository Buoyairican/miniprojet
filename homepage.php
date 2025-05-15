<?php
session_start();
require 'connection.php';
$con = connection();

// Fetch 9 items
$sql = "SELECT Item_ID, Name, Description, Image ,Price FROM items LIMIT 9";
$res = mysqli_query($con, $sql);
$products = [];
while ($row = mysqli_fetch_assoc($res)) {
    $products[] = $row;
}

// Slider images (you can replace with DB‐driven list)
$slides = [
  'images/slide1.jpg',
  'images/slide2.jpg',
  'images/slide3.jpg',
];
//extract all the filter categories

$catRes = mysqli_query($con, "SELECT ID, Name FROM categories WHERE Visibility = 1");
$categories = [];
while ($c = mysqli_fetch_assoc($catRes)) {
    $categories[] = $c;
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DimaBuy – Home</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="layout/homepage.css">
</head>
<body>

  <!-- HEADER -->
<header class="header">
  <div class="header-left">
    <img src="images/logo.png" alt="Logo" class="logo-img">
    <span class="site-name">DimaBuy</span>
  </div>

<div class="header-center">
  <form action="search.php" method="get">  
  <div class="search-container">
    <select name="filter" class="search-filter" onchange="this.form.submit()">
        <option value="" disabled selected hidden>Filter</option>
        <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['ID'] ?>">
        <?= htmlspecialchars($cat['Name']) ?>
        </option>
        <?php endforeach; ?>
    </select>
    <div class="search-box">
      <input type="text" name = "q" class="search-input" placeholder="Search…">
      <img src="images/search-icon.png" alt="Search" class="search-icon">
    </div>
  </div>
  </form>
</div>

  <div class="header-right">
    <a href="profile.php" class="icon profile">
      <img src="images/profile.png" alt="Profile">
    </a>
    <a href="cartuser.php" class="icon cart">
      <img src="images/cart.png" alt="Cart">
    </a>
  </div>
</header>

  <!-- SLIDER -->
   
  <section class="slider">
  <button class="arrow prev">&#10094;</button>
  <img id="slide-img" src="images/slide1.jpg">
  <button class="arrow next">&#10095;</button>
  </section>


  <!-- PRODUCTS GRID -->
  <section class="products">
  <?php foreach ($products as $p): ?>
    <div class="card">
      <div class="thumb">
        <img
          src="images/<?= htmlspecialchars($p['Image'])?>"
          alt="<?= htmlspecialchars($p['Name'])?>">
      </div>
      <div class="info">
        <h3><?= htmlspecialchars($p['Name'])?></h3>
        <p><?= htmlspecialchars($p['Description'])?></p>
        <p class="price">
          Price: <?= number_format($p['Price'],2)?> MAD
        </p>
        <!-- Only this button is a link now -->
        <a 
          href="product.php?id=<?= $p['Item_ID']?>" 
          class="btn-buy">
          View Details
        </a>
      </div>
    </div>
  <?php endforeach; ?>
</section>



  <!-- FOOTER -->
  <footer class="footer">
    © DimaBuy 2025
  </footer>

  <!-- SLIDER SCRIPT -->
  <script>
    const slides = <?= json_encode($slides) ?>;
    let idx = 0;
    const imgEl = document.getElementById('slide-img');
    document.querySelector('.prev').onclick = () => {
      idx = (idx - 1 + slides.length) % slides.length;
      imgEl.src = slides[idx];
    };
    document.querySelector('.next').onclick = () => {
      idx = (idx + 1) % slides.length;
      imgEl.src = slides[idx];
    };
    setInterval(() => {
      idx = (idx + 1) % slides.length;
      imgEl.src = slides[idx];
    }, 30000);
  </script>

</body>
</html>
