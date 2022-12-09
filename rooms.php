
<section class="py-5 bg-gray-100 " id="rooms">
    <div class="container pt-5">
        
        <div class="pt-5">
         
            <div class="col-lg-12" >
                <div class="pt-5 w3-center text-success pb-2 " style="border-bottom: 2px solid #1cc88a;"><b style="font-size: 2.5rem;">Hotel Rooms</b>       
                </div>
            
            </div>
            <div class="py-3 d-flex justify-content-md-center"><input class="col-lg-5 form-control mb-2" name="search_box" id="search_box" type="text" placeholder="Search Room" aria-label="Search"></div>

            <div id="dynamic_content_room"></div>

            </div>    
            
             
        </div>

        
</section>


<script>
    $(document).ready(function() {
        load_data(1);

        function load_data(page, query = '') {
            $.ajax({
                url: "fetch_room_new.php",
                method: "POST",
                data: {
                    page: page,
                    query: query
                },
                success: function(data) {
                    $('#dynamic_content_room').html(data);
                }
            });

            $(document).on('click', '.page-link', function() {
            var page = $(this).data('page_number');
            var query = $('#search_box').val();
            load_data(page, query);
            });

            $('#search_box').keyup(function() {
                var query = $('#search_box').val();
                load_data(1, query);
            });
        }

    });
</script>


