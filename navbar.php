<?php
session_start();
include_once("Includes/conn.php");

if (isset($_SESSION['CID'])) {
    $G_ID = $_SESSION['CID'];

    $sql_query = "SELECT * FROM web_user WHERE wID = ' $G_ID'";
    $run_guest_query = mysqli_query($db, $sql_query);
    $row_guest = mysqli_fetch_assoc($run_guest_query);

    $Uname = $row_guest['wUName'];

    $btn = '
    <a class=" nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    ' . $Uname . '
    <img class="ml-2 rounded-circle" src="Images/head.jpg" width="28rem;" height="28rem;">
    </a>

<!-- Dropdown - User Information -->
<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
    <!-- Dropdown - User Information 
    <a class="dropdown-item" href="#">
        <i class="fas fa-user-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        My Profile
    </a>
    -->

    

    <a class="dropdown-item" href="logout">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
    </a>

</div>

    ';

    $link = '                
    <li class="nav-item">
    <a class="nav-link" href="reservation.php">Book Now</a>
</li>    

    <li class="nav-item">
        <a class="nav-link" href="transaction">My Reservation</a>
    </li>
     
    ';

    $show = " ";
    $_SESSION['show'] = $show;
} else {
    $btn = '
    <a class=" nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                    <img class="ml-2 rounded-circle" src="Images/head.jpg" width="28rem;" height="28rem;">
                    </a>

                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                    <a class="dropdown-item" href="signin">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Sign In
                    </a>

                    <a class="dropdown-item" href="signup">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Sign Up
                    </a>

                    <a class="dropdown-item" href="login">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Staff Login
                </a>

                </div>
    ';

    $link = '   
    <li class="nav-item">
    <a class="nav-link" href="reservation.php">Book Now</a>
</li>       
    ';

    $show = "d-none";
    $_SESSION['show'] = $show;
}

?>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 px-lg-5" id="mainNav">

    <a class="navbar-brand" href="#">
        <div class="ml-2 mt-1"> 
            
            <img class="ml-2 rounded-circle" src="Images/idsc.png" width="55rem;" height="55rem;">
            <b style="font-size: 1.7rem;">IDSC Hotel</b>
        </div>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
     aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav ">
            
            <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rooms">Rooms</a>
            </li>

             

            
             

                 <?php echo $link; ?>

 
            <div class=" d-none d-sm-block" style="
            width: 0;
  border-right: 2px solid #70e2ad;
  height: 30px;
  margin: auto 1rem;
  
  "></div>


            <li class="nav-item dropdown no-arrow">

                <?php echo $btn; ?>

            </li>
        </ul>
    </div>
</nav>