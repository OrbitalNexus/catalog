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

// welcome message.
    $welcome =
    '<h1 class="title">CREATE ACCOUNT</h1>
    <hr>';

    // display form. 
    $form =
    '<form action="" method="post">
    <div class="container">
        <div class="login">
            <p class="user">User</p>
            <input name="username" id="userName" type="text">
            <p class="pass">Password</p>
            <input type="password" name="password1" id="password1">
            <p class="pass">Verify Password</p>
            <input type="password" name="password2" id="password2">
        </div>
        <div class="buttons">
            <input class="reset" type="reset" value="Reset">
            <input disabled id="createBut" class="submit1" type="submit" name="submit" value="Create Account">
        </div>
    </div> 
    </form>';

    // normal navbar. 
    $topnav =
    '<div class="nav-container">
    <div class="topnav">
        <a class="active" href=".">Login</a>
        <a class="prod" href="./catalog.php">Products</a>
        <a class="CA" href="./create-account.php">Create Account</a>
    </div>
    </div>';
    
    //echo normal navbar and welcome and fields for password verification display. 
    echo $topnav;
    echo $welcome;
    echo '<p id="passOne"></p>';
    echo '<p id="passTwo"></p>';
    echo '<p id="passThree"></p>';
    echo '<p id="passFour"></p>';
    echo '<p id="passFive"></p>';
    echo '<p id="passSix"></p>';

    // if create account button is pushed check that passwords match and check if function runs. 
    if (isset($_POST['submit'])) {
        if ($_POST['password1'] === $_POST['password2']){
            if (isDuplicate()) {

                // else is function not and something in username then create account. 
            } else if (!isDuplicate()) {
                if (!empty($_POST['username'])){
                    addUser();
                    echo '<br><br>';
                    echo '<p class="account-success">Account created successfully</p>';
                    echo '<br>';
                    echo '<a class="logged" href=".">Login</a>';
                } else if (empty($_POST['username'])) {
                    echo '<p class="userEmpty">Username cannot be empty</p>';
                }
                
            }
            // if passwords do not match display error message. 
        } else if ($_POST['password1'] != $_POST['password2']) {
            echo '<br>';
            echo '<p class="passError">Passwords do not match</p>';
        }
    }
    // display form. 
    echo $form;
    ?>

<script src="./js/script.js"></script>
</body>
</html>
<?php
// if button pushed connect to database check username if already exists. 
function isDuplicate() {
    if (isset($_POST['submit']) && !empty($_POST['submit'])) {
        $user = $_POST['username'];
        $pass = $_POST['password1'];
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
            
     

     $sql = "SELECT * FROM user";
     $results = mysqli_query($conn, $sql);
     while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        if ($row['username'] == $_POST['username']) {
            echo '<br><br>';
            echo '<p class="already-user">Username already exists</p>';
            mysqli_close($conn);
            return true;
     }
    }
    mysqli_close($conn);
    return false;
}

// connect to database salt and hash, insert new user into database. 
function addUser() {

    if (isset($_POST['submit']) && !empty($_POST['submit'])) {
        $user = $_POST['username'];
        $pass = $_POST['password1'];
    }

     $conn = mysqli_connect(HOST,USER,PASS,DB);
     
     $salt1 = 'alsfdkj89iejfnv77';
     $salt2 = 'mviolaulaksdjf894';
     $pass = $salt1.$pass.$user.$salt2;
     $pass = hash('sha512', $pass);
     
     $sql = "INSERT INTO user (username, passwords) VALUES('$user', '$pass');";
     mysqli_query($conn, $sql);
     mysqli_close($conn);
     return;
}

?>