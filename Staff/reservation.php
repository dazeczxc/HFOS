<?php

include('../Includes/header.php');
include('../Includes/staff_navbar.php');
include('../Includes/conn.php');

$comment ='';
$tcode = '';
if(isset($_POST["send_reply"])){
    $comment = $_POST["reply"];
    $tcode = $_POST["tcode"];

    $query_reply= "UPDATE reservation SET Reply='$comment' WHERE TransactionCode='$tcode'";
	$query_run_query_reply = mysqli_query($db, $query_reply);

}
 
?>


<!-- Decline reservation Modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transactionCode" id="transs_code">
                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-times text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to decline reservation?</h4>
                    <h4 class="text-warning">This action cannot be undone!</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="declinebtn" class="btn btn-success px-5">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--  Decline reservation Modal -->

<!-- Confirm reservation Modal -->
<div class="modal fade" id="confirmmodal" tabindex="-1" aria-labelledby="confirmmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transactionCode" id="confirm_transs_code">
                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-check text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to Confirm reservation?</h4>
                    <h4 class="text-warning">This action cannot be undone!</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="approvebtn" class="btn btn-success px-5">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--  Decline reservation Modal -->

<!-- cancel reservation Modal -->
<div class="modal fade" id="cancelmodal" tabindex="-1" aria-labelledby="confirmmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transactionCode" id="cancel_reservation_transs_code">
                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-times text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to Cancel the reservation?</h4>
                    <h4 class="text-warning">This action cannot be undone!</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="cancelreservebtn" class="btn btn-success px-5">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--  cancel reservation Modal -->

<!-- check in reservation Modal -->
<div class="modal fade" id="checkinmodal" tabindex="-1" aria-labelledby="confirmmodal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <form action="reservation_checkin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="transactionCode" id="check_in_transs_code">
                <div class="modal-body px-4 w3-center">
                    <i class="fa fa-check text-gray-400 fa-3x py-3"></i>
                    <h4> Are you sure to Check in the Guest?</h4>
                    <h4 class="text-warning">This action cannot be undone!</h4>
                </div>
                <div class="pb-4 w3-center">
                    <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="confirm_reservation_roomid" class="btn btn-success px-5">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--  check in reservation Modal -->




<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Reservation Tables -->
    <div class="card w3-white" style="margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">

        <div class="">
            <div>
                <div class="d-flex justify-content-lg-between align-items-lg-baseline border-bottom-success px-4 pt-3">
                    <p style="font-size: 1.4rem;" class="w3-left w3-text-teal"><b>Reservation Management</b></p>
                    <div class="d-flex align">

                        <input type="text" name="search_box" id="search_box" class="form-control col-7 " placeholder="Search Name or Code..." />


                        <a class="btn btn-success ml-2" href="reservation_add">Add Reservation</a>

                    </div>
                </div>


                <div class="px-3 py-2">
                    <?php
                    if (isset($_SESSION['StaffReservationConfirmMessage'])) {
                        echo $_SESSION['StaffReservationConfirmMessage'];
                        unset($_SESSION['StaffReservationConfirmMessage']);
                    }

                    ?>



                    <div class="mt-2 " id="dynamic_content">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Reservation tables -->



        <!-- View Online Reservation Details Modal -->
        <div id="view_details_modal_OL" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal_OL" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-gray-700" id="exampleModalLabel">Request Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="reservation_detail">

                    </div>
                </div>
            </div>
        </div>
        <!-- End of View Details Modal -->

        <!-- View reservation details Modal -->
        <div id="view_details_modal_reservation" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal_reservation" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-gray-700" id="exampleModalLabel">Reservation Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="reservation_details">

                    </div>
                </div>
            </div>
        </div>
        <!-- End of View Details Modal -->


        <?php
        include('../Includes/scripts.php');
        include('../Includes/footer.php');
        ?>

        <script>
            $(document).ready(function() {

                load_data(1);

                function load_data(page, query = '') {
                    $.ajax({
                        url: "fetch_Reservation.php",
                        method: "POST",
                        data: {
                            page: page,
                            query: query
                        },
                        success: function(data) {
                            $('#dynamic_content').html(data);
                        }
                    });
                }

                //setInterval(function(){load_data(1);},2000);

                $(document).on('click', '.page-link', function() {
                    var page = $(this).data('page_number');
                    var query = $('#search_box').val();
                    load_data(page, query);
                });

                $('#search_box').keyup(function() {
                    var query = $('#search_box').val();
                    load_data(1, query);
                });


                $(document).on('click', '.view_OL', function() {
                    var trans_code = $(this).attr("id");
                    if (trans_code != '') {
                        $.ajax({
                            url: "online_Reservation_Details.php",
                            method: "POST",
                            data: {
                                trans_code: trans_code
                            },
                            success: function(data) {
                                $('#reservation_detail').html(data);
                                $('#view_details_modal_OL').modal('show');
                            }
                        });
                    }
                });

                $(document).on('click', '.view_reservation', function() {
                    var trans_code = $(this).attr("id");
                    if (trans_code != '') {
                        $.ajax({
                            url: "reservation_details.php",
                            method: "POST",
                            data: {
                                trans_code: trans_code
                            },
                            success: function(data) {
                                $('#reservation_details').html(data);
                                $('#view_details_modal_reservation').modal('show');
                            }
                        });
                    }
                });



                $(document).on('click', '.delete_btn', function(e) {
                    e.preventDefault();

                    var trans_code = $(this).closest('tr').find('.transaction_code').text();
                    //console.log(staffid);
                    $('#transs_code').val(trans_code);
                    $('#deletemodal').modal('show');
                });

                $(document).on('click', '.confirm_btn', function(e) {
                    e.preventDefault();

                    var trans_code = $(this).closest('tr').find('.transaction_code').text();
                    //console.log(staffid);
                    $('#confirm_transs_code').val(trans_code);
                    $('#confirmmodal').modal('show');
                });

                $(document).on('click', '.cancel_reservation_btn', function(e) {
                    e.preventDefault();

                    var trans_code = $(this).closest('tr').find('.transaction_code').text();
                    //console.log(staffid);
                    $('#cancel_reservation_transs_code').val(trans_code);
                    $('#cancelmodal').modal('show');
                });

                $(document).on('click', '.checkin_reservation_btn', function(e) {
                    e.preventDefault();

                    var trans_code = $(this).closest('tr').find('.transaction_code').text();
                    //console.log(staffid);
                    $('#check_in_transs_code').val(trans_code);
                    $('#checkinmodal').modal('show');
                });

            });


            $(document).ready(function() {
                $("#flash-msg").delay(2000).fadeOut("slow");
            });

            $(document).ready(function() {

                var minDate = new Date();
                minDate.setDate(minDate.getDate())

                $('#datetimepicker').datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: minDate,
                });

                $('#toggle').on('click', function() {
                    $('#datetimepicker').datepicker('toggle')
                })




                $('#datetimepicker2').datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: minDate,
                });

                $('#toggle2').on('click', function() {
                    $('#datetimepicker2').datepicker('toggle')
                })



            });
        </script>