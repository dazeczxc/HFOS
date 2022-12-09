
<?php

$output = '';
include('../Includes/conn.php');

if (isset($_POST["staff_id"])) {
    $RoomID = $_POST["staff_id"];

     //rooms query
    $query_Rooms = "SELECT * FROM rooms WHERE RoomID = $RoomID";  
    $run_query_Rooms= mysqli_query($db, $query_Rooms);
    $result_Rooms = mysqli_fetch_assoc($run_query_Rooms);

    $RoomType = $result_Rooms['RoomType'];

    //roomtype query
    $query_RoomType = "SELECT * FROM roomtype WHERE roomtypeid = '$RoomType'";  
    $run_query_RoomType= mysqli_query($db, $query_RoomType);
    $result_RoomType = mysqli_fetch_assoc($run_query_RoomType);
 
    //reservation query
    $query_reservation = "SELECT * FROM reservation WHERE RoomID = $RoomID";  
    $run_query_reservation = mysqli_query($db, $query_reservation);
    $result_reservation = mysqli_fetch_assoc($run_query_reservation);

    $trans_code = $result_reservation['TransactionCode'];
 
    //guest query
    $query_Guest = "SELECT * FROM recent_guest WHERE TransactionCode = '$trans_code'";  
    $run_query_Guest = mysqli_query($db, $query_Guest);
    $result_Guest = mysqli_fetch_assoc($run_query_Guest);



    $from = $result_reservation['Arrival'];
    $to = $result_reservation['Departure'];

    $price = $result_RoomType['roomprice'];

    $from1 = strtotime($from);
    $to1 = strtotime($to);
    $datediff = $to1 - $from1;
    $days = round($datediff/(60*24*60));
    $nights = $days;
    $totalRates = $nights * $price;

//date format

$Arrival2 = date('M d, Y', $from1);
$Departure2 = date('M d, Y', $to1);

$Bday1 = strtotime($result_Guest['Birthdate']);
$Bday = date('M d, Y', $Bday1 );



    $output ='
    <div class=" border-bottom-success mb-3">
    <h1 class="w3-text-teal">'.$result_Guest['Name'].'</h1>
  </div>

  <div class=" d-flex px-3 justify-content-lg-between text-gray-700">
                  <div>
                      <p>
                      <span class="text-success">Personal Details: </span><br>
                      <span class="text-gray-500">Nationality: </span>'.$result_Guest['Nationality'].'<br>
                      <span class="text-gray-500">Birtdate: </span>'.$Bday.'<br>
                      <span class="text-gray-500">Home Address: </span>'.$result_Guest['Address'].'<br>

                      </p>
                  </div>

                  <div>
                      <p>
                      <span class="text-success">Contacts: </span><br>

                      <span class="text-gray-500">Phone Number: </span>'.$result_Guest['PNumber'].'<br>
                      <span class="text-gray-500">Email: </span>'.$result_Guest['Email'].'<br>
  
                      </p>
                  </div>

                  <div>
                      <p>
                      <span class="text-success">Company and Address: </span><br>

                      <span class="text-gray-500">Company: </span>'.$result_Guest['Company'].'<br>
                      <span class="text-gray-500">Address: </span>'.$result_Guest['CompanyAddress'].'<br>
  
                      </p>
                  </div>

                  <div>
                      <p>
                      <span class="text-success">If Foreigner: </span><br>
                      
                      <span class="text-gray-500">Origin: </span>'.$result_Guest['Origin'].'<br>
                       

                      <span class="text-gray-500">Passport: </span>'.$result_Guest['Passport'].'<br>
                      <span class="text-gray-500">Issued at: </span>'.$result_Guest['IssuedAt'].'

                      </p>
                  </div>
              </div>
               

    <table class="table w3-center ">
              <tr class="bg-success w3-text-white">
                  <td>Room Number</td>
                   <td>Room Type</td>
                  <td>Description</td>
                  <td style="width: 120px;">Rates</td>
              </tr>
              <tr>
                  <td>'.$result_Rooms["RoomNumber"].'</td>
                   <td>'.$result_RoomType["roomtype"].'</td>
                  <td >'.$result_RoomType["roomtypedescription"].'</td>
                  <td ><span>&#8369 </span>'.$result_RoomType["roomprice"].'.00</td>

                  
                  
              </tr>

          </table>

     

          <table class="table w3-center" >

          <tr class="table-success w3-text-teal">
              <td>Adult(s)</td>
              <td>Kid(s)</td>

              <td>Arrival</td>
              <td>Departure</td>
              <td class="w3-center">Num. of Night(s)</td>

              <td>Total Rates</td>
              <td class="w3-center">Downpayment</td>

              </tr>
          <tr>
              <td>'.$result_Guest['GuestNumber'].'</td>
              <td>'.$result_Guest['GuestNumber2'].'</td>

               <td>'.$Arrival2.'</td>
              <td>'.$Departure2.'</td>
              <td class="w3-center">'. $nights.'</td>

              <td><span>&#8369 </span>'.$result_reservation['TotalRates'].'.00</td>
              <td class="w3-center"><span>&#8369 </span>'.$result_reservation['Downpayment'].'.00</td>

              </tr>
      </table>
      <div class="modal-footer">

      <table >
          <tr>
              <td class="d-none transaction_code">'.$trans_code.'</td>
              <td class="pl-2"><button type="button" class="px-2 btn btn-danger cancel_reservation_btn" data-bs-dismiss="modal">Cancel Reservation</button></td>
              <td class="pl-2"><button type="button" class="px-2 btn btn-success px-5 checkin_reservation_btn" data-bs-dismiss="modal" >Check in</button></td>
              </td>
          </tr>
      </table>  

      

      </div>
           ';


  echo $output;
  mysqli_close($db);

}

?>