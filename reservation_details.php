<?php
include('header.php');
?>


<?php
session_start();
include_once("Includes/conn.php");

if (isset($_SESSION['CID'])) {
    $wID = $_SESSION['CID'];

    $sql_query = "SELECT * FROM web_user WHERE wID = ' $wID'";
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

    $show = " ";
    $_SESSION['show'] = $show;
} else {
    $btn = '
    <a class="text-success  nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                    <img class="ml-2 rounded-circle" src="Upload/User_Pics/2.png" width="28rem;" height="28rem;">
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
    <a class="nav-link text-success" href="#">Book Now</a>
</li>     ';

    $show = "d-none";
    $_SESSION['show'] = $show;
}











?>



<nav class="navbar navbar-expand-lg navbar-light bg-white  fixed-top py-3 px-lg-5 shadow" id="mainNav">


    <a class="navbar-brand" href="#">
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


<?php

if (isset($_GET['R_roomid'])) {
    $R_roomID = $_GET['R_roomid'];

    $R_Rquery = "SELECT * FROM rooms WHERE RoomID = $R_roomID";
    $runR_Rquery = mysqli_query($db, $R_Rquery);
    $row_roomm = mysqli_fetch_assoc($runR_Rquery);

    $rTypee = $row_roomm['RoomType'];

    $room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$rTypee'";
    $run_room_type = mysqli_query($db, $room_type);
    $row_type = mysqli_fetch_assoc($run_room_type);

    $datenow = date('Ymd');
    $timenow = date("His");
    $TransactionCode = $datenow . '' . $timenow;



} else {
    echo "<script>window.location.href='reservation';</script>";
}

if (isset($_SESSION['from']) && isset($_SESSION['to'])) {

    $RArrival = $_SESSION['from'];
    $RDeparture = $_SESSION['to'];

    $from1 = strtotime($RArrival);
                            $to1 = strtotime($RDeparture);
                            $datediff = $to1 - $from1;
                            $nights = round($datediff/(60*24*60));
                            
                            $price = $row_type['roomprice'];
                            $totalRates = $nights * $price; 
    
} else {
    $_SESSION['ReservationMessage'] = '
    <div class="alert alert-danger alert-dismissable" id="flash-msg">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <h4>Page reload, please try again!</h4>
    </div>
';

     echo "<script>window.location.href='reservation';</script>";

}

?>


<div class="container pt-5 pb-5">
    <div class="pt-5">
        <div class="pt-3"></div>
    </div>
    

    <form action=" reservation_details_extend.php" method="POST" autocomplete="off">

      <div class=" row">


        <div class="col-lg-8 mt-2">


          <div class="card  shadow-sm">
             
            <div class="row py-3 px-4 text-gray-700">

            <h4 class="pb-2 text-success">Reservation Form</h4>

              <input type="hidden" name="GuestID" id="GuestID" class="form-control" required>

              <div class="col-md-2 mb-3">
                <label for="inputEmail4" class="form-label">No. Adult<span class="text-danger">*</span></label>
                <input type="number" min="0" name="GuestNumber" value="0" class="form-control" required>
              </div>

              <div class="col-md-2 mb-3">
                <label for="inputEmail4" class="form-label">No. Kids<span class="text-danger">*</span></label>
                <input type="number" min="0" name="GuestNumber2" value="0" class="form-control" required>
              </div>

              <div class="col-md-5 mb-3">
                <label for="inputEmail4" class="form-label">Guest Name<span class="text-danger">*</span></label>
                <input type="text" name="Name" id="Name" class="form-control" required>
              </div>

              <div class="col-md-3 mb-3">
                <label for="inputEmail4" class="form-label">Nationality<span class="text-danger">*</span></label>
                <input type="text" name="Nationality" id="Nationality" class="form-control" required>
              </div>
              <div class="col-md-3 mb-3">
                <label for="inputEmail4" class="form-label">Date of Birth<span class="text-danger">*</span></label>
                <input type="text" name="Birthdate" id="birthday" class="form-control" required>
              </div>




              <div class="col-md-3 mb-3">
                <label for="inputPassword4" class="form-label">Phone Number</label>
                <input type="text" name="PNumber" id="PNumber" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Email Address</label>
                <input type="Email" name="Email" id="Email" class="form-control">
              </div>

              <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Home Address</label>
                <input type="text" name="Address" id="Address" class="form-control">
              </div>


              <div class="col-md-4">
                <label for="inputPassword4" class="form-label">Company</label>
                <input type="text" name="Company" id="Company" class="form-control">
              </div>

              <div class="col-md-4">
                <label for="inputPassword4" class="form-label">Company Address</label>
                <input type="text" name="CompanyAddress" id="CompanyAddress" class="form-control">
              </div>


            </div>

          </div>

          <div class="card mt-3  pt-1 py-2 px-4 shadow-sm">
            <div class="row">
              <label for="inputPassword4" class="form-label">For foreign guest</label>

              <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Country of Origin</label>

                <input type="text" name="Origin" id="Origin" class="form-control">
              </div>

              <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Passport Number</label>

                <input type="text" name="Passport" id="Passport" class="form-control">
              </div>

              <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Issued at</label>

                <input type="text" name="IssuedAt" id="issuedAt" class="form-control">
              </div>


            </div>
          </div>

          <div class="card mt-3 py-3 px-4 shadow-sm">
            <div class="row">

              <div class=" mb-3">
                <label for="inputEmail4" class="form-label">Additional Request</label>
                <textarea type="text" name="Guest_Request" class="form-control"></textarea>
              </div>

               


              <div class="d-flex justify-content-end">
                <a href="reservation" class="btn btn-warning">Cancel Reservation</a>

                <input type="submit" name="reserve_btn" value="Continue" class="ml-2 px-4 btn btn-success">
              </div>

            </div>


            <input type="hidden" name="TransactionCode" value="<?php echo $TransactionCode; ?>">
 
            <input type="hidden" name="RRoomID" value="<?php echo $R_roomID; ?>">
            <input type="hidden" name="RGuestID" value="<?php echo $wID; ?>">
            <input type="hidden" name="RAccommodation" value="Online Reservation">
            <input type="hidden" name="RArrival" value="<?php echo $RArrival; ?>">
            <input type="hidden" name="RDeparture" value="<?php echo $RDeparture; ?>">
 
          </div>


        </div>

        <div class="col mt-2 card shadow-sm">
          
            <div class=" ">
                <div class="py-3 px-4  ">

                    <div class=" h-5 text-success text-uppercase mb-2 mt-2">Selected Room</div>
                    <div class="  pr-3 text-justify">
                        <p class="pt-1 card-text">
                        <span class="text-gray-600">Room: </span><?php  echo $row_type['roomtype']; ?><br>
                        <span class="text-gray-600">Rate: </span><span>&#8369 </span><?php echo $row_type['roomprice'];  ?>.00/Night<br>
                        <span class="text-gray-600">Description:</span><br> <span class="pl-4"> <?php echo $row_type['roomtypedescription'];  ?> </span><br><br>
                        <span class="text-gray-600">Arrival: </span><?php  
                            
                            
                            $Date_Arrival = strtotime($RArrival);
                            echo date('F d, Y', $Date_Arrival);
                                 
                            ?> <br>
                            <span class="text-gray-600">Departure: </span><?php   
                            
                            $Date_Departure = strtotime($RDeparture);
                            echo date('F d, Y', $Date_Departure);
                            ?> <br>
                            <span class="text-gray-600">No. Of Nights: </span><?php
                                                        
                            
                            echo $nights;  ?> 
                              
                            
                    </p>
                    </div>

                 
                </div>

            </div>
           

          <div class=" mt-2  ">
            <div class=" py-3">
              <h5 class="w3-text-teal">Other Amenities:</h5>

              <div class="px-3">
                <div class="form-check" style="font-size: 1.1rem;">
                  <?php include('checkbox_amenities.php'); ?>
                </div>
              </div>
            </div>
          </div>


        </div>

      </div>
    </form>
  </div>

<section>
    <div class="h-100 bg-success py-5 w3-center text-gray-200">
        
    </div>
</section>


<?php
include('scripts.php');
include('footer.php');
?>

<script>
$(function() {

    $('#birthday').datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: '-71:+0'

    });
});

</script>