<?php
include('../includes/header.php');
include('../includes/navbar.php');
?>


<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Roomtype tables -->
    <div class="card w3-white" style=" margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">
    <div class="">
            <div>
                <div class="d-flex justify-content-lg-between align-items-lg-baseline border-bottom-success px-4 pt-3">
                <p style="font-size: 1.4rem;" class="w3-left w3-text-teal"><b>Accommodation Management</b></p>

                    <div class="d-flex">

                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Search..." />

                        <button style="margin-left: 10px;" type="button" class=" btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="px-3 py-3">
                    <?php
                    if (isset($_SESSION['AccommMessage'])) {
                        echo $_SESSION['AccommMessage'];
                        unset($_SESSION['AccommMessage']);
                    }

                    ?>



        
                <div class="table-responsive" id="dynamic_content">

                </div>
            </div>
        </div>
    </div>
    <!-- End Roomtype tables -->

    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">

                    <div class="modal-body">
                        <input type="hidden" name="AccommodationID">

                        <div class="mb-3">
                            <label>Accommodation Type</label>

                            <input type="text" name="AccommodationType" class="form-control" placeholder="Type of Accommodation" required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>

                            <textarea rows="9" type="text" name="AccommodationDescription" class="form-control" placeholder="Descriptions.." required></textarea>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="accommodationsave" class="btn w3-teal">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editmodal">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">

                    <div class="modal-body">
                        <input type="hidden" name="AccommodationID" id="AccommodationID">

                        <div class="mb-3">
                            <label>Accommodation Type</label>

                            <input type="text" name="AccommodationType" id="AccommodationType" class="form-control" placeholder="Type of Accommodation" required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea rows="9" type="text" id="AccommodationDescription" name="AccommodationDescription" class="form-control" placeholder="Descriptions.." required></textarea>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="accommodationedit" class="btn w3-teal">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




    <?php
    include('../includes/scripts.php');
    include('../includes/footer.php');
    ?>

    <script>
        $(document).ready(function() {

            load_data(1);

            function load_data(page, query = '') {
                $.ajax({
                    url: "fetch_Accommodation.php",
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


            $(document).on('click', '.editbtn', function() {
                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();


                console.log(data);
                $('#AccommodationID').val(data[0]);
                $('#AccommodationType').val(data[1]);
                $('#AccommodationDescription').val(data[2]);



            });

            $(document).ready(function () {
    $("#flash-msg").delay(2000).fadeOut("slow");
});

        });
    </script>