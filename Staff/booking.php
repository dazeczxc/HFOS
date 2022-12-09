<?php
include('../Includes/header.php');
include('../Includes/staff_navbar.php');

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="card bg-success mb-4 shadow-sm">
        <div class="d-flex">
            <div class="d-flex justify-content-end">

                <div class="w3-white">
                    <div class=" text-center w3-text-teal p-2" style="margin-right: 80px; margin-left: 140px ;">
                        View Available Rooms
                    </div>
                </div>
                <div class="">
                    <img src="../Images/arrow2.png" class="" style="height: 38px; width: 38px;">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="bg-success">
                    <div class=" text-center w3-text-white p-2" style="margin-right: 90px; margin-left: 110px ;">
                        Customer Information
                    </div>
                </div>
                <div class="bg-success">
                    <img src="../Images/arrow_white.png" class="" style="height: 38px; width: 38px;">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="bg-success">
                    <div class=" text-center w3-text-white p-2" style="margin-right: 100px; margin-left: 110px ;">
                        Payment Settlement
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main COntent -->

    <?php
                if(isset($_SESSION['BookingMessage'])){
                    echo $_SESSION['BookingMessage'];
                    unset($_SESSION['BookingMessage']);
                }
                
                ?>
    <div class="container-fluid " id="room_content">

    </div>



    <!-- View Details Modal -->
    <div id="view_details_modal" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                 
                <div class=" bg-white" id="booking_detail">

                </div>

            </div>
        </div>
    </div>

    <!-- End of View  Details Modal -->
    
    <!-- View Reservation Details Modal -->
    <div id="view_details_reserve_modal" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-gray-700" id="exampleModalLabel">Reservation Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="reserve_detail">

                    </div>
                </div>
                 
                 

            </div>
        </div>
    </div>

    <!-- End of View Reservation Details Modal -->

        <!-- Checkout Modal -->
        <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                 

                <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="transactionID" id="transs_id">
                    <div class="modal-body px-4 w3-center">
                        <i class="fa fa-sign-out-alt text-gray-400 fa-3x py-3"></i>
                        <h4> Are you sure to check out the guest?</h4>
                        <h4 class="text-warning">This action cannot be undone!</h4>
                    </div>
                    <div class= "pb-4 w3-center">
                        <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="tID" class="btn btn-success px-5">Confirm</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Checkout Modal -->

    <!-- update Modal -->
    <div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                 

                <form action="booking_update_booking.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="transactionIDD" id="transs_idd">
                    <div class="modal-body px-4 w3-center">
                        <i class="fa fa-sign-out-alt text-gray-400 fa-3x py-3"></i>
                        <h4> Are you sure to update the booking info?</h4>
                        <h4 class="text-warning">This action cannot be undone!</h4>
                    </div>
                    <div class= "pb-4 w3-center">
                        <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_booking_btnnn" class="btn btn-success px-5">Confirm</button>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End update Modal -->
    
    
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



    <?php
    include('../Includes/scripts.php');
    include('../Includes/footer.php');
    ?>

    <script>
        $(document).ready(function() {

            load_data(1);

            function load_data(page, query = '') {
                $.ajax({
                    url: "booking_display_rooms.php",
                    method: "POST",
                    data: {
                        page: page,
                        query: query
                    },
                    success: function(data) {
                        $('#room_content').html(data);
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




            $(document).on('click', '.view_data', function() {
                var staff_id = $(this).attr("id");
                if (staff_id != '') {
                    $.ajax({
                        url: "booking_detail.php", 
                        method: "POST",
                        data: {
                            staff_id: staff_id
                        },
                        success: function(data) {
                            $('#booking_detail').html(data);
                            $('#view_details_modal').modal('show');
                        }
                    });
                }
            });
            
            $(document).on('click', '.view_data_reserve', function() {
                var staff_id = $(this).attr("id");
                if (staff_id != '') {
                    $.ajax({
                        url: "booking_detail_reserve.php", 
                        method: "POST",
                        data: {
                            staff_id: staff_id
                        },
                        success: function(data) {
                            $('#reserve_detail').html(data);
                            $('#view_details_reserve_modal').modal('show');
                        }
                    });
                }
            });

            $(document).on('click', '.delete_btn', function(e) {
                e.preventDefault();

                var transid = $(this).closest('tr').find('.transaction_id').text();
                //console.log(staffid);
                $('#transs_id').val(transid);
                $('#deletemodal').modal('show');
            });


            $(document).on('click', '.update_btn', function(e) {
                e.preventDefault();

                var transid = $(this).closest('tr').find('.transaction_id').text();
                //console.log(staffid);
                $('#transs_idd').val(transid);
                $('#update_modal').modal('show');
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

        $(document).ready(function () {
    $("#flash-msg").delay(2000).fadeOut("slow");
});
    </script>