<?php
require('src/config.php');
require('src/dbconnect.php');

$pageTitle = "Create order";
//$pageId = "create_order";

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//exit;


if (isset($_POST['createOrderBtn'])) {
	$firstName    = trim($_POST['firstName']);
	$lastName     = trim($_POST['lastName']);
	$email        = trim($_POST['email']);
	$password     = trim($_POST['password']);
	$phone        = trim($_POST['phone']);
	$street       = trim($_POST['street']);
	$city         = trim($_POST['city']);
	$country      = trim($_POST['country']);
	$postalCode   = trim($_POST['postalCode']);
	$totalPrice   = trim($_POST['totalPrice']);
    


//	$error = "";
//	//error messages
//    if (empty($firstName) || empty($lastName)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your names are missing.</li>";
//    }
//    if (empty($email)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your e-mail adress is missing.</li>";
//    }
//    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your e-mail adress is not correct</li>";
//    }
//    if (empty($password)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your password is missing</li>";
//    }
//    if (!empty($password) && strlen($password) < 8) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your password should be at least 8 characters long.</li>";
//    }
//    if (empty($phone)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your phone number is missing.</li>";
//    }
//    if (empty($street)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your street adress is missing.</li>";
//    }
//    if (empty($city)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your city is missing.</li>";
//    }
//    if (empty($country)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your country is missing.</li>";
//    }
//    if (empty($postal_codeode)) {
//        $error .= "<li class='list-group-item list-group-item-danger'>Your postal code is missing.</li>";
//    }
//
//
//    if ($error) {
//    	$_SESSION['msg'] = "<ul class='list-group'>{$error}</ul>";
//          redirect('checkout.php');
////    	header('Location: checkout.php');
////		exit;
//	}

    try {
	        $query = "
	            SELECT * FROM users
	            WHERE email = :email
	        ";
	        $stmt = $dbconnect->prepare($query);
	        $stmt->bindValue(':email', $email);
	        $stmt->execute();
	        $user = $stmt->fetch();
	    } catch (\PDOException $e) {
	        throw new \PDOException($e->getMessage(), (int) $e->getCode());
	    }
    
//echo "<pre>";
//print_r($user);
//echo "</pre>";
    
    if($user){ //if user exist in database
        $userId = $user['id'];
    }else{
        try { //else create a new user and fetch the newly created id
	        $query = "
	            INSERT INTO users (first_name, last_name, email, password, phone, street, postal_code, city, country) 
                values (:firstName, :lastName, :email, :password, :phone, :street, :postalCode, :city, :country);
	        ";
	        $stmt = $dbconnect->prepare($query);
	        $stmt->bindValue(':firstName', $firstName);
	        $stmt->bindValue(':lastName', $lastName);
	        $stmt->bindValue(':email', $email);
	        $stmt->bindValue(':password', $password);
	        $stmt->bindValue(':phone', $phone);
	        $stmt->bindValue(':street', $street);
	        $stmt->bindValue(':postalCode', $postalCode);
	        $stmt->bindValue(':city', $city);
	        $stmt->bindValue(':country', $country);
	        $stmt->execute();
	        $userId = $dbconnect -> lastInsertId();
	    } catch (\PDOException $e) {
	        throw new \PDOException($e->getMessage(), (int) $e->getCode());
	    }
    }

    
//echo "<pre>";
//print_r($userId);
//echo "</pre>";

//create data in orders table
    try {
	        $query = "
	            INSERT INTO orders (user_id, total_price, billing_full_name, billing_street, billing_postal_code, billing_city, billing_country) 
                values (:userId, :totalPrice, :fullName, :street, :postalCode, :city, :country);
	        ";
	        $stmt = $dbconnect->prepare($query);
	        $stmt->bindValue(':userId', $userId);
	        $stmt->bindValue(':totalPrice', $totalPrice);
	        $stmt->bindValue(':fullName', "{$firstName} {$lastName}");
	        $stmt->bindValue(':street', $street);
	        $stmt->bindValue(':postalCode', $postalCode);
	        $stmt->bindValue(':city', $city);
	        $stmt->bindValue(':country', $country);
	        $stmt->execute();
	        $orderId = $dbconnect -> lastInsertId();
	    } catch (\PDOException $e) {
	        throw new \PDOException($e->getMessage(), (int) $e->getCode());
	    }
//
//echo "<pre>";
//print_r($orderId);
//echo "</pre>";
//exit;
//create order items
foreach($_SESSION['cartItems'] as $cartId => $cartItem) {
    
    try {
	        $query = "
	            INSERT INTO order_items (order_id, product_id, quantity, unit_price, product_title) 
                values (:orderId, :productId, :quantity, :price, :title);
	        ";
	        $stmt = $dbconnect->prepare($query);
	        $stmt->bindValue(':orderId', $orderId);
	        $stmt->bindValue(':productId', $cartItem['id']);
	        $stmt->bindValue(':quantity', $cartItem['quantity']);
	        $stmt->bindValue(':price', $cartItem['price']);
	        $stmt->bindValue(':title', $cartItem['name']);//name comes from checkout.php 
	        $stmt->execute();
	    } catch (\PDOException $e) {
	        throw new \PDOException($e->getMessage(), (int) $e->getCode());
	    }

}
unset($_SESSION['cartItems']);// clear cart
 header('Location: order-confirmation.php');
	exit;   
    
}
header('Location: checkout.php');
	exit;  
