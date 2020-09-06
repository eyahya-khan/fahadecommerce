<?php
require('../src/config.php');
require('../src/dbconnect.php');

$pageTitle = "Order confirmation";
$pageId = "order_confirmation";

try {
        $query = "
        SELECT * FROM orders
        ";
        $stmt = $dbconnect->query($query);
        $orders = $stmt-> fetchAll();
    } catch (\PDOException $e){
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    } 

//echo "<pre>";
//print_r($orders);
//echo "</pre>";
//exit;

?>

<?php include('../layout/header.php');?>

<body>
    <div class="container">
       <a href="productadmin.php"><button class="btn btn-info">Product Admin</button></a><br>
        <br>
        <h1>Received Order</h1>
        <br>
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th style="width: 15%">Order id</th>
                    <th style="width: 50%">Customer Name</th>
                    <th style="width: 15%">Price</th>
                    <th style="width: 10%">Status</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $key => $order) { ?>
                <tr>
                    <td><a href="order.php?id=<?=$order['id']?>">#<?=$order['id']?></a></td>
                    <td><?=$order['billing_full_name']?></td>
                    <td><?=$order['total_price']?></td>
                    <td>
                        <select name="status" id="status" class="form-control">
                            <option>Open</option>
                            <option>Sended</option>
                            <option>Processed</option>
                            <option>Canceled</option>
                        </select>
                    </td>

                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

    <?php include('../layout/foot.php');?>
