<?php
    // database connection
    require('src/dbconnect.php');
    require('src/config.php');
    $pageTitle = "Login";
 //Log in validation
    $msg   = "";
    $error ='';
    if (isset($_POST['doLogin'])) {
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);        
    try {
      $query = "
        SELECT * FROM users 
        WHERE email = :email;
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':email', $email);
      $stmt->execute(); 
      $user = $stmt->fetch(); 
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    } 
//validation of email           
    if(empty($email)){
         $error .=  '<li> Email must not be empty</li>';
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
         $error .=  '<li> Incorrect email format</li>';
    }else if ($email !== $user['email']){
         $error .=  '<li>'. $email. ' is not registered</li>';
    }
//decrypting password
$decryptPassword = password_verify($password,$user['password']);  
    if(empty($password)){
         $error .=  '<li> Password must not be empty</li>';
    }else if($email === $user['email'] && !$decryptPassword){
         $error .=  '<li>' .$password. ' is not correct password</li>';
    }
    if($user['email'] && $decryptPassword){
            $_SESSION['firstname'] = $user['first_name'];
//            redirect('productadmin.php');
            header('Location: admin/productadmin.php');
            exit;
    }
    if($error){
        $msg = "<ul style='background-color:#f8d7da;'>{$error}</ul>";
    }
  }
?>
<?php include('layout/header.php'); ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="register.php" class="float-right">|| Sign up</a>
                <a href="index.php" class="float-right mr-2"><i class="fa fa-home"> </i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <img src="image/IMG_1288.jpg" alt="" width="100%" height="320px" class="mt-2 mb-2">
            </div>
        </div>
        <div class="row">
            <div class="offset-4 col-4">
                <form method="POST" action="">
                    <legend class="text-left mt-3">Log in</legend>
                    <hr>
                    <!--show error message for log in-->
                    <?=$msg?><br>
                    <p>
                        <label for="input1"> E-mail:</label><br>
                        <input type="text" class="form-control" name="email">
                    </p>
                    <p>
                        <label for="input2">Password:</label><br>
                        <input type="password" class="form-control" name="password">
                    </p>
                    <p>
                        <input type="submit" name="doLogin" value="Login" class="btn btn-success">
                    </p>
                </form>
                <hr>
            </div>
        </div>
    </div>
    <?php include('layout/footer.php'); ?>
