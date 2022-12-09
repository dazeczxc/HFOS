<?php

include('../Includes/conn_pdo.php');


$limit = '10';
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

$query = "
SELECT * FROM recent_transaction 
";

if($_POST['query'] != '')
{
  $query .= '
  WHERE TransactionDate LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" || 
    TransactBy LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" || 

  TransactionCode IN (SELECT TransactionCode FROM recent_guest WHERE Name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ) ||
  RoomID IN (SELECT RoomID FROM rooms WHERE RoomNumber LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" )


  

  ';
}

 

$query .= 'ORDER BY TransactionDate ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '

<table class="table table-bordered table-hover">
<tr style="background: linear-gradient(225deg, #20cc8a,#4adda5);" class="text-gray-100">
<td class="d-none">RoomID</td>
  <td >Date</td>
  <td>Name</td>
  <td>Room</td>
  <td>Room Type</td>
  <td>Arrival - Departure</td>
  <td>Issued By</td>

  <td>Amount</td>

   </tr>
';
$output .= '<tbody class="table-sm">';

if($total_data > 0)
{
  

  foreach($result as $row)
  {

    

    $rtype = $row["TransactionCode"];
    $queryRoomtype = "SELECT * FROM recent_guest WHERE TransactionCode = '$rtype'";
    $statementss = $connect->prepare($queryRoomtype);
    $statementss->execute();
    $resultss = $statementss->fetchAll();

    foreach($resultss as $row_guest){
    }
    $RoomID = $row['RoomID'];

    $queryRoom = "SELECT * FROM rooms WHERE RoomID = '$RoomID'";
    $run_queryRoom = $connect->prepare($queryRoom);
    $run_queryRoom->execute();
    $results_run_queryRoom = $run_queryRoom->fetchAll();

    foreach($results_run_queryRoom as $row_room){
    }

     $queryRoom = "SELECT * FROM roomtype WHERE roomtypeid IN(SELECT RoomType FROM rooms WHERE RoomID = '$RoomID'
     
     
     )";
    $statementsss = $connect->prepare($queryRoom);
    $statementsss->execute();
    $resultsss = $statementsss->fetchAll();
    foreach($resultsss as $row_roomType){
    }

  


    $output .= '
    
    <tr class="" style="cursor: pointer">
      <td class="d-none room_id">'.$row["TransactionID"].'</td>
      <td class="py-2" style="width: 120px;">'.$row["TransactionDate"].'</td>
      <td class="py-2" style="width: 160px;">'.$row_guest["Name"].'</td>
      <td class="py-2">'.$row_room["RoomNumber"].'</td>
      <td class="py-2">'.$row_roomType["roomtype"].'</td>
      <td class="py-2">'.$row["Arrival"].' - '.$row["Departure"].'</td>
      <td class="py-2">'.$row["TransactBy"].'</td>

      <td class="py-2"><span>&#8369 </span>'.$row["TotalRates"].'.00</td>


       

    </tr>
    ';
  }
}
else
{
  $output .= '
  <tr>
    <td colspan="8" align="center">No Record</td>
  </tr>
  </tbody>
  ';
}

 

$output .= '
</table>
<div class="d-flex justify-content-lg-between">
<label class="text-gray-600">Total Records:  '.$total_data.'</label>

 

<div <align="center">
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