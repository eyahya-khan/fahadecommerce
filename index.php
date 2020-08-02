<?php
require('src/dbconnect.php');

//fetch all information
    try {
  $query = "SELECT * FROM products;";
  $stmt = $dbconnect->query($query);
  $products = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>

<?php include('layout/header.php');?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container">
        <h2>Sweden Bangla trade venture background image</h2>

        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">| Log in</a>
                <a href="register.php" class="float-right">|| Sign up |</a>
                <a href="index.php" class="float-right mr-2"><i class="fa fa-home"> </i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <img src="image/IMG_1288.jpg" alt="" width="100%" height="320px" class="mt-2 mb-2">
            </div>
            <div class="col-6">
                <img src="image/IMG_1296.jpg" alt="" width="100%" height="320px" class="mt-2 mb-2">
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody class="text-dark text-center">
                <?php foreach ($products as $key => $product) { ?>
                <tr>
                    <td><a href="product.php?hidID=<?=$product['id']?>"><img src="image/<?php echo $product['img']; ?>" width="50px" height="50px"></a></td>
                    <td><a href="product.php?hidID=<?=$product['id']?>" class="text-dark"><?php echo $product['name']; ?> </a></td>
                    <td><a href="product.php?hidID=<?=$product['id']?>" class="text-dark"><?php echo $product['price']; ?> taka/item</a></td>
                    <td><?php echo $product['quantity']; ?> items available</td>
                    <td>

                    <!--counting first line-->
                    <?php
                    $pos = strpos($product['description'], '.');
                    $firstSentence = substr($product['description'], 0, max($pos+1, 40));
                    echo $firstSentence;
                    ?>
                       <!--sending id to product.php page for fetching specific data-->
                <br><a href="product.php?hidID=<?=$product['id']?>"><em>more info</em></a>
                </td>

                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        
    </div>
    <?php include('layout/footer.php');?>
