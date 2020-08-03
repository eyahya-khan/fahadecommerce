<?php
    // database connection
    require('src/dbconnect.php');
    require('src/config.php');
    $pageTitle = "sign up";
//sign up validation
    $msg       = '';
    $error     = '';
    $msgSignup = '';
    if (isset($_POST['signUp'])) {
        $firstname        = trim($_POST['firstname']);
        $lastname         = trim($_POST['lastname']);
        $address          = trim($_POST['address']);
        $postcode         = trim($_POST['postcode']);
        $city             = trim($_POST['city']);
        $country          = trim($_POST['country']);
        $phone            = trim($_POST['phone']);
        $email            = trim($_POST['email']);
        $password         = trim($_POST['password']);
        $confirmPassword  = trim($_POST['confirmPassword']);
    try {
	$stmt  = $dbconnect->query("SELECT * FROM users");
	$users = $stmt->fetchAll(); 
   } catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int) $e->getCode());
  }
    //check database for existing email
    foreach ($users as $key => $user) { 
    if($email === $user['email']){
     $error .= '<li> Email already exists.</li>';
    }
    }   
    //validation of firstname
  if (empty($firstname)) {
       $error .=  '<li> firstname must not be empty</li>';
  }else if(is_numeric($firstname)){
       $error .=  '<li> firstname: Only number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z ]*$/",$firstname)){
       $error .=  '<li> firstname: Only letter and whitespace are allowed</li>'; 
  }else if(strlen($firstname) > 60){
       $error .=  '<li> firstname must have less than 60 characters</li>'; 
  }
//validation of lastname
  if (empty($lastname)) {
       $error .=  '<li> lastname must not be empty</li>';
  }else if(is_numeric($lastname)){
       $error .=  '<li> lastname: Only number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z ]*$/",$lastname)){
       $error .=  '<li> lastname: Only letter and whitespace are allowed</li>'; 
  }else if(strlen($lastname) > 60){
       $error .=  '<li> lastname must have less than 60 characters</li>'; 
  }
//validation of email           
    if(empty($email)){
        $error .= '<li>Email must not be empty</li>';
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error .= '<li>Incorrect email format</li>';
        //if want to allow &#?+!% just place after a-z0-9
        //but not allow /\)(
    }else if(!preg_match('/^([a-z0-9_\.-]+)@([a-z\.-]+)\.([a-z\.]{2,6})$/',$email)){
        $error .= '<li>Not good formatted email, use lowercase,number and _-. only';   
    }else if(preg_match('/^([0-9]+)@([a-z\.-]+)\.([a-z\.]{2,6})$/',$email)){
        $error .= '<li>Only number is not allowed</li>';
    }           
//validation of password 
    if(empty($password)){
        $error .= '<li>Password must not be empty</li>';
    }
    if(!empty($password) && strlen($password) < 6){
        $error .= '<li>Password must have at least 6 character</li>';
    }
    if($confirmPassword !== $password){
        $error .= '<li>Confirm password must be same as password</li>';
    }
//validation of phone
    if (empty($phone)) {
       $error .=  '<li> phone must not be empty</li>';
  }else if(!preg_match('/^[0-9]{10}+$/',$phone)){
       $error .=  '<li> phone: only 10 digit mobile number is allowed</li>';
  }
//validation of street
//validation of streetpostal code
    if (empty($postcode)) {
       $error .=  '<li> postcode must not be empty</li>';
  }else if(!preg_match('/^[0-9]{5}+$/',$postcode)){
       $error .=  '<li> postcode: only 5 digit postal code is allowed</li>';
  }    
//validation of city
  if (empty($city)) {
       $error .=  '<li> city must not be empty</li>';
  }else if(is_numeric($city)){
       $error .=  '<li> city: number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z ]*$/",$city)){
       $error .=  '<li> city: Only letter and whitespace are allowed</li>'; 
  }else if(strlen($city) > 90){
       $error .=  '<li> city must have less than 60 characters</li>'; 
  }else if(strlen($city) < 5){
       $error .=  '<li> city must be 4 characters long</li>'; 
  }
//validation of country
  if (empty($country)) {
       $error .=  '<li> country must not be empty</li>';
  }else if(is_numeric($country)){
       $error .=  '<li> country: Only number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z ]*$/",$country)){
       $error .=  '<li> country: Only letter and whitespace are allowed</li>'; 
  }else if(strlen($country) > 90){
       $error .=  '<li> country must have less than 60 characters</li>'; 
  }else if(strlen($country) < 5){
       $error .=  '<li> country must be 4 characters long</li>'; 
  } 
//encrypting password
$secrectPassword = password_hash($password,PASSWORD_BCRYPT);
    if($error){
        $msgSignup = "<ul style='background-color:#f8d7da;'>{$error}</ul>";
    }else{
        //after validation data inserted into table
    try {
      $query = "
        INSERT INTO users (first_name, last_name, email, password, phone, street, postal_code, city, country)
        VALUES (:firstname, :lastname, :email, :password, :phone, :street, :postalcode, :city, :country);
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':firstname', $firstname);
      $stmt->bindValue(':lastname', $lastname);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', $secrectPassword);
      $stmt->bindValue(':phone', $phone);
      $stmt->bindValue(':street', $address);
      $stmt->bindValue(':postalcode', $postcode);
      $stmt->bindValue(':city', $city);
      $stmt->bindValue(':country', $country);
      $result = $stmt->execute();    
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
    if($result){
      $msgSignup = "<ul style='background-color:#d4edda;'>Sign up successfull. Now you can log in with email and password</ul>";   
    }
  }
}
?>
<?php include('layout/header.php'); ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">|| Log in</a>
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
                    <legend class="text-left mt-3">Sign up</legend>
                    <hr>
                    <!--show error message for Sign Up-->
                    <?=$msgSignup?>
                    <p>
                        <label for="input1">First name:</label><br>
                        <input type="text" class="form-control" name="firstname">
                    </p>
                    <p>
                        <label for="input2">Last name:</label><br>
                        <input type="text" class="form-control" name="lastname">
                    </p>
                    <p>
                        <label for="input3">Address:</label><br>
                        <input type="text" class="form-control" name="address">
                    </p>
                    <p>
                        <label for="input4">Post code:</label><br>
                        <input type="text" class="form-control" name="postcode">
                    </p>
                    <p>
                        <label for="input5">City:</label><br>
                        <input type="text" class="form-control" name="city">
                    </p>
                    <p>
                        <label for="input6">Country:</label><br>
                        <input type="text" class="form-control" name="country">
                    </p>
                    <p>
                        <label for="input7">Mobile:</label><br>
                        <input type="text" class="form-control" name="phone">
                    </p>
                    <p>
                        <label for="input8">E-mail:</label><br>
                        <input type="text" class="form-control" name="email">
                    </p>
                    <p>
                        <label for="input9">Password:</label><br>
                        <input type="password" class="form-control" name="password">
                    </p>
                    <p>
                        <label for="input10">Confirm Password:</label><br>
                        <input type="password" class="form-control" name="confirmPassword">
                    </p>
                    <p>
                        <input type="submit" name="signUp" value="Sign Up" class="btn btn-success">
                    </p>
                </form>
                <hr>
            </div>
        </div>
    </div>
    <?php include('layout/footer.php'); ?>
