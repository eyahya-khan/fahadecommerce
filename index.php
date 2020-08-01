<?php
require('src/dbconnect.php');

if(isset($_POST['add'])){
    $title   = trim($_POST['fname']);
    $price   = trim($_POST['price']);
$description = trim($_POST['description']);
$file_name   = $_FILES['file']['name'];
$file_loc    = $_FILES['file']['tmp_name'];
$file_store  = "image/".$file_name;
if(!move_uploaded_file($file_loc, $file_store)){
   
}else{

    try {
      $query = "
        INSERT INTO products (name, price, description, img)
        VALUES (:name,:price, :description, :image);
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':name', $title);
      $stmt->bindValue(':price', $price);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':image', $file_name);
      $stmt->execute();    
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }    
}
 
}
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
    <title>Sweden Bangla trade venture</title>
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

        <form action="" method="post" enctype="multipart/form-data">
            <!--   <label>Name:</label>-->
            <input type="text" name="fname" placeholder="Product name">
            <!--   <label>Price:</label>-->
            <input type="text" name="price" placeholder="Price/unit">
            <label>Choose Image:</label>
            <input type="file" name="file"><br>
            <textarea name="description" class="form-control" placeholder="Product Description" rows="5" cols="30"></textarea><br>

            <input type="submit" name="add" value="Add">

        </form>
        <br>
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
                    <td></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>
