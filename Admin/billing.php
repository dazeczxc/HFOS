<?php

include('../Includes/header.php');
include('../Includes/navbar.php');

include('../Includes/conn_pdo.php');

$today = date("Y/m/d");
$time = date("h:i a");

$queryRoom = "SELECT * FROM rooms";
$statement = $connect->prepare($queryRoom);
$statement->execute();
$total_data = $statement->rowCount();
$result = $statement->fetchAll();

$total = $total_data;

//check in today
$queryC = "SELECT * FROM transaction WHERE Arrival = '$today'";
$statementC = $connect->prepare($queryC);
$statementC->execute();
$total_dataC = $statementC->rowCount();
$resultC = $statementC->fetchAll();

$totalC = $total_dataC;

//available rooms
$queryRoomV = "SELECT * FROM rooms WHERE RoomStatus = 'Vacant'";
$statementV = $connect->prepare($queryRoomV);
$statementV->execute();
$total_dataV = $statementV->rowCount();
$resultV = $statementV->fetchAll();

if ($total_dataV > 0) {
    $V = $total_dataV;
    $percentageV = ($V / $total) * 100;
}


//booked rooms
$queryRoomB = "SELECT * FROM rooms WHERE RoomStatus = 'Booked'";
$statementB = $connect->prepare($queryRoomB);
$statementB->execute();
$total_dataB = $statementB->rowCount();
$resultB = $statementB->fetchAll();

if ($total_dataB > 0) {
    $B = $total_dataB;
    $percentageB = ($B / $total) * 100;
}



//check out today
$queryRoomO = "SELECT * FROM recent_transaction WHERE Departure = '$today'";
$statementO = $connect->prepare($queryRoomO);
$statementO->execute();
$total_dataO = $statementO->rowCount();
$resultO = $statementO->fetchAll();




//reservations
$queryRoomR = "SELECT * FROM reservation WHERE ReservationStatus = 'Approved' ";
$statementR = $connect->prepare($queryRoomR);
$statementR->execute();
$total_dataR = $statementR->rowCount();
$resultR = $statementR->fetchAll();

//reservations today
$queryRoomA = "SELECT * FROM reservation WHERE ReservationStatus = 'Approved' AND TransactionDate = '$today'";
$statementA = $connect->prepare($queryRoomA);
$statementA->execute();
$total_dataA = $statementA->rowCount();
$resultA = $statementA->fetchAll();

if ($total_dataA > 0) {
    $A = $total_dataA;
    $percentageA = ($A / $total_dataR) * 100;
} else {
    $A = 0;
}


//recent transactions
$queryRecentT = "SELECT * FROM recent_transaction";
$statementRecentT = $connect->prepare($queryRecentT);
$statementRecentT->execute();
$total_dataRecentT = $statementRecentT->rowCount();
$resultRecentT = $statementRecentT->fetchAll();


//guest folio
$query_geust = "SELECT * FROM guest WHERE GuestID IN (SELECT GuestID FROM recent_transaction)";
$statement_guest = $connect->prepare($query_geust);
$statement_guest->execute();
$total_data_guest = $statement_guest->rowCount();
$result_guest = $statement_guest->fetchAll();

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="h3 mb-0 text-gray-800">Daily Report</h2>
        <div class="mr-3 d-flex">
             <div class="mr-3">
                <?php

                 $date = strtotime($today);
                
                echo date('l,  F d, Y', $date);
                ?>
                </div>
                <div id="runningTime"></div>
             
        </div>


    </div>

    <div class="row">

        <!-- Reservation -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 pt-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">Number of Reservation Today</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h4 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_dataA; ?>/<?php echo $total_dataR; ?></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-auto mr-3">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="pt-4">
                        <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#reserve_today">View details </a><br>

                        <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#reserve_all">View all reservation</a>

                        </p>

                    </div>
                </div>
            </div>
        </div>

        <!-- Vacant -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 pt-3 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">Number of Check ins today</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h4 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_dataC; ?>/<?php echo $total_dataB; ?></div>
                                </div>
                                <div class="col mr-4">
                                    <div class="progress progress-sm mr-">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentageB; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto mr-3">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>

                    <div class=" pt-4  ">
                        <p>
                            <a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#check_in_today">View details</a><br>
                            <a href="#" class="text-success " data-bs-toggle="modal" data-bs-target="#check_in_all">View all booked guest</a>

                        </p>

                    </div>

                </div>
            </div>
        </div>


        <!-- CHeck out -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100 pt-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">Number of Check out today</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h4 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_dataO;
                                                                                                ?></div>
                                </div>
                                <div class="col mr-4">

                                </div>
                            </div>
                        </div>
                        <div class="col-auto mr-3">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="pt-4">
                        <p>
                            <a href="#" class="text-warning" data-bs-toggle="modal" data-bs-target="#check_out_today">View details </a><br>
                        </p>

                    </div>

                </div>
            </div>
        </div>

        <!-- transactions -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 pt-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Number of All Transactions</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h4 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_dataRecentT; ?></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-auto mr-3">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="pt-4">
                        <a href="#" class="text-info" data-bs-toggle="modal" data-bs-target="#recent_transactions">View details </a><br>

                        </p>

                    </div>
                </div>
            </div>
        </div>


        <!-- GUest folio -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 pt-3 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">Guest Folio</div>

                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h4 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_data_guest; ?> </div>
                                </div>
                                <div class="col mr-4">

                                </div>
                            </div>
                        </div>
                        <div class="col-auto mr-3">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>

                    <div class=" pt-4  ">
                        <p>
                            <a href="#" class="text-success " data-bs-toggle="modal" data-bs-target="#guest_folio">View all Guest</a>

                        </p>

                    </div>

                </div>
            </div>
        </div>
        <!-- End of GUest folio -->

        <!-- reserve today -->
        <div class="modal fade" id="reserve_today" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  ">
                <div class="modal-content">
                    <div class="modal-header border-bottom-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Reserve Guest Today</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div style="max-height: 500px;
                    overflow: auto;
                    width: 100%;
                    display: inline-block;">
                        <table class="table table-hover " >
                         
                        <tr  class="bg-primary text-gray-100 " style="position: sticky; top: 0; z-index: 1;" >

                                <th class="d-none">RoomID</td>

                                <td>Name</td>
                                <td>Phone Number</td>
                                <td>Address</td>

                                <td>Room </td>
                                <td>Room Type</td>

                                <td>Arrival - Departure</td>
                            </tr>

                            <?php
                            if ($total_dataA > 0) {


                                foreach ($resultA as $reserve_today) {
                                    $guest_id = $reserve_today['GuestID'];
                                    $room_id = $reserve_today['RoomID'];

                                    $query_reserve_today = "SELECT * FROM guest WHERE GuestID = $guest_id";
                                    $statementreserve_today = $connect->prepare($query_reserve_today);
                                    $statementreserve_today->execute();
                                    $result_reserve_today = $statementreserve_today->fetchAll();
                                    foreach ($result_reserve_today as $row_guest) {
                                    }

                                    $query_reserve_room = "SELECT * FROM rooms WHERE RoomID = $room_id";
                                    $statementreserve_room = $connect->prepare($query_reserve_room);
                                    $statementreserve_room->execute();
                                    $result_reserve_room = $statementreserve_room->fetchAll();
                                    foreach ($result_reserve_room as $row_room) {
                                    }
                                    $roomtype = $row_room['RoomType'];

                                    $query_reserve_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = $roomtype";
                                    $statementreserve_roomtype = $connect->prepare($query_reserve_roomtype);
                                    $statementreserve_roomtype->execute();
                                    $result_reserve_roomtype = $statementreserve_roomtype->fetchAll();
                                    foreach ($result_reserve_roomtype as $row_roomtype) {
                                    }


                                    echo '
                                        <tr data-href="#" class="view_reservation" id=" " style="cursor: pointer">

                                             <td class="py-2">' . $row_guest['Name'] . '</td>
                                            <td class="py-2">' . $row_guest['PNumber'] . '</td>
                                            <td class="py-2">' . $row_guest['Address'] . '</td>
                                            <td class="py-2">' . $row_room['RoomNumber'] . '</td>
                                            <td class="py-2">' . $row_roomtype['roomtype'] . '</td>

                                            <td class="py-2">' . $reserve_today['Arrival'] . ' - ' . $reserve_today['Departure'] . '</td>
                              
                                        </tr>
                                    ';
                                }
                            } else {
                                echo '
                            <tr>
                            <td colspan="6" align="center">No Reservation Today</td>
                          </tr>
                            ';
                            }

                            ?>

                        </table>
                    </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- reserve todayl -->


        <!-- reserve all -->
        <div class="modal fade" id="reserve_all" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-bottom-primary">
                        <h5 class="modal-title" id="exampleModalLabel">All Reservations</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    <div style="max-height: 500px;
                    overflow: auto;
                    width: 100%;
                    display: inline-block;">
                        <table class="table table-hover " >
                         
                        <tr  class="bg-primary text-gray-100 " style="position: sticky; top: 0; z-index: 1;" >


                         
 
                                <td>Name</td>
                                <td>Phone Number</td>
                                <td>Address</td>
                                <td>Room </td>
                                <td>Room Type</td>
                                <td>Arrival - Departure</td>

                            </tr>

                            <?php
                            if ($total_dataR > 0) {


                                foreach ($resultR as $reserve_all) {
                                    $guest_id_all = $reserve_all['GuestID'];
                                    $room_id_all = $reserve_all['RoomID'];

                                    $query_reserve_all = "SELECT * FROM guest WHERE GuestID = $guest_id_all";
                                    $statementreserve_ALL = $connect->prepare($query_reserve_all);
                                    $statementreserve_ALL->execute();
                                    $result_reserve_ALL = $statementreserve_ALL->fetchAll();
                                    foreach ($result_reserve_ALL as $row_guest_ALL) {
                                    }

                                    $query_reserve_roomALL = "SELECT * FROM rooms WHERE RoomID = $room_id_all";
                                    $statementreserve_roomALL = $connect->prepare($query_reserve_roomALL);
                                    $statementreserve_roomALL->execute();
                                    $result_reserve_roomALL = $statementreserve_roomALL->fetchAll();
                                    foreach ($result_reserve_roomALL as $row_roomALL) {
                                    }

                                    $roomtypeAll = $row_roomALL['RoomType'];

                                    $query_reserve_roomtypeAll = "SELECT * FROM roomtype WHERE roomtypeid = $roomtypeAll";
                                    $statementreserve_roomtypeAll = $connect->prepare($query_reserve_roomtypeAll);
                                    $statementreserve_roomtypeAll->execute();
                                    $result_reserve_roomtypeAll = $statementreserve_roomtypeAll->fetchAll();
                                    foreach ($result_reserve_roomtypeAll as $row_roomtypeAll) {
                                    }


                                    echo '
                                        <tr data-href="#" class="view_reservation" id=" " style="cursor: pointer">

                                             <td class="py-2">' . $row_guest_ALL['Name'] . '</td>
                                            <td class="py-2">' . $row_guest_ALL['PNumber'] . '</td>
                                            <td class="py-2">' . $row_guest_ALL['Address'] . '</td>
                                            <td class="py-2">' . $row_roomALL['RoomNumber'] . '</td>
                                            <td class="py-2">' . $row_roomtypeAll['roomtype'] . '</td>

                                            <td class="py-2">' . $reserve_all['Arrival'] . ' - ' . $reserve_all['Departure'] . '</td>
                              
                                        </tr>
                                    ';
                                }
                            } else {
                                echo '
                            <tr>
                            <td colspan="6" align="center">No Reservation</td>
                          </tr>
                            ';
                            }
                            ?>

                        </table>
                    </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- End Add Modal -->

        <!-- check in today -->
        <div class="modal fade" id="check_in_today" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl ">
                <div class="modal-content">
                    <div class="modal-header border-bottom-success">
                        <h5 class="modal-title" id="exampleModalLabel">Check In Today</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div style="max-height: 500px;
                    overflow: auto;
                    width: 100%;
                    display: inline-block;">
                        <table class="table table-hover " >
                         
                        <tr  class="  text-gray-100 " style="position: sticky; top: 0; z-index: 1; background: linear-gradient(225deg, #20cc8a,#4adda5);" >


                                 <th class="d-none">RoomID</td>
                                <td>Room </td>
                                <td>Room Type</td>
                                <td>Name</td>
                                <td>Phone Number</td>
                                <td>Issued by</td>
                                <td>Arrival - Departure</td>
                            </tr>

                            <?php
                            if ($total_dataC > 0) {
                                foreach ($resultC as $checkin_today) {
                                    $guesttrand_id = $checkin_today['GuestID'];
                                    $roomtrans_id = $checkin_today['RoomID'];

                                    $query_trans_today = "SELECT * FROM guest WHERE GuestID = $guesttrand_id";
                                    $statementrans_today = $connect->prepare($query_trans_today);
                                    $statementrans_today->execute();
                                    $result_trans_today = $statementrans_today->fetchAll();
                                    foreach ($result_trans_today as $row_trans_guest) {
                                    }

                                    $query_trans_room = "SELECT * FROM rooms WHERE RoomID = $roomtrans_id";
                                    $statementtrans_room = $connect->prepare($query_trans_room);
                                    $statementtrans_room->execute();
                                    $result_trans_room = $statementtrans_room->fetchAll();
                                    foreach ($result_trans_room as $row_transroom) {
                                    }
                                    $trans_roomtype = $row_transroom['RoomType'];

                                    $query_trans_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = $trans_roomtype";
                                    $statementrans_roomtype = $connect->prepare($query_trans_roomtype);
                                    $statementrans_roomtype->execute();
                                    $result_trans_roomtype = $statementrans_roomtype->fetchAll();
                                    foreach ($result_trans_roomtype as $row_trans_roomtype) {
                                    }


                                    echo '
                                        <tr data-href="#" class="view_reservation" id=" " style="cursor: pointer">
                                            <td class="py-2">' . $row_transroom['RoomNumber'] . '</td>
                                            <td class="py-2">' . $row_trans_roomtype['roomtype'] . '</td>
                                             <td class="py-2">' . $row_trans_guest['Name'] . '</td>
                                            <td class="py-2">' . $row_trans_guest['PNumber'] . '</td>
                                            <td class="py-2">' . $checkin_today['TransactBy'] . '</td>
                                            <td class="py-2">' . $checkin_today['Arrival'] . ' - ' . $checkin_today['Departure'] . '</td>
                              
                                        </tr>
                                    ';
                                }
                            } else {
                                echo '
                            <tr>
                                <td colspan="6" align="center">No Check In Today</td>
                            </tr>
                            ';
                            }

                            ?>

                        </table>
                    </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- check in todayl -->

        <!-- check in all -->
        <div class="modal fade" id="check_in_all" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-bottom-success">
                        <h5 class="modal-title" id="exampleModalLabel">Active Check Ins</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div style="max-height: 500px;
                    overflow: auto;
                    width: 100%;
                    display: inline-block;">
                        <table class="table table-hover " >
                         
                        <tr  class="  text-gray-100 " style="position: sticky; top: 0; z-index: 1; background: linear-gradient(225deg, #20cc8a,#4adda5);" >


                                <th class="d-none">RoomID</td>
                                <td>Room </td>
                                <td>Room Type</td>
                                <td>Name</td>
                                <td>Phone Number</td>
                                <td>Issued by</td>
                                <td>Arrival - Departure</td>
                                <td>Total Rates</td>

                            </tr>

                            <?php

                            $querytrans = "SELECT * FROM transaction ORDER BY RoomID";
                            $statementrans = $connect->prepare($querytrans);
                            $statementrans->execute();
                            $total_data_trans = $statementrans->rowCount();
                            $resultrans = $statementrans->fetchAll();

                            if ($total_data_trans > 0) {


                                foreach ($resultrans as $checkin_all) {
                                    $guestall_id = $checkin_all['GuestID'];
                                    $roomtall_id = $checkin_all['RoomID'];

                                    $query_all_room = "SELECT * FROM rooms WHERE RoomID = '$roomtall_id'";
                                    $statementall_room = $connect->prepare($query_all_room);
                                    $statementall_room->execute();
                                    $result_all_room = $statementall_room->fetchAll();
                                    foreach ($result_all_room as $row_allroom) {
                                    }

                                    $query_trans_all = "SELECT * FROM guest WHERE GuestID = $guestall_id";
                                    $statementrans_all = $connect->prepare($query_trans_all);
                                    $statementrans_all->execute();
                                    $result_trans_all = $statementrans_all->fetchAll();
                                    foreach ($result_trans_all as $row_all_guest) {
                                    }



                                    $all_roomtype = $row_allroom['RoomType'];

                                    $query_all_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = $all_roomtype";
                                    $statemenall_roomtype = $connect->prepare($query_all_roomtype);
                                    $statemenall_roomtype->execute();
                                    $result_all_roomtype = $statemenall_roomtype->fetchAll();
                                    foreach ($result_all_roomtype as $row_all_roomtype) {
                                    }


                                    echo '
                                        <tr data-href="#" class="view_reservation" id=" " style="cursor: pointer">
                                            <td class="py-2">' . $row_allroom['RoomNumber'] . '</td>
                                            <td class="py-2">' . $row_all_roomtype['roomtype'] . '</td>
                                             <td class="py-2">' . $row_all_guest['Name'] . '</td>
                                            <td class="py-2">' . $row_all_guest['PNumber'] . '</td>
                                            <td class="py-2">' . $checkin_all['TransactBy'] . '</td>                                           
                                            <td class="py-2">' . $checkin_all['Arrival'] . ' - ' . $checkin_all['Departure'] . '</td>
                                            <td class="py-2">' . $checkin_all['TotalRates'] . '</td>

                                        </tr>
                                    ';
                                }
                            } else {
                                echo '
                            <tr>
                                <td colspan="7" align="center">No Active Transaction</td>
                            </tr>
                            ';
                            }
                            ?>

                        </table>
                    </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- check in all -->

        <!-- check out today  for edit up to check out all-->
        <div class="modal fade" id="check_out_today" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl ">
                <div class="modal-content">
                    <div class="modal-header border-bottom-warning">
                        <h5 class="modal-title" id="exampleModalLabel">Check Out Guest Today</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                 

                    <div class="modal-body">
                    <div style="max-height: 500px;
                    overflow: auto;
                    width: 100%;
                    display: inline-block;">
                        <table class="table table-hover " >
                         
                        <tr  class="bg-warning  text-gray-100 " style="position: sticky; top: 0; z-index: 1;" >

                                <th class="d-none">RoomID</td>

                                <td>Name</td>
                                <td>Phone Number</td>
                                <td>Issued by</td>

                                <td>Room </td>
                                <td>Room Type</td>

                                <td>Arrival - Departure</td>
                                <td>Total Rates </td>

                            </tr>

                            <?php
                            if ($total_dataO > 0) {
                                foreach ($resultO as $checkout_today) {
                                    $guest = $checkout_today['TransactionCode'];
                                    $room = $checkout_today['RoomID'];

                                    $query_trans_today = "SELECT * FROM recent_guest WHERE TransactionCode = $guest";
                                    $statementrans_today = $connect->prepare($query_trans_today);
                                    $statementrans_today->execute();
                                    $result_trans_today = $statementrans_today->fetchAll();
                                    foreach ($result_trans_today as $row_trans_guest) {
                                    }

                                    $query_trans_room = "SELECT * FROM rooms WHERE RoomID = $room";
                                    $statementtrans_room = $connect->prepare($query_trans_room);
                                    $statementtrans_room->execute();
                                    $result_trans_room = $statementtrans_room->fetchAll();
                                    foreach ($result_trans_room as $row_transroom) {
                                    }
                                    $trans_roomtype = $row_transroom['RoomType'];

                                    $query_trans_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = $trans_roomtype";
                                    $statementrans_roomtype = $connect->prepare($query_trans_roomtype);
                                    $statementrans_roomtype->execute();
                                    $result_trans_roomtype = $statementrans_roomtype->fetchAll();
                                    foreach ($result_trans_roomtype as $row_trans_roomtype) {
                                    }


                                    echo '
                                        <tr data-href="#" class="view_reservation" id=" " style="cursor: pointer">

                                             <td class="py-2">' . $row_trans_guest['Name'] . '</td>
                                            <td class="py-2">' . $row_trans_guest['PNumber'] . '</td>
                                            <td class="py-2">' . $checkout_today['TransactBy'] . '</td>

                                             <td class="py-2">' . $row_transroom['RoomNumber'] . '</td>
                                            <td class="py-2">' . $row_trans_roomtype['roomtype'] . '</td>

                                            <td class="py-2">' . $checkout_today['Arrival'] . ' - ' . $checkout_today['Departure'] . '</td>
                                            <td class="py-2">' . $checkout_today['TotalRates'] . '</td>

                                        </tr>
                                    ';
                                }
                            } else {
                                echo '
                                <tr>
                                    <td colspan="7" align="center">No Check Out for Today</td>

                                </tr>
                                ';
                            }
                            ?>

                        </table>
                    </div>  
                    </div>


                </div>
            </div>
        </div>
        <!-- check out todayl -->


        <!-- recent transactions -->
        <div class="modal fade" id="recent_transactions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-lg-end">

                            <div class="col-md-3">
                                <label for="inputPassword4" class="form-label">Select Date</label>
                                <input type="date" name="search_date" id="search_date" class="form-control" placeholder="Select Date">
                            </div>
                            <!--
                            <div class="col-md-3">
                                <label for="inputPassword4" class="form-label">Select Week</label>
                                <input type="text" name="search_week" id="search_week" class="form-control" placeholder="Select Week">
                            </div>
                            -->

                            <div class="col-md-4">
                                <label for="inputPassword4" class="form-label">Select Month</label>
                                <input type="month" name="search_month" id="search_month" class="form-control">
                            </div>

                            <div class="col-md-7">
                                 
                            </div>

                            <div class="col-md-4 ">
                                 <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Search..." />

                            </div>

                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <div id="all_transactions">

                        </div>

                    </div>
                    <div class="modal-footer">
                    <a href="export_new.php" class="btn btn-info" target="_blank">Export Data</a>

                    </div>


                </div>
            </div>
        </div>
        <!--  end recent transactions-->

        <!-- guest folio -->
        <div class="modal fade" id="guest_folio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  ">
                <div class="modal-content">

                    <div class=" px-3 py-3 border-bottom-success">
                        <div class="d-flex justify-content-lg-between">
                            <h5 class="modal-title" id="exampleModalLabel">Guest Folio</h5>
                            <div class="d-flex justify-content-lg-end">

                            <input type="text" name="search_box_guest" id="search_box_guest" class="mr-4 w3-right form-control" placeholder="Search..." />
                            <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>
                            
                        </div>
                        
                 
                    </div>
                                    
                


                    <div class="modal-body">
                        <div id="guest_folio_details"></div>
                    </div>

                   


                </div>
            </div>
        </div>
        <!-- end guest folio-->

        <!-- View guest Details Modal -->
        <div id="view_guest_modal_OL" class="modal fade border-success" tabindex="-1" aria-labelledby="view_details_modal_OL" aria-hidden="true">
            <div class="modal-dialog modal-xl ">
                <div class="modal-content ">

                    <div id="guest_detail">
                    </div>



                </div>
            </div>
        </div>
        <!-- End of View Details Modal -->


        <?php
        include('../Includes/scripts.php');
        include('../Includes/footer.php');
        ?>

        <script>
            $(document).ready(function() {

                 

                $('#search_date1').datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true
                    
                });

                $('#search_week').datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    showWeek: true,
                    showOtherMonths: true,
                    onSelect: function (selectedDate, instance) {
                        $('#search_week').val("");
                        var month = $.datepicker.iso8601Week(new Date(selectedDate));
                        var date = new Date(selectedDate);
                        var year = date.getFullYear();

                        $('#search_week').val("'"+ selectedDate +"'");
        }
                    
                });

                 
                

                load_data1(1);

                function load_data1(page, query = '') {
                    $.ajax({
                        url: "fetch_guest_folio.php",
                        method: "POST",
                        data: {
                            page: page,
                            query: query,
                        },
                        success: function(data) {
                            $('#guest_folio_details').html(data);
                        }
                    });
                }

                $(document).on('click', '.page-link', function() {
                    var page = $(this).data('page_number');
                    var query = $('#search_box_guest').val();

                    load_data1(page, query);
                });


                $('#search_box_guest').keyup(function() {
                    var query = $('#search_box_guest').val();
                    load_data1(1, query);

                });


                $(document).on('click', '.view_guest', function() {
                    var guest_ID = $(this).attr("id");
                    if (guest_ID != '') {
                        $.ajax({
                            url: "guest_folio_details.php",
                            method: "POST",
                            data: {
                                guest_ID: guest_ID
                            },
                            success: function(data) {
                                $('#guest_detail').html(data);
                                $('#view_guest_modal_OL').modal('show');
                            }
                        });
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {

                load_data(1);

                function load_data(page, query = '') {
                    $.ajax({
                        url: "fetch_report_transactions.php",
                        method: "POST",
                        data: {
                            page: page,
                            query: query,
                        },
                        success: function(data) {
                            $('#all_transactions').html(data);
                        }
                    });
                }

                $(document).on('click', '.page-link', function() {
                    var page = $(this).data('page_number');
                    var query = $('#search_box ').val();

                    load_data(page, query);
                });


                $('#search_box ').keyup(function() {
                    var query = $('#search_box ').val();
                    load_data(1, query);

                });

                $('#search_date ').change(function() {
                    var query = $('#search_date ').val();
                    load_data(1, query);

                });

                $('#search_date ').keyup(function() {
                    var query = $('#search_date ').val();
                    load_data(1, query);

                });

                $('#search_week ').change(function() {
                    var query = $('#search_week ').val();
                    load_data(1, query);

                });

                $('#search_week ').keyup(function() {
                    var query = $('#search_week ').val();
                    load_data(1, query);

                });

                $('#search_month').change(function() {
                    var query = $('#search_month').val();
                    load_data(1, query);

                });


                


            });
        </script>
        <script type="text/javascript">
$(document).ready(function() {
 setInterval(runningTime, 1000);
});
function runningTime() {
  $.ajax({
    url: 'timeScript.php',
    success: function(data) {
       $('#runningTime').html(data);
     },
  });
}
</script>