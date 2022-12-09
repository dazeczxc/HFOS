<?php
session_start();
include_once("Includes/conn.php");
include_once("Includes/header.php");
include('header.php');


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $get_record = mysqli_query($db, "Select * from user where id= '$user_id'");
  if(!empty($get_record) > 0){
      $row = mysqli_fetch_assoc($get_record);
      $accessType = $row['access'];

      if ($accessType == "Administrator") {
        echo "<script>window.location.href='Admin/index';</script>";
      } else if ($accessType == "Staff") {
        echo "<script>window.location.href='Staff/index';</script>";
      }
  }else{
      
  }
}


$username = $password = "";
$usernameErr = $passwordErr = "";

if (isset($_POST['btnlogin'])) {
  if (empty($_POST['username'])) {
    $usernameErr = "Username is Required!";
  } else {
    $username = $_POST['username'];
  }

  if (empty($_POST['password'])) {
    $passwordErr = "Password is Required!";
  } else {
    $password = $_POST['password'];
  }

  if ($username && $password) {

     

    $sql = "Select * from user where username = '$username'";
    $check_username = mysqli_query($db, $sql );

    if (mysqli_num_rows($check_username) > 0) {

      $row = mysqli_fetch_assoc($check_username);
      $db_password = $row["password"];
      $accessType = $row["access"];
      $user_id = $row["id"];
      $staff_name = $row['staffname'];

      if ($password == $db_password) {
        

        if ($accessType == "Administrator") {

          echo "<script>window.location.href='Admin/index';</script>";

          $_SESSION['user_id'] = $user_id;
        $_SESSION['staffname'] = $staff_name;
        $_SESSION['staffpic'] = $row['pic'];

        } else if ($accessType == "Staff") {

          echo "<script>window.location.href='Staff/index';</script>";

          $_SESSION['user_id'] = $user_id;
        $_SESSION['staffname'] = $staff_name;
        $_SESSION['staffpic'] = $row['pic'];

        }
      } else {

        $passwordErr = "Wrong Password!";
      }
    } else {
      
      $usernameErr = "Username not registered";
    }
  }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width-device-width, initial-scale=1.0">
  <title>Hotel</title>
  <link rel="stylesheet" type="text/css" href="Css/login.css">
 
  <style>
  .field-icon {
    float: right;
    margin-left: -25px;
    margin-top: -25px;
    position: relative;

  }
</style>
</head>

<body>
  <div class="center">
    <h1 style="color: #34bb55;">Login</h1>
    <form action="" method="POST" autocomplete="off">
      <div class="form-group">
        <div class="pt-2  text-success   mb-1 mt-2">Username</div>
         <input class="form-control" name="username" type="text" value="<?php echo $username; ?>">
 
        <span class="text-warning"><?php echo $usernameErr; ?></span>

      </div>
      <div class=" form-group">
        <div class="pt-2  text-success   mb-1 mt-2">Password</div>
         <input class="form-control" name="password" value="" type="password" id="password-field" > 
        <span toggle="#password-field" class="fa fa-eye field-icon toggle-password pr-2"></span>

         <span class="text-warning"><?php echo $passwordErr; ?></span>

      </div>
      <input type="submit" name="btnlogin" value="Login" class="pass_data" id="<?php $row["username"]; ?>">

    </form>
    <a class=" nav-link  "  href="index">Go to Website</a>
  </div>
  

  
</body>

</html>

<script>
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password"){
      input.attr("type", "text");
    
    } else{
      input.attr("type", "password");
    }
  })
</script>

 