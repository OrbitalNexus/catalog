<?php
session_start();

if (isset($_POST['username']) && !empty($_POST['username'])) {
    $_SESSION['user'] = $_POST['username'];
}

// Update cart quantity on cart page.
if (isset($_POST['update'])) {
    for ($i = 0; $i < sizeof($_SESSION['qty']); $i++) {
        $postQty = 'qty-'.$i;
        $_SESSION['qty'][$i] = $_POST[$postQty];
    }

    // Remove item from cart is qty equals zero.
    for ($i = 0; $i < sizeof($_SESSION['qty']); $i++) {
        if ($_SESSION['qty'][$i] == 0) {
            unset($_SESSION['prod-name'][$i]);
            unset($_SESSION['price'][$i]);
            unset($_SESSION['qty'][$i]);
            unset($_SESSION['prod-id'][$i]);
        }
    }
    
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

// logged in navbar.
$lognav =
    '<div class="nav-container">
    <div class="topnav">
        <a class="prod" href="./catalog.php">Products</a>
        <a class="cart" href="./cart.php">Cart</a>
        <a class="log-out" href="./logout.php">Logout</a>
    </div>
    </div>';

    // when place order button is pushed print list with total and remove cart.
    if (isset($_POST['place-order']) && !empty($_POST['place-order'])) {
        echo $lognav;
        echo "<p class='thanks'>Thank you for your purchase!<p>";
        echo '<div class="list-container">';
        for ($i = 0; $i < sizeof($_SESSION['prod-id']); $i++) {
            echo '<p class="name-list">'.$_SESSION['prod-name'][$i].'</p>';
            echo '<p class="qty-list">Quantity: '.$_SESSION['qty'][$i].'</p>';
            $gtotal += ($_SESSION['price'][$i] * $_SESSION['qty'][$i]);
        }
            echo "Grand Total: $" . $gtotal;
            echo '</div>';

            for ($i = 0; $i < sizeof($_SESSION['prod-id']) + 8; $i++) {
                    unset($_SESSION['prod-name'][$i]);
                    unset($_SESSION['price'][$i]);
                    unset($_SESSION['qty'][$i]);
                    unset($_SESSION['prod-id'][$i]);
                }
        // else if there's something in cart show a cart table.       
    } else if (isset($_SESSION['prod-id']) && !empty($_SESSION['prod-id'])) {
            echo $lognav;
            echo '<form action="" method="post">';
            $gtotal = 0;
            echo '<br><br>';
            echo '<div class="table-container">';
            echo '<table class="cart-table"><tr class="row-head"><th class="head-name">Name</th><th class="head-price">Price</th><th class="head-qty">Qty</th><th class="head-total">Total</th></tr>';
        for ($i = 0; $i < sizeof($_SESSION['prod-id']); $i++) {
            echo '<tr>';
            echo '<td class="data-name">'.$_SESSION['prod-name'][$i].'</td>';
            echo '<td class="data-price">$'.$_SESSION['price'][$i].'</td>';
            echo '<td class="data-qty"><input class="qty-input" type="number" min="0" name="qty-'.$i.'" placeholder="'.$_SESSION['qty'][$i].'" value="'.$_SESSION['qty'][$i].'"></input></td>';
            echo '<td class="data-total">$'.($_SESSION['price'][$i] * $_SESSION['qty'][$i]).'</td>';
            echo '</tr>';
            $gtotal += ($_SESSION['price'][$i] * $_SESSION['qty'][$i]);
        }
            echo '<tr><td class="grand-total" colspan="3">Grand Total:</td><td class="g-total">$'.$gtotal.'</td></tr>';
            echo '</table>';
            echo '</div>';
            echo '<div class="order-buttons">';
            echo '<input class="update-cart" type="submit" name="update" value="Update Cart">';
            echo '<input class="place" type="submit" name="place-order" value="Place Order">';
            echo '</div>';

            echo "<p class='last-item'>Please only remove last item added to cart by setting to zero, thank you.<p>";
        
            // else show message that cart is empty.
        } else if (!isset($_SESSION['prod-id']) || empty($_SESSION['prod-id'])) {
            echo $lognav;
            echo '<br><br>';
            echo "Your cart is empty... add something to it :)";
        } 


    
    


?>
    
</body>
</html>