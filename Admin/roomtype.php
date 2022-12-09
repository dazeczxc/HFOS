<?php
include('../Includes/header.php');
include('../Includes/navbar.php');
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Roomtype tables -->
    <div class="card w3-white" style="margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">

    <div class="">
            <div>
                <div class="d-flex justify-content-lg-between align-items-lg-baseline border-bottom-success px-4 pt-3">
                <p style="font-size: 1.4rem;" class="w3-left w3-text-teal"><b>Room Types</b></p>

                    <div class="d-flex">

                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Search..." />

                        <button style="margin-left: 10px;" type="button" class=" btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="px-3 py-3">
                    <?php
                    if (isset($_SESSION['RoomTypeMessage'])) {
                        echo $_SESSION['RoomTypeMessage'];
                        unset($_SESSION['RoomTypeMessage']);
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
                    <input type="hidden" name="RoomTypeID">

                    <div class="mb-3">
                        <label>Room Type</label>

                        <input type="text" name="RoomType" class="form-control" placeholder="Room Type" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>

                        <textarea rows="9" name="RoomDescription" class="form-control" placeholder="Description Here..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Rates</label>

                        <input type="text" name="RoomPrice" class="form-control" placeholder="0" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="roomtypesave" class="btn btn-success">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Add Modal -->



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
                    <input type="hidden" name="RoomTypeID" id="RoomTypeID">

                    <div class="mb-3">
                        <label>Room Type</label>

                        <input type="text" name="RoomType" id="RoomType" class="form-control" placeholder="Room Type" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>

                        <textarea rows="9" id="RoomDescription" name="RoomDescription" class="form-control" placeholder="Description Here..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Rates</label>

                        <input type="text" id="RoomPrice" name="RoomPrice" class="form-control" placeholder="0" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="roomtypeedit" class="btn btn-success">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Edit Modal -->


    <!-- Delete Modal -->
    <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                 
                <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="roomtype_id" id="roomtype_delete_id">
                    <div class="modal-body px-4 w3-center">
                        <i class="fa fa-trash text-gray-400 fa-3x py-3"></i>
                        <h4> Are you sure to delete this room type?</h4>
                        <h4 class="text-warning">This action cannot be undone!</h4>
                    </div>
                    <div class= "pb-4 w3-center">
                        <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="roomtypedel" class="btn btn-success px-5">Confirm</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Delete Modal -->


<?php
include('../Includes/scripts.php');
include('../Includes/footer.php');
?>

<script>
    $(document).ready(function() {

        load_data(1);

        function load_data(page, query = '') {
            $.ajax({
                url: "fetch_RoomType.php",
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
            $('#RoomTypeID').val(data[0]);
            $('#RoomType').val(data[1]);
            $('#RoomDescription').val(data[2]);
            $('#RoomPrice').val(data[4]);

        });


        $(document).on('click', '.delete_btn', function(e) {
                e.preventDefault();

                var roomtypeid = $(this).closest('tr').find('.roomtype_id').text();
                 //console.log(roomtypeid);
                $('#roomtype_delete_id').val(roomtypeid);
                $('#deletemodal').modal('show');
        });



        $(document).ready(function() {
            $("#flash-msg").delay(2000).fadeOut("slow");
        });

    });
</script>