<?php
include('header.php');

include_once("Includes/conn.php");


?>

<!-- Checkout Modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <form action="Includes/server.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transactionID" id="transs_id">
                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-trash text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to cancel reservation?</h4>
                    <h4 class="text-warning">This action cannot be undone!</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="cancelReservation" class="btn btn-success px-5">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Checkout Modal -->


<!-- out Modal -->
<div class="modal fade" id="deletemodal_out" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <form action="Includes/server.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transactionID" id="transss_id">
                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-trash text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to delete transaction?</h4>
                    <h4 class="text-warning">This action cannot be undone!</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="cancelReservation_out" class="btn btn-success px-5">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End out Modal -->



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
    <a class="nav-link text-success" href="reservation.php">Book Now</a>
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
    <a class="nav-link text-success" href="signin">Book Now</a>
</li>     ';

    $show = "d-none";
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





<section class=" bg-gray-200 <?php echo $_SESSION['show']; ?> pt-5 pb-5" id="transaction">
    <div class="container bg-gray-200    pt-5">

        <div class="row pt-5">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card bg-gray-100 shadow px-3 py-3    ">
                    <h4 class="text-success">My Reservation </h4>
                    <?php
                    if (isset($_SESSION['TransReservationMessage'])) {
                        echo $_SESSION['TransReservationMessage'];
                        unset($_SESSION['TransReservationMessage']);
                    }


                    ?>

                    <?php

                    $sql_reservation = "SELECT * FROM reservation WHERE TransactionCode IN 
                        (SELECT TransactionCode FROM recent_guest WHERE wID IN (SELECT wID FROM web_user WHERE wID = '$G_ID')) ORDER BY Arrival DESC
                        ";
                    $run_sql_reservation = mysqli_query($db, $sql_reservation);
                    if (mysqli_num_rows($run_sql_reservation) > 0) {
                        while ($row_reserve = mysqli_fetch_array($run_sql_reservation)) {

                            $Arrival = strtotime($row_reserve['Arrival']);
                            $Arrival = date(' F d, Y', $Arrival);

                            $Depart = strtotime($row_reserve['Departure']);
                            $Depart = date(' F d, Y', $Depart);

                            $Roomid = $row_reserve['RoomID'];

                            if(!empty($Roomid)){
                                $sql_rooms = "SELECT * FROM rooms WHERE RoomID = '$Roomid'";
                                $run_sql_rooms = mysqli_query($db, $sql_rooms);
                                $rows = mysqli_fetch_assoc($run_sql_rooms);
    
                                $rtype = $rows['RoomType'];
                                $sql_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = '$rtype'";
                                $run_sql_roomtype = mysqli_query($db, $sql_roomtype);
                                $row_rtype = mysqli_fetch_assoc($run_sql_roomtype);
                            }else{

                            }
                            

                            if ($row_reserve['ReservationStatus'] == 'Pending') {
                                $alert = 'alert-light';
                                $status = ' 
                                        <p> Status: <span class="text-warning">' . $row_reserve['ReservationStatus'] . '</span>
                                    ';
                                $code = ' ';
                                $button = '
                                    <div class=" ">
                                        <table >
                                            <tr>
                                                <td class="d-none transaction_id">' . $row_reserve['TransactionCode'] . '</td>
                                                <td class="pr-2"> <button class="btn btn-success view_reservation px-3" id="' . $row_reserve['TransactionCode'] . '">View Details</button> </td>
                                                <td><button type="button" class="px-2 btn btn-warning delete_btn " data-bs-dismiss="modal">Cancel Reservation</button></td>
                                            </tr>
                                        </table>   
                                    </div>
                                    ';
                            } elseif ($row_reserve['ReservationStatus'] == 'Approved') {
                                $alert = 'alert-success';

                                $status = ' 
                                    <p> Status: <span class="text-success">' . $row_reserve['ReservationStatus'] . '</span>
                                    ';
                                $code = 'Code:<span style="font-weight:bold; font-size: 1.1rem" class="pl-1  ">
                                        ' . $row_reserve['TransactionCode'] . '</span><br>';
                                $button = '
                                        <div class=" ">
                                                 <table >
                                                <tr>
                                                <td class="d-none transaction_id">' . $row_reserve['TransactionCode'] . '</td>
                                                <td class="pr-2"> <button class="btn btn-success view_reservation px-3" id="' . $row_reserve['TransactionCode'] . '">View Details</button> </td>
                                                <td><button type="button" class="px-2 btn btn-warning delete_btn">Cancel Reservation</button></td>
                                                </tr>
                                                </table>   
                                         </div>
                                    ';

                                    $output = '


                                <div class="py-3 alert ' . $alert . ' shadow-sm">
                                    <button  class="close" type="button"><i class="text-success fa fa-bookmark"></i></button>
                                    ' . $status . '
                                     <br>
                                     ' . $code . '
                                     
                                     Room: <span  class=" ">' . $row_rtype['roomtype'] . '   </span> <br>
                                     Rate: <span  class=" ">' . $row_rtype['roomprice'] . '.00/Night </span> <br>

                                        <span class=" pr-1">' . $Arrival . '</span> - 
                                        <span class="pl-1">' . $Depart . '</span><br>
                                        
                                    </p>
                                    ' . $button . '
                                </div>
                                
                                ';

                            } elseif ($row_reserve['ReservationStatus'] == 'Denied') {
                                $alert = 'alert-danger';

                                $status = ' 
                                        <p> Status: <span class="text-danger">Cancelled</span>
                                    ';
                                $code = ' ';
                                $button = '
                                        <div class=" ">
                                        <a href="Includes/server.php?deleteReservation=' . $row_reserve['TransactionCode'] . '" class="btn btn-danger w3-text-white"> Delete Reservation</a>
                                        </div>
                                    ';
                                    $output = '
                                    <div class="py-3 alert ' . $alert . ' shadow-sm">
                                        <button  class="close" type="button"><i class="text-success fa fa-bookmark"></i></button>
                                        ' . $status . '
                                         <br>
                                         ' . $code . '
                                         
                                         Room: <span  class=" ">' . $row_rtype['roomtype'] . '   </span> <br>
                                         Rate: <span  class=" ">' . $row_rtype['roomprice'] . '.00/Night </span> <br>
    
                                            <span class=" pr-1">' . $Arrival . '</span> - 
                                            <span class="pl-1">' . $Depart . '</span><br>
                                            
                                        </p>
                                        ' . $button . '
                                    </div>
                                    
                                    ';
                            }

                            elseif ($row_reserve['ReservationStatus'] == 'CheckIn') {
                                $alert = 'alert-info';

                                $status = ' 
                                    <p> Status: <span class="text-success">Booked</span>
                                    ';
                                $code = 'Code:<span style="font-weight:bold; font-size: 1.1rem" class="pl-1  ">
                                        ' . $row_reserve['TransactionCode'] . '</span><br>';
                                $button = '
                                <div class=" ">
                                         <table >
                                        <tr>
                                        <td class="d-none transaction_id">' . $row_reserve['TransactionCode'] . '</td>
                                        <td class="pr-2"> <button class="btn btn-success view_reservation_book px-3" id="' . $row_reserve['TransactionCode'] . '">View Invoice</button> </td>
                                         </tr>
                                        </table>   
                                 </div>
                            ';

                            $output = '
                            
                                <div class="py-3 alert ' . $alert . ' shadow-sm">
                                
                                    <button  class="close" type="button"><i class="text-success fa fa-bookmark"></i></button>
                                    ' . $status . '
                                     <br>
                                     ' . $code . '
                                     
                                     Room: <span  class=" ">' . $row_rtype['roomtype'] . '   </span> <br>
                                     Rate: <span  class=" ">' . $row_rtype['roomprice'] . '.00/Night </span> <br>

                                        <span class=" pr-1">' . $Arrival . '</span> - 
                                        <span class="pl-1">' . $Depart . '</span><br>
                                        
                                    </p>
                                    ' . $button . '
                                    
                                </div>
                                
                                ';
                            }

                            elseif ($row_reserve['ReservationStatus'] == 'CheckOut') {
                                $alert = 'alert-warning';

                                $status = ' 
                                    <p> Status: <span class="text-success">Checked Out</span>
                                    ';
                                $code = 'Code:<span style="font-weight:bold; font-size: 1.1rem" class="pl-1  ">
                                        ' . $row_reserve['TransactionCode'] . '</span><br>';
                                $button = '
                                <div class=" ">
                                         <table >
                                        <tr>
                                        <td class="d-none transaction_id">' . $row_reserve['TransactionCode'] . '</td>
                                        <td class="pr-2"> <button class="btn btn-success view_reservation_out px-3" id="' . $row_reserve['TransactionCode'] . '">View Invoice</button> </td>
                                        <td><button type="button"  class="px-5 btn btn-warning delete_btn_out">Delete</button></td>
                                        
 
                                        </tr>
                                        </table>   
                                 </div>
                            ';
                             
                                 

                                $code = $row_reserve['TransactionCode'];
                                $rate_query = "SELECT * FROM rating WHERE TransactionCode = '$code' ";
                                $run_query_rate = mysqli_query($db, $rate_query);
                                if(mysqli_num_rows($run_query_rate) > 0){
                                    $rate = '';
                                }else{
                                    $rate ='
                                    <div class="mt-3 alert alert-light alert-dismissable" id="rate_msg">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <h5>How was your experience?</h5>
                                        <div color:white;">
                                            <i class="fa fa-star fa-2x" data-index="0"></i>
                                            <i class="fa fa-star fa-2x" data-index="1"></i>
                                            <i class="fa fa-star fa-2x" data-index="2"></i>
                                            <i class="fa fa-star fa-2x" data-index="3"></i>
                                            <i class="fa fa-star fa-2x" data-index="4"></i>
                                             
                                            
                                        </div>
                                    </div>
                                    ';
                                }


                    
                            $output = '
                            
                                <div class="py-3 alert ' . $alert . ' shadow-sm">
                                    <button  class="close" type="button"><i class="text-success fa fa-bookmark"></i></button>
                                    ' . $status . '
                                     <br>
                                     ' . $code . '
                                     
 
                                        <span class=" pr-1">' . $Arrival . '</span> - 
                                        <span class="pl-1">' . $Depart . '</span><br>
                                        
                                    </p>
                                    ' . $button . '

                                    '.$rate.'
                                </div>
                                
                                ';
                            }
                            

                            echo $output;
                             
                        }
                    } else {
                        echo '
                            <div class="alert alert-warning " ">
                            <h5>You do not have reservation</h5>
                            </div>
                            ';
                    }


                    ?>

                </div>
            </div>








        </div>
    </div>
</section>


<!-- View reservation details Modal -->
<div id="view_details_modal_reservation" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal_reservation" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reservation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="reservation_detail">

            </div>
        </div>
    </div>
</div>
<!-- End of View Details Modal -->

<!-- View booked details Modal -->
<div id="view_details_modal_reservation_book" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal_reservation" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="reservation_detail_book">

            </div>
        </div>
    </div>
</div>
<!-- End of View booked Details Modal -->

 <!-- View out details Modal -->
<div id="view_details_modal_reservation_out" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal_reservation" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="reservation_detail_out">

            </div>
        </div>
    </div>
</div>
<!-- End of View out Details Modal -->


<?php
include('scripts.php');
include('footer.php');
?>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.view_reservation', function() {
            var tran_code = $(this).attr("id");
            if (tran_code != '') {
                $.ajax({
                    url: "view_my_reservation_info.php",
                    method: "POST",
                    data: {
                        tran_code: tran_code
                    },
                    success: function(data) {
                        $('#reservation_detail').html(data);
                        $('#view_details_modal_reservation').modal('show');
                    }
                });
            }
        });


        $(document).on('click', '.view_reservation_book', function() {
            var tran_code = $(this).attr("id");
            if (tran_code != '') {
                $.ajax({
                    url: "view_my_reservation_info_book.php",
                    method: "POST",
                    data: {
                        tran_code: tran_code
                    },
                    success: function(data) {
                        $('#reservation_detail_book').html(data);
                        $('#view_details_modal_reservation_book').modal('show');
                    }
                });
            }
        });

        $(document).on('click', '.view_reservation_out', function() {
            var tran_code = $(this).attr("id");
            if (tran_code != '') {
                $.ajax({
                    url: "view_my_reservation_info_out.php",
                    method: "POST",
                    data: {
                        tran_code: tran_code
                    },
                    success: function(data) {
                        $('#reservation_detail_out').html(data);
                        $('#view_details_modal_reservation_out').modal('show');
                    }
                });
            }
        });
        

        $(document).on('click', '.delete_btn', function(e) {
            e.preventDefault();

            var transid = $(this).closest('tr').find('.transaction_id').text();
            //console.log(staffid);
            $('#transs_id').val(transid);
            $('#deletemodal').modal('show');
        });

        $(document).on('click', '.delete_btn_out', function(e) {
            e.preventDefault();

            var transid = $(this).closest('tr').find('.transaction_id').text();
            //console.log(staffid);
            $('#transss_id').val(transid);
            $('#deletemodal_out').modal('show');
        });


    });

    $(document).ready(function() {
        $("#flash-msg").delay(2000).fadeOut("slow");
    });
</script>

<?php
if (isset($_POST['save'])) {
    $ratedIndex = $_POST['ratedIndex'];

    $ratedIndex = $ratedIndex + 1;
    $query = "SELECT * FROM recent_transaction WHERE TransactionCode = '$code'";
	$run_query = mysqli_query($db, $query);
    $room = mysqli_fetch_assoc($run_query);
    $rid = $room['RoomID'];

    $query1 = "SELECT * FROM rooms WHERE RoomID = '$rid'";
	$run_query1 = mysqli_query($db, $query1);
    $r1 = mysqli_fetch_assoc($run_query1);
    $rtype = $r1['RoomType'];




    $query_Rate_save = "INSERT INTO rating (RoomID, TransactionCode, Star) VALUES ('$rtype', '$code', '$ratedIndex')";
	$run_query_Rate_save = mysqli_query($db, $query_Rate_save);

}

?>


<script>
        var ratedIndex = -1;

        $(document).ready(function () {
            resetStarColors();

             

            $('.fa-star').on('click', function () {
               ratedIndex = parseInt($(this).data('index'));
               
               $("#rate_msg").delay(1).fadeOut("fast");

               saveToTheDB();
            });

            $('.fa-star').mouseover(function () {
                resetStarColors();
                var currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            $('.fa-star').mouseleave(function () {
                resetStarColors();

                if (ratedIndex != -1)
                    setStars(ratedIndex);
            });
        });

        function saveToTheDB() {
            $.ajax({
               url: "transaction.php",
               method: "POST",
               dataType: 'json',
               data: {
                   save: 1,
                    
                   ratedIndex: ratedIndex
               }, success: function (r) {
                    uID = r.id;
                    localStorage.setItem('uID', uID);
               }
            });
        }

        function setStars(max) {
            for (var i=0; i <= max; i++)
                $('.fa-star:eq('+i+')').css('color', 'yellow');
        }

        function resetStarColors() {
            $('.fa-star').css('color', 'gray');
        }
    </script>