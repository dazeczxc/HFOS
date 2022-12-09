<?php
include('../Includes/header.php');
include('../Includes/staff_navbar.php');
?>



<?php
include('../Includes/conn.php');
if (isset($_GET["roomid"])) {
  $roomid = $_GET["roomid"];

  $query = "SELECT * FROM rooms WHERE RoomID = '$roomid'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);

  $Roomtype = $row['RoomType'];

  $query_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = '$Roomtype'";
  $result_query_roomtype = mysqli_query($db, $query_roomtype);
  $row_roomtype = mysqli_fetch_assoc($result_query_roomtype);

  $datenow = date('Ymd');
  $timenow = date("His");
  $TransactionCode = $datenow . '' . $timenow;
} else {
  echo "<script>window.location.href='booking';</script>";
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <div class="card bg-success mb-2 shadow-sm">
    <div class="d-flex">
      <div class="d-flex justify-content-end">

        <div class="bg-success">
          <div class=" text-center text-white p-2" style="margin-right: 80px; margin-left: 140px ;">
            View Available Rooms
          </div>
        </div>
        <div class="w3-white">
          <img src="../Images/arrow.png" class="w3-white" style="height: 38px; width: 38px;">
        </div>
      </div>

      <div class="d-flex justify-content-end">
        <div class="bg-white">
          <div class=" text-center w3-text-teal p-2" style="margin-right: 90px; margin-left: 110px ;">
            Customer Information
          </div>
        </div>
        <div class="bg-success">
          <img src="../Images/arrow2.png" class="" style="height: 38px; width: 38px;">
        </div>
      </div>

      <div class="d-flex justify-content-end">
        <div class="bg-success">
          <div class=" text-center w3-text-white p-2" style="margin-right: 100px; margin-left: 110px ;">
            Payment Settlement
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Main COntent -->

  <div class="container-fluid ">
    <form action=" booking_payment_settlement.php" method="POST" autocomplete="off">

      <div class=" row">


        <div class="col-lg-8 mt-2">


          <div class="card  shadow-sm">
            <button type="button" class="col-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Select Old Guest</button>
            <div class="row py-3 px-4 text-gray-700">



              <input type="hidden" name="GuestID" id="GuestID" class="form-control" required>



              <div class="col-md-5 mb-3">
                <label for="inputEmail4" class="form-label">Guest Name<span class="text-danger">*</span></label>
                <input type="text" name="Name" id="Name" class="form-control" required>
              </div>

              <div class="col-md-4 mb-3">
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

              <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Email Address</label>
                <input type="Email" name="Email" id="Email" class="form-control">
              </div>

              <div class="col-md-5 mb-3">
                <label for="inputPassword4" class="form-label">Home Address</label>
                <input type="text" name="Address" id="Address" class="form-control">
              </div>


              <div class="col-md-5">
                <label for="inputPassword4" class="form-label">Company</label>
                <input type="text" name="Company" id="Company" class="form-control">
              </div>

              <div class="col-md-5">
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

              <div class="col-md-2 mb-3">
                <label for="inputEmail4" class="form-label">No. Adult(s)<span class="text-danger">*</span></label>
                <input type="number" name="GuestNumber" min="0" value="0" class="form-control" required>
              </div>

              <div class="col-md-2 mb-3">
                <label for="inputEmail4" class="form-label">No. Kid(s)<span class="text-danger">*</span></label>
                <input type="number" name="GuestNumber2" min="0" value="0" class="form-control" required>
              </div>

              <div class="col-md-2 mb-3">
                <label for="inputPassword4" class="form-label">Discount (%)</label>
                <input type="text" name="Discount" class="mr-3 form-control" placeholder="0 " value="0">
              </div>

              <div class="col-md-3 mb-3">
                <label for="inputPassword4" class="form-label">Date of Arrival<span class="text-danger">*</span></label>
                <input type="text" name="Arrival" id="datetimepicker" class="mr-3 form-control" placeholder="Select Date" required>
              </div>

              <div class="col-md-3 mb-3">
                <label for="inputPassword4" class="form-label">Date of Departure<span class="text-danger">*</span></label>
                <input type="text" name="Departure" id="datetimepicker2" class="mr-3 form-control" placeholder="Select Date" required>
              </div>


              <div class="d-flex justify-content-end">
                <a href="booking.php" class="btn btn-warning px-4">Back</a>
                <input type="submit" name="Guestsave" value="Next" class="ml-2 px-4 btn btn-success">
              </div>

            </div>


            <input type="hidden" name="TransactionCode" value="<?php echo $TransactionCode; ?>">
            <input type="hidden" name="RoomID" value="<?php echo $row['RoomID']; ?>">

          </div>





        </div>

        <div class="col mt-2 card shadow-sm">
          <div class="pt-3 h-5 text-success text-uppercase mb-2 mt-2">Selected Room</div>
          <div class="  pr-3 text-justify">
            <table>
              <tr>
                <td>Room:</td>
                <td class="pl-2"><?php echo $row['RoomNumber']; ?></td>
              </tr>
              <tr>
                <td>Type:</td>
                <td class="pl-2"><?php echo $row_roomtype['roomtype']; ?></td>
              </tr>
              <tr>
                <td>Rate:</td>
                <td class="pl-2"><span>&#8369 </span> <?php echo $row_roomtype['roomprice']; ?>.00/Night</td>
              </tr>

            </table>
            <p class="pt-1 card-text">Description:<br> <span class="pl-4"> <?php echo $row_roomtype['roomtypedescription']; ?> </span><br></p>



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
</div>



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


  <?php
  $date_Array = array();
  $query_reservation = "SELECT * FROM reservation WHERE RoomID = $roomid AND ReservationStatus = 'Approved'";
  $run_query_reservation = mysqli_query($db, $query_reservation);

  if (mysqli_num_rows($run_query_reservation) > 0) {


    $date_Array = "[";

    while ($result_room_queryR = mysqli_fetch_array($run_query_reservation)) {

      $Arrival = $result_room_queryR['Arrival'];
      $Departure = $result_room_queryR['Departure'];

      $from = strtotime($Arrival);
      $to = strtotime($Departure);
      $from1 = $from+86400;

      for ($curentdate = $from1; $curentdate <= $to; $curentdate += (86400)) {
        $reserve_date = date('Y-m-d', $curentdate);
        $date_Array .= "'" . $reserve_date . "',";
      }
    }
    $date_Array .= "''";
    $date_Array .= "];";
  } else {
    $date_Array = "[];";
  }
  ?>


  <script>
    $(function() {

      var minDate = new Date();
      minDate.setDate(minDate.getDate())

      var minDate2 = new Date();
      minDate2.setDate(minDate2.getDate() + 1)

      var disable_dates = <?php echo $date_Array; ?>


      $('#datetimepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        timepicker: false,

        minDate: minDate,
        beforeShowDay: function(date) {
          var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
          return [disable_dates.indexOf(string) == -1]
        }

      });

      $('#datetimepicker2').datepicker({

        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        timepicker: false,
        showOtherMonths: true,
        selectOtherMonths: true,
        minDate: minDate2,
        beforeShowDay: function(date) {
          var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
          return [disable_dates.indexOf(string) == -1]
        }
      });

      $('#birthday').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,

        yearRange: '-71:+0'


      });

    });
  </script>


  <script>
    $(document).ready(function() {

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
      $("#flash-msg").delay(2000).fadeOut("slow");
    });
  </script>