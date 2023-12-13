<?php
session_start();

// session for user.
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $_SESSION['user'] = $_POST['username'];
}

// connect to database.
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

// display unique product based on get id. 
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $sql = "SELECT * FROM product WHERE ID = ".$_GET['id'];
    $results = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $id = $row['id'];
        $product = '<div class="card-container2">
        <div class="card">
        <span class="card-name">'.$row['name'].'</span>
        <div class="card-description">'.$row['description'].'</div>
        <div class="card-price">$'.$row['price'].'</div>
        <div class="card-image-holder"><img class="card-image" src="'.$row['image'].'" alt=""></div></div>
        </div>';
    }
        echo '</div>';
    
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
    #error_reporting(-1);
    #ini_set( 'display_errors', 1 );
    
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

    // either show logged in navbar or normal navbar depending on if logged in or not. 
    if (isset($_SESSION['user'])) {
        echo $lognav;
    } else {
        echo $topnav;
    }

    // form for add to cart and qty dropdown. 
    echo '<h1>PRODUCT DETAILS</h1>';
    echo '<p class="welcome">Add your items to the cart</p>';
    echo $product;
    echo '<form class="cart-form" action="" method="post">
    <input type="hidden" name="id" value="'.$_GET['id'].'">
    <label for="product">Qty:</label>
    <select name="qty" id="qty">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    </select>
    <input class="add-to-cart" type="submit" name="add-to-cart" value="Add to Cart">
    </form>';

    // function to add items to cart.
    function cartAdd() {
        
        // connect to db to get price and name. 
        $conn = mysqli_connect(HOST,USER,PASS,DB);
        $sql = 'SELECT * FROM product WHERE ID = '.$_POST['id'].'';
        $results = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            $price = $row['price'];
            $productName = $row['name'];
        }
    
        // if something is not in cart then create session variables in an array. 
        if (!isset($_SESSION['prod-id'])) {
            $_SESSION['prod-id'] = array();
            $_SESSION['qty'] = array();
            $_SESSION['price'] = array();
            $_SESSION['prod-name'] = array();
        }

        // push the array with cart items. 
        array_push($_SESSION['prod-id'], $_POST['id']);
        array_push($_SESSION['qty'], $_POST['qty']);
        array_push($_SESSION['price'], $price);
        array_push($_SESSION['prod-name'], $productName);
      return true;     
    }
    
    // if add to cart button pushed and logged in, see if cart if empty and then add items to cart.
        if (isset($_POST['add-to-cart'])) {
            if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                if (!isset($_SESSION['prod-id'])) {
                    cartAdd();
                     echo "<p class='items'>Items added successfully</p>";
                     echo '<a class="conShop" href="/catalog/catalog.php">Continue Shopping</a>';

                // else if cart is not empty run for loop to check duplicates set session to true if found.
                } else if (isset($_SESSION['prod-id'])) {
                    $_SESSION['dupe'] = false;
                    for ($i = 0; $i < sizeof($_SESSION['prod-id']); $i++) {
                        if ($_GET['id'] == $_SESSION['prod-id'][$i]) {
                            echo '<p class="already-cart">Already in cart. Added '.$_POST['qty'].'<p>';
                            $_SESSION['qty'][$i] = $_SESSION['qty'][$i] + $_POST['qty'];
                            $_SESSION['dupe'] = true;
                            } 
                    }
                    // if no duplicates found then add item to cart. 
                        if ($_SESSION['dupe'] == false) {
                            cartAdd();
                            echo "<p class='items'>Items added successfully</p>";
                            echo '<a class="conShop" href="/catalog/catalog.php">Continue Shopping</a>';
                        }
                        
                }
                     
                // else if not logged in display please login message.
            } else if (empty($_SESSION['user']) && !isset($_SESSION['user'])) {
                echo "<p class='please-login'>Please login first</p>";
                echo '<a class="login-first" href=".">Login</a>';
            }
                   
     } 
    ?>
</body>
</html>