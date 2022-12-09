<?php

include('../Includes/header.php');
include('../Includes/staff_navbar.php');

 
?>


<?php
include('../Includes/conn.php');

if (isset($_GET['R_roomid'])) {
    $R_roomID = $_GET['R_roomid'];

    $R_Rquery = "SELECT * FROM rooms WHERE RoomID = $R_roomID";
    $runR_Rquery = mysqli_query($db, $R_Rquery);
    $row_roomm = mysqli_fetch_assoc($runR_Rquery);

    $rTypee = $row_roomm['RoomType'];

    $room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$rTypee'";
    $run_room_type = mysqli_query($db, $room_type);
    $row_type = mysqli_fetch_assoc($run_room_type);
} 

if (isset($_SESSION['from']) && isset($_SESSION['to'])) {

    $RArrival = $_SESSION['from'];
    $RDeparture = $_SESSION['to'];

    $from1 = strtotime($RArrival);
    $to1 = strtotime($RDeparture);
    $datediff = $to1 - $from1;
    $days = round($datediff / (60 * 24 * 60));
    $nights = $days;

    $price = $row_type['roomprice'];
    $totalRates = $nights * $price;
} else {
    $_SESSION['ReservationMessage'] = '
    <div class="alert alert-danger alert-dismissable" id="flash-msg">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <h4>Page reload, please try again!</h4>
    </div>
';

    header('location: ../Reservation/reservation');
}

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Reservation Tables -->
    <div class="card w3-white" style="margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">



        <div class="card-body">
            <?php
            if (isset($_SESSION['StaffReservationConfirmMessage'])) {
                echo $_SESSION['StaffReservationConfirmMessage'];
                unset($_SESSION['StaffReservationConfirmMessage']);
            }

            ?>
            <div class="d-flex justify-content-lg-between align-items-lg-baseline">
                <p style="font-size: 1.4rem;" class="w3-left w3-text-teal"><b>Guest Reservation Details</b></p>
            </div>

            <div class="text-gray-700">

                <div class="row ">
                    <div class="col-lg-8 pb-3">


                        <form method="POST" action="../Includes/server.php" autocomplete="off">
                            <div class="card  shadow-sm">
                            <button type="button" class="col-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Select Old Guest</button>
                                <div class="row py-3 px-4">



                                    <input type="hidden" name="GuestID" id="GuestID" class="form-control" required>

                                    <div class="col-md-2 mb-3">
                                        <label for="inputEmail4" class="form-label">Adult(s)<span class="text-danger">*</span></label>
                                        <input type="number" name="GuestNumber" min="0" value="0" class="form-control" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="inputEmail4" class="form-label">Kid(s)<span class="text-danger">*</span></label>
                                        <input type="number" name="GuestNumber2" min="0" value="0" class="form-control" required>
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
                                        <input type="text" name="Company" id="Company" class=" form-control">
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

                                        <input type="text" name="IssuedAt" id="IssuedAt" class="form-control">
                                    </div>


                                </div>
                            </div>


                    </div>

                    <div class="col-lg-4 ">
                        <div class="py-3 px-4 card shadow-sm">

                            <div class=" h-5 text-success text-uppercase mb-2 mt-2">Selected Room</div>
                            <div class="  pr-3 text-justify">
                                <p class="pt-1 card-text">
                                    <span class="text-gray-600">Room Number: </span><?php echo $row_roomm['RoomNumber']; ?><br>
                                    <span class="text-gray-600">Room: </span><?php echo $row_type['roomtype']; ?><br>
                                    <span class="text-gray-600">Rate: </span><span>&#8369 </span><?php echo $row_type['roomprice'];  ?>.00/Night<br>
                                    <span class="text-gray-600">Description:</span><br> <span class="pl-4"> <?php echo $row_type['roomtypedescription'];  ?> </span><br><br>
                                    <span class="text-gray-600">Arrival: </span><?php   
                                     $Date_Arrival = strtotime($RArrival);
                                     echo date('F d, Y', $Date_Arrival); ?> <br>
                                    <span class="text-gray-600">Departure: </span><?php  
                                     $Date_Departure = strtotime($RDeparture);
                                     echo date('F d, Y', $Date_Departure);   ?> <br>
                                    <span class="text-gray-600">No. Of Nights: </span><?php


 

                                                    echo $nights;  ?> <br>
                                    <span class="text-gray-600">Sub-total Rates: </span><span>&#8369 </span><?php

                                                                            echo $totalRates;  ?>.00 <br>

                                </p>
                            </div>

                            
                            <div class=" mb-3 pt-4">
                                        <label for="inputPassword4" class="form-label">Additional Request</label>

                                        <textarea rows="4" name="Guest_Request" class="form-control"></textarea>
                                    </div>

                        </div>

                    </div>


                </div>



                <input type="hidden" name="TransactBy" value="<?php echo $_SESSION['staffname']; ?>">
                <input type="hidden" name="RRoomID" value="<?php echo $R_roomID; ?>">
                <input type="hidden" name="RAccommodation" value="Reservation">
                <input type="hidden" name="RArrival" value="<?php echo $RArrival; ?>">
                <input type="hidden" name="RDeparture" value="<?php echo $RDeparture; ?>">
                <input type="hidden" name="totalRates" value="<?php echo $totalRates; ?>">





                <div class="col-lg-12 mt-3 mb-4">
                    <div class="d-flex justify-content-start">
                        <input type="submit" name="ReserveButton" value="Save Reservation" class="mr-2 px-3 btn btn-success">

                        <a href="reservation" class="btn btn-warning">Cancel Reservation</a>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Reservation tables -->

<!-- Add Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg   ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Guest</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="search_box" id="search_box" class=" mb-2 form-control" placeholder="Search Guest...." />

        <div class="table" id="dynamic_content">


        </div>



      </div>
    </div>
  </div>
  <!-- End Add Modal -->


<?php
include('../Includes/scripts.php');
include('../Includes/footer.php');
?>

<script>
    
    $(document).ready(function() {
        $("#flash-msg").delay(2000).fadeOut("slow");

        $(document).on('click', '.selectbtn', function() {

$tr = $(this).closest('tr');

var data = $tr.children("td").map(function() {
  return $(this).text();
}).get();


console.log(data);
$('#GuestID').val(data[0]);
$('#Name').val(data[1]);
$('#Nationality').val(data[2]);
$('#birthday').val(data[3]);
$('#PNumber').val(data[4]);
$('#Email').val(data[5]);
$('#Address').val(data[6]);
$('#Company').val(data[7]);
$('#CompanyAddress').val(data[8]);
$('#Origin').val(data[9]);
$('#Passport').val(data[10]);
$('#IssuedAt').val(data[11]);

});




    });

    $(document).ready(function() {

        var minDate = new Date();
        minDate.setDate(minDate.getDate())
        
        var minDate2 = new Date();
        minDate2.setDate(minDate2.getDate()+1)

        $('#datetimepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: minDate,
        });

        $('#toggle').on('click', function() {
            $('#datetimepicker').datepicker('toggle')
        })




        $('#datetimepicker2').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: minDate2,
        });

        $('#toggle2').on('click', function() {
            $('#datetimepicker2').datepicker('toggle')
        })

        $('#birthday').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: '-71:+0'

        });

        load_data(1);

      function load_data(page, query = '') {
        $.ajax({
          url: "fetch_old_guest.php",
          method: "POST",
          data: {
            page: page,
            query: query
          },
          success: function(data) {
            $('#dynamic_content').html(data);
          }
        });
      }


      $(document).on('click', '.page-link', function() {
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(page, query);
      });



      $('#search_box').keyup(function() {
        var query = $('#search_box').val();
        load_data(1, query);
      });

      

    });
</script>