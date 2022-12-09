<?php

require('../Includes/conn_pdo.php');
require('../Includes/conn.php');

$query = "
SELECT * FROM recent_transaction 
";


$query .= 'ORDER BY TransactionDate ASC ';


$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();
$result = $statement->fetchAll();
$output = '

<table class="table table-bordered">
<tr style="background: linear-gradient(225deg, #20cc8a,#4adda5);" class="text-gray-100">
 
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


$query_sum = "SELECT SUM(TotalRates) AS Total_Amount FROM recent_transaction";
    $run_query_sum = mysqli_query($db, $query_sum);
    $row_sum = mysqli_fetch_assoc($run_query_sum);


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
    
    <tr>
       
      <td class="py-2" style="width: 120px;">'.$row["TransactionDate"].'</td>
      <td class="py-2" style="width: 160px;">'.$row_guest["Name"].'</td>
      <td class="py-2">'.$row_room["RoomNumber"].'</td>
      <td class="py-2">'.$row_roomType["roomtype"].'</td>
      <td class="py-2">'.$row["Arrival"].' - '.$row["Departure"].'</td>
      <td class="py-2">'.$row["TransactBy"].'</td>

      <td class="py-2">'.$row["TotalRates"].'</td>

   
    ';
  }
  $output .= ' </tr>
  <tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td>Total:</td>
  <td class="pt-3">' . $row_sum['Total_Amount'] . '</td>

  </tr>';
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
  
 ';
 header('Content-Disposition:attachment;filename=Report.xls');

  echo $output;





?>