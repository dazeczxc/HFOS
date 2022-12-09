<?php  
include("../Includes/conn.php");
 if(isset($_POST["roomid"]))  
 {  
     $roomid = $_POST["roomid"];

      $query = "SELECT * FROM rooms WHERE RoomID = '$roomid'";  
      $result = mysqli_query($db, $query);  
 
      while($row = mysqli_fetch_array($result))  
      {  $out='
            <h1>'.$row['RoomID'].'</h1>
            <h1>'.$row['RoomName'].'</h1>';
   
      }  
      echo $out;
 
 }  
 ?>