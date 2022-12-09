<?php
if (isset($_POST["guest_ID"])) {
    $output = '';
    include('../Includes/conn.php');

    $g_ID = $_POST["guest_ID"];

    //guest query
    $query_Guest = "SELECT * FROM guest WHERE GuestID = '$g_ID'";
    $run_query_Guest = mysqli_query($db, $query_Guest);
    $result_Guest = mysqli_fetch_assoc($run_query_Guest);

    $output = '
            <div class="modal-header border-bottom-success">
             

                <p class="modal-title h4 w3-text-teal" id="exampleModalLabel">' . $result_Guest['Name'] . '</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 
            </div>

            <div class="modal-body">
                <div class=" d-flex px-3 justify-content-lg-between text-gray-700">
                    <div>
                        <p>
                        <span class="text-success">Personal Details: </span><br>
                        <span class="text-gray-500">Nationality: </span>' . $result_Guest['Nationality'] . '<br>
                        <span class="text-gray-500">Birthdate: </span>' . $result_Guest['Birthdate'] . '<br>
                        <span class="text-gray-500">Home Address: </span>' . $result_Guest['Address'] . '<br>

                        </p>
                    </div>

                    <div>
                        <p>
                        <span class="text-success">Contacts: </span><br>

                        <span class="text-gray-500">Phone Number: </span>' . $result_Guest['PNumber'] . '<br>
                        <span class="text-gray-500">Email: </span>' . $result_Guest['Email'] . '<br>
    
                        </p>
                    </div>

                    <div>
                        <p>
                        <span class="text-success">Company and Address: </span><br>

                        <span class="text-gray-500">Company: </span>' . $result_Guest['Company'] . '<br>
                        <span class="text-gray-500">Address: </span>' . $result_Guest['CompanyAddress'] . '<br>
    
                        </p>
                    </div>

                    <div>
                        <p>
                        <span class="text-success">If Foreigner: </span><br>
                        <span class="text-gray-500">Origin: </span>
                        ' . $result_Guest['Origin'] . '<br>
                        <span class="text-gray-500">Passport: </span>

                        ' . $result_Guest['Passport'] . '<br>
 
                        </p>
                    </div>
                </div>
            

                <table class="table table-sm w3-center  table-hover">
                    <tr class="bg-success text-white">
                            <td class="py-2"> Date</td>
                            <td class="py-2">Issued By</td>
                            <td class="py-2" align="left">Room</td>
                            <td class="py-2">Adult(s)</td>
                            <td class="py-2">Kid(s)</td>

                            <td class="py-2">Arrival - Departure</td>
                            <td class="py-2">Nights</td>

 
                            <td class="py-2">Amount</td>
                        </tr> 
             ';

    $query_transact = "SELECT * FROM recent_transaction WHERE GuestID = $g_ID";
    $run_query_transact = mysqli_query($db, $query_transact);

    $query_sum = "SELECT SUM(TotalRates) AS Total_Amount FROM recent_transaction WHERE GuestID = $g_ID";
    $run_query_sum = mysqli_query($db, $query_sum);
    $row_sum = mysqli_fetch_assoc($run_query_sum);


    while ($row_transact = mysqli_fetch_array($run_query_transact)) {
        $RoomID = $row_transact['RoomID'];
        $t_code = $row_transact['TransactionCode'];

        $query_room = "SELECT * FROM rooms WHERE RoomID = '$RoomID'";
        $run_query_room = mysqli_query($db, $query_room);
        $result_room = mysqli_fetch_assoc($run_query_room);

        $type = $result_room['RoomType'];
        $query_roomtype = "SELECT * FROM roomtype WHERE roomtypeid = '$type'";
        $run_query_roomtype = mysqli_query($db, $query_roomtype);
        $result_roomtype = mysqli_fetch_assoc($run_query_roomtype);

        $query_recent_guest = "SELECT * FROM recent_guest WHERE TransactionCode = '$t_code'";
        $run_query_recent_guest = mysqli_query($db, $query_recent_guest);
        $result_recent_guest = mysqli_fetch_assoc($run_query_recent_guest);

        $tdate =  $row_transact["TransactionDate"];
        $from1 = strtotime($tdate);
        $TransactionDate = date('M d, Y', $from1);

        $Arrival =  $row_transact["Arrival"];
        $from2 = strtotime($Arrival);
        $ArrivalDate = date('M d, Y', $from2);

        $Departure =  $row_transact["Departure"];
        $to = strtotime($Departure);
        $DepartureDate = date('M d, Y', $to);


        $datediff = $to - $from2;
        $date_difference = round($datediff / (60 * 24 * 60));
        $nights = $date_difference;
        $output .= '
                

                <tr >
                 
                    <td class="pt-3">' . $TransactionDate . '</td>
                    <td class="pt-3">' . $row_transact["TransactBy"] . '</td>
                    <td class="pt-3" align="left">' . $result_room["RoomNumber"] . '('. $result_roomtype["roomtype"] .')</td>
                    <td class="pt-3">' . $result_recent_guest["GuestNumber"] . '</td>
                    <td class="pt-3">' . $result_recent_guest["GuestNumber2"] . '</td>

                    <td class="pt-3">' . $ArrivalDate . ' - ' . $DepartureDate . '</td>
                    <td class="pt-3">' . $nights . '</td>
 
                    <td class="pt-3"><span>&#8369 </span>' . $row_transact["TotalRates"] . '.00</td>
 
                </tr>
                ';
    }


    $output .= '
                <tr class="table-borderless">
                    <td class="pt-3"> </td>
                    <td class="pt-3">  </td>
                    <td class="pt-3"> </td>
                    <td class="pt-3"> </td>
                    <td class="pt-3"> </td>
                    <td class="pt-3"> </td>

                    <td class="pt-3 pr-3" align="right"> Total: </td>
                    <td class="pt-3"><span>&#8369 </span>' . $row_sum['Total_Amount'] . '.00</td>
                </tr>
                </table>
             
             </div>
             <div  class="d-flex justify-content-end px-3" >  
             <table >
                <tr>
                    <td class="d-none room_id">' . $g_ID . '</td>
                    <td><button type="button" class="px-4 btn btn-warning delete_btn " data-bs-dismiss="modal">Delete Guest</button>
                    </td>
                </tr>
            </table>
                
             </div>
        
        
        ';

    echo $output;
    mysqli_close($db);
}

?>
<div class="">
    <div>






        <div class="px-3 py-2">



            <div class="py-2 table-responsive" id="dynamic_content">
            </div>
        </div>
    </div>
</div>

<?php
//                    <input type="text" name="search_box" id="search_box" class="form-control w3-center" placeholder="Search..." />


?>

<script>
    $(document).ready(function() {

        load_data(1);

        function load_data(page, query = '') {
            $.ajax({
                url: "fetch_guest_transaction.php",
                method: "POST",
                data: {
                    page: page,
                    query: query
                },
                success: function(data) {
                    $('#dynamic_content2').html(data);
                }
            });
        }

        $(document).on('click', '.page-link', function() {
            var page = $(this).data('page_number');
            var query = $('#search_box').val();
            load_data(page, query);
        });

        $('#search_box').keyup(function() {
            var query = $('#search_box').val();
            load_data(1, query);
        });
    });
</script>