<?php
require('../src/config.php');
require('../src/dbconnect.php');
$pageTitle = "Order confirmation";
$pageId = "order_confirmation";

if(empty($_GET['id'])){
    header('Location: orders.php');
    exit;
}
//echo "<pre>";
//print_r($_GET);
//echo "</pre>";
//exit;

//fetch order
//try {
//        $query = "
//        SELECT * FROM orders
//        WHERE id = :id
//        ";
//        $stmt = $dbconnect->prepare($query);
//        $stmt -> bindValue(':id',$_GET['id']);
//        $stmt -> execute();
//        $order = $stmt-> fetch();
//    } catch (\PDOException $e){
//      throw new \PDOException($e->getMessage(), (int) $e->getCode());
//    }

//echo "<pre>";
//print_r($order);
//echo "</pre>";



try {
        $query = "
        SELECT * FROM `orders`
        INNER JOIN users ON orders.user_id = users.id
        INNER JOIN order_items ON orders.id = order_items.order_id
        INNER JOIN products ON products.id = order_items.product_id
        WHERE orders.id = :id
        ";
        $stmt = $dbconnect->prepare($query);
        $stmt -> bindValue(':id',$_GET['id']);
        $stmt -> execute();
        $data = $stmt-> fetchAll();
    } catch (\PDOException $e){
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

$orderData = $data[0];

//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;





//fetch user
//try {
//        $query = "
//        SELECT * FROM users
//        WHERE id = :id
//        ";
//        $stmt = $dbconnect->prepare($query);
//        $stmt -> bindValue(':id', $order['user_id']);
//        $stmt -> execute();
//        $user = $stmt-> fetch();
//    } catch (\PDOException $e){
//      throw new \PDOException($e->getMessage(), (int) $e->getCode());
//    }
//   

//fetch from products
//try {
//        $query = "
//        SELECT * FROM products
//        WHERE id = :id
//        ";
//        $stmt = $dbconnect->prepare($query);
//        $stmt -> bindValue(':id', $order['user_id']);
//        $stmt -> execute();
//        $user = $stmt-> fetch();
//    } catch (\PDOException $e){
//      throw new \PDOException($e->getMessage(), (int) $e->getCode());
//    }

//echo "<pre>";
//print_r($user);
//echo "</pre>";


//fetch order items
//try {
//        $query = "
//        SELECT * FROM order_items
//        WHERE order_id = :id
//        ";
//        $stmt = $dbconnect->prepare($query);
//        $stmt -> bindValue(':id',$_GET['id']);
//        $stmt -> execute();
//        $orderItems = $stmt-> fetchAll();
//    } catch (\PDOException $e){
//      throw new \PDOException($e->getMessage(), (int) $e->getCode());
//    }


//echo "<pre>";
//print_r($order);
//echo "</pre>";
//
//echo "<pre>";
//print_r($user);
//echo "</pre>";
//
//echo "<pre>";
//print_r($orderItems);
//echo "</pre>";
//exit;

?>

<?php include('../layout/header.php');?>

<body>
    <div class="container">
        <br>
        <h1>Received Order for #<?=$orderData['order_id']?></h1>
        <br>
        <a href="orders.php"><button class="btn btn-info">Back to Order</button></a><br>
       <br> <h3 class="border-bottom">Customer Info</h3>
        <div class="row mb-2 ml-2">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name: <?=$orderData['billing_full_name']?></li>
            <li class="list-group-item">Email: <?=$orderData['email']?></li>
            <li class="list-group-item">Telephone: <?=$orderData['phone']?></li>
            <li class="list-group-item">Address: <?=$orderData['street']?></li>
            <li class="list-group-item">Postal code: <?=$orderData['postal_code']?></li>
            <li class="list-group-item">City: <?=$orderData['city']?></li>
            <li class="list-group-item">Country: <?=$orderData['country']?></li>
            <li class="list-group-item">Order Date: <?=$orderData['created_at']?></li>
        </ul>
        </div>
        <h3 class="border-bottom">Products Info</h3>
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th style="width: 30%">Product image</th>
                    <th style="width: 30%">Product Name</th>
                    <th class="text-center" style="width: 15%">Quantity</th>
                    <th class="text-center" style="width: 30%">Price/Item</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $orderItem) { ?>
                <tr>
                    <td><img src="../image/<?=$orderItem['img']?>" width="40px" height="40px"></td>
                    <td><?=$orderItem['product_title']?></td>
                    <td class="text-center"><?=$orderItem['quantityy']?></td>
                    <td class="text-center"><?=$orderItem['unit_price']?></td>
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center"><strong>Total: <?=$orderData['total_price']?> Taka</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php include('../layout/foot.php');?>
