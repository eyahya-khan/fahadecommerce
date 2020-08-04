<?php 
// database connection
require('src/config.php');
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
if (!empty($_POST['cartId'])
    && !empty($_POST['quantity'])
    && isset($_SESSION['cartItems'][$_POST['cartId']])) 
{
      $_SESSION['cartItems'][$_POST['cartId']]['quantity'] = $_POST['quantity'];
}
header('location: ' . $_SERVER['HTTP_REFERER']);
exit;
