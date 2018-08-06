<?php

session_start();

if($_SESSION) {
    header("Location: index.php");
}
else{
    header("Location: login.php");
}




