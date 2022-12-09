<?php
include('header.php');

session_start();

include_once("Includes/conn.php");

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

    $check_username = mysqli_query($db, "Select * from web_user where wUName= '$username'");
    $check_username_row = mysqli_num_rows($check_username);

    if ($check_username_row > 0) {
      $row = mysqli_fetch_assoc($check_username);
      $db_password = $row["wPWord"];



      if (md5($password) == $db_password) {
        $_SESSION['CID'] = $row["wID"];

        echo "<script>window.location.href='reservation.php';</script>";
      } else {

        $passwordErr = "Wrong Password!";
      }
    } else {

      $usernameErr = "Username not registered";
    }
  }
}

?>
<style>
  .field-icon {
    float: right;
    margin-left: -25px;
    margin-top: -25px;
    position: relative;
    cursor: pointer;

  }
</style>


<header class="masthead">


  <div class="container">
    <div class="w3-center pt-3">

    </div>

    <div class=" p-3">
      <form action="" method="POST" autocomplete="off">

        <div class="row">
          <div class="col-lg-3"> </div>

          <div class="col-lg-5 col-sm-12 ">
            <h2 class="pt-5 w3-center  text-white font-weight-bold">Please login to continue</h2>
            <div class="border-light card px-3 py-3 shadow-lg bg-white">

              <div class="    text-success   mb-1 mt-2">Username</div>
              <span class="text-warning"><?php echo $usernameErr; ?></span>

              <input name="username" type="text" value="<?php echo $username; ?>" class="form-control bg-transparent border-success">

              <div class="form-group">
                <div class="pt-2  text-success   mb-1 mt-2">Password</div>
                <span class="text-warning"> <?php echo $passwordErr; ?></span>

                <input type="password" name="password" value="" id="password-field" class="form-control bg-transparent border-success">
                <span toggle="#password-field" class="fa fa-eye field-icon toggle-password pr-2"></span>
              </div>

              <div class="d-flex justify-content-center pt-3">
                <input type="submit" name="btnlogin" value="Sign In" class=" ml-2 px-5 btn btn-success">

              </div>


            </div>

            <div class=" pb-2 w3-center text-white">
              <h5> Don't have an Account? <br>
                Go to </h5>
              <a style="font-size: 1.5rem;" href="signup" class=" font-weight-bold text-white ">Sign Up</a>

            </div>
            <div class="w3-center">

              <h5 class="text-white"> or</h5>
              <a style="font-size: 1.1rem;" href="index" class="text-white pt-1">Return Home</a>

            </div>

          </div>

          <div class="col-lg-3"></div>

        </div>

      </form>
    </div>


  </div>
</header>
<?php
include('scripts.php');
include('footer.php');
?>
<script>
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");

    } else {
      input.attr("type", "password");
    }
  })
</script>