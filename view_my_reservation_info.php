<?php  
 if(isset($_POST["tran_code"]))  
 {  
     include('Includes/conn.php');
      $output = '';  

      $trans_code = $_POST["tran_code"];

      //guest query
      $query_Guest = "SELECT * FROM recent_guest WHERE TransactionCode = '$trans_code'";  
      $run_query_Guest = mysqli_query($db, $query_Guest);
      $result_Guest = mysqli_fetch_assoc($run_query_Guest);

      //reservation query
      $query_reservation = "SELECT * FROM reservation WHERE TransactionCode = '$trans_code'";  
      $run_query_reservation = mysqli_query($db, $query_reservation);
      $result_reservation = mysqli_fetch_assoc($run_query_reservation);

      $Room_ID = $result_reservation['RoomID'];

      //rooms query
      $query_Rooms = "SELECT * FROM rooms WHERE RoomID = $Room_ID";  
      $run_query_Rooms= mysqli_query($db, $query_Rooms);
      $result_Rooms = mysqli_fetch_assoc($run_query_Rooms);

      $RoomType = $result_Rooms['RoomType'];

      //roomtype query
      $query_RoomType = "SELECT * FROM roomtype WHERE roomtypeid = '$RoomType'";  
      $run_query_RoomType= mysqli_query($db, $query_RoomType);
      $result_RoomType = mysqli_fetch_assoc($run_query_RoomType);

      $from = $result_reservation['Arrival'];
      $to = $result_reservation['Departure'];
  
      $from1 = strtotime($from);
      $to1 = strtotime($to);
      $datediff = $to1 - $from1;
      $days = round($datediff/(60*24*60));
      $nights = $days;

        //date format

        $Arrival2 = date('M d, Y', $from1);
        $Departure2 = date('M d, Y', $to1);
  


      $output ='

      <table class="table ">
      <tr class="bg-warning w3-text-white">
           <td>Room Type</td>
          <td>Description</td>
          <td style="width: 120px;">Rates</td>
      </tr>
      <tr>
           <td>'.$result_RoomType["roomtype"].'</td>
          <td >'.$result_RoomType["roomtypedescription"].'</td>
          <td ><span>&#8369 </span>'.$result_RoomType["roomprice"].'.00</td>

          
      </tr>

  </table>

<table class="table">
  <tr class="table-warning w3-text-teal">
      <td>Name</td>
      <td>Home Address</td>
      <td>Contact Info</td>
      <td>Company</td>
      <td>If Foreigner</td>

      
  </tr>
  <tr>
      <td>
          '.$result_Guest['Name'].'<br>
          '.$result_Guest['Nationality'].'<br>
          '.$result_Guest['Birthdate'].'


      <td>
      '.$result_Guest['Address'].'
      </td>
      <td>
          '.$result_Guest['PNumber'].'<br>'.$result_Guest['Email'].'
      </td>
      <td>'.$result_Guest['Company'].'<br>
      '.$result_Guest['CompanyAddress'].'
      </td>
      <td>'.$result_Guest['Origin'].'<br>
      '.$result_Guest['Passport'].'<br>
      '.$result_Guest['IssuedAt'].'

      </td>
      
  </tr>
  </table>

  <table class="table w3-center">

  <tr class="table-warning w3-text-teal">
      <td>Adult(s)</td>
      <td>Kid(s)</td>

      <td>Arrival</td>
      <td>Departure</td>
      <td class="w3-center">Night(s)</td>
      <td>Total Rates</td>

      </tr>
  <tr>
      <td>'.$result_Guest['GuestNumber'].'</td>
      <td>'.$result_Guest['GuestNumber2'].'</td>

      <td>'.$Arrival2.'</td>
      <td>'.$Departure2.'</td>
      <td class="w3-center">'. $nights.'</td>

      <td><span>&#8369 </span>'.$result_reservation['TotalRates'].'.00</td>

      </tr>
</table>';

    $amen_query = "SELECT * FROM amen_transaction WHERE TransactionCode = '$trans_code'";
                $run_amen_query = mysqli_query($db, $amen_query);
                if (mysqli_num_rows($run_amen_query) > 0) {

                    $output .= '
                    <table class="table">
                    <tr class="table-warning w3-text-teal">
                    <td><span >Other Amenities:</span></td>
                    </tr>
                    </table>
                    <table class="table">
                    <tr>
    
                        ';
                    while ($amen_rows = mysqli_fetch_array($run_amen_query)) {
                        $id = $amen_rows['AmenID'];
                        $amen_query2 = "SELECT * FROM amenities WHERE AmenID = '$id'";
                        $run_amen_query2 = mysqli_query($db, $amen_query2);
                        $row = mysqli_fetch_assoc($run_amen_query2);
                        $output .= '
                         
                                     <td ><span class="text-gray-600">' . $amen_rows['AmenQuantity'] . ' ' . $amen_rows['AmenName'] . '</span></td>
 
                        ';
                    }
                    $output .= '
                    </tr>
                    </table>
                    ';
                } else {
                    $output .= ' ';
                }

if(!empty($result_reservation['Requests'])){
    $output .= ' <table class="text-gray-500 ">';
    $output .= '<tr>
            <td>Additional request: <span class="text-gray-800 ">'.$result_reservation['Requests'].'</span></td>
        </tr>';

        if(!empty($result_reservation['Reply'])){
            $output .= '<tr>
            <td>Replied: <span class="text-gray-800 ">'.$result_reservation['Reply'].'</span><span class="text-gray-600"><br> -For more queries you can call/text on our number or send us an email. Thank You!-</span></td>
        </tr>';
        }else{
            
        }


    $output .= '
    </table>';
}else{
    $output .= ' ';
}

$output .= '
<div class="modal-footer">
<button type="button" class="px-3 btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
 
</div>
             ';


    echo $output;
 }
 ?>