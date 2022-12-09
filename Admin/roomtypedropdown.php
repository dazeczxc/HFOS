 


<?php
include("../Includes/conn.php");

$roomTypesQuery = "SELECT * FROM roomtype";
$run_roomTypesQuery = mysqli_query($db, $roomTypesQuery);

if(mysqli_num_rows($run_roomTypesQuery) > 0){
    while ($rowtype = mysqli_fetch_array($run_roomTypesQuery)) {

        $out = '<option value="'.$rowtype["roomtypeid"].'"> '.$rowtype['roomtype'].'</option>';
        echo $out;
    
    }
}else{
    
}
 

?>
