<?php
include('../Includes/header.php');
include('../Includes/navbar.php');
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Staff tables -->
    <div class="card w3-white" style="margin-right:10px; margin-top: 10px; box-shadow: 0 1px 3px rgb(0 0 0 / 0.2);">

    <div class="">
            <div>
                <div class="d-flex justify-content-lg-between align-items-lg-baseline border-bottom-success px-4 pt-3">
                <p style="font-size: 1.4rem;" class="w3-left w3-text-teal"><b>Staff Management</b></p>

                    <div class="d-flex">

                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Search..." />

                        <button style="margin-left: 10px;" type="button" class=" btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="px-3 py-3">
                    <?php
                    if (isset($_SESSION['StaffMessage'])) {
                        echo $_SESSION['StaffMessage'];
                        unset($_SESSION['StaffMessage']);
                    }

                    ?>

  
                <div class="container-fluid " id="dynamic_content">

                </div>
            </div>
        </div>
    </div>
    <!--ENd Staff tables -->




    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="../Includes/server.php" method="POST" enctype="multipart/form-data" autocomplete="off">

                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="mb-3">
                            <label>Name</label>

                            <input type="text" name="staffname" class="form-control" placeholder="Name" required>
                        </div>

                        <div class="mb-3">
                            <label>Phone Number</label>

                            <input type="text" name="pnumber" class="form-control" placeholder="Phone Number" required>
                        </div>

                        <div class="mb-3">
                            <label>Username</label>

                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>

                            <input type="text" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="UserType">User Type</label>
                            <select name="access" class="form-select" id="UserType" required>
                                <option selected disabled>Select Access Type</option>

                                <option value="Administrator">Administrator</option>
                                <option value="Staff">Staff</option>

                            </select>
                        </div>

                        

                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" name="StaffPic" id="StaffPic" class="form-control" required>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="staffsave" class="btn btn-success">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- ENd ADD Modal -->



    <!-- Edit Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editmodal">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="../Includes/server.php" method="POST" enctype="multipart/form-data" autocomplete="off">

                    <div class="modal-body" id="edit_modal_content">



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="staffedit" class="btn btn-success">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Edit Modal -->

    <!-- View Details Modal -->
    <div id="view_details_modal" class="modal fade" tabindex="-1" aria-labelledby="view_details_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body" id="staff_detail">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning w3-text-white" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- End of View Details Modal -->

        <!-- Delete Modal -->
        <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                 

                <form action="../Includes/server.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="staffID" id="staff_delete_id">
                    <div class="modal-body px-4 w3-center">
                        <i class="fa fa-trash text-gray-400 fa-3x py-3"></i>
                        <h4> Are you sure to delete this staff?</h4>
                        <h4 class="text-warning">This action cannot be undone!</h4>
                    </div>
                    <div class= "pb-4 w3-center">
                        <button type="button" class="btn btn-warning w3-text-white px-5" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="staffdel" class="btn btn-success px-5">Confirm</button>
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
                    url: "fetch_Staff.php",
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
                var staff_id = $(this).attr("id");
                if (staff_id != '') {
                    $.ajax({
                        url: "staff_edit_modal.php",
                        method: "POST",
                        data: {
                            staff_id: staff_id
                        },
                        success: function(data) {
                            $('#edit_modal_content').html(data);
                            $('#editmodal').modal('show');
                        }
                    });
                }
            });


            $(document).on('click', '.view_data', function() {
                var staff_id = $(this).attr("id");
                if (staff_id != '') {
                    $.ajax({
                        url: "staff_view_modal.php",
                        method: "POST",
                        data: {
                            staff_id: staff_id
                        },
                        success: function(data) {
                            $('#staff_detail').html(data);
                            $('#view_details_modal').modal('show');
                        }
                    });
                }
            });


            $(document).on('click', '.delete_btn', function(e) {
                e.preventDefault();

                var staffid = $(this).closest('tr').find('.staff_id').text();
                //console.log(staffid);
                $('#staff_delete_id').val(staffid);
                $('#deletemodal').modal('show');
            });



        });

        $(document).ready(function () {
    $("#flash-msg").delay(2000).fadeOut("slow");
});
    </script>