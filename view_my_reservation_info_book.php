<?php  
     include('Includes/conn.php');

 if(isset($_POST["tran_code"]))  
 { 

    $trans_code = $_POST["tran_code"];

    //guest query
    $query_Guest = "SELECT * FROM recent_guest WHERE TransactionCode = '$trans_code'";  
    $run_query_Guest = mysqli_query($db, $query_Guest);
    $result_Guest = mysqli_fetch_assoc($run_query_Guest);

    //reservation query
    $query_reservation = "SELECT * FROM transaction WHERE TransactionCode = '$trans_code'";  
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


    $amentotal = 0;
        $query_amen = "SELECT * FROM amen_transaction WHERE TransactionCode = $trans_code";
        $run_query_amen = mysqli_query($db, $query_amen);
        if (mysqli_num_rows($run_query_amen) > 0) {
            while ($row_amen = mysqli_fetch_array($run_query_amen)) {

                $amentotal += $row_amen['AmenRates'];
            }
        }

        $dis = $result_Guest['Discount'];
        $downpayment= $result_reservation['Downpayment'];

      //date format

      $Arrival2 = date('M d, Y', $from1);
      $Departure2 = date('M d, Y', $to1);

       

      $price = $result_RoomType['roomprice'];

      $Subtotal = $nights * $price; //room total
      $SUbtotal_with_amen = $Subtotal + $amentotal;
      $totalRates = $SUbtotal_with_amen - ($SUbtotal_with_amen * ($dis / 100));

      $discounts = $SUbtotal_with_amen * ($dis / 100);
      $balance = $totalRates - $downpayment;

      if(!empty($downpayment)){
          $dp = $downpayment;
          $dp = "<span>&#8369 </span>" . $downpayment . ".00";
      }else{
          $dp = 0;
      }

      $output ='
      <div class="bg-white card pb-3 print-container" >
        <div class="  pl-3 pr-3 pt-2  text-lg w3-text-white">
            <div class=" text-gray-700">
                <div class="d-flex justify-content-lg-between  align-items">
                    <div class="pb-1"><p class="text-success card-text">
                    <img   src="Images/idsc.png" width="50rem;" height="50rem;">

                    <span  style="font-size: 1.5rem;"><b>IDSC Hotel</b></span>
                     </div>
 
                          
                        
                        <div >
                            <div class="d-flex">
                                <div class="pr-3">

                                    <p style="font-size: 0.9rem;">
                                        Date of  Issue:<br>
                                        Time:<br>

                                        Handled By:</p>
                                </div>
                                
                                <p style="font-size: 0.9rem;">
                                ' . $result_reservation['TransactionDate'] . '
                                    
                                    <br>' . $result_reservation['TransactionTime'] . '<br>

                                    ' . $result_reservation['TransactBy'] . '
                                </p>
                            </div>
                        </div>

 
                </div>
            </div>
            
        </div>

        <div class="pt-3 px-4 row">
            <div class=" px-3 pt-2 card col-lg-3 border-left-success shadow-sm">
                
                <span class="text-success" style="font-size: 0.9rem">Guest Details:</span>  
                    <div class="pl-2 pt-2 text-gray-800">
                        <p>' . $result_Guest['Name'] . '<br>
                        <p>' . $result_Guest['Nationality'] . '<br>
                             
                        <p>' . $result_Guest['Birthdate'] . '<br>
                        <p>' . $result_Guest['Address'] . '<br>
                        </p>
                    </div>

                    <span class="text-success" style="font-size: 0.9rem">Contact Info:</span>  
                        <div class="pl-2 pt-2 text-gray-800">
                            <p>
                            ' . $result_Guest['PNumber'] . '<br>' . $result_Guest['Email'] . '<br>

                             </p>
                        </div>

                    <span class="text-success" style="font-size: 0.9rem">Company and Address:</span> 
                    <div class="pl-2 pt-2 text-gray-800">
                        <p>
                        ' . $result_Guest['Company'] . '<br>' . $result_Guest['CompanyAddress'] . '<br>

                        </p>
                    </div>

                    <span class="text-success" style="font-size: 0.9rem">For foreign guest:</span> 

                     
                    <div class="d-flex">
                        <div class="pr-2 pl-2 pt-2 ">
                            <p>
                                Origin:<br>
                                Passport:<br>
                                Issued At: 
                            </p>
                        </div>
                        <div class="pt-2 text-gray-800">

                        ' . $result_Guest['Origin'] . '<br>' . $result_Guest['Passport'] . '<br>' . $result_Guest['IssuedAt'] . '
                            
                        </div>
                    </div>
                </p>
            </div>

            <div class="ml-3 py-2 px-3 card col border-left-success shadow-sm">
                <div class="d-flex justify-content-lg-between">
                    <div class="w3-center pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Adult(s):</span><br>
                            ' . $result_Guest['GuestNumber'] . '
                        </p>
                    </div>

                    <div class="w3-center pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Kid(s):</span><br>
                            ' . $result_Guest['GuestNumber2'] . '
                        </p>
                    </div>

                    <div class=" w3-center pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">Arrival Date:</span><br>
                            ' . $Arrival2 . '
                        </p>
                    </div>

                    <div class="w3-center pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">Departure Date:</span><br>
                            ' . $Departure2 . '
                                                    </p>
                    </div>
                    <div class="w3-center pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Of Night(s):</span><br>
                            ' . $nights . '
                        </p>
                    </div>
                </div>

                <section class="mt-2 p-1 bg-success"></section>
                <div>
                    <table class="table">
                        
                        <tr class="text-success table-sm">
                            <td>Description</td>
                            <td align="right " style="width: 150px;"> Unit Cost</td>
                            <td align="center " style="width: 150px;">Qty/No</td>
                            <td align="right " style="width: 150px;">Amount</td>
                        </tr>
                        <tr>
                            <td >' . $result_RoomType['roomtype'] . ' 
                             </td>
                            <td align="right "><span>&#8369 </span>' . $result_RoomType['roomprice'] . '.00</td>
                            <td align="center ">' . $nights . '</td>
                            <td align="right "><span>&#8369 </span>' . $Subtotal . '.00</td>
                        </tr>';

                        $amen_query = "SELECT * FROM amen_transaction WHERE TransactionCode = '$trans_code'";
                        $run_amen_query = mysqli_query($db, $amen_query);
                        if (mysqli_num_rows($run_amen_query) > 0) {
                            while ($amen_rows = mysqli_fetch_array($run_amen_query)) {
                                $id = $amen_rows['AmenID'];
                                $amen_query2 = "SELECT * FROM amenities WHERE AmenID = '$id'";
                                $run_amen_query2 = mysqli_query($db, $amen_query2);
                                $row3 = mysqli_fetch_assoc($run_amen_query2);
                
                                $output .= '
                                                <tr>
                                                             <td>' . $amen_rows['AmenName'] . '</td>
                                                             <td align="right "><span>&#8369 </span>' . $row3['AmenRates'] . '.00</td>
                                                             <td align="center">' . $amen_rows['AmenQuantity'] . '</td>
                                                            <td align="right "><span>&#8369 </span>' . $amen_rows['AmenRates'] . '.00</td>
                                                        </tr>
                            
                                                ';
                            }
                        }

                        $output .= '
                        <tr class="table-borderless"><td></td></tr>

                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class= " text-success">Subtotal</td>
                            <td align="right "><span>&#8369 </span>' . $SUbtotal_with_amen . '.00</td>
                        </tr>
                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class=" text-success">Discount</td>
                            <td  align="right "> ' . $dis. '% <span class="text-warning">(' . $discounts . ')</span></td>
                        </tr>

                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class=" text-success">Total</td>
                            <td  align="right " ><span>&#8369 </span>' . $totalRates . '.00</td>
                        </tr>

                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class=" text-success">Downpayment</td>
                            <td  align="right ">' . $dp . '</td>
                        </tr>

                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class=" text-success">Balance</td>
                            <td  align="right " style="font-size: 1.2rem; "><span>&#8369 </span>' . $balance. '.00</td>
                        </tr>
                        
                    </table>
                    
                </div>
            </div>

          
        </div>
    </div>
    
        
           
          ';
                
echo $output;


  }