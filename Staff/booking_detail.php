
<?php

$output = '';
include('../Includes/conn.php');

if (isset($_POST["staff_id"])) {
    $RoomID = $_POST["staff_id"];

    $query = "SELECT * FROM rooms WHERE RoomID = '$RoomID'";
    $result = mysqli_query($db, $query);
    $row  = mysqli_fetch_assoc($result);

    $roomtype = $row['RoomType'];
    $queryroomtype = "SELECT * FROM roomtype WHERE roomtypeid = '$roomtype'";
    $resultroomtype = mysqli_query($db, $queryroomtype);
    $row3 = mysqli_fetch_assoc($resultroomtype);

    $price = '<td><span>&#8369 </span>' . $row3['roomprice'] . '.00</td>';

    $query2 = "SELECT * FROM transaction WHERE RoomID = $RoomID";
    $result2 = mysqli_query($db, $query2);



    if (mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_assoc($result2);

        $querycode = $row2['TransactionCode'];
        $amentotal = 0;
        $query_amen = "SELECT * FROM amen_transaction WHERE TransactionCode = $querycode";
        $run_query_amen = mysqli_query($db, $query_amen);
        if (mysqli_num_rows($run_query_amen) > 0) {
            while ($row_amen = mysqli_fetch_array($run_query_amen)) {

                $amentotal += $row_amen['AmenRates'];
            }
        }

        $queryguest = "SELECT * FROM recent_guest  WHERE TransactionCode = '$querycode'";
        $resultguest = mysqli_query($db, $queryguest);
        $rowguest = mysqli_fetch_assoc($resultguest);

        $dis = $rowguest['Discount'];
        $downpayment= $row2['Downpayment'];

        

        $from = $row2['Arrival'];
        $to = $row2['Departure'];

        $from = strtotime($from);
        $to = strtotime($to);
        $datediff = $to - $from;
        $date_difference = round($datediff / (60 * 24 * 60));
        $nights = $date_difference;





        //date format
        $Arrival2 = date('M d, Y', $from);
        $Departure2 = date('M d, Y', $to);

        $price = $row3['roomprice'];

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


        $transactions = '
          <style>
    @media print{
        body * {
            visibility: hidden;
        
        }

        .print-container, .print-container * {
                visibility: visible;
            }

        .print-container {
            position: absolute;
            left: 0px;
            top: 0px;
        }

         
    }

    @page {
  size: landscape;
}
</style>

    <div class="bg-white card pb-3 print-container" >
        <div class="  pl-3 pr-3 pt-2  text-lg w3-text-white">
            <div class=" text-gray-700">
                <div class="d-flex justify-content-lg-between  align-items">
                    <div class="pb-1"><p class="text-success card-text">
                    <img   src="../Images/idsc.png" width="50rem;" height="50rem;">

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
                                ' . $row2['TransactionDate'] . '
                                    
                                    <br>' . $row2['TransactionTime'] . '<br>

                                    ' . $row2['TransactBy'] . '
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
                        <p>' . $rowguest['Name'] . '<br>
                        <p>' . $rowguest['Nationality'] . '<br>
                             
                        <p>' . $rowguest['Birthdate'] . '<br>
                        <p>' . $rowguest['Address'] . '<br>
                        </p>
                    </div>

                    <span class="text-success" style="font-size: 0.9rem">Contact Info:</span>  
                        <div class="pl-2 pt-2 text-gray-800">
                            <p>
                            ' . $rowguest['PNumber'] . '<br>' . $rowguest['Email'] . '<br>

                             </p>
                        </div>

                    <span class="text-success" style="font-size: 0.9rem">Company and Address:</span> 
                    <div class="pl-2 pt-2 text-gray-800">
                        <p>
                        ' . $rowguest['Company'] . '<br>' . $rowguest['CompanyAddress'] . '<br>

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

                        ' . $rowguest['Origin'] . '<br>' . $rowguest['Passport'] . '<br>' . $rowguest['IssuedAt'] . '
                            
                        </div>
                    </div>
                </p>
            </div>

            <div class="ml-3 py-2 px-3 card col border-left-success shadow-sm">
                <div class="d-flex justify-content-lg-between">
                    <div class="w3-center pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Adult(s):</span><br>
                            ' . $rowguest['GuestNumber'] . '
                        </p>
                    </div>

                    <div class="w3-center pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Kid(s):</span><br>
                            ' . $rowguest['GuestNumber2'] . '
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
                            <td >' . $row3['roomtype'] . ' 
                             </td>
                            <td align="right "><span>&#8369 </span>' . $row3['roomprice'] . '.00</td>
                            <td align="center ">' . $nights . '</td>
                            <td align="right "><span>&#8369 </span>' . $Subtotal . '.00</td>
                        </tr>';





        $amen_query = "SELECT * FROM amen_transaction WHERE TransactionCode = '$querycode'";
        $run_amen_query = mysqli_query($db, $amen_query);
        if (mysqli_num_rows($run_amen_query) > 0) {
            while ($amen_rows = mysqli_fetch_array($run_amen_query)) {
                $id = $amen_rows['AmenID'];
                $amen_query2 = "SELECT * FROM amenities WHERE AmenID = '$id'";
                $run_amen_query2 = mysqli_query($db, $amen_query2);
                $row3 = mysqli_fetch_assoc($run_amen_query2);

                $transactions .= '
                                <tr>
                                             <td>' . $amen_rows['AmenName'] . '</td>
                                             <td align="right "><span>&#8369 </span>' . $row3['AmenRates'] . '.00</td>
                                             <td align="center">' . $amen_rows['AmenQuantity'] . '</td>
                                            <td align="right "><span>&#8369 </span>' . $amen_rows['AmenRates'] . '.00</td>
                                        </tr>
            
                                ';
            }
        }





        $transactions .= '
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
                            <td  align="right "> ' . $rowguest['Discount'] . '% <span class="text-warning">(' . $discounts . ')</span></td>
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
          
    } else {
        $transactions = " ";
    }

    $RoomStatus = $row['RoomStatus'];
    if ($RoomStatus == "Booked") {
        $buttons = '
        <table class="table-sm   table-borderless" >
        <tr class="table-sm">
            <td class="d-none transaction_id">' . $row2['TransactionCode'] . '</td>
              
              
             <td align="right">
                <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Close</button>
                <button type="button" class="px-4 btn btn-info  update_btn " data-bs-dismiss="modal">Update Info</button>           
                <button onclick="window.print();"    class="btn btn-info">Print Invoice</button>
                <button type="button" class="px-4 btn btn-success  delete_btn " data-bs-dismiss="modal">Check Out</button>
            </td>
        </tr>
    </table>
        ';
    } else if ($RoomStatus == "Vacant") {
        $buttons = '
               <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
               <a href="booking_input_customer_info?roomid= ' . $row['RoomID'] . '" class="btn btn-success w3-text-white">Book Now</a>


           ';
    }







    $output .= $transactions;
    $output .= ' 
 
            <div class="modal-footer">';

    $output .= $buttons;
}
$output .= '  
           </table>  
      </div>  
      ';
echo $output;

mysqli_close($db);

?>











