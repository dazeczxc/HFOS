<?php

include('../Includes/conn_pdo.php');
include('../Includes/conn.php');


$limit = '7';
$page = 1;
if($_POST['page'] > 1)
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}

$Accom = "Online Reservation";
$Accom2 = "Reservation";



$query = "
SELECT * FROM reservation  WHERE ReservationStatus != 'CheckOut' AND  ReservationStatus != 'Denied' AND ReservationStatus != 'CheckIn' 
";

if($_POST['query'] != '')
{
  $query .= '
  && ReservationStatus != "Denied" && TransactionCode LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ||
  TransactionCode IN (SELECT TransactionCode FROM recent_guest WHERE 
  Name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%") || RoomID IN (SELECT RoomID FROM rooms WHERE RoomNumber LIKE "%'.str_replace(' ', '%', $_POST['query']).'%")

  ';
  
}
$query .= 'ORDER BY Arrival ASC ';


$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '
<div style="max-height: 530px;
overflow: auto;
width: 100%;
 display: inline-block;">
<table class="table table-hover " >
 
<tr  class="bg-info text-gray-100 " style="position: sticky; top: 0; z-index: 1; background: linear-gradient(225deg, #20cc8a,#4adda5);" >

  <td class="d-none">RoomID</td>
  <td >Transaction Code</td>
  <td >Pax</td>
  <td >Name</td>
   <td>Room</td>
   <td>Arrival</td>
  <td>Departure</td>
  <td>Status</td>
  </tr>
  
';
if($total_data > 0)
{
  foreach($result as $row)
  {

    $Roomid =  $row['RoomID'];
    $Tid =  $row['TransactionCode'];
    $Reserve_Status =  $row['ReservationStatus'];
    $Accommodationtype =  $row['Accommodationtype'];

    //date format
    $from = $row['Arrival'];
    $to = $row['Departure'];

    $Arrival = strtotime($from);
    $Arrival2 = date('M d, Y', $Arrival);

    $Departure = strtotime($to);
    $Departure2 = date('M d, Y', $Departure);

        $stmt = $connect->prepare("SELECT * FROM recent_guest WHERE TransactionCode = '$Tid'");
        $stmt->execute();
        $row_guest = $stmt->fetchAll();
        foreach($row_guest as $rowG){}


        $stmt2 = $connect->prepare("SELECT * FROM rooms WHERE RoomID = $Roomid");
        $stmt2->execute();
        $row_room = $stmt2->fetchAll();
          foreach($row_room as $rowR){
            $type=$rowR["RoomType"];

            $sql = "SELECT * FROM roomtype WHERE roomtypeid = $type";
            $run_sql = mysqli_query($db, $sql);
            $rtype = mysqli_fetch_assoc($run_sql);



          }

        
          if($Reserve_Status == "Pending"){

            $buttons = '
            <tr data-href="#" class="view_OL table-warning w3-text-teal" id="'.$Tid.'" style="cursor: pointer">

                  <td class="d-none">'.$row["TransactionID"].'</td>
                  <td class="py-2 ">'.$row["TransactionCode"].'</td>
                  <td class="py-2 ">'.$rowG["GuestNumber"].'</td>
                  <td class="py-2">'.$rowG['Name'].'</td>
                   <td class="py-2">'.$rowR['RoomNumber'].' - '.$rtype['roomtype'].'</td>
                   <td class="py-2">'.$Arrival2.'</td>
                  <td class="py-2">'.$Departure2.'</td>
                  <td class="py-2 text-warning"><b>Pending</b></td>
                </tr>
          ';

          }elseif($Reserve_Status == "Approved" && $Accommodationtype == $Accom){

            $buttons = '
             <tr data-href="#" class="view_reservation table-info text-gray-700" id="'.$Tid.'" style="cursor: pointer">

                  <td class="d-none">'.$row["TransactionID"].'</td>
                  <td class="py-2 ">'.$row["TransactionCode"].'</td>
                  <td class="py-2 ">'.$rowG["GuestNumber"].'</td>

                  <td class="py-2">'.$rowG['Name'].'</td>
                  <td class="py-2">'.$rowR['RoomNumber'].' - '.$rtype['roomtype'].'</td>
                  <td class="py-2">'.$Arrival2.'</td>
                  <td class="py-2">'.$Departure2.'</td>
                  <td class="py-2 text-success"><b>Confirmed</b></td>

                </tr>
                
            ';

          }elseif($Reserve_Status == "Approved" && $Accommodationtype == $Accom2){

            $buttons = '
             <tr data-href="#" class="view_reservation" id="'.$Tid.'" style="cursor: pointer">

                  <td class="d-none">'.$row["TransactionID"].'</td>
                  <td class="py-2 ">'.$row["TransactionCode"].'</td>
                  <td class="py-2 ">'.$rowG["GuestNumber"].'</td>

                  <td class="py-2">'.$rowG['Name'].'</td>
                  <td class="py-2">'.$rowR['RoomNumber'].' - '.$rtype['roomtype'].'</td>
                  <td class="py-2">'.$Arrival2.'</td>
                  <td class="py-2">'.$Departure2.'</td>
                  <td class="py-2 text-success"><b>Confirmed</b></td>
 
                </tr>
                
            ';

          }else{
            $buttons = '';
          }


          $output .= '
                <tbody class="table-sm  ">
                '.$buttons.'
                      ';
       

    
  }
}
else
{
  $output .= '
  <tr>
    <td colspan="8" align="center">No Reservations</td>
  </tr>
  </tbody>
  ';
}

$output .= '
</table>
<div class="d-flex justify-content-lg-between">
<label class="text-gray-600">Total Records:  '.$total_data.'</label>
<div <align="center" style="margin-top: 10px;">
  <ul class="pagination">
';


$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

if($total_links > 4)
{
  if($page < 5)
  {
    for($count = 1; $count <= 5; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '...';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 5;
    if($page > $end_limit)
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $end_limit; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    else
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $page - 1; $count <= $page + 1; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '...';
      $page_array[] = $total_links;
    }
  }
}
else
{
  for($count = 1; $count <= $total_links; $count++)
  {
    $page_array[] = $count;
  }
}


if($total_data > $limit){
for($count = 0; $count < count($page_array); $count++)
{
  if($page == $page_array[$count])
  {
    $page_link .= '
    <li class="page-item disabled">
      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
    </li>
    ';

    $previous_id = $page_array[$count] - 1;
    if($previous_id > 0)
    {
      $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
    }
    else
    {
      $previous_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Previous</a>
      </li>
      ';
    }
    $next_id = $page_array[$count] + 1;
    if($next_id > $total_links)
    {
      $next_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Next</a>
      </li>
        ';
    }
    else
    {
      $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
    }
  }
  else
  {
    if($page_array[$count] == '...')
    {
      $page_link .= '
      <li class="page-item disabled">
          <a class="page-link" href="#">...</a>
      </li>
      ';
    }
    else
    {
      $page_link .= '
      <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
      ';
    }
  }
}
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>
  </div>

</div>
';




  echo $output;





?>