<?php  

      $output = '';  
      include('../Includes/conn.php');

      if(isset($_POST["staff_id"])){
        $RoomID = $_POST["staff_id"];

        $query = "SELECT * FROM rooms WHERE RoomID = '$RoomID'";  
        $result = mysqli_query($db, $query);
        $row  = mysqli_fetch_assoc($result);

        $roomtype = $row['RoomType'];
          $queryroomtype = "SELECT * FROM roomtype WHERE roomtypeid = '$roomtype'";  
          $resultroomtype = mysqli_query($db, $queryroomtype);
          $row3 = mysqli_fetch_assoc($resultroomtype);

          $price ='<td><span>&#8369 </span>'. $row3['roomprice'].'.00</td>';

          $query2 = "SELECT * FROM transaction WHERE RoomID = $RoomID";   
        $result2 = mysqli_query($db, $query2);

        

      if(mysqli_num_rows($result2) > 0){
        $row2 = mysqli_fetch_assoc($result2);

        

        
        $querycode = $row2['TransactionCode'];
  
        $queryguest = "SELECT * FROM recent_guest  WHERE TransactionCode = '$querycode'";      
        $resultguest = mysqli_query($db, $queryguest);
        $rowguest = mysqli_fetch_assoc($resultguest);

        
 

                        $from = $row2['Arrival'];
                        $to = $row2['Departure'];
                    
                        $from1 = strtotime($from);
                        $to1 = strtotime($to);
                        $datediff = $to1 - $from1;
                        $days = round($datediff/(60*24*60));
                        $nights = $days + 1;

    //date format
    
    $Arrival2 = date('M d, Y', $from1);
    $Departure2 = date('M d, Y', $to1);
                    
        
          $transactions = '
          
          <table class="table">
            <tr class="table-success w3-text-teal table-sm">
                <td>Name</td>
                <td>Home Address</td>
                <td>Contact Info</td>
                <td>Company</td>
                <td>If Foreigner</td>

                
            </tr>
            <tr>
                <td>
                    '.$rowguest['Name'].'<br>
                    '.$rowguest['Birthdate'].'<br>

                     '.$rowguest['Nationality'].'

                <td>
                '.$rowguest['Address'].'
                </td>
                <td>
                    '.$rowguest['PNumber'].'<br>'.$rowguest['Email'].'
                </td>
                <td>
                    '.$rowguest['Company'].'<br>'.$rowguest['CompanyAddress'].'
                </td>
                <td>
                    '.$rowguest['Origin'].'<br>'.$rowguest['Passport'].'<br>'.$rowguest['IssuedAt'].'
                </td>
            </tr>
            </table>

            <table class="table">

            <tr class="table-success table-sm w3-text-teal">

               <td>Guest</td>
                <td>Arrival</td>
                <td>Departure</td>
                <td>Nights</td>
                <td>Discount</td>
                <td>Total Rates</td>
                

                </tr>
            <tr>
            <td>'.$rowguest['GuestNumber'].'</td>
                <td>'.$Arrival2.'</td>
                <td>'.$Departure2.'</td>
                <td class="w3-center">'.$nights.'</td>
                <td>'.$rowguest['Discount'].' %</td>
                <td><span>&#8369 </span>'.$row2['TotalRates'].'.00</td>

                </tr>
        </table>
          
          ';

     }else{
          $transactions = " ";
     }

     $RoomStatus = $row['RoomStatus'];
      if($RoomStatus == "Booked"){
           $buttons = '
            <table>
        <tr>
        <td class="d-none transaction_id">'.$row2['TransactionID'].'</td>
        <td><button type="button" class="px-4 btn btn-warning delete_btn " data-bs-dismiss="modal">Check Out</button></td>
        </tr>
        </table> 
            ';

      }else if($RoomStatus == "Vacant"){
          $buttons = '
               <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
               <a href="booking_input_customer_info?roomid= '.$row['RoomID'].'" class="btn btn-success w3-text-white">Book Now</a>


           ';
      }



      $output .= '  
      <div class="table-responsive">  
           <table class="table">';  

     
           $output .= '  
                
                <table class="table ">
                <tr class="bg-success w3-text-white">
                    <td>Room Number</td>
                     <td>Room Type</td>
                    <td>Description</td>
                    <td style="width: 120px;">Rates</td>
                </tr>
                <tr>
                    <td>'.$row["RoomNumber"].'</td>
                     <td>'.$row3["roomtype"].'</td>
                    <td >'.$row3["roomtypedescription"].'</td>';

                    
                    $output .= $price;
                    $output .= '
                </tr>

            </table>';
            $output .= $transactions;
            $output .= ' 
 
            <div class="modal-footer">';

            $output .= $buttons;
            $output .= ' 
        </div>
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;

    mysqli_close($db);
