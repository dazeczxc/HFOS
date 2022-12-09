<?php
include('header.php');
?>


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





<section class="bg-gray-200 <?php echo $_SESSION['show']; ?> pt-5 " id="reservation">

    <div class="container  bg-gray-200 pt-5">

        <div class="px-3 pt-5 pb-5">

            <div class="row pt-5">
                <div class="col-lg-3"></div>

                <div class="pt-4 mt-3 px-4  col card shadow-sm">

                    <form method="POST" action="#" autocomplete="off">
                        <div class="row mb-3">
                            <?php
                            if (isset($_SESSION['ReservationMessage'])) {
                                echo $_SESSION['ReservationMessage'];
                                unset($_SESSION['ReservationMessage']);
                            }

                            ?>
                            <div class="col-lg-12 w3-center text-success pb-4 "><b style="font-size: 1.8rem;">Reservation</b></div>


                            <div class="col-sm-6 col-lg-6  mb-3 ">
                                <label>Arrival</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" id="toggle" class="input-group-text"><i class="fa fa-calendar-alt"></i></button>
                                    </div>
                                    <input type="text" class="col-sm-2 col-xl-12 form-control" name="Sarival" id="datetimepicker" placeholder="select date" required />
                                </div>
                            </div>




                            <div class="col-sm-6 col-lg-6  mb-3 ">
                                <label>Departure</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" id="toggle2" class="input-group-text"><i class="fa fa-calendar-alt"></i></button>
                                    </div>
                                    <input type="text" class="col-sm-2 col-xl-12 form-control" name="Sdeparture" id="datetimepicker2" placeholder="select date" required />
                                </div>
                            </div>



                        </div>

                        <div class="w3-center pb-4">
                            <button type="submit" name="btnSearchRoom" class="btn px-5 btn-success">Search Rooms</button>

                        </div>

                    </form>
                </div>

                <div class="col-lg-4"></div>
            </div>
        </div>
    </div>
    </section

    <section class="bg-gray-100" id="result">
        <div class="container pb-5">
                <div class=" row">



                    <?php
                    include('Includes/conn.php');

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
                        <div class="col-lg-12 w3-center  pt-2 pb-1 "></div>
                            <div class="alert alert-success w3-center">
                            <h4> Available room from ' . $Arrival . ' to ' . $Departure . ' </h4>
                        </div>
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

                                $query_t = "SELECT COUNT(Star) AS total FROM rating WHERE RoomID = $RoomType";
                                $run_query_t = mysqli_query($db, $query_t);                               
                                $row_sumt = mysqli_fetch_assoc($run_query_t);

                                if($row_sumt['total'] > 0){
                                    $query_sum = "SELECT SUM(Star) AS rating FROM rating WHERE RoomID = $RoomType";
                                    $run_query_sum = mysqli_query($db, $query_sum);
                                    $row_sum = mysqli_fetch_assoc($run_query_sum);

                                    $total = $row_sumt['total'];
                                    $total_rate = $row_sum['rating'];

                                    $rating = $total_rate/$total;
                                    
                                    $rounded = '<b>'.round($rating ,2).' / 5 <i class="fas fa-star star-warning mr-1 main_star"></i></b>';

                                }else{
                                    $rounded =' <i class="fas fa-star star-warning mr-1 main_star"></i> No Ratings ';

                                }
 

                                $output = '

                                        <div class="col-lg-3  pt-4">
                                            <div class="card shadow-sm">
 
                                                <div class="card-img-top"><img src="Upload/' . $result_room_queryR["RoomImage"] . '" alt="image" width="100%;" height="180px;"></div>
                                                <div class=" card-body">


                                                <div class=" text-center">
                                                    <h5 class="text-warning  mb-4">
                                                    '.$rounded.'
                                                    </h5>
                                                 </div>


                                                    <p class="card-text ">Room:  ' . $result_room_type['roomtype'] . '</p> 
                                                    <p class="card-text ">Rate:  <span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
                                                    <a href="'.$bookbtn.'?R_roomid=' . $result_room_queryR['RoomID'] . '" class="btn btn-success col">Book Now</a>
                                                </div>
                                            </div>
                                        </div>
                                                ';
                                echo $output;
                            }
                        }else{}



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

                                

                                $query_t = "SELECT COUNT(Star) AS total FROM rating WHERE RoomID = $rtype";
                                $run_query_t = mysqli_query($db, $query_t);                               
                                $row_sumt = mysqli_fetch_assoc($run_query_t);

                                if($row_sumt['total'] > 0){
                                    $query_sum = "SELECT SUM(Star) AS rating FROM rating WHERE RoomID = $rtype";
                                    $run_query_sum = mysqli_query($db, $query_sum);
                                    $row_sum = mysqli_fetch_assoc($run_query_sum);

                                    $total = $row_sumt['total'];
                                    $total_rate = $row_sum['rating'];

                                    $rating = $total_rate/$total;
                                    
                                    $rounded = '<b>'.round($rating ,2).' / 5 <i class="fas fa-star star-warning mr-1 main_star"></i></b>';

                                }else{
                                    $rounded =' <i class="fas fa-star star-warning mr-1 main_star"></i> No Ratings ';

                                }
 




                                $output = '

                                        <div class="col-lg-3  pt-4">
                                            <div class="card shadow-sm">
 
                                            
                                                <div class="card-img-top"><img src="Upload/' . $result_room_reserve["RoomImage"]. '" alt="image" width="100%;" height="180px;"></div>
                                                <div class=" card-body">


                                                <div class=" text-center">
                                                    <h5 class="text-warning  mb-4">
                                                    '.$rounded.'
                                                    </h5>
                                                 </div>

                                                    <p class="card-text ">Room:  ' . $result_room_type['roomtype'] . '</p> 
                                                    <p class="card-text ">Rate:  <span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
                                                    <a href="'.$bookbtn.'?R_roomid=' . $result_room_reserve['RoomID'] . '" class="btn btn-success col">Book Now</a>
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

                                                                            
                                                                        $query_t = "SELECT COUNT(Star) AS total FROM rating WHERE RoomID = $RoomType";
                                                                        $run_query_t = mysqli_query($db, $query_t);                               
                                                                        $row_sumt = mysqli_fetch_assoc($run_query_t);

                                                                        if($row_sumt['total'] > 0){
                                                                            $query_sum = "SELECT SUM(Star) AS rating FROM rating WHERE RoomID = $RoomType";
                                                                            $run_query_sum = mysqli_query($db, $query_sum);
                                                                            $row_sum = mysqli_fetch_assoc($run_query_sum);

                                                                            $total = $row_sumt['total'];
                                                                            $total_rate = $row_sum['rating'];

                                                                            $rating = $total_rate/$total;
                                                                            
                                                                            $rounded = '<b>'.round($rating ,2).' / 5 <i class="fas fa-star star-warning mr-1 main_star"></i></b>';

                                                                        }else{
                                                                            $rounded =' <i class="fas fa-star star-warning mr-1 main_star"></i> No Ratings ';

                                                                        }
                                                                            $output = '
                                    
                                                            <div class="col-lg-3  pt-4">
                                                                <div class="card shadow-sm">

                                                                <div class=" text-center">
                                                                    <h5 class="text-warning  mb-4">
                                                                    '.$rounded.'
                                                                    </h5>
                                                                </div>
                                     
                                                                    <div class="card-img-top"><img src="Upload/' . $result_room_queryR["RoomImage"] . '" alt="image" width="100%;" height="180px;"></div>
                                                                    <div class=" card-body">
                                                                        <p class="card-text ">Room:  ' . $result_room_type['roomtype'] . '</p> 
                                                                        <p class="card-text ">Rate:  <span>&#8369 </span>' . $result_room_type['roomprice'] . '.00 / Day</p>
                                                                        <a href="'.$bookbtn.'?R_roomid=' . $result_room_queryR['RoomID'] . '" class="btn btn-success col">Book Now</a>
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


                                            $query_t = "SELECT COUNT(Star) AS total FROM rating WHERE RoomID = $RoomType";
                                                                        $run_query_t = mysqli_query($db, $query_t);                               
                                                                        $row_sumt = mysqli_fetch_assoc($run_query_t);

                                                                        if($row_sumt['total'] > 0){
                                                                            $query_sum = "SELECT SUM(Star) AS rating FROM rating WHERE RoomID = $RoomType";
                                                                            $run_query_sum = mysqli_query($db, $query_sum);
                                                                            $row_sum = mysqli_fetch_assoc($run_query_sum);

                                                                            $total = $row_sumt['total'];
                                                                            $total_rate = $row_sum['rating'];

                                                                            $rating = $total_rate/$total;
                                                                            
                                                                            $rounded = '<b>'.round($rating ,2).' / 5 <i class="fas fa-star star-warning mr-1 main_star"></i></b>';

                                                                        }else{
                                                                            $rounded =' <i class="fas fa-star star-warning mr-1 main_star"></i> No Ratings ';

                                                                        }

                                            $output = '
        
                    <div class="col-lg-3  pt-4">
                        <div class="card shadow-sm">

                        <div class=" text-center">
                                                    <h5 class="text-warning  mb-4">
                                                    '.$rounded.'
                                                    </h5>
                                                 </div>
         
                            <div class="card-img-top"><img src="Upload/' . $result_room_query["RoomImage"] . '" alt="image" width="100%;" height="180px;"></div>
                            <div class=" card-body">
                                <p class="card-text ">Room:  ' . $result_room_type['roomtype'] . '</p> 
                                <p class="card-text ">Rate:  <span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
                                <a href="'.$bookbtn.'?R_roomid=' . $result_room_query['RoomID'] . '" class="btn btn-success col">Book Now</a>
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



                                    $query_t = "SELECT COUNT(Star) AS total FROM rating WHERE RoomID = $RoomType";
                                                                        $run_query_t = mysqli_query($db, $query_t);                               
                                                                        $row_sumt = mysqli_fetch_assoc($run_query_t);

                                                                        if($row_sumt['total'] > 0){
                                                                            $query_sum = "SELECT SUM(Star) AS rating FROM rating WHERE RoomID = $RoomType";
                                                                            $run_query_sum = mysqli_query($db, $query_sum);
                                                                            $row_sum = mysqli_fetch_assoc($run_query_sum);

                                                                            $total = $row_sumt['total'];
                                                                            $total_rate = $row_sum['rating'];

                                                                            $rating = $total_rate/$total;
                                                                            
                                                                            $rounded = '<b>'.round($rating ,2).' / 5 <i class="fas fa-star star-warning mr-1 main_star"></i></b>';

                                                                        }else{
                                                                            $rounded =' <i class="fas fa-star star-warning mr-1 main_star"></i> No Ratings ';

                                                                        }

                                    $output = '

                                        <div class="col-lg-3  pt-4">
                                            <div class="card shadow-sm">

                                            <div class=" text-center">
                                                    <h5 class="text-warning  mb-4">
                                                    '.$rounded.'
                                                    </h5>
                                                 </div>
 
                                                <div class="card-img-top"><img src="Upload/' . $result_room_booked["RoomImage"] . '" alt="image" width="100%;" height="180px;"></div>
                                                <div class=" card-body">
                                                    <p class="card-text ">Room:  ' . $result_room_type['roomtype'] . '</p> 
                                                    <p class="card-text ">Rate:  <span>&#8369 </span>' . $result_room_type['roomprice'] . '.00/Night</p>
                                                    <a href="'.$bookbtn.'?R_roomid=' . $result_room_booked['RoomID'] . '" class="btn btn-success col">Book Now</a>
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
    </section>

     



<?php
include('scripts.php');
include('footer.php');
?>

<script type="text/javascript">
    $(document).ready(function() {

        var minDate = new Date();
        minDate.setDate(minDate.getDate())
        
        var minDate2 = new Date();
        minDate2.setDate(minDate2.getDate()+1)

        $('#datetimepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: minDate,
        });

        $('#toggle').on('click', function() {
            $('#datetimepicker').datepicker('toggle')
        })




        $('#datetimepicker2').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: minDate2,
            showOtherMonths: true,
                    selectOtherMonths: true
        });

        $('#toggle2').on('click', function() {
            $('#datetimepicker2').datepicker('toggle')
        })



    });

    $(document).ready(function() {
        $("#flash-msg").delay(2000).fadeOut("slow");
    });
</script>