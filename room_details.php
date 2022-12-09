<?php
include('header.php');
include_once("Includes/conn.php");

if (isset($_GET['roomidko'])) {
    $R_ID = $_GET['roomidko'];

    $room_query = "SELECT * FROM rooms WHERE RoomID = '$R_ID'";
    $run_room_query = mysqli_query($db, $room_query);
    $row_room = mysqli_fetch_assoc($run_room_query);

    $rType = $row_room['RoomType'];

    $room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$rType'";
    $run_room_type = mysqli_query($db, $room_type);
    $row_type = mysqli_fetch_assoc($run_room_type);
}
?>


<?php
session_start();


if (isset($_SESSION['CID'])) {
    $G_ID = $_SESSION['CID'];

    $sql_query = "SELECT * FROM web_user WHERE wID = ' $G_ID'";
    $run_guest_query = mysqli_query($db, $sql_query);
    $row_guest = mysqli_fetch_assoc($run_guest_query);

    $Uname = $row_guest['wUName'];

    $btn = '
    <a class="text-success  nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    ' . $Uname . '
    <img class="ml-2 rounded-circle" src="Images/head.jpg" width="28rem;" height="28rem;">
    </a>

<!-- Dropdown - User Information -->
<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
    
     
    

    <a class="dropdown-item" href="logout">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
    </a>

</div>

    ';

    $link = '                
    <li class="nav-item">
    <a class="nav-link text-success" href="#">Book Now</a>
</li> 
<li class="nav-item">
<a class="nav-link text-success" href="transaction">My Reservation</a>
</li>    ';


$bookbtn ='reservation_details';

    $show = " ";
    $_SESSION['show'] = $show;
} else {
    $btn = '
    <a class="text-success  nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                </div>
    ';

    $link = '                
    <li class="nav-item">
    <a class="nav-link text-success" href="signin">Book Now</a>
</li>     ';

$bookbtn ='signin';

    $show = "";
    $_SESSION['show'] = $show;
}




?>



<nav class="navbar navbar-expand-lg navbar-light bg-white  fixed-top py-3 px-lg-5 shadow" id="mainNav">


    <a class="navbar-brand" href="index">
        <div class="ml-2 mt-1 text-success"> 
            
            <img class="ml-2 rounded-circle" src="Images/idsc.png" width="55rem;" height="55rem;">
            <b style="font-size: 1.7rem;">IDSC Hotel</b>
        </div>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav ">

            <li class="nav-item">
                <a class="nav-link text-success " href="index#about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success " href="index#rooms">Rooms</a>
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


<div class="container-fluid pt-5 pl-lg-5 pr-5">
    <div class="w3-center text-success pt-5">
        <h1>Room Details</h1>
    </div>

    <div class="card shadow-lg">
        <div class="row ">
            <div class="col-lg-7">
                <img class="h-100" src="Upload/<?php echo $row_room['RoomImage']; ?>" width="100%;">

            </div>

            <div class="col-lg-5">

                <div class="card-body">
                        <p class="card-text text-justify"><?php echo $row_type['roomtypedescription']; ?></p>
                         

                        <div class="d-flex">
                            <p class="card-text mr-3">Room Type: </p>
                            <p class="text-success">  <?php echo $row_type['roomtype'];?></p>
                        </div>

                        <div class="d-flex">
                            <p class="card-text mr-3">Room Rate: </p>
                            <p class="text-success">P  <?php echo $row_type['roomprice'];?>.00</p>
                        </div>
                        
                </div>
                

            </div>

        </div>
    </div>
    <div class="w3-center pt-4">
    <a href="index.php#rooms" class="btn btn-warning">Return</a>

    </div>

</div>


<?php
include('scripts.php');
include('footer.php');
?>