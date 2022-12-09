<?php

include('../Includes/header.php');
include('../Includes/staff_navbar.php');

include('../Includes/conn_pdo.php');

$today = date("Y/m/d");
$time = date("h:i a");

$queryRoom = "SELECT * FROM rooms";
$statement = $connect->prepare($queryRoom);
$statement->execute();
$total_data = $statement->rowCount();
$result = $statement->fetchAll();

$total = $total_data;

//goods
$queryRoomV = "SELECT * FROM rooms WHERE RoomStatus = 'Vacant'";
$statementV = $connect->prepare($queryRoomV);
$statementV->execute();
$total_dataV = $statementV->rowCount();
$resultV = $statementV->fetchAll();

if($total_dataV>0){
  $V = $total_dataV;
  $percentageV = ($V / $total) * 100;
}


//goods
$queryRoomB = "SELECT * FROM rooms WHERE RoomStatus = 'Booked'";
$statementB = $connect->prepare($queryRoomB);
$statementB->execute();
$total_dataB = $statementB->rowCount();
$resultB = $statementB->fetchAll();

if($total_dataB>0){
  $B = $total_dataB;
  $percentageB = ($B / $total) * 100;
}



//goods
$queryRoomO = "SELECT * FROM transaction WHERE Departure = '$today'";
$statementO = $connect->prepare($queryRoomO);
$statementO->execute();
$total_dataO = $statementO->rowCount();
$resultO = $statementO->fetchAll();

if($total_dataO>0){
  $O = $total_dataO;
  $percentageO = ($O / $B) * 100;
}


//goods
$queryRoomR = "SELECT * FROM reservation WHERE ReservationStatus = 'Approved'";
$statementR = $connect->prepare($queryRoomR);
$statementR->execute();
$total_dataR = $statementR->rowCount();
$resultR = $statementR->fetchAll();

$queryRoomA = "SELECT * FROM reservation WHERE ReservationStatus = 'Approved' AND Arrival = '$today'";
$statementA = $connect->prepare($queryRoomA);
$statementA->execute();
$total_dataA = $statementA->rowCount();
$resultA = $statementA->fetchAll();

if($total_dataA > 0){
  $A = $total_dataA;
  $percentageA = ($A / $total_dataR) * 100;
}else{
  $A = 0;
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h2 class="h3 mb-0 text-gray-800">Hotel Front Office System</h2>
    <div class="mr-3 d-flex">
             <div class="mr-3">
                <?php
                $today = date('Y-m-d');

                 $date = strtotime($today);
                
                echo date('l,  F d, Y', $date);
                ?>
                </div>
                <div id="runningTime"></div>
             
        </div>


  </div>

  <div class="row">


    <!-- Vacant -->
    <div class="col-xl-3 col-md-6 mb-4">
    <a href="booking" role="button" class=" " style="text-decoration: none;">

      <div class="card border-left-success shadow h-100 py-3 ">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vacant Rooms</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_dataV;
                                                                            echo "/";
                                                                            echo $total_data; ?></div>
                </div>
                <div class="col mr-4">
                  <div class="progress progress-sm mr-">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentageV; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                   <span class="text-success">Available</span><br>
                <?php 
                
                foreach($resultV as $row){
                  $rtype = $row['RoomType'];
                  $queryRoomtype = "SELECT * FROM roomtype WHERE roomtypeid = $rtype";
                  $statement = $connect->prepare($queryRoomtype);
                  $statement->execute();
                  $resulttype = $statement->fetchAll();
                  foreach($resulttype as $rowtype){
                    echo $row['RoomNumber'].' - '.$rowtype['roomtype'].'  <br>';

                  }
                }

                ?>
                </p>
                
              </div>
          
        </div>
      </div>
      </a>
    </div>
    

    <!-- Reservation -->
    <div class="col-xl-3 col-md-6 mb-4">
    <a href="reservation" role="button" class=" " style="text-decoration: none;">

      <div class="card border-left-primary shadow h-100 py-3">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Reservation</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_dataR; ?></div>
                </div>
                 
              </div>
            </div>
            <div class="col-auto mr-3">
              <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
            </div>
          </div>
          <div class="pt-4">
                <p><span class="text-primary">Reserve Rooms</span><br>
                <?php 

                  $queryRooms = "SELECT * FROM rooms WHERE RoomID IN(SELECT RoomID FROM reservation WHERE ReservationStatus = 'Approved')";
                  $statementx = $connect->prepare($queryRooms);
                  $statementx->execute();
                  $total_datax = $statementx->rowCount();
                  $resultx = $statementx->fetchAll();
                
                  if($total_datax > 0){
                    foreach($resultx as $row){
                      $rtype = $row['RoomType'];
                      $queryRoomtype = "SELECT * FROM roomtype WHERE roomtypeid = $rtype";
                      $statement = $connect->prepare($queryRoomtype);
                      $statement->execute();
                      $resulttype = $statement->fetchAll();
                      foreach($resulttype as $rowtype){
                        echo $row['RoomNumber'].' - '.$rowtype['roomtype'].'  <br>';
                      }
                      }
                    }
                ?>
                </p>
              
              </div>
        </div>
      </div>
    </a>
    </div>

    <!-- Arrival -->
    <div class="col-xl-3 col-md-6 mb-4">
    <a href="reservation" role="button" class=" " style="text-decoration: none;">

      <div class="card border-left-info shadow h-100 py-3">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Arriving Today</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $A;
                                                                            echo "/";
                                                                            echo $total_dataR; ?></div>
                </div>
                <div class="col mr-4">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $percentageA; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto mr-3">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>

          <div class="pt-4">
              <p><span class="text-info">Arriving Guest</span><br>
                <?php 

                  $queryRooms = "SELECT * FROM reservation WHERE ReservationStatus = 'Approved' AND   Arrival = '$today'";
                  $statementx = $connect->prepare($queryRooms);
                  $statementx->execute();
                  $total_datax = $statementx->rowCount();
                  $resultx = $statementx->fetchAll();
                
                  if($total_datax > 0){
                    foreach($resultx as $row){
                      $TCODE = $row['TransactionCode'];

                      $queryRoomss = "SELECT * FROM recent_guest WHERE TransactionCode = $TCODE";
                      $statementss = $connect->prepare($queryRoomss);
                      $statementss->execute();
                      $resultss = $statementss->fetchAll();

                      foreach($resultss as $rowss){
                        $RID = $rowss['RoomID'];

                        $queryRoomsss = "SELECT * FROM rooms WHERE RoomID = $RID";
                        $statementsss = $connect->prepare($queryRoomsss);
                        $statementsss->execute();
                        $resultsss = $statementsss->fetchAll();
                        foreach($resultsss as $rowsss){
                        }
                        echo $rowsss['RoomNumber'].' - '.$rowss['Name'].'  <br>';

                      }
                    }

                  }
                ?>


                </p>
                
              </div>

        </div>
      </div>
    </a>
    </div>

    <!-- CHeck out -->
    <div class="col-xl-3 col-md-6 mb-4">
    <a href="booking" role="button" class=" " style="text-decoration: none;">

      <div class="card border-left-warning shadow h-100 py-3">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Need to Checkout today</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_dataO;
                                                                            echo "/";
                                                                            echo $total_dataB; ?></div>
                </div>
                <div class="col mr-4">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentageO; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto mr-3">
              <i class="fas fa-check fa-2x text-gray-300"></i>
            </div>
          </div>
          <div class="pt-4">
              <p><span class="text-warning">Check Out today</span><br>
                <?php 

                  $queryRooms = "SELECT * FROM transaction WHERE departure = '$today'";
                  $statementx = $connect->prepare($queryRooms);
                  $statementx->execute();
                  $total_datax = $statementx->rowCount();
                  $resultx = $statementx->fetchAll();
                
                  if($total_datax > 0){
                    foreach($resultx as $row){
                      $TCODE = $row['TransactionCode'];

                      $queryRoomss = "SELECT * FROM recent_guest WHERE TransactionCode = $TCODE";
                      $statementss = $connect->prepare($queryRoomss);
                      $statementss->execute();
                      $resultss = $statementss->fetchAll();

                      foreach($resultss as $rowss){
                        $RID = $rowss['RoomID'];

                        $queryRoomsss = "SELECT * FROM rooms WHERE RoomID = $RID";
                        $statementsss = $connect->prepare($queryRoomsss);
                        $statementsss->execute();
                        $resultsss = $statementsss->fetchAll();
                        foreach($resultsss as $rowsss){
                        }
                        echo $rowsss['RoomNumber'].' - '.$rowss['Name'].'  <br>';

                      }
                    }
                  }

                ?>

                </p>
                
              </div>
          
        </div>
      </div>
    </a>
    </div>




    
    <!-- Available Rooms 
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-3 ">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class=" h5 text-success   mb-2">Available Rooms</div>
              <div class="row no-gutters align-items-center">
                <p>
                <?php 
                
                foreach($resultV as $row){
                  $rtype = $row['RoomType'];
                  $queryRoomtype = "SELECT * FROM roomtype WHERE roomtypeid = $rtype";
                  $statement = $connect->prepare($queryRoomtype);
                  $statement->execute();
                  $resulttype = $statement->fetchAll();
                  foreach($resulttype as $rowtype){
                    echo $row['RoomNumber'].' - '.$rowtype['roomtype'].'  <br>';

                  }
                }
                
                
                ?>


                </p>
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
-->

    <!-- Reserve Rooms 
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-3 ">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class=" h5 text-primary   mb-2">Reserve Rooms</div>
              <div class="row no-gutters align-items-center">
                <p>
                <?php 

                  $queryRooms = "SELECT * FROM rooms WHERE RoomID IN(SELECT RoomID FROM reservation WHERE ReservationStatus = 'Approved')";
                  $statementx = $connect->prepare($queryRooms);
                  $statementx->execute();
                  $total_datax = $statementx->rowCount();
                  $resultx = $statementx->fetchAll();
                
                  if($total_datax > 0){
                    foreach($resultx as $row){
                      echo $row['RoomNumber'].' - '.$row['RoomType'].'  <br>';

                    }
                  }else{
                    
                  }

                ?>

                </p>
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
-->

    <!-- Arriving today 
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-3 ">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class=" h5 text-info   mb-2">Arriving Guest</div>
              <div class="row no-gutters align-items-center">
                <p>
                <?php 

                  $queryRooms = "SELECT * FROM reservation WHERE ReservationStatus = 'Approved' AND   Arrival = '$today'";
                  $statementx = $connect->prepare($queryRooms);
                  $statementx->execute();
                  $total_datax = $statementx->rowCount();
                  $resultx = $statementx->fetchAll();
                
                  if($total_datax > 0){
                    foreach($resultx as $row){
                      $TCODE = $row['TransactionCode'];

                      $queryRoomss = "SELECT * FROM recent_guest WHERE TransactionCode = $TCODE";
                      $statementss = $connect->prepare($queryRoomss);
                      $statementss->execute();
                      $resultss = $statementss->fetchAll();

                      foreach($resultss as $rowss){
                        $RID = $rowss['RoomID'];

                        $queryRoomsss = "SELECT * FROM rooms WHERE RoomID = $RID";
                        $statementsss = $connect->prepare($queryRoomsss);
                        $statementsss->execute();
                        $resultsss = $statementsss->fetchAll();
                        foreach($resultsss as $rowsss){
                        }
                        echo $rowsss['RoomNumber'].' - '.$rowss['TransactionCode'].'  <br>';

                      }

                    }

                  }else{
                    
                  }

                ?>


                </p>
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
-->

    <!-- Departure today 
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-3 ">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class=" h5 text-warning   mb-2">Check Out</div>
              <div class="row no-gutters align-items-center">
                <p>
                <?php 

                  $queryRooms = "SELECT * FROM transaction WHERE departure = '$today'";
                  $statementx = $connect->prepare($queryRooms);
                  $statementx->execute();
                  $total_datax = $statementx->rowCount();
                  $resultx = $statementx->fetchAll();
                
                  if($total_datax > 0){
                    foreach($resultx as $row){
                      $TCODE = $row['TransactionCode'];

                      $queryRoomss = "SELECT * FROM recent_guest WHERE TransactionCode = $TCODE";
                      $statementss = $connect->prepare($queryRoomss);
                      $statementss->execute();
                      $resultss = $statementss->fetchAll();

                      foreach($resultss as $rowss){
                        $RID = $rowss['RoomID'];

                        $queryRoomsss = "SELECT * FROM rooms WHERE RoomID = $RID";
                        $statementsss = $connect->prepare($queryRoomsss);
                        $statementsss->execute();
                        $resultsss = $statementsss->fetchAll();
                        foreach($resultsss as $rowsss){
                        }
                        echo $rowsss['RoomNumber'].' - '.$row['Arrival'].'  <br>';

                      }

                    }

                  }else{
                    
                  }

                ?>


                </p>
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
-->



<?php
include('../Includes/scripts.php');
include('../Includes/footer.php');
?>


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

