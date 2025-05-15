<?php
// layout.php

// 1) Shared startup: session + DB
require_once __DIR__ . '/../connection.php';
$con = connection();

// 2) Fetch categories for the search filter
$catRes = mysqli_query($con, "SELECT ID, Name FROM categories WHERE Visibility = 1");
$categories = [];
while ($c = mysqli_fetch_assoc($catRes)) {
    $categories[] = $c;
}
mysqli_close($con);

// 3) Render the opening HTML + header
function render_header($title = 'DimaBuy') {
    global $categories;
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="layout/homepage.css">
</head>
<body>
  <header class="header">
    <div class="header-left">
        <a href="homepage.php" class="logo-link">
      <img src="images/logo.png" alt="Logo" class="logo-img">
      </a>
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
            <input type="text" name="q" class="search-input" placeholder="Search…">
            <img src="images/search-icon.png" alt="Search" class="search-icon"
                 onclick="this.closest('form').submit()">
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
    <?php
}

// 4) Render the closing footer + HTML
function render_footer() {
    ?>
  <footer class="footer">
    © DimaBuy 2025
  </footer>
</body>
</html>
    <?php
}
