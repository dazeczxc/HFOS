<?php 
include('Includes/conn.php');

$room_query = "SELECT * FROM rooms WHERE RoomType IN(SELECT roomtypeid FROM roomtype)";
$run_room_query = mysqli_query($db, $room_query);

if(mysqli_num_rows($run_room_query) > 0){

echo '<div class="col-lg-12 w3-center text-success pb-2 " style="border-bottom: 2px solid #1cc88a;"><b style="font-size: 1.8rem;">Hotel Rooms </b></div>
';
while ($row = mysqli_fetch_array($run_room_query)) {
    $rType = $row['RoomType'];

    $room_type = "SELECT * FROM roomtype WHERE roomtypeid = '$rType'";
    $run_room_type = mysqli_query($db, $room_type);
    $row_type = mysqli_fetch_assoc($run_room_type);

    $query_t = "SELECT COUNT(Star) AS total FROM rating WHERE RoomID = $rType";
    $run_query_t = mysqli_query($db, $query_t);                               
    $row_sumt = mysqli_fetch_assoc($run_query_t);

    if($row_sumt['total'] > 0){
        $query_sum = "SELECT SUM(Star) AS rating FROM rating WHERE RoomID = $RoomType";
        $run_query_sum = mysqli_query($db, $query_sum);
        $row_sum = mysqli_fetch_assoc($run_query_sum);

        $total = $row_sumt['total'];
        $total_rate = $row_sum['rating'];

        $rating = $total_rate/$total;
        
        $rounded = '<b>'.round($rating ,2).' / 5 <i class="fas fa-star star-warning mr-1 main_star"></i></b>';

    }else{
        $rounded =' <i class="fas fa-star star-warning mr-1 main_star"></i> No Ratings ';

    }
    

 
    $output = '
                <div class="col-lg-4 pt-4">
                    <div class="card shadow-sm">
                        <div class="card-img-top"><img src="Upload/'.$row["RoomImage"].'" alt="image" width="100%;" height="250px;"></div>
                        <div class=" card-body">

                        <div class=" text-center">
                                                    <h5 class="text-warning  mb-4">
                                                    '.$rounded.'
                                                    </h5>
                                                 </div>


                            <div class="text-success pb-2" style="font-size: 1.1rem;">'.$row_type['roomtype'].'</div>
                            <div class="pb-4" style="font-size: 1rem; height: 70px; overflow: hidden;">
                            
                            <p class="card-text">'.$row_type['roomtypedescription'].'</p>

                            </div>


                            <a  href="room_details?roomidko='.$row['RoomID'].'" class="card-link text-success mr-3">View Full Details</a>

                                                    
                         
                        </div>

                        
                    </div>
                </div>
            
            ';
            echo $output;

}
}else{
    echo '';
}
?>