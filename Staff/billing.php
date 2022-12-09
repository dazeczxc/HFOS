<?php

include('../Includes/header.php');
include('../Includes/staff_navbar.php');
include('../Includes/conn.php');


if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
} else {
    echo "<script>window.location.href='../index.php';</script>";
}

if (isset($_POST['del_guest_folio'])){
    $guest_id = $_POST['guest_folio_id'];
	$query = "DELETE FROM guest WHERE GuestID = $guest_id";
	$query_run = mysqli_query($db, $query);

    if ($query_run) {
		$_SESSION['Guest_folio_message'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Guest deleted successfully!</h5>
		</div>
	
	';

 	} else {
		$_SESSION['Guest_folio_message'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

 	}

	mysqli_close($db);
}
?>

 <!-- Delete Modal -->
 <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">


                        <form action="#" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="guest_folio_id" id="room_delete_id">
                            <div class="modal-body px-4 w3-center">
                                <i class="fa fa-user text-gray-400 fa-3x py-3"></i>
                                <h4> Are you sure to delete this Guest?</h4>
                                <h4 class="text-warning">This action cannot be undone!</h4>
                            </div>
                            <div class="pb-4 w3-center">
                                <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="del_guest_folio" class="btn btn-success px-5">Confirm</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- End Delete Modal -->



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Reservation Tables -->
    <div class="card w3-white" style="margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">

        <div class="">
            <div>
                <div class="d-flex justify-content-lg-between align-items-lg-baseline border-bottom-success px-4 pt-3">
                    <p style="font-size: 1.4rem;" class="w3-left w3-text-teal"><b>Guest Folio</b></p>

                    <input type="text" name="search_box" id="search_box" class="form-control col-2 " placeholder="Search..." />

                </div>


                <div class="px-3 py-2">
                    <?php
                    if (isset($_SESSION['Guest_folio_message'])) {
                        echo $_SESSION['Guest_folio_message'];
                        unset($_SESSION['Guest_folio_message']);
                    }

                    ?>


                    <div class="py-2 table-responsive" id="dynamic_content">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Reservation tables -->


        <!-- View guest Details Modal -->
        <div id="view_guest_modal_OL" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal_OL" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered">
                <div class="modal-content ">

                    <div id="guest_detail">
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
                            url: "fetch_billing.php",
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

                    $(document).on('click', '.page-link', function() {
                        var page = $(this).data('page_number');
                        var query = $('#search_box').val();
                        load_data(page, query);
                    });

                    $('#search_box').keyup(function() {
                        var query = $('#search_box').val();
                        load_data(1, query);
                    });


                    $(document).on('click', '.view_guest', function() {
                        var guest_ID = $(this).attr("id");
                        if (guest_ID != '') {
                            $.ajax({
                                url: "guest_folio_details.php",
                                method: "POST",
                                data: {
                                    guest_ID: guest_ID
                                },
                                success: function(data) {
                                    $('#guest_detail').html(data);
                                    $('#view_guest_modal_OL').modal('show');
                                }
                            });
                        }
                    });


                    $(document).on('click', '.delete_btn', function(e) {
                        e.preventDefault();

                        var roomid = $(this).closest('tr').find('.room_id').text();
                        //console.log(roomid);
                        $('#room_delete_id').val(roomid);
                        $('#deletemodal').modal('show');
                    });


                });


                $(document).ready(function() {
                    $("#flash-msg").delay(2000).fadeOut("slow");
                });
            </script>