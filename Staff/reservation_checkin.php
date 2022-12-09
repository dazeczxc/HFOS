<?php

include('../Includes/header.php');
include('../Includes/staff_navbar.php');
include('../Includes/conn.php');


if (isset($_POST['confirm_reservation_roomid'])) {

	$TransactByy = $_SESSION['staffname'];
	$Trans_Code = $_POST['transactionCode'];

	$query_Select_reservation = "SELECT * FROM reservation WHERE TransactionCode = $Trans_Code";
	$query_Run_query_Select_reservation = mysqli_query($db, $query_Select_reservation);
	$resss = mysqli_fetch_assoc($query_Run_query_Select_reservation);

	$R_RRoomID = $resss['RoomID'];
    $R_GuestID = $resss['GuestID'];

    $query_guest = "SELECT * FROM guest WHERE GuestID = $R_GuestID";
	$run_query_guest = mysqli_query($db, $query_guest);
	$row_guest = mysqli_fetch_assoc($run_query_guest);

	$query_check_room_status = "SELECT * FROM rooms WHERE RoomID = $R_RRoomID";
	$run_query_check_room_status = mysqli_query($db, $query_check_room_status);
	$row_room = mysqli_fetch_assoc($run_query_check_room_status);
    $rtype = $row_room['RoomType'];
    $room_status = $row_room['RoomStatus'];

    $query_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = $rtype";
	$run_query_roomtype = mysqli_query($db, $query_roomtype);
	$row_roomtype = mysqli_fetch_assoc($run_query_roomtype);

    if($room_status == "Booked"){
        $_SESSION['StaffReservationConfirmMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h4>The room was occupied, you need to check them out first!</h4>
		</div>

	';
    echo "<script>window.location.href='../Staff/Reservation';</script>";

             mysqli_close($db);

    }else{}

}
?>





<!-- Begin Page Content -->
<div class="container-fluid bg-gray-100">



    <!-- Reservation Tables -->
    <div class="card w3-white pb-3" style="margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">
        <div class="">
            <div>
                <div class="d-flex justify-content-lg-between align-items-lg-baseline border-bottom-success px-4 pt-3">
                    <p style="font-size: 1.4rem;" class="  w3-text-teal"><b>Check in of Guest</b></p>

                </div>
                <div class="container-fluid ">
                <form action="reservation_payment.php" method="POST" autocomplete="off"> 

                    <div class=" row">


                        <div class="col-lg-8 mt-3">


                            <div class="card  shadow-sm">

                                <div class="row py-3 px-4 text-gray-700">



                                    <input type="hidden" name="GuestID"  value="<?php echo $row_guest['GuestID']; ?>" class="form-control" required>



                                    <div class="col-md-5 mb-3">
                                        <label for="inputEmail4" class="form-label">Guest Name<span class="text-danger">*</span></label>
                                        <input type="text" name="Name" value="<?php echo $row_guest['Name']; ?>" class="form-control" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="inputEmail4" class="form-label">Nationality<span class="text-danger">*</span></label>
                                        <input type="text" name="Nationality" value="<?php echo $row_guest['Nationality']; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="inputEmail4" class="form-label">Date of Birth<span class="text-danger">*</span></label>
                                        <input type="text" name="Birthdate" id="birthday" value="<?php echo $row_guest['Birthdate']; ?>" class="form-control" required>
                                    </div>




                                    <div class="col-md-3 mb-3">
                                        <label for="inputPassword4" class="form-label">Phone Number</label>
                                        <input type="text" name="PNumber" value="<?php echo $row_guest['PNumber']; ?>" class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="inputPassword4" class="form-label">Email Address</label>
                                        <input type="Email" name="Email" value="<?php echo $row_guest['Email']; ?>" class="form-control">
                                    </div>

                                    <div class="col-md-5 mb-3">
                                        <label for="inputPassword4" class="form-label">Home Address</label>
                                        <input type="text" name="Address" value="<?php echo $row_guest['Address']; ?>" class="form-control">
                                    </div>


                                    <div class="col-md-5">
                                        <label for="inputPassword4" class="form-label">Company</label>
                                        <input type="text" name="Company" value="<?php echo $row_guest['Company']; ?>" class="form-control">
                                    </div>

                                    <div class="col-md-5">
                                        <label for="inputPassword4" class="form-label">Company Address</label>
                                        <input type="text" name="CompanyAddress" value="<?php echo $row_guest['CompanyAddress']; ?>" class="form-control">
                                    </div>


                                </div>

                            </div>

                            <div class="card mt-3  pt-1 py-2 px-4 shadow-sm text-gray-700">
                                <div class="row">
                                    <label for="inputPassword4" class="form-label">For foreign guest</label>

                                    <div class="col-md-4 mb-3">
                                        <label for="inputPassword4" class="form-label">Country of Origin</label>

                                        <input type="text" name="Origin" value="<?php echo $row_guest['Origin']; ?>" class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="inputPassword4" class="form-label">Passport Number</label>

                                        <input type="text" name="Passport" value="<?php echo $row_guest['Passport']; ?>" class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="inputPassword4" class="form-label">Issued at</label>

                                        <input type="text" name="IssuedAt" value="<?php echo $row_guest['IssuedAt']; ?>" class="form-control">
                                    </div>


                                </div>
                            </div>

                            <div class="card mt-3 py-3 px-4 shadow-sm text-gray-700">
                                <div class="row">

                                    <div class="col-md-2 mb-3">
                                        <label for="inputEmail4" class="form-label">Adult(s)<span class="text-danger">*</span></label>
                                        <input type="number" min="0" name="GuestNumber" value="<?php echo $row_guest['GuestNumber']; ?>" class="form-control" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="inputEmail4" class="form-label">Kid(s)<span class="text-danger">*</span></label>
                                        <input type="number" min="0" name="GuestNumber2" value="<?php echo $row_guest['GuestNumber2']; ?>" class="form-control" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="inputPassword4" class="form-label">Discount (%)</label>
                                        <input type="text" name="Discount" class="mr-3 form-control" placeholder="0 " value="0">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="inputPassword4" class="form-label">Date of Arrival<span class="text-danger">*</span></label>
                                        <input type="text" name="Arrival" value="<?php echo $resss['Arrival']; ?>" id="datetimepicker" class="mr-3 form-control" placeholder="Select Date" required>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="inputPassword4" class="form-label">Date of Departure<span class="text-danger">*</span></label>
                                        <input type="text" name="Departure" value="<?php echo $resss['Departure']; ?>" id="datetimepicker2" class="mr-3 form-control" placeholder="Select Date" required>
                                    </div>


                                    <div class="d-flex justify-content-end">
                                        <a href="booking.php" class="btn btn-warning">Cancel</a>
                                        <input type="submit" name="Reserve_checkin_btn" value="Next" class="ml-2 px-4 btn btn-success">
 
                                    </div>

                                </div>

                                <input type="hidden" name="Downpayment" value="<?php echo $resss['Downpayment']; ?>">
                                <input type="hidden" name="Requests" value="<?php echo $resss['Requests']; ?>">
                                <input type="hidden" name="Accommodation" value="<?php echo $resss['Accommodationtype']; ?>">

                                <input type="hidden" name="TransactionCode" value="<?php echo $Trans_Code; ?>">
                                <input type="hidden" name="RoomID" value="<?php echo $R_RRoomID; ?>">

                            </div>





                        </div>

                        <div class="col mt-3 card shadow-sm">
                            <div class="pt-3 h-5 text-success text-uppercase mb-2 mt-2">Selected Room</div>
                            <div class="  pr-3 text-justify text-gray-800">
                                <table>
                                    <tr>
                                        <td>Room:</td>
                                        <td class="pl-2"><?php echo $row_room['RoomNumber']; ?></td>
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

                            <div class="mt-2">
                                <div class="pt-3 h-5 text-success  mb-2 mt-2">Guest Request</div>
                                <p class="text-gray-800 px-2"><?php echo $resss['Requests']; ?></p>

                            </div>

                            <div class=" mt-2  ">
                                <div class=" py-3">
                                    <h5 class="w3-text-teal">Other Amenities:</h5>

                                    <div class="px-3">
                                        <div class="form-check" style="font-size: 1.1rem;">
                                            
                                            
                                            <?php

                                            echo '<table class="table table-sm">';

                                            $query_trans = "SELECT * FROM amen_transaction WHERE TransactionCode = $Trans_Code";
                                            
                                            $run_query_trans = mysqli_query($db, $query_trans);
                                            if (mysqli_num_rows($run_query_trans) > 0) {

                                                while ($result = mysqli_fetch_array($run_query_trans)) {
                                                    $amenID = $result['AmenID'];

                                                    $query_amen = "SELECT * FROM amenities WHERE AmenID = $amenID";       
                                                    $run_query_amen = mysqli_query($db, $query_amen);
                                                    $res = mysqli_fetch_assoc($run_query_amen);

                                                    $out ='<tr>';
                                                    $out .= '<td style="width: 80px;"><input type="number" min="0" name="amenities[]" value="'.$result['AmenQuantity'].'" class="form-control">
                                                             
                                            
                                                     </select>
                                                             <td ><span>'.$result['AmenName'].'</span></td>
                                                             
                                                             </td>';
                                                    $out .= '<td align="left" class=" "><span>&#8369 </span>'.$res['AmenRates'].'.00 / '.$res['AmenQuantity'].'</td>';
                                             
                                                    $out .= '</tr>';
                                                    echo $out;
                                                }
                                            }

                                            $query = "SELECT * FROM amenities WHERE AmenID NOT IN(SELECT AmenID FROM amen_transaction WHERE TransactionCode = '$Trans_Code')";
                                            $run_query = mysqli_query($db, $query);
                                            
                                            if (mysqli_num_rows($run_query) > 0) {

                                                while ($row = mysqli_fetch_array($run_query)) {

                                                    $out ='<tr>';
                                                    $out .= '<td style="width: 80px;"><input type="number" min="0" name="amenities[]" placeholder="0" class="form-control">
                                                             
                                            
                                                     </select>
                                                             <td ><span>'.$row['AmenName'].'</span></td>
                                                             
                                                             </td>';
                                                    $out .= '<td align="left" class=" "><span>&#8369 </span>'.$row['AmenRates'].'.00 / '.$row['AmenQuantity'].'</td>';
                                             
                                                    $out .= '</tr>';
                                                    echo $out;
                                                }
                                            }

                                            

                                            

                                            
                                            echo '</table>';
                                            

                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                    </form>
                </div>
            </div>

        </div>






    </div>
</div>





</div>
<!-- End Reservation tables -->






<?php
include('../Includes/scripts.php');
include('../Includes/footer.php');
?>




 

<?php

$query_reservation = "SELECT * FROM reservation WHERE RoomID = $R_RRoomID AND GuestID != $R_GuestID";
$run_query_reservation = mysqli_query($db, $query_reservation);

if (mysqli_num_rows($run_query_reservation) > 0) {
    $date_Array = array();

      $date_Array = "[";
      
    while ($result_room_queryR = mysqli_fetch_array($run_query_reservation)) {

    $Arrival = $result_room_queryR['Arrival'];
    $Departure = $result_room_queryR['Departure'];

    $from = strtotime($Arrival);
    $to = strtotime($Departure);

    for($curentdate = $from; $curentdate <= $to; $curentdate += (86400) ){
        $reserve_date = date('Y-m-d', $curentdate);
        $date_Array .= "'".$reserve_date."',";
    }
     
  }
      $date_Array .= "''";
      $date_Array .= "];";
 
} else{
    $date_Array = "[];";
}
mysqli_close($db);
?>


<script>
  $(function() {

    var minDate = new Date();
    minDate.setDate(minDate.getDate())

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
      minDate: minDate,
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