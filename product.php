<?php
require('src/dbconnect.php');
//add
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
//update
if(isset($_POST['updateBtn'])){
    $name    = trim($_POST['name']);
    $price   = trim($_POST['price']);
$description = trim($_POST['description']);
$file_name   = $_FILES['file']['name'];
$file_loc    = $_FILES['file']['tmp_name'];
$file_store  = "image/".$file_name;
if(!move_uploaded_file($file_loc, $file_store)){
}else{
    try {
      $query = "
        UPDATE products
        SET description = :description, name = :name, price = :price, img = :img
        WHERE id = :id;
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':price', $price);
      $stmt->bindValue(':img', $file_name);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
//     $message =  "<ul style='background-color:#d4edda;'>Post updated successfully</ul>";
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
    }
    }


// delete from table
if(isset($_POST['deleteBtn'])){
    $id   = trim($_POST['hidId']);
try {
    $query = "
      DELETE FROM products
      WHERE id = :id;
    ";
    $stmt = $dbconnect->prepare($query);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $message = 
      '<div class="alert alert-success" role="alert">
        Product deleted successfully.
      </div>';
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
  }
  }

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
            <input type="text" name="fname" placeholder="Product name">
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
                    <td>
                        <!--delete-->
                        <form action="" method="POST" class="float-right">
                            <input type="hidden" name="hidId" value="<?=$product['id']?>">
                            <input type="submit" name="deleteBtn" value="Delete" class="btn btn-danger delete-product-btn">
                        </form>
                        <!--Update post-->
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal" 
                        data-name="<?=htmlentities($product['name'])?>" 
                        data-price="<?=htmlentities($product['price'])?>" 
                        data-description="<?=htmlentities($product['description'])?>" 
                        data-img="<?=htmlentities($product['img'])?>" 
                        data-id="<?=htmlentities($product['id'])?>">Update</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!--update modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Update Product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Update Name: </label>
                                <input type="text" class="form-control" name="name" for="recipient-name">
                                <label for="recipient-name" class="col-form-label">Update Description: </label>
                                <textarea class="form-control" name="description" for="recipient-name" rows="6"></textarea>
                                <label for="recipient-name" class="col-form-label">Update Price: </label>
                                <input type="text" class="form-control" name="price" for="recipient-name">
                                <label>Choose Image:</label>
                                <input type="file" name="file"><br>
                                <input type="hidden" class="form-control" name="id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" name="updateBtn" value="Update" class="btn btn-success update-product-btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <!--update-->
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name'); // Extract info from data-* attributes
            var description = button.data('description'); // Extract info from data-* attributes
            var price = button.data('price'); // Extract info from data-* attributes
            var img = button.data('img'); // Extract info from data-* attributes
            var id = button.data('id'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find(".modal-body input[name='name']").val(name);
            modal.find(".modal-body textarea[name='description']").val(description);
            modal.find(".modal-body input[name='price']").val(price);
            modal.find(".modal-body input[name='img']").val(img);
            modal.find(".modal-body input[name='id']").val(id);
        });

    </script>

</body>

</html>
