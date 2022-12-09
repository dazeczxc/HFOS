<?php

include('../Includes/header.php');
include('../Includes/staff_navbar.php');

 
?>





<!-- Begin Page Content -->
<div class="container-fluid bg-gray-100">



    <!-- Reservation Tables -->
    <div class="card w3-white" style="margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">
        <div class="">
            <div>
                <div class="d-flex justify-content-lg-between align-items-lg-baseline border-bottom-success px-4 pt-3">
                    <p style="font-size: 1.4rem;" class="  w3-text-teal"><b>Search Room</b></p>
                    <a class="btn btn-success px-4" href="reservation">Reservation List</a>

                </div>
                <div class="col px-5 pt-3">

                    <form method="POST" action="#" autocomplete="off">
                        <div class="row mb-3">

                            <div class="  col-lg-2  mb-3 ">
                                <label>Arrival</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" id="toggle" class="input-group-text"><i class="fa fa-calendar-alt"></i></button>
                                    </div>
                                    <input type="text" class="col-sm-2 col-xl-12 form-control" name="Sarival" id="datetimepicker" placeholder="select date" required />
                                </div>
                            </div>




                            <div class=" col-lg-2  mb-3 ">
                                <label>Departure</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" id="toggle2" class="input-group-text"><i class="fa fa-calendar-alt"></i></button>
                                    </div>
                                    <input type="text" class="col-sm-2 col-xl-12 form-control" name="Sdeparture" id="datetimepicker2" placeholder="select date" required />
                                </div>
                            </div>

                            <div class=" col-lg-3  mb-3">
                                <label class="text-white">Departure</label>

                                <button type="submit" name="btnSearchRoom" class="btn px-5 btn-success">Search Rooms</button>

                            </div>

                        </div>



                    </form>
                </div>

            </div>


        </div>
    </div>

    <div class=" row   pb-5">



        <?php
        include('../Includes/conn.php');

        $vacant = "Vacant";
        $booked = "Booked";

        if (isset($_POST['btnSearchRoom'])) {



            $from = $_POST['Sarival'];
            $to = $_POST['Sdeparture'];

            $_SESSION['from'] = $from;
            $_SESSION['to'] = $to;


            $SearchArrival = date("Y-m-d", strtotime($from));
            $SearchDeparture = date("Y-m-d", strtotime($to));

            $Arrival = strtotime($from);
            $Departure = strtotime($to);
            $Arrival = date('F d, Y', $Arrival);
            $Departure = date('F d, Y', $Departure);

            echo '
<div class=" w3-center   pt-3    ">
<div class=" alert alert-success w3-center">
<h4> Available room from ' . $Arrival . ' to ' . $Departure . ' </h4>
</div></div>
';



            //getting all rooms from reservation
            $query_room_from_reservation = "SELECT * FROM rooms WHERE RoomStatus ='Vacant' AND  RoomID IN
(SELECT RoomID FROM reservation WHERE ReservationStatus = 'Approved' AND RoomID NOT IN
(SELECT RoomID FROM reservation WHERE ReservationStatus = 'Approved' AND
'$SearchArrival' BETWEEN Arrival AND Departure OR '$SearchDeparture' BETWEEN Arrival AND Departure
OR (Arrival <= '$SearchArrival'  AND  Departure >= '$SearchDeparture' ) 
)
)";
            $run_query_room_from_reservation = mysqli_query($db, $query_room_from_reservation);

            if (mysqli_num_rows($run_query_room_from_reservation) > 0) {
                while ($result_room_queryR = mysqli_fetch_array($run_query_room_from_reservation)) {
                    $RoomType = $result_room_queryR['RoomType'];
                    $query_room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$RoomType'";
                    $run_query_room_type = mysqli_query($db, $query_room_type);
                    $result_room_type = mysqli_fetch_assoc($run_query_room_type);

                    $output = '

    <div class="col-lg-2  pt-4">
        <div class="card shadow-sm">

            <div class="card-img-top"><img src="../Upload/' . $result_room_queryR["RoomImage"] . '" alt="image" width="100%;" height="140px;"></div>
            <div class=" card-body">
                <p class="card-text ">Room ' . $result_room_queryR['RoomNumber'] . '</p> 

                <p class="card-text ">' . $result_room_type['roomtype'] . '</p> 
                <p class="card-text "><span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
                <a href="reservation_add_input_details?R_roomid=' . $result_room_queryR['RoomID'] . '" class="btn btn-success col">Reserve</a>
            </div>
        </div>
    </div>
            ';
                    echo $output;
                }
            } else {
            }



            //plain vacant rooms no reservation or transaction
            $query_room_reserve = "SELECT * FROM rooms WHERE RoomStatus ='vacant' AND RoomID
NOT IN(SELECT RoomID FROM reservation WHERE ReservationStatus = 'Approved')";
            $run_query_room_reserve = mysqli_query($db, $query_room_reserve);

            if (mysqli_num_rows($run_query_room_reserve) > 0) {

                while ($result_room_reserve = mysqli_fetch_array($run_query_room_reserve)) {

                    $rtype = $result_room_reserve['RoomType'];
                    $query_room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$rtype'";
                    $run_query_room_type = mysqli_query($db, $query_room_type);
                    $result_room_type = mysqli_fetch_assoc($run_query_room_type);

                    $output = '

    <div class="col-lg-2  pt-4">
        <div class="card shadow-sm">

            <div class="card-img-top"><img src="../Upload/' . $result_room_reserve["RoomImage"] . '" alt="image" width="100%;" height="140px;"></div>
            <div class=" card-body">
                <p class="card-text ">Room ' . $result_room_reserve['RoomNumber'] . '</p> 

                <p class="card-text ">' . $result_room_type['roomtype'] . '</p> 
                <p class="card-text "><span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
                <a href="reservation_add_input_details?R_roomid=' . $result_room_reserve['RoomID'] . '" class="btn btn-success col">Reserve</a>
            </div>
        </div>
    </div>
    ';
                    echo $output;
                }
            }


            $sql_reserve = "SELECT * FROM reservation WHERE ReservationStatus = 'Approved'";
            $run_sql_reserve = mysqli_query($db, $sql_reserve);
            if (mysqli_num_rows($run_sql_reserve) > 0) {


                //selecting booked rooms where transaction is not in reservation
                $query_room_from_reservation = "SELECT * FROM rooms WHERE RoomStatus ='Booked' AND  RoomID IN
(SELECT RoomID FROM transaction WHERE RoomID NOT IN
(SELECT RoomID FROM transaction WHERE
'$SearchArrival' BETWEEN Arrival AND Departure OR '$SearchDeparture' BETWEEN Arrival AND Departure
OR (Arrival <= '$SearchArrival'  AND  Departure >= '$SearchDeparture' ) 

))";
                $run_query_room_from_reservation = mysqli_query($db, $query_room_from_reservation);

                if (mysqli_num_rows($run_query_room_from_reservation) > 0) {
                    while ($result_room_queryR = mysqli_fetch_array($run_query_room_from_reservation)) {
                        $RID = $result_room_queryR['RoomID'];

                        $ssql = "SELECT * FROM rooms WHERE RoomID = $RID AND RoomID NOT IN(SELECt RoomID FROM reservation)";
                        $run_ssql = mysqli_query($db, $ssql);

                        if (mysqli_num_rows($run_ssql) > 0) {
                            while ($result_run_ssql = mysqli_fetch_array($run_ssql)) {

                                $RoomType = $result_run_ssql['RoomType'];
                                $query_room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$RoomType'";
                                $run_query_room_type = mysqli_query($db, $query_room_type);
                                $result_room_type = mysqli_fetch_assoc($run_query_room_type);

                                $output = '

                        <div class="col-lg-2  pt-4">
                            <div class="card shadow-sm">

                                <div class="card-img-top"><img src="../Upload/' . $result_room_queryR["RoomImage"] . '" alt="image" width="100%;" height="140px;"></div>
                                <div class=" card-body">
                                <p class="card-text ">Room ' . $result_room_queryR['RoomNumber'] . '</p> 

                                <p class="card-text ">' . $result_room_type['roomtype'] . '</p> 

                                 <p class="card-text "><span>&#8369 </span>' . $result_room_type['roomprice'] . '.00 / Day</p>
                                    <a href="reservation_add_input_details?R_roomid=' . $result_room_queryR['RoomID'] . '" class="btn btn-success col">Reserve</a>
                                </div>
                            </div>
                        </div>
                            ';
                                echo $output;
                            }
                        }
                    }
                }




                //for both booked room at transaction and reservation
                $query_room_from_transaction =
                    "SELECT * FROM rooms WHERE RoomStatus ='Booked' AND  RoomID IN
(SELECT RoomID FROM reservation WHERE ReservationStatus='Approved' AND RoomID NOT IN
    (SELECT RoomID FROM reservation WHERE ReservationStatus = 'Approved' AND
        '$SearchArrival' BETWEEN Arrival AND Departure OR '$SearchDeparture' BETWEEN Arrival AND 
        Departure OR (Arrival <= '$SearchArrival'  AND  Departure >= '$SearchDeparture' )

    
)
)";

                $run_query_room_from_transaction = mysqli_query($db, $query_room_from_transaction);

                if (mysqli_num_rows($run_query_room_from_transaction) > 0) {
                    while ($result_room_query = mysqli_fetch_array($run_query_room_from_transaction)) {
                        $RooID = $result_room_query['RoomID'];

                        $sql = "SELECT * FROM rooms WHERE RoomID = $RooID AND  RoomID IN
(SELECT RoomID FROM transaction WHERE RoomID NOT IN
(SELECT RoomID FROM transaction WHERE '$SearchArrival' BETWEEN Arrival AND Departure 
OR '$SearchDeparture' BETWEEN Arrival AND Departure OR (Arrival <= '$SearchArrival'  
AND  Departure >= '$SearchDeparture' ) 
)
)";
                        $run_sql = mysqli_query($db, $sql);
                        if (mysqli_num_rows($run_sql) > 0) {
                            while ($result_sql = mysqli_fetch_array($run_sql)) {

                                $RoomType = $result_sql['RoomType'];
                                $query_room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$RoomType'";
                                $run_query_room_type = mysqli_query($db, $query_room_type);
                                $result_room_type = mysqli_fetch_assoc($run_query_room_type);

                                $output = '

<div class="col-lg-2  pt-4">
<div class="card shadow-sm">

<div class="card-img-top"><img src="../Upload/' . $result_room_query["RoomImage"] . '" alt="image" width="100%;" height="140px;"></div>
<div class=" card-body">
<p class="card-text ">Room ' . $result_room_query['RoomNumber'] . '</p> 

<p class="card-text ">' . $result_room_type['roomtype'] . '</p> 
<p class="card-text "><span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
<a href="reservation_add_input_details?R_roomid=' . $result_room_query['RoomID'] . '" class="btn btn-success col">Book Now</a>
</div>
</div>
</div>
';
                                echo $output;
                            }
                        }
                    }
                }
            } else {

                $query_room_booked = "SELECT * FROM rooms WHERE RoomStatus ='Booked' AND  RoomID IN
(SELECT RoomID FROM transaction WHERE RoomID NOT IN
(SELECT RoomID FROM transaction WHERE
    '$SearchArrival' BETWEEN Arrival AND Departure OR '$SearchDeparture' BETWEEN Arrival AND Departure
    OR (Arrival <= '$SearchArrival'  AND  Departure >= '$SearchDeparture' ) 
)
)";
                $run_query_room_booked = mysqli_query($db, $query_room_booked);

                if (mysqli_num_rows($run_query_room_booked) > 0) {

                    while ($result_room_booked = mysqli_fetch_array($run_query_room_booked)) {
                        $RoomType = $result_room_booked['RoomType'];
                        $query_room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$RoomType'";
                        $run_query_room_type = mysqli_query($db, $query_room_type);
                        $result_room_type = mysqli_fetch_assoc($run_query_room_type);
                        $output = '

    <div class="col-lg-2  pt-4">
        <div class="card shadow-sm">

            <div class="card-img-top"><img src="../Upload/' . $result_room_booked["RoomImage"] . '" alt="image" width="100%;" height="140px;"></div>
            <div class=" card-body">
                <p class="card-text ">Room ' . $result_room_booked['RoomNumber'] . '</p> 

                <p class="card-text ">' . $result_room_type['roomtype'] . '</p> 
                <p class="card-text "><span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
                <a href="reservation_add_input_details?R_roomid=' . $result_room_booked['RoomID'] . '" class="btn btn-success col">Reserve</a>
            </div>
        </div>
    </div>
    ';
                        echo $output;
                    }
                }
            }



            //end
        }
        ?>


    </div>



</div>
<!-- End Reservation tables -->



<?php
include('../Includes/scripts.php');
include('../Includes/footer.php');
?>

<script>
    $(document).ready(function() {


    });


    $(document).ready(function() {
        $("#flash-msg").delay(2000).fadeOut("slow");
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



    });
</script>