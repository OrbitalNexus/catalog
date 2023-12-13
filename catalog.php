<?php
session_start();

// session for user logged in. 
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $_SESSION['user'] = $_POST['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <?php

    // normal navbar for when not logged in. 
      $topnav =
      '<div class="nav-container">
      <div class="topnav">
          <a class="active" href=".">Login</a>
          <a class="prod" href="./catalog.php">Products</a>
          <a class="CA" href="./create-account.php">Create Account</a>
      </div>
      </div>';
  
      // navbar for when logged in. 
      $lognav =
      '<div class="nav-container">
      <div class="topnav">
          <a class="prod" href="./catalog.php">Products</a>
          <a class="cart" href="./cart.php">Cart</a>
          <a class="log-out" href="./logout.php">Logout</a>
      </div>
      </div>';

      // either display logged in navbar or normal navbar. 
      if (isset($_SESSION['user'])) {
        echo $lognav;
        } else {
        echo $topnav;
        }
    // run this function to display catalog. 
    getProducts();
    ?>
</body>
</html>
<?php
// function for catalog, connect to database. 
function getProducts() {
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '1550');
        define('DB', 'palindromes');
    } else {
        define('HOST', 'localhost');
        define('USER', 'joshwiza_elfman');
        define('PASS', 'FluxQuantum99$');
        define('DB', 'joshwiza_palindromes');
    }

    $conn = mysqli_connect(HOST,USER,PASS,DB);
    $sql = "SELECT * FROM product;";
    $results = mysqli_query($conn, $sql);
        echo '<h1>WAREHOUSE PRODUCTS</h1>';
        echo '<p class="fine-goods">A pristine selection of fine goods made for the wiley coyotes out there!</p>';

        echo '<div class="master-container">';

        // loop through database to display each item in catalog.
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $id = $row['id'];
        echo '<div class="card-container">';
        echo '<div class="card">';
        echo '<span class="card-name">'.$row['name'].'</span>';
        echo '<div class="prod-details"><a href="product.php?id='.$id.'">Product Details</a></div>';
        echo '<div class="card-price">$'.$row['price'].'</div>';
        echo '<div class="card-image-holder"><img class="card-image" src="'.$row['image'].'" alt=""></div></div>';
        
        echo '</div>';
    }
        echo '</div>';
        echo '</div>';

        return;
}
?>