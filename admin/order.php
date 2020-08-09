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
try {
        $query = "
        SELECT * FROM orders
        WHERE id = :id
        ";
        $stmt = $dbconnect->prepare($query);
        $stmt -> bindValue(':id',$_GET['id']);
        $stmt -> execute();
        $order = $stmt-> fetch();
    } catch (\PDOException $e){
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

//echo "<pre>";
//print_r($order);
//echo "</pre>";

//fetch user
try {
        $query = "
        SELECT * FROM users
        WHERE id = :id
        ";
        $stmt = $dbconnect->prepare($query);
        $stmt -> bindValue(':id', $order['user_id']);
        $stmt -> execute();
        $user = $stmt-> fetch();
    } catch (\PDOException $e){
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

//echo "<pre>";
//print_r($user);
//echo "</pre>";


//fetch order items
try {
        $query = "
        SELECT * FROM order_items
        WHERE order_id = :id
        ";
        $stmt = $dbconnect->prepare($query);
        $stmt -> bindValue(':id',$_GET['id']);
        $stmt -> execute();
        $orderItems = $stmt-> fetchAll();
    } catch (\PDOException $e){
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

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
        <h1>Received Order for #<?=$order['id']?></h1>
        <br>
        <h3 class="border-bottom">Customer Info</h3>
        <div class="row mb-2 ml-2">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name: <?=$order['billing_full_name']?></li>
            <li class="list-group-item">Email: <?=$user['email']?></li>
            <li class="list-group-item">Telephone: <?=$user['phone']?></li>
            <li class="list-group-item">Address: <?=$user['street']?></li>
            <li class="list-group-item">Postal code: <?=$user['postal_code']?></li>
            <li class="list-group-item">City: <?=$user['city']?></li>
            <li class="list-group-item">Country: <?=$user['country']?></li>
        </ul>
        </div>
        <h3 class="border-bottom">Products Info</h3>
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th style="width: 60%">Product Name</th>
                    <th class="text-center" style="width: 15%">Quantity</th>
                    <th class="text-center" style="width: 20%">Price/Item</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $key => $orderItem) { ?>
                <tr>
                    <td><?=$orderItem['product_title']?></td>
                    <td class="text-center"><?=$orderItem['quantity']?></td>
                    <td class="text-center"><?=$orderItem['unit_price']?></td>
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center"><strong>Total: <?=$order['total_price']?> Taka</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php include('../layout/footer.php');?>
