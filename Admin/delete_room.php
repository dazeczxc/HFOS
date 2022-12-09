<?php  
 if(isset($_POST["room_id"]))  
 {  
     $Roomid = $_POST["room_id"];
      include('../Includes/conn.php');
      $query = "DELETE FROM rooms WHERE RoomID = '.$Roomid.'";  
      $result = mysqli_query($db, $query);   
      mysqli_close($db);

 }  
 ?>