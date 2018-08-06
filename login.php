<?php

session_start();
require 'database.php';

if($_GET) $errorMessage = $_GET['errorMessage'];
else $errorMessage = '';

if ($_POST) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashPassword = MD5($password);

//    echo($hashPassword . " - " . $password); exit();
//  CONNECT TO DATABASE
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//  GET USER DATA FROM DATABASE
    $sql = "SELECT * FROM customers WHERE email = '$username' AND password = '$password' LIMIT 1";
    $q = $pdo->prepare($sql);
    $q->execute(array());
    $data = $q->fetch(PDO::FETCH_ASSOC);

//  CHECK IF USER EXISTS AND PASSWORD IS CORRECT
    if ($data){
        $_SESSION["username"] = $username;
        header("Location: success.php");
    }
    else{
        header("Location: login.php?errorMessage=Invalid Credentials");
        exit();
    }
}
else //show empty login

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<h1>Sign in</h1>
<form class="form-horizontal" action="login.php" method="post">

    <input name="username" type="text" placeholder="me@email.com" required>
    <input name="password" type="password" required>
    <button type="submit" class="btn btn-success">Sign in</button>
    <br>
    <br>
    <?php
    if($_SESSION){
        echo ("<a href='logout.php'>Log out</a>");
    }
    else{
        echo("Not logged in");
    }
    ?>
    <br>
    <p style="color: red"><?php echo $errorMessage; ?> </p>

</form>
</div>
</body>

</html>