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
<!DOCTYPE html>
<html lang="en">

<head>
    <title>home page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Sweden Bangla trade venture background image</h2>
        <p>Sweden Bangla trade venture menu</p>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL no</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product) { ?>
                <tr>
                    <td><?php echo $product['id']; ?> </td>
                    <td><img src="image/<?php echo $product['img']; ?>" width="50px" height="50px"></td>
                    <td><?php echo $product['name']; ?> </td>
                    <td><?php echo $product['price']; ?> </td>
                    <td><?php echo $product['description']; ?></td>
                    <td>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        
    </div>

</body>

</html>
