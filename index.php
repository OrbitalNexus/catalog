<?php
session_start();
$granted = false;
$m = '';

// if login button is pushed create session variables for user and granted to true. 
if (isset($_POST['submit']) && !empty($_POST['submit'])) {

    if (isLogged()) {
        $_SESSION['granted'] = true;
        $_SESSION['user'] = $_POST['username'];
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
    <script defer src="./js/script.js"></script>
</head>
<body>
    <?php
    // welcome message in form. 
    $welcome = 
    '<h1 class="title" >ACME WAREHOUSE STORE</h1>
    <p class="welcome-message">Welcome to the largest fine goods emporium on earth</p>
    <hr>';

    // login form. 
    $form =
    '<form action="." method="post">
    <div class="container">
    <p class="welcome">Login to Your Account</p>
        <div class="login">
            <p class="user">User</p>
            <input name="username" id="userName" type="text">
            <p class="pass">Password</p>
            <input type="password" name="password" id="passWord">
        </div>
        <div class="buttons">
            <input class="submit" type="submit" name="submit" value="Login">
        </div>
        <hr>
        <div class="create">
            <p class="create-account">Create Your Account</p>
            <a class="createBut" href="./create-account.php">Create Account</a>
        </div>
    </div> 
    </form>';

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
    
    // if session granted is not set echo normal navbar and welcome. 
    if (!isset($_SESSION['granted'])) {
        echo $topnav;
        echo $welcome;

        // if log in button pushed but incorrect password or username display error message and echo form. 
        if (isset($_POST['submit']) && !empty($_POST['submit'])) {
            if (!isLogged()) {
                echo '<p class="access">Username or password is incorrect</p>';
                }
        }
            echo $form;

            // if session granted echo logged in navbar and welcome grant access. 
        } else if (isset($_SESSION['granted'])){
        echo $lognav;
        echo $welcome;
        echo '<p class="gained-access">Enjoy our emporium, '.$_SESSION['user'].'</p>';
        echo '<img class="store-front" src="./img/storefront.jpeg" alt="">';
    }

    ?>
</body>
</html>
<?php
// connect to database, salt and hash, check username and password against database.
// return true or false if they match or not. 
function isLogged() {
    if (isset($_POST['submit']) && !empty($_POST['submit'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
    }
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
            
     $salt1 = 'alsfdkj89iejfnv77';
     $salt2 = 'mviolaulaksdjf894';
     $pass = $salt1.$pass.$user.$salt2;
     $pass = hash('sha512', $pass);

     $sql = "SELECT * FROM user WHERE username='". $user . "' AND passwords='" . $pass . "'; ";
     $results = mysqli_query($conn, $sql);
     $row = mysqli_fetch_array($results);
            
     if ($user === $row['username'] && $pass === $row['passwords']) {
        mysqli_close($conn);
        return true;
    } else if (!isset($_SESSION['granted'])) {
        mysqli_close($conn);
        return false;
    }
}



?>