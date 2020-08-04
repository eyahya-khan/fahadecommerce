<?php 
require('src/config.php');

if (!empty($_POST['cartId']) && isset($_SESSION['cartItems'][$_POST['cartId']])) {
       unset($_SESSION['cartItems'][$_POST['cartId']]);
}

header('location: ' . $_SERVER['HTTP_REFERER']);
exit;
