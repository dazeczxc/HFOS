<?php

include('../Includes/header.php');
include('../Includes/staff_navbar.php');
include("../Includes/conn.php");

$TransactionCode ='';
$RoomID ='';

if (isset($_POST['Guestsave'])) {

    $RoomID = $_POST['RoomID'];

    $sql_query_room = "SELECT * FROM rooms where RoomID = '$RoomID'";
    $run_sql_query_room = $db->query($sql_query_room) or die($db->error);
    $rowRoom = $run_sql_query_room->fetch_assoc();
    $RoomType = $rowRoom['RoomType'];

    $sql_query_roomtype = "SELECT * FROM roomtype where roomtypeid= '$RoomType'";
    $resultrun_sql_query_roomtype = $db->query($sql_query_roomtype) or die($db->error);
    $rowRoomType = $resultrun_sql_query_roomtype->fetch_assoc();
    $price = $rowRoomType['roomprice'];

    $GuestID = $_POST['GuestID'];

    $GuestNumber = $_POST['GuestNumber'];
    $GuestNumber2 = $_POST['GuestNumber2'];

    $Name = $_POST['Name'];
    $Nationality = $_POST['Nationality'];
    $Birthdate = $_POST['Birthdate'];
    $PNumber = $_POST['PNumber'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $Company = $_POST['Company'];
    $CompanyAddress = $_POST['CompanyAddress'];
    $Origin = $_POST['Origin'];
    $Passport = $_POST['Passport'];
    $IssuedAt = $_POST['IssuedAt'];
    $Discount = $_POST['Discount'];


    $TransactionDate = date("Y/m/d");
    $TransactionTime = date("h:i a");

    $TransactionCode = $_POST['TransactionCode'];
    $TransactBy = $_SESSION['staffname'];

    $Arrival = $_POST['Arrival'];
    $Departure = $_POST['Departure'];



    $amen_Qty = array();
    $amen = $_POST['amenities'];
    foreach ($amen as $value) {
        $amen_Qty[] = $value;
    }

    $sql_amen = "SELECT * FROM amenities";
    $run_sql_amen = mysqli_query($db, $sql_amen);

    $aRates = array();
    $amen_ID = array();
    $amen_Name = array();
    while ($row_amen = mysqli_fetch_array($run_sql_amen)) {
        $aID = $row_amen['AmenID'];
        $aName = $row_amen['AmenName'];
        $aRates = $row_amen['AmenRates'];

        $amen_ID[] = $aID;
        $amen_Name[] = $aName;
        $amen_Rates[] = $aRates;
    }

    for ($i = 0; $i < count($amen_Qty); $i++) {
        $amount = (float)$amen_Rates[$i] * (float)$amen_Qty[$i];

        $query_save = "INSERT INTO amen_transaction (TransactionCode, AmenID, AmenName, AmenQuantity, AmenRates) VALUES 
        ('$TransactionCode', '" . $amen_ID[$i] . "', '" . $amen_Name[$i] . "', '" . $amen_Qty[$i] . "', '$amount')";
        $run_query_save = mysqli_query($db, $query_save);
    }

    //delete 0 quantity
    $segre = "SELECT * FROM amen_transaction WHERE AmenQuantity = '' AND TransactionCode = '$TransactionCode'";
    $run_segre = mysqli_query($db, $segre);
    if (mysqli_num_rows($run_segre) > 0) {
        while ($segre_rows = mysqli_fetch_array($run_segre)) {
            $idd = $segre_rows['id'];
            $segre_del = "DELETE FROM amen_transaction WHERE id = $idd";
            $run_segre_del = mysqli_query($db, $segre_del);
        }
    }



    $query_sum = "SELECT SUM(AmenRates) AS Total_Amen_Rates FROM amen_transaction WHERE TransactionCode = '$TransactionCode'";
    $run_query_sum = mysqli_query($db, $query_sum);
    $row_sum = mysqli_fetch_assoc($run_query_sum);
    $amentotal = $row_sum['Total_Amen_Rates'];

    $from = strtotime($Arrival);
    $to = strtotime($Departure);
    $datediff = $to - $from;
    $date_difference = round($datediff / (60 * 24 * 60));
    $nights = $date_difference;
    $Subtotal = $nights * $price; //room total
    $SUbtotal_with_amen = $Subtotal + $amentotal;
    $totalRates = $SUbtotal_with_amen - ($SUbtotal_with_amen * ($Discount / 100));

    $discounts = $SUbtotal_with_amen * ($Discount / 100);

} else {
    echo "<script>window.location.href='booking';</script>";
}

?>


<!-- cancel btn Modal -->
<div class="modal fade" id="cancelmodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transactionCode" id="transs_code">
                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-reply-all text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to Cancel transaction?</h4>
                    <h4 class="text-warning">This action cannot be undone!</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="CancelBtn" class="btn btn-success px-5">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--  Decline reservation Modal -->

<!-- check in guest Modal -->
<div class="modal fade" id="checkin_modal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="GuestID" value="<?php echo $GuestID; ?>">
                <input type="hidden" name="GuestNumber" value="<?php echo $GuestNumber; ?>">
                <input type="hidden" name="GuestNumber2" value="<?php echo $GuestNumber2; ?>">

                <input type="hidden" name="RoomID" value="<?php echo $RoomID; ?>">
                <input type="hidden" name="Name" value="<?php echo $Name; ?>">
                <input type="hidden" name="Nationality" value="<?php echo $Nationality; ?>">

                <input type="hidden" name="Birthdate" value="<?php echo $Birthdate; ?>">
                <input type="hidden" name="PNumber" value="<?php echo $PNumber; ?>">
                <input type="hidden" name="Email" value="<?php echo $Email; ?>">

                <input type="hidden" name="Address" value="<?php echo $Address; ?>">
                <input type="hidden" name="Company" value="<?php echo $Company; ?>">
                <input type="hidden" name="CompanyAddress" value="<?php echo $CompanyAddress; ?>">
                <input type="hidden" name="Origin" value="<?php echo $Origin; ?>">
                <input type="hidden" name="Passport" value="<?php echo $Passport; ?>">
                <input type="hidden" name="IssuedAt" value="<?php echo $IssuedAt; ?>">
                <input type="hidden" name="Discount" value="<?php echo $Discount; ?>">


                <input type="hidden" name="TransactionDate" value="<?php echo $TransactionDate; ?>">
                <input type="hidden" name="TransactionTime" value="<?php echo $TransactionTime; ?>">
                <input type="hidden" name="TransactionCode" value="<?php echo $TransactionCode; ?>">
                <input type="hidden" name="TransactBy" value="<?php echo $TransactBy; ?>">

                <input type="hidden" name="accommodation" value="">
                <input type="hidden" name="Arrival" value="<?php echo $Arrival; ?>">
                <input type="hidden" name="Departure" value="<?php echo $Departure; ?>">
                <input type="hidden" name="Discount" value="<?php echo $Discount; ?>">

                <input type="hidden" name="TotalRates" value="<?php echo $totalRates; ?>">

                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-check text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to Check In the Guest?</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="BookButton" class="btn btn-success px-5">Confirm</button>
                </div>

            </form>

        </div>
    </div>
</div>
<!--  check in guest Modal -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="card bg-white mb-3">
        <div class="d-flex">
            <div class="d-flex justify-content-end">

                <div class="bg-success">
                    <div class=" text-center text-white p-2" style="margin-right: 80px; margin-left: 140px ;">
                        View Available Rooms
                    </div>
                </div>
                <div class="">
                    <img src="../Images/arrow_white.png" class="bg-success" style="height: 38px; width: 38px;">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="bg-success">
                    <div class=" text-center text-white p-2" style="margin-right: 90px; margin-left: 110px ;">
                        Customer Information
                    </div>
                </div>
                <div class="bg-success">
                    <img src="../Images/arrow.png" class="bg-white" style="height: 38px; width: 38px;">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="bg-white">
                    <div class=" text-center w3-text-teal p-2" style="margin-right: 100px; margin-left: 110px ;">
                        Payment Settlement
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main COntent -->


    <style>
        @media print {
            body * {
                visibility: hidden;

            }

            .print-container,
            .print-container * {
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
    <div class="card shadow-sm pb-3 print-container">
        <div class="  pl-3 pr-3 pt-2  text-lg  ">
            <div class=" text-gray-700">
                <div class="d-flex justify-content-lg-between  align-items">
                    <div class="pb-1">
                        <p class="card-text text-success"><span style="font-size: 1.5rem;"><b>IDSC Hotel</b></span><br>
                            <span style="font-size: 1rem; font-weight:bold;">INVOICE</span>
                        </p>
                    </div>



                    <div>
                        <div class="d-flex pr-3">
                            <div class="pr-3">

                                <p style="font-size: 0.9rem;">
                                    Date of Issue:<br>
                                    Time:<br>

                                    Handled By:</p>
                            </div>

                            <p style="font-size: 0.9rem;">
                                <?php
                                $date1 = strtotime($TransactionDate);
                                $date2 = date('M d, Y', $date1);
                                echo $date2;
                                ?><br>
                                <?php echo $TransactionTime; ?><br>

                                <?php echo $TransactBy; ?>
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
                    <p>
                        <?php echo $Name; ?><br>
                        <?php echo $Nationality; ?><br>

                        <?php
                        $Bday = strtotime($Birthdate);
                        $Bday = date('F d, Y', $Bday);
                        echo $Bday;
                        ?><br>
                        <?php echo $Address; ?><br>
                    </p>
                </div>

                <span class="text-success" style="font-size: 0.9rem">Contact Info:</span>
                <div class="pl-2 pt-2 text-gray-800">
                    <p>
                        <?php echo $PNumber . ' <br>' . $Email; ?><br>
                    </p>
                </div>

                <span class="text-success" style="font-size: 0.9rem">Company and Address:</span>
                <div class="pl-2 pt-2 text-gray-800">
                    <p>
                        <?php echo $Company; ?><br>
                        <?php echo $CompanyAddress; ?><br>
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

                        <?php echo $Origin; ?><br>
                        <?php echo $Passport; ?><br>
                        <?php echo $IssuedAt; ?>
                    </div>
                </div>
                </p>
            </div>

            <div class="ml-3 py-2 px-3 card col border-left-success shadow-sm">
                <div class="d-flex justify-content-between">
                    <div class=" pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Adult(s):</span>
                            <?php echo $GuestNumber; ?>
                        </p>
                    </div>

                    <div class=" pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Kid(s):</span>
                            <?php echo $GuestNumber2; ?>
                        </p>
                    </div>

                    <div class=" pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">Arrival Date:</span>
                            <?php
                            $Arrival = strtotime($Arrival);
                            $Arrival = date('M d, Y', $Arrival);
                            echo $Arrival;
                            ?>
                        </p>
                    </div>

                    <div class=" pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">Departure Date:</span>
                            <?php
                            $Departure = strtotime($Departure);
                            $Departure = date('M d, Y', $Departure);
                            echo $Departure;
                            ?>
                        </p>
                    </div>
                    <div class=" pt-2 text-gray-800">
                        <p>
                            <span class="text-success" style="font-size: 0.9rem">No. Of Night(s):</span>
                            <?php echo $nights; ?>
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
                            <td><?php echo $rowRoomType['roomtype']; ?>
                            </td>
                            <td align="right "><span>&#8369 </span><?php echo $rowRoomType['roomprice']; ?>.00</td>
                            <td align="center "> <?php echo $nights; ?></td>
                            <td align="right "><span>&#8369 </span><?php echo $Subtotal; ?>.00</td>
                        </tr>

                        <?php

                        $amen_query = "SELECT * FROM amen_transaction WHERE TransactionCode = '$TransactionCode'";
                        $run_amen_query = mysqli_query($db, $amen_query);
                        if (mysqli_num_rows($run_amen_query) > 0) {
                            while ($amen_rows = mysqli_fetch_array($run_amen_query)) {
                                $id = $amen_rows['AmenID'];
                                $amen_query2 = "SELECT * FROM amenities WHERE AmenID = '$id'";
                                $run_amen_query2 = mysqli_query($db, $amen_query2);
                                $row = mysqli_fetch_assoc($run_amen_query2);
                                echo '
                                <tr>
                                             <td>' . $amen_rows['AmenName'] . '</td>
                                             <td align="right "><span>&#8369 </span>' . $row['AmenRates'] . '.00</td>
                                             <td align="center">' . $amen_rows['AmenQuantity'] . '</td>
                                            <td align="right "><span>&#8369 </span>' . $amen_rows['AmenRates'] . '.00</td>
                                        </tr>
            
                                ';
                            }
                        } else {
                            //none
                        }


                        mysqli_close($db);
                        ?>

                        <tr class="table-borderless">
                            <td></td>
                        </tr>

                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class=" text-success">Subtotal</td>
                            <td align="right "><span>&#8369 </span><?php echo $SUbtotal_with_amen; ?>.00</td>
                        </tr>
                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class=" text-success">Discount</td>
                            <td align="right "> <?php echo $Discount; ?>% <span class="text-warning">(<?php echo $discounts; ?>)</span></td>
                        </tr>

                        <tr class="table-sm table-borderless">
                            <td></td>
                            <td></td>
                            <td align="right " class=" text-success">Total</td>
                            <td align="right " style="font-size: 1.2rem; "><span>&#8369 </span> <?php echo $totalRates; ?>.00</td>
                        </tr>

                    </table>
                    <table class="table table-borderless" align="right">
                        <tr>

                        </tr>
                    </table>
                </div>
            </div>


        </div>

    </div>

    <div class="col-lg-12 d-flex justify-content-lg-end py-3 ">

        <table>
            <tr>
                <td class="d-none transaction_code"><?php echo $TransactionCode; ?></td>
                <td class="pl-2"><button type="submit" class="cancelbtn btn btn-warning">Cancel</button></td>
                <td class="pl-2">
                    <button type="submit" class="bookbtn btn btn-success ml-2">Check in</button>
                </td>
                </td>
            </tr>
        </table>

    </div>


    <?php
    include('../Includes/scripts.php');
    include('../Includes/footer.php');
    ?>

    <script>
        $(document).on('click', '.cancelbtn', function(e) {
            e.preventDefault();

            var trans_code = $(this).closest('tr').find('.transaction_code').text();
            //console.log(staffid);
            $('#transs_code').val(trans_code);
            $('#cancelmodal').modal('show');
        });

        $(document).on('click', '.bookbtn', function(e) {
            e.preventDefault();

            var trans_code = $(this).closest('tr').find('.transaction_code').text();
            //console.log(staffid);
            $('#transs_code').val(trans_code);
            $('#checkin_modal').modal('show');
        });
    </script>