<?php
include('header.php');
?>


<header class="masthead">

<div class="container">
    <div class="w3-center">



    <h2 class=" w3-center  text-white font-weight-bold">Sign up Page</h2>
    </div>

    <div class="p-3">
        <form method="POST" action="Includes/server.php" autocomplete="off">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 border-success card px-3 py-3">
                <?php
                session_start();
                if(isset($_SESSION['SignUpMessage'])){
                    echo $_SESSION['SignUpMessage'];
                    unset($_SESSION['SignUpMessage']);
                }
                
                ?>
                
                    <div class="row">
                    <div class="col-lg-12 mb-2">
                        <div class="  text-success    mb-1 mt-2">Name</div>

                        <input type="text" name="Name" class="form-control" placeholder=" " required>
                    </div>

                    <div class="col-lg-5 col-sm-3 mb-2">
                        <div class="  text-success   mb-1 mt-2">Phone Number</div>

                        <input type="text" name="PNumber" class="form-control" placeholder=" " required>
                    </div>

                    <div class="col-lg-7 col-xs-3 mb-2">
                        <div class="  text-success   mb-1 mt-2">Email Address</div>

                        <input type="Email" name="Email" class="form-control" placeholder=" " required>
                    </div>

                    <div class="col-lg-6 col-sm-12 mb-2">
                        <div class="  text-success   mb-1 mt-2">Username</div>
                        <input type="text" name="Username" class="form-control" placeholder=" " required>
                    </div>

                    <div class="col-lg-6 col-sm-12 mb-2">
                        <div class="  text-success   mb-1 mt-2">Password</div>

                        <input type="password" name="Password" class="form-control" placeholder=" " required>
                    </div>

                    <div class="d-flex justify-content-center pt-3 pb-2">
                         <input type="submit" name="CustomerSave" value="Sign Up" class="ml-2 px-5 btn btn-success">
                    </div>

                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        </form>
    </div>

    <div class=" pb-2 w3-center text-white">
              <h5> Already have an Account? <br>
                Go to </h5>
              <a style="font-size: 1.5rem;" href="signin" class=" font-weight-bold text-white ">Sign In</a>

            </div>
            <div class="w3-center">

              <h5 class="text-white"> or</h5>
              <a style="font-size: 1.1rem;" href="index" class="text-white pt-1">Return Home</a>

            </div>


</div>

</header>


<?php
include('scripts.php');
include('footer.php');
?>

<script>

$(document).ready(function () {
    $("#flash-msg").delay(2000).fadeOut("slow");
});
</script>